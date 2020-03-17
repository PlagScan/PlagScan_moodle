<?php

// This file is part of the Plagscan plugin for Moodle - http://moodle.org/
// 
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * lib.php - Contains Plagiarism plugin specific functions called by Modules.
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo <rolmedo@plagscan.com>)
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\event\assign_creation_completed;
use plagiarism_plagscan\event\assign_creation_started;
use plagiarism_plagscan\event\assign_update_completed;

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

define('PLAGIARISM_PLAGSCAN_LOG_SERVER_COMMUNICATION', 0);

//get global class
global $CFG;
require_once($CFG->dirroot . '/plagiarism/lib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_connection.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_file.php');

class plagscan_credentials_exception extends moodle_exception {
    
}

///// plagscan Class ////////////////////////////////////////////////////
class plagiarism_plugin_plagscan extends plagiarism_plugin {

    const RUN_NO = 0;
    const RUN_MANUAL = 1;
    const RUN_AUTO = 2;
    const RUN_ALL = 3;
    const RUN_DUE = 4;
    const RUN_SUBMIT_MANUAL = 5;
    const RUN_SUBMIT_ON_CLOSED_SUBMISSION = 6;
    const SHOWSTUDENTS_NEVER = 0;
    const SHOWSTUDENTS_ALWAYS = 1;
    const SHOWSTUDENTS_ACTCLOSED = 2;
    const SHOWS_ONLY_PLVL = 0;
    const SHOWS_LINKS = 1;
    const ONLINE_TEXT = 1;
    const ONLINE_TEXT_NO = 0;

    private $ps_yellow_level = null;
    private $ps_red_level = null;

    /**
     * hook to add plagiarism specific settings to a module settings page
     * @param object $mform  - Moodle form
     * @param object $context - current context
     * @param string $modulename - name of module
     */
    public function get_form_elements_module($mform, $context, $modulename = "") {
        global $DB, $USER, $COURSE, $CFG;

        if (!has_capability('plagiarism/plagscan:enable', $context)) {
            return '';
        }
        $groups = trim(get_config('plagiarism_plagscan', 'plagscan_groups'));

        $groups = explode(",", $groups);
        $enable_plagscan = false;

        if (sizeof($groups) == 1 && $groups[0] == "") {
            $enable_plagscan = true;
        }
        $category = $DB->get_record('course_categories', array('id' => $COURSE->category));
        $category = $category->name;


        if (!$enable_plagscan) {
            for ($i = 0; $i < sizeof($groups); $i++) {
                if (strtolower($groups[$i]) == strtolower($category)) {
                    $enable_plagscan = true;
                    break;
                }
            }
        }

        if (!$enable_plagscan) {
            return '';
        }


        if ($modulename != "mod_forum") {
            //cm update
            $cmid = optional_param('update', 0, PARAM_INT);
            
            $psfileopts = array(self::RUN_NO => get_string('no'),
                self::RUN_SUBMIT_MANUAL => get_string('runsubmitmanual', 'plagiarism_plagscan'),
                self::RUN_MANUAL => get_string('runmanual', 'plagiarism_plagscan'),
                self::RUN_SUBMIT_ON_CLOSED_SUBMISSION => get_string('runsubmitonclosedsubmission', 'plagiarism_plagscan'),
                self::RUN_ALL => get_string('runalways', 'plagiarism_plagscan'),
                self::RUN_AUTO => get_string('runautomatic', 'plagiarism_plagscan'),
                self::RUN_DUE => get_string('runduedate', 'plagiarism_plagscan'));

            $showstudentsopt = array(self::SHOWSTUDENTS_NEVER => get_string('show_to_students_never', 'plagiarism_plagscan'),
                self::SHOWSTUDENTS_ALWAYS => get_string('show_to_students_always', 'plagiarism_plagscan'),
                self::SHOWSTUDENTS_ACTCLOSED => get_string('show_to_students_actclosed', 'plagiarism_plagscan'));

            $showstudentslinks = array(self::SHOWS_ONLY_PLVL => get_string('show_to_students_plvl', 'plagiarism_plagscan'),
                self::SHOWS_LINKS => get_string('show_to_students_links', 'plagiarism_plagscan'));

            $onlinetextsubmission = array(self::ONLINE_TEXT_NO => get_string('online_text_no', 'plagiarism_plagscan'),
                self::ONLINE_TEXT => get_string('online_text_yes', 'plagiarism_plagscan'));

            $mform->addElement('header', 'plagscandesc', get_string('plagscan', 'plagiarism_plagscan'));

            $mform->addElement('select', 'plagscan_upload', get_string("useplagscan_filessubmission", "plagiarism_plagscan"), $psfileopts);
            $mform->addHelpButton('plagscan_upload', 'useplagscan_filessubmission', 'plagiarism_plagscan');

// prints non-disclosure notice if it's activated
            if (get_config('plagiarism_plagscan', 'plagscan_nondisclosure_notice_email')) {
                $mform->addElement('checkbox', 'nondisclosure_notice', get_string('plagscan_nondisclosure_notice_email', 'plagiarism_plagscan'));
                $mform->addHelpButton('nondisclosure_notice', 'plagscan_nondisclosure_notice_email', 'plagiarism_plagscan');
                $mform->addElement('static', 'nondisclosure_notice_desc', '', get_string('nondisclosure_notice_desc', 'plagiarism_plagscan', get_config('plagiarism_plagscan', 'plagscan_nondisclosure_notice_email')));
            }
            
            $show_exclude_options = true;
            if($cmid){
                $instanceconfig = plagscan_get_instance_config($cmid);
                if(!empty($instanceconfig->username) && ($instanceconfig->submissionid == NULL || intval($instanceconfig->submissionid) <= 0 )){
                    $show_exclude_options = false;
                }            
            }
            
            if($show_exclude_options){
                $mform->addElement('checkbox', 'exclude_self_matches', get_string('exclude_self_matches', 'plagiarism_plagscan'));
                $mform->addHelpButton('exclude_self_matches', 'exclude_self_matches', 'plagiarism_plagscan');
                $mform->setDefault('exclude_self_matches', get_config('plagiarism_plagscan', 'plagscan_defaults_exclude_self_matches'));

                $mform->addElement('checkbox', 'exclude_from_repository', get_string('exclude_from_repository', 'plagiarism_plagscan'));
                $mform->addHelpButton('exclude_from_repository', 'exclude_from_repository', 'plagiarism_plagscan');
                $mform->setDefault('exclude_from_repository', get_config('plagiarism_plagscan', 'plagscan_defaults_exclude_from_repository'));
            }
            
            $mform->addElement('select', 'online_text', get_string('online_submission', 'plagiarism_plagscan'), $onlinetextsubmission);
            $mform->addHelpButton('online_text', 'online_submission', 'plagiarism_plagscan');
            $mform->setDefault('online_text', get_config('plagiarism_plagscan', 'plagscan_defaults_online_text'));
            
            $mform->addElement('select', 'show_to_students', get_string("show_to_students", "plagiarism_plagscan"), $showstudentsopt);
            $mform->addHelpButton('show_to_students', 'show_to_students', 'plagiarism_plagscan');
            $mform->setDefault('show_to_students', get_config('plagiarism_plagscan', 'plagscan_defaults_show_to_students'));

            $mform->addElement('select', 'show_students_links', get_string("show_to_students_opt2", "plagiarism_plagscan"), $showstudentslinks);
            $mform->addHelpButton('show_students_links', 'show_to_students_opt2', 'plagiarism_plagscan');
            $mform->setDefault('show_students_links', get_config('plagiarism_plagscan', 'plagscan_defaults_show_students_links'));
            $mform->disabledIf('show_students_links', 'show_to_students', 'eq', 0);

            /*  $mform->addElement('html', '<div class="box boxaligncenter gradingtable p-y-1">');
              $mform->addElement('html', '<div class="flexible generaltable generalbox">');
              $mform->addElement('html', '</div>');
              $mform->addElement('html', '</div>');
              $this->add_action_buttons(true); */

            if ($cmid) {
                $mform->setDefault('plagscan_upload', $instanceconfig->upload);
                if (isset($instanceconfig->enable_online_text)) {
                    $mform->setDefault('online_text', $instanceconfig->enable_online_text);
                }
                
                if($show_exclude_options){
                    if(isset($instanceconfig->exclude_self_matches)){
                        $mform->setDefault('exclude_self_matches', $instanceconfig->exclude_self_matches);
                    }

                    if(isset($instanceconfig->exclude_from_repository)){
                        $mform->setDefault('exclude_from_repository', $instanceconfig->exclude_from_repository);
                    }
                }                    

                $mform->setDefault('show_to_students', $instanceconfig->show_report_to_students);
                $mform->setDefault('show_students_links', $instanceconfig->show_students_links);


                if (get_config('plagiarism_plagscan', 'plagscan_nondisclosure_notice_email')) {
                    $mform->setDefault('nondisclosure_notice', $instanceconfig->nondisclosure);
                }

                if (get_config('plagiarism_plagscan', 'plagscan_multipleaccounts')) {
                    if (!empty($instanceconfig->username)) {
                        if ($instanceconfig->username == $USER->email) {
                            $user = $USER;
                        } else {
                            $user = $DB->get_record('user', array('email' => $instanceconfig->username));
                        }
                        if ($user) {
                            $name = fullname($user) . " ({$user->email})";
                            $mform->addElement('static', 'plagscan_admin_email', '', get_string('filesassociated', 'plagiarism_plagscan', $name));
                        }
                    }
                    $url = new moodle_url('/plagiarism/plagscan/userconfig.php', array('sesskey' => sesskey()));
                    $link = html_writer::link($url, get_string('updateyoursettings', 'plagiarism_plagscan'), array('target' => '_blank'));
                    $mform->addElement('html', $link);
                }
            } else {
                $mform->setDefault('plagscan_upload', self::RUN_NO);
            }
        }
    }

    /* hook to save plagiarism specific settings on a module settings page
     * @param object $data - data from an mform submission.
     */

    public function save_form_elements($data) {
        global $DB, $USER, $CFG;

        if ($data->modulename != "assign") {
            return '';
        }

        $cmid = $data->coursemodule;

        $modulesql = 'SELECT m.id, m.name, cm.instance' .
                ' FROM {course_modules} cm' .
                ' INNER JOIN {modules} m on cm.module = m.id ' .
                'WHERE cm.id = ?';
        $moduledetail = $DB->get_record_sql($modulesql, array($cmid));

        if (!empty($moduledetail)) {
            $sql = "SELECT * FROM " . $CFG->prefix . $moduledetail->name . " WHERE id= ?";
            $module = $DB->get_record_sql($sql, array($moduledetail->instance));
        }

        if (isset($data->plagscan_upload)) {
            $config = new \stdClass();
            $config->upload = filter_var($data->plagscan_upload, FILTER_VALIDATE_INT);

            if ($config->upload !== self::RUN_NO) {
                $assignlog = array(
                    'context' => \context_system::instance(),
                    'objectid' => $cmid
                );

                assign_creation_started::create($assignlog)->trigger();
                
                $is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');

                if ($is_multiaccount) {
                    $user = $USER;
                } else {
                    $user = $DB->get_record('user', array('email' => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
                }
                
                $oldconfig = plagscan_get_instance_config($cmid, false);
                if (!isset($oldconfig->username) || empty($oldconfig->username)) {
                    $config->username = $user->email;
                } else {
                    $config->username = $oldconfig->username;
                }

                
                if ( !isset($oldconfig->ownerid) || empty($oldconfig->ownerid) || intval($oldconfig->ownerid) <= 0 ) {
                    if (!isset($oldconfig->username) || empty($oldconfig->username)) {
                        $config->ownerid = $user->id;
                    } else {
                        $owner = $DB->get_record('user', array("email" => $oldconfig->username));
                        $config->ownerid = $owner->id;
                    }
                } else {
                    $config->ownerid = $oldconfig->ownerid;
                }
                
                $validation_default = array('options' => array('default' => 0));
                
                if(isset($data->exclude_self_matches)){
                    $config->exclude_self_matches = filter_var($data->exclude_self_matches, FILTER_VALIDATE_INT, $validation_default);
                }
                else{
                    $config->exclude_self_matches = 0;
                }
                
                if(isset($data->exclude_from_repository)){
                    $config->exclude_from_repository = filter_var($data->exclude_from_repository, FILTER_VALIDATE_INT, $validation_default);
                }
                else {
                    $config->exclude_from_repository = 0;
                }
                
                $connection = new plagscan_connection();
                
                if ((!isset($oldconfig->upload) || empty($oldconfig->upload)) && (!isset($oldconfig->submissionid) || intval($oldconfig->submissionid) <= 0)) {
                    if ($is_multiaccount) {
                        $submissionid = $connection->create_submissionid($cmid, $module, $config, $user);
                        if (intval($submissionid) <= 0){
                            //throw new moodle_exception('error_assignment_creation', 'plagiarism_plagscan');
                            $error_msg = "PlagScan: ".get_string('error_assignment_creation', 'plagiarism_plagscan') . ".";
                            if(intval($submissionid) == -1){
                                $error_msg .= " " . get_string('error_user_does_not_belong_to_the_institution', 'plagiarism_plagscan'). ".";
                            }
                            \core\notification::add($error_msg, \core\output\notification::NOTIFY_ERROR);
                            return;
                        }
                        $assignlog['other']['submissionid'] = $submissionid;
                        assign_creation_completed::create($assignlog)->trigger();
                    }
                    else {
                        $submissionid = null;
                    }
                }
                else {
                    $submissionid = $oldconfig->submissionid;
                    if ($submissionid != NULL) {
                        $assign_owner = $DB->get_record("user", array("id" => $config->ownerid));
                        $connection->update_submission($cmid, $module, $config, $submissionid, $assign_owner);
                        assign_update_completed::create($assignlog)->trigger();
                    }
                }
                
                $config->show_report_to_students = filter_var($data->show_to_students, FILTER_VALIDATE_INT, $validation_default);
                $config->show_students_links = filter_var($data->show_students_links, FILTER_VALIDATE_INT, $validation_default);
                $config->enable_online_text = filter_var($data->online_text, FILTER_VALIDATE_INT, $validation_default);

                $config->submissionid = $submissionid;
                //nondisclosure document
                if (isset($data->nondisclosure_notice) && $data->nondisclosure_notice == 1 && get_config('plagiarism_plagscan', 'plagscan_nondisclosure_notice_email')) {
                    $config->nondisclosure = 1;
                    //$config->username = get_config('plagiarism_plagscan', 'plagscan_nondisclosure_notice_email');
                }
                //END nondisclosure document
            }
            plagscan_set_instance_config($cmid, $config);
        }
    }

    public function cron() {
        
    }

    public function print_disclosure($cmid) {
        global $PAGE, $USER;
        $disclosure = '';
        
        $instanceconfig = plagscan_get_instance_config($cmid);

        if(!isset($instanceconfig->upload) || $instanceconfig->upload == plagiarism_plugin_plagscan::RUN_NO)
            return $disclosure;
        
        if (get_config('plagiarism_plagscan', 'plagscan_studentpermission')) {
            $returl = urlencode($PAGE->url->out());
            $url = new moodle_url('/plagiarism/plagscan/optout.php', array('sesskey' => sesskey(),
                'cmid' => $cmid));
            if (get_user_preferences('plagiarism_plagscan_optout', false)) {
                $disclosure .= get_string('studentdisclosureoptedout', 'plagiarism_plagscan');
                $disclosure .= html_writer::empty_tag('br');

                $url->param('optout', 0);
                $disclosure .= html_writer::link($url, get_string('studentdisclosureoptin', 'plagiarism_plagscan'));
            } else {
                $disclosure .= get_config('plagiarism_plagscan', 'plagscan_student_disclosure');
                $disclosure .= html_writer::empty_tag('br');

                $url->param('optout', 1);
                $disclosure .= html_writer::link($url, get_string('studentdisclosureoptout', 'plagiarism_plagscan'));
            }
        } else {
            $disclosure .= get_config('plagiarism_plagscan', 'plagscan_student_disclosure');
        }
        return $disclosure;
    }

    /**
     * hook to allow plagiarism specific information to be displayed beside a submission
     * @param array  $linkarray contains all relevant information for the plugin to generate a link
     * @return string
     *
     */
    public function get_links($linkarray) {

        global $CFG, $USER, $COURSE, $DB, $PAGE, $cm;

        $cmid = $linkarray['cmid'];

        $is_file = isset($linkarray['file']);
        $is_content = isset($linkarray['content']);

        if ($is_file && $linkarray['file']->get_filearea() == 'introattachment') {
            return '';
        }

        $is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');

        // Check if plagscan is enabled for this module instance (and cache the result)
        static $psfileenabled = array();
        static $instanceconfig = null;
        ;

        if (!isset($psfileenabled[$cmid])) {
            $instanceconfig = plagscan_get_instance_config($cmid);
            $psfileenabled[$cmid] = $instanceconfig->upload;
        }
        if ($psfileenabled[$cmid] == self::RUN_NO) {
            return '';
        }

        if ($CFG->version < 2011120100) {
            $context = get_context_instance(CONTEXT_MODULE, $cmid);
        } else {
            $context = context_module::instance($cmid);
        }

        //get viewreport varinviable
        //get assigned closed
        $viewreport = false;
        $modulesql = 'SELECT m.id, m.name, cm.instance' .
                ' FROM {course_modules} cm' .
                ' INNER JOIN {modules} m on cm.module = m.id ' .
                'WHERE cm.id = ?';
        $moduledetail = $DB->get_record_sql($modulesql, array($cmid));

        if (!empty($moduledetail)) {
            $sql = "SELECT * FROM " . $CFG->prefix . $moduledetail->name . " WHERE id= ?";
            $module = $DB->get_record_sql($sql, array($moduledetail->instance));
        }
        if (empty($module)) {
            // No such cmid.
            return false;
        }
        $assignclosed = false;
        $time = time();
        if (!empty($module->preventlate) && !empty($module->timedue)) {
            $assignclosed = ($module->timeavailable <= $time && $time <= $module->timedue);
        } else if (!empty($module->timeavailable)) {
            $assignclosed = ($module->timeavailable <= $time);
        } else if (!empty($module->duedate)) {
            $assignclosed = ($module->duedate <= $time);
        }


        //END get assigned closed
        if (isset($instanceconfig->show_report_to_students) && (
                $instanceconfig->show_report_to_students == self::SHOWSTUDENTS_ALWAYS ||
                $instanceconfig->show_report_to_students == self::SHOWSTUDENTS_ACTCLOSED && $assignclosed)) {
            $viewreport = true;
        }
        $showplvl = false;
        $showlinks = false;
        if ($viewreport) {
            if ($instanceconfig->show_students_links == self::SHOWS_LINKS) {
                $showplvl = true;
                $showlinks = true;
            } else {
                $showplvl = true;
            }
        }
        //END get viewreport variable


        $connection = new plagscan_connection();

        // Check if the user is able to view links (and cache the result)
        static $viewlinks = array();
        if (!isset($viewlinks[$cmid])) {
            $viewlinks[$cmid] = has_capability('plagiarism/plagscan:control', $context);
        }
        $viewlinksb = false; //viewlinks can see message and submit; viewreport just the plaglevel
        if ($viewlinks[$cmid]) {
            $viewlinksb = true;
        }

        //Check if the assignment was created from a previous versions without creating it on PS too
        if ($instanceconfig->ownerid != null && intval($instanceconfig->ownerid) > 0 ) {
            $assign_owner = $DB->get_record('user', array("id" => $instanceconfig->ownerid));
            $assign_psownerid = $connection->find_user($assign_owner);
        } else {
            $assign_owner = $DB->get_record('user', array("email" => $instanceconfig->username));
            $assign_psownerid = $connection->find_user($assign_owner);
        }
        
        //INVOLVE TEACHER - TODO: Maybe should go in another place
        static $involved;
        if ($is_multiaccount && $instanceconfig->submissionid != null && $instanceconfig->submissionid != 'ownerid' && $instanceconfig->ownerid != null 
                && $assign_psownerid != null && $assign_owner->id != $USER->id && !isset($involved[$cmid][$USER->id])) {
            
            if ($connection->is_assistant($context, $instanceconfig, $USER)) {
                $is_involved = $connection->involve_assistant($instanceconfig, $assign_psownerid, $USER);
                $involved[$cmid][$USER->id] = $is_involved;
                if ($is_involved["result"] < 1){
                    $error_msg = get_string('error_involving_assistant', 'plagiarism_plagscan') . ".";
                    if ($is_involved["result"] == -1){
                        $error_msg .= " " . get_string('error_user_does_not_belong_to_the_institution', 'plagiarism_plagscan') . ".";
                        $error_msg .= " " . get_string('plagscan_user_id', 'plagiarism_plagscan') . ": " . $is_involved["psuserid"];
                    }
                    else if ($is_involved["result"] == -2){    
                        $error_msg .= " " . get_string('error_assignment_or_owner_does_not_exist_or_belong', 'plagiarism_plagscan') . ".";
                        $error_msg .= " " . get_string('plagscan_user_id', 'plagiarism_plagscan') . ": " . $assign_psownerid;
                    }
                    else{
                        $error_msg .= " " . get_string('plagscan_user_id', 'plagiarism_plagscan') . ": " . $is_involved["psuserid"];
                    }
                    $error_msg .= " " . get_string('plagscan_assingment_id', 'plagiarism_plagscan') . ": " . $instanceconfig->submissionid;
                    \core\notification::add("PlagScan: ".$error_msg, \core\output\notification::NOTIFY_ERROR);
                }
            }
        }

        $result = '';
        if ($is_file || ($is_content && $instanceconfig->enable_online_text == 1)) {
            
            static $ps_red_level, $ps_yellow_level;
            if ($ps_red_level[$cmid][$USER->id] == null && $ps_yellow_level[$cmid][$USER->id] == null) {
                try {
                    if ($instanceconfig->nondisclosure == 1) {
                        $connection->enable_nondisclosure();
                    }
                    $data = (array) $connection->get_user_settings($assign_owner);
                    if(isset($data['redLevel']))
                        $ps_red_level[$cmid][$USER->id] = $data['redLevel'];
                    else
                        $ps_red_level[$cmid][$USER->id] = 50;
                    if(isset($data['yellowLevel']))
                        $ps_yellow_level[$cmid][$USER->id] = $data['yellowLevel'];
                    else
                        $ps_yellow_level[$cmid][$USER->id] = 10;
                } catch (moodle_exception $exce) {
                    return get_string('connectionfailed', 'plagiarism_plagscan');
                }
            }

            $pageurl = $PAGE->url;
            $pagination = optional_param('page', -1, PARAM_INT);
            
            if($pagination != -1){
                $pageurl->param('page', $pagination);
            }
            
            // Hack to fix the missing 'userid' when marking a single submission
            $test = $pageurl->out_omit_querystring();
            $cmp = '/mod/assignment/submissions.php';
            if (substr_compare($test, $cmp, -strlen($cmp)) == 0) {
                $params = $pageurl->params();
                if (array_key_exists('mode', $params)) {
                    if ($params['mode'] == 'single') {
                        if (!array_key_exists('userid', $params)) {
                            $pageurl->param('userid', optional_param('userid', 0, PARAM_INT));
                        }
                        if (!array_key_exists('offset', $params)) {
                            $pageurl->param('offset', optional_param('offset', 0, PARAM_INT));
                        }
                        if (!array_key_exists('filter', $params)) {
                            $pageurl->param('filter', optional_param('filter', 0, PARAM_INT));
                        }
                    }
                }
            }

            static $ajaxenabled;
            if (!isset($ajaxenabled[$cmid])) {
                $jsmodule = array(
                    'name' => 'plagiarism_plagscan',
                    'fullpath' => '/plagiarism/plagscan/ajax.js',
                    'requires' => array('json'),
                );
                $PAGE->requires->js_init_call('M.plagiarism_plagscan.init', array($context->instanceid, $viewlinksb, $showlinks, $viewreport, $ps_yellow_level[$cmid][$USER->id], $ps_red_level[$cmid][$USER->id], urlencode($pageurl)), true, $jsmodule);
                //$this->page->requires->yui_module('moodle-local_pluginname-modulename', 'M.local_pluginname.init_modulename',
                //array(array('aparam'=>'paramvalue')));
                $ajaxenabled[$cmid] = true;
            }
            
            //Create output for each file
            $message = html_writer::empty_tag('br') .
                    html_writer::tag('img', "", array('src' => new moodle_url('/plagiarism/plagscan/images/plagscan_icon.png'),
                        'width' => '25px', 'height' => '24px'));
            $message .= $connection->get_message_view_from_linkarray($linkarray, $context, $viewlinksb, $showlinks, $viewreport, $ps_yellow_level[$cmid][$USER->id] , $ps_red_level[$cmid][$USER->id], $pageurl);

            //END create message

            if ($viewreport || $viewlinksb || has_capability('plagiarism/plagscan:viewfullreport', $context)) {
                $result = ' ' . $message;
            }
        }
        //END create submit


        return $result;
    }

    /**
     * hook to allow status of submitted files to be updated - called on grading/report pages.
     *
     * @param object $course - full Course object
     * @param object $cm - full cm object
     */
    public function update_status($course, $cm) {
        global $PAGE, $DB;

        //called at top of submissions/grading pages - allows printing of admin style links or updating status
        $run = plagscan_get_instance_config($cm->id);

        if ($run->upload == self::RUN_NO) {
            return '';
        }

        $output = '';
//$DB->set_debug(true);
        if ($run->upload == self::RUN_AUTO) {
            $modinfo = get_fast_modinfo($course);
            $cminfo = $modinfo->get_cm($cm->id);
            if ($cminfo->modname != 'assignment' && $cminfo->modname != 'assign') {
                // Not an assignment - auto submission to plagscan will not work
                $output .= get_string('onlyassignmentwarning', 'plagiarism_plagscan');
            } else {
                if ($cminfo->modname == 'assignment') {
                    $timedue = $DB->get_field('assignment', 'timedue', array('id' => $cm->instance));
                } else {
                    $timedue = $DB->get_field('assign', 'duedate', array('id' => $cm->instance));
                }
                if (!$timedue) {
                    // No deadline set - auto submission will never happen
                    $output .= get_string('nodeadlinewarning', 'plagiarism_plagscan');
                } else {
                    if ($timedue < $run->complete) {
                        $output .= get_string('autodescriptionsubmitted', 'plagiarism_plagscan', userdate($run->complete, get_string('strftimedatetimeshort')));
                    } else {
                        $output .= get_string('autodescription', 'plagiarism_plagscan');
                    }
                }
            }
            $output .= '<br/>';
        }
        //  print_r($cm->id); = 37
        //    $filearray = $this->get_links($linkarray->file);
        //     $contentarray = $this->get_links($linkarray->content);
        //$checkallfilestatus = new moodle_url('/plagiarism/plagscan/classes/file_submission/check_filestatus.php', array('cmid' => $cm->id,'return' => urlencode($PAGE->url)));
        //$output .= html_writer::link($checkallfilestatus, get_string('checkallfilestatus', 'plagiarism_plagscan'));
        //$output .= html_writer::empty_tag('br');
        //$checkalltextstatus = new moodle_url('/plagiarism/plagscan/classes/content_submission/check_contentstatus.php', array('cmid' => $cm->id,'return' => urlencode($PAGE->url)));
        //$output .= html_writer::link($checkalltextstatus, get_string('checkalltextstatus', 'plagiarism_plagscan'));


        return $output;
    }

    /*
      public function set_content($linkarray, $cm) {

      $onlinetextdata = $this->get_onlinetext($linkarray["userid"], $cm);
      return (empty($onlinetextdata->onlinetext)) ? '' : $onlinetextdata->onlinetext;
      }

      public function get_onlinetext($userid, $cm) {
      global $DB;
      // Get latest text content submitted as we do not have submission id.
      $submissions = $DB->get_records_select('assign_submission', ' userid = ? AND assignment = ? ',
      array($userid, $cm->instance), 'id DESC', 'id', 0, 1);
      $submission = end($submissions);
      $moodletextsubmission = $DB->get_record('assignsubmission_onlinetext',
      array('submission' => $submission->id), 'onlinetext, onlineformat');
      $onlinetextdata = new \stdClass();
      $onlinetextdata->itemid = $submission->id;
      $onlinetextdata->onlinetext = $moodletextsubmission->onlinetext;
      $onlinetextdata->onlineformat = $moodletextsubmission->onlineformat;
      return $onlinetextdata;
      } */
}

function plagscan_set_instance_config($cmid, $data) {
    global $DB;

    $current = $DB->get_record('plagiarism_plagscan_config', array('cm' => $cmid));
    if ($current) {
        $data->id = $current->id;
        $DB->update_record('plagiarism_plagscan_config', $data);
    } else {
        $data->cm = $cmid;
        $DB->insert_record('plagiarism_plagscan_config', $data);
    }
}

function plagscan_get_instance_config($cmid, $defaultconfig = true) {
    global $DB;

    if ($config = $DB->get_record('plagiarism_plagscan_config', array('cm' => $cmid))) {
        return $config;
    }

    $default = new \stdClass();
    if ($defaultconfig) {
        $default->upload = plagiarism_plugin_plagscan::RUN_NO;
        $default->complete = 0;
        $default->username = '';
        $default->show_report_to_students = plagiarism_plugin_plagscan::SHOWSTUDENTS_NEVER;
        $default->show_students_links = plagiarism_plugin_plagscan::SHOWS_ONLY_PLVL;
    }

    return $default;
}

function plagscan_user_opted_out($userid) {
    static $enabled = null;
    static $optout = array();

    if (is_null($enabled)) {
        $enabled = get_config('plagiarism_plagscan', 'plagscan_studentpermission');
    }
    if (!$enabled) {
        return false;
    }
    if (!isset($optout[$userid])) {
        $optout[$userid] = get_user_preferences('plagiarism_plagscan_optout', false, $userid);
    }

    return $optout[$userid];
}
