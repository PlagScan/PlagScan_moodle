<?php

// This file is part of Moodle - http://moodle.org/
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
 * plagscan_setting_form.php - shows the settings elements
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo <rolmedo@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\classes;

use moodleform;
use moodle_url;
use html_writer;

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.
}

require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

class plagscan_settings_form extends moodleform {

    /**
     * Defines the settings form
     */
    function definition() {
        global $CFG;

        $mform = & $this->_form;

        //initial variables
        $languageoptions = array(0 => get_string('english', 'plagiarism_plagscan'), 1 => get_string('german', 'plagiarism_plagscan'), 2 => get_string('spanish', 'plagiarism_plagscan'), 3 => get_string('french', 'plagiarism_plagscan'));
        $emailoptions = array(0 => get_string('email_policy_never', 'plagiarism_plagscan'), 1 => get_string('email_policy_always', 'plagiarism_plagscan'), 2 => get_string('email_policy_ifred', 'plagiarism_plagscan'));
        $dataoptions = array(0 => get_string('noone', 'plagiarism_plagscan'), 1 => get_string('noonedocs', 'plagiarism_plagscan'), 2 => get_string('myinstitution', 'plagiarism_plagscan'), 3 => get_string('generaldatabase', 'plagiarism_plagscan'));
        $autostartoptions = array(0 => get_string('no'), 1 => get_string('yes'));
        $autodel = array(0 => get_string('week', 'plagiarism_plagscan'), 1 => get_string('weeks', 'plagiarism_plagscan'), 2 => get_string('months', 'plagiarism_plagscan'), 3 => get_string('neverdelete', 'plagiarism_plagscan'));
        $docx = array(0 => get_string('docxemail', 'plagiarism_plagscan'),
            1 => get_string('docxgenerate', 'plagiarism_plagscan'),
            2 => get_string('docxnone', 'plagiarism_plagscan'));
        $accountsopts = array(0 => get_string('singleaccount', 'plagiarism_plagscan'),
            1 => get_string('individualaccounts', 'plagiarism_plagscan'));

        //build form
        $mform->addElement('html', "<div style='margin-left: 10%;margin-right: 30%;'><img style='margin-left:32%;' src='images/logo-new.png'/> <br /><div style='margin-left: 15%;'>" . get_string('plagscanexplain', 'plagiarism_plagscan') . "</div><br />");

        $callback_working = get_config('plagiarism_plagscan', 'plagscan_callbackworking');

        $url = new moodle_url('/plagiarism/plagscan/check_callback.php');

        if ($callback_working == 1) {
            $mform->addElement('html', "<div style='margin-left:0%;color:green;text-align: center;'>" . get_string("callback_working", "plagiarism_plagscan") . "</div><br/>");
        } else {
            $mform->addElement('html', "<div style='margin-left:0%;color:red;text-align: center;'>" . get_string("callback_notchecked", "plagiarism_plagscan") . " " . html_writer::link($url, get_string('callback_check', 'plagiarism_plagscan')) . " <br/> " . get_string('callback_help', 'plagiarism_plagscan') . "</div><br/>");
        }

        $mform->addElement('html', "<div>");

        $mform->addElement('checkbox', 'plagscan_use', get_string('useplagscan', 'plagiarism_plagscan'));

        //$mform->addElement('text', 'plagscan_version', get_string('plagscan_API_version', 'plagiarism_plagscan'), array('style' => 'height: 33px'));
        //$mform->addHelpButton('plagscan_version', 'plagscan_API_version', 'plagiarism_plagscan');
        //$mform->setDefault('plagscan_version', '3.0');
        //$mform->addRule('plagscan_version', null, 'required', null, 'client');
        //$mform->setType('plagscan_version', PARAM_TEXT);

        $mform->addElement('text', 'plagscan_id', get_string('plagscan_client_id', 'plagiarism_plagscan'), array('style' => 'height: 33px'));
        $mform->addRule('plagscan_id', null, 'required', null, 'client');
        $mform->setType('plagscan_id', PARAM_TEXT);

        $mform->addElement('text', 'plagscan_key', get_string('plagscan_API_key', 'plagiarism_plagscan'), array('size' => '40', 'style' => 'height: 33px'));
        $mform->addHelpButton('plagscan_key', 'plagscan_API_key', 'plagiarism_plagscan');
        $mform->addRule('plagscan_key', null, 'required', null, 'client');
        $mform->setType('plagscan_key', PARAM_TEXT);

        $mform->addElement('select', 'plagscan_language', get_string("api_language", "plagiarism_plagscan"), $languageoptions);
        $mform->addHelpButton('plagscan_language', 'api_language', 'plagiarism_plagscan');
        $mform->setDefault('plagscan_language', '0');

        $mform->addElement('select', 'plagscan_email_policy', get_string("email_policy", "plagiarism_plagscan"), $emailoptions);
        $mform->setDefault('plagscan_email_policy', '0');

        /* $mform->addElement('select', 'plagscan_data_policy', get_string("data_policy", "plagiarism_plagscan"), $dataoptions);
          $mform->disabledIf('plagscan_data_policy', 'plagscan_use', 'eq', 0);
          $mform->addHelpButton('plagscan_data_policy', 'datapolicyhelp', 'plagiarism_plagscan'); */


        $mform->addElement('checkbox', 'plagscan_web', get_string("plagscan_web_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_own_workspace', get_string("plagscan_own_workspace_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_own_repository', get_string("plagscan_own_repository_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_orga_repository', get_string("plagscan_orga_repository_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_plagiarism_prevention_pool', get_string("plagscan_ppp_policy", "plagiarism_plagscan"));


        $mform->addElement('selectyesno', 'plagscan_studentpermission', get_string('plagscan_studentpermission', 'plagiarism_plagscan'), 0);

        $mform->addElement('textarea', 'plagscan_student_disclosure', get_string('studentdisclosure', 'plagiarism_plagscan'), 'wrap="virtual" rows="6" cols="50"');
        $mform->addHelpButton('plagscan_student_disclosure', 'studentdisclosure', 'plagiarism_plagscan');
        $mform->setDefault('plagscan_student_disclosure', get_string('studentdisclosuredefault', 'plagiarism_plagscan'));

        $mform->addElement('text', 'plagscan_groups', get_string('allowgroups', 'plagiarism_plagscan'), array('size' => '40', 'style' => 'height: 33px'));
        $mform->addHelpButton('plagscan_groups', 'allowgroups', 'plagiarism_plagscan');
        $mform->setType('plagscan_groups', PARAM_TEXT);

        $mform->addElement('text', 'plagscan_nondisclosure_notice_email', get_string('plagscan_nondisclosure_notice_email', 'plagiarism_plagscan'), array('style' => 'height: 33px', 'placeholder' => get_string('plagscan_nondisclosure_notice_email_desc', 'plagiarism_plagscan')));
        $mform->addHelpButton('plagscan_nondisclosure_notice_email', 'plagscan_nondisclosure_notice_email', 'plagiarism_plagscan');
        $mform->setType('plagscan_nondisclosure_notice_email', PARAM_TEXT);

        $mform->addElement('select', 'plagscan_autodel', get_string("autodel", "plagiarism_plagscan"), $autodel);
        $mform->setDefault('plagscan_autodel', '3');

        $mform->addElement('select', 'plagscan_docx', get_string('handledocx', 'plagiarism_plagscan'), $docx);
        $mform->setDefault('plagscan_docx', 0);

        $mform->addElement('select', 'plagscan_multipleaccounts', get_string('plagscan_multipleaccounts', 'plagiarism_plagscan'), $accountsopts, 0);
        $mform->setDefault('plagscan_multipleaccounts', 1);

        $mform->addElement('text', 'plagscan_admin_email', get_string('plagscan_admin_email', 'plagiarism_plagscan'), array('style' => 'height: 33px'));
        $mform->addHelpButton('plagscan_admin_email', 'plagscan_admin_email', 'plagiarism_plagscan');
        $mform->setType('plagscan_admin_email', PARAM_TEXT);
        $mform->disabledIf('plagscan_admin_email', 'plagscan_multipleaccounts', 'eq', 1);
        
        $mform->addElement('text', 'plagscan_server', get_string('plagscanserver', 'plagiarism_plagscan'), array('size' => '40', 'style' => 'height: 33px'));
        $mform->addHelpButton('plagscan_server', 'plagscanserver', 'plagiarism_plagscan');
        $mform->setDefault('plagscan_server', 'https://api.plagscan.com/v3');
        $mform->addRule('plagscan_server', null, 'required', null, 'client');
        $mform->setType('plagscan_server', PARAM_TEXT);
        
        $wipe_user_url = new moodle_url('/plagiarism/plagscan/wipe_plagscan_user_cache.php');
        $mform->addElement('html', html_writer::link($wipe_user_url, get_string('wipe_plagscan_user_cache_link', 'plagiarism_plagscan')) 
        . ' <a class="btn btn-link p-a-0" role="button" data-container="body" data-toggle="popover" data-placement="right"'
        . 'data-content="'.get_string('wipe_plagscan_user_cache_help', 'plagiarism_plagscan').'<div style=\'color:red;\'>'.get_string('wipe_plagscan_user_cache_alert', 'plagiarism_plagscan').'</div>" data-html="true" tabindex="0" data-trigger="focus">'
        . '<i class="icon fa fa-question-circle text-info fa-fw " aria-hidden="true" title="" aria-label=""></i>'
        . '</a><br/>');


        $mform->addElement('html', "</br></br>");
        $mform->addElement('header', 'plagscan_assignment_defaults', get_string('plagscan_assignment_defaults_header', 'plagiarism_plagscan'));
        $mform->addElement('html', get_string('plagscan_assignment_defaults_explain', 'plagiarism_plagscan') 
        . "<br /><br />");

            $showstudentsopt = array(\plagiarism_plugin_plagscan::SHOWSTUDENTS_NEVER => get_string('show_to_students_never', 'plagiarism_plagscan'),
                \plagiarism_plugin_plagscan::SHOWSTUDENTS_ALWAYS => get_string('show_to_students_always', 'plagiarism_plagscan'),
                \plagiarism_plugin_plagscan::SHOWSTUDENTS_ACTCLOSED => get_string('show_to_students_actclosed', 'plagiarism_plagscan'));

            $showstudentslinks = array(\plagiarism_plugin_plagscan::SHOWS_ONLY_PLVL => get_string('show_to_students_plvl', 'plagiarism_plagscan'),
                \plagiarism_plugin_plagscan::SHOWS_LINKS => get_string('show_to_students_links', 'plagiarism_plagscan'));

            $onlinetextsubmission = array(\plagiarism_plugin_plagscan::ONLINE_TEXT_NO => get_string('online_text_no', 'plagiarism_plagscan'),
                \plagiarism_plugin_plagscan::ONLINE_TEXT => get_string('online_text_yes', 'plagiarism_plagscan'));
            
            
            $mform->addElement('checkbox', 'plagscan_defaults_exclude_self_matches', get_string('exclude_self_matches', 'plagiarism_plagscan'));
            $mform->addHelpButton('plagscan_defaults_exclude_self_matches', 'exclude_self_matches', 'plagiarism_plagscan');

            $mform->addElement('checkbox', 'plagscan_defaults_exclude_from_repository', get_string('exclude_from_repository', 'plagiarism_plagscan'));
            $mform->addHelpButton('plagscan_defaults_exclude_from_repository', 'exclude_from_repository', 'plagiarism_plagscan');
        
            $mform->addElement('select', 'plagscan_defaults_online_text', get_string('online_submission', 'plagiarism_plagscan'), $onlinetextsubmission);
            $mform->addHelpButton('plagscan_defaults_online_text', 'online_submission', 'plagiarism_plagscan');
            
            $mform->addElement('select', 'plagscan_defaults_show_to_students', get_string("show_to_students", "plagiarism_plagscan"), $showstudentsopt);
            $mform->addHelpButton('plagscan_defaults_show_to_students', 'show_to_students', 'plagiarism_plagscan');
            $mform->setDefault('plagscan_defaults_show_to_students', \plagiarism_plugin_plagscan::SHOWSTUDENTS_NEVER);

            $mform->addElement('select', 'plagscan_defaults_show_students_links', get_string("show_to_students_opt2", "plagiarism_plagscan"), $showstudentslinks);
            $mform->addHelpButton('plagscan_defaults_show_students_links', 'show_to_students_opt2', 'plagiarism_plagscan');
            $mform->setDefault('plagscan_defaults_show_students_links', \plagiarism_plugin_plagscan::SHOWS_ONLY_PLVL);
            $mform->disabledIf('plagscan_defaults_show_students_links', 'plagscan_defaults_show_to_students', 'eq', 0);
            $mform->setExpanded('plagscan_assignment_defaults', false);
        
        $mform->addElement('html', "</div>");

        //$mform->addElement('button', 'plagscan_connectiontester', get_string('testconnection', 'plagiarism_plagscan'));


        /*
          $radioarray=array();
          $radioarray[] =& $mform->createElement('radio', 'share', '', "compare only with web" , 0, "");
          $radioarray[] =& $mform->createElement('radio', 'share', '', "compare to my documents", 1, "");
          $radioarray[] =& $mform->createElement('radio', 'share', '', "compare to my institution database", 2, "");
          $radioarray[] =& $mform->createElement('radio', 'share', '', "compare with general database", 3, "");
          $mform->addGroup($radioarray, 'compPoly', 'Compare With', array(' '), false);

          $mform->addElement('advcheckbox', 'web', "Data Policy", 'compare only with web', array('group' => 1), array(-1, 0));
          $mform->addElement('advcheckbox', 'documents', '', 'compare to my documents', array('group' => 1), array(-1, 1));
          $mform->addElement('advcheckbox', 'database', '', 'compare to my institution database', array('group' => 1), array(-1, 2));
          $mform->addElement('advcheckbox', 'generaldb', '', 'compare with general database', array('group' => 1), array(-1, 3));
          //$mform->addElement('text', 'plagscan_call_back_script', get_string('plagscan_call_back_script', 'plagiarism_plagscan'));

          $mform->addElement('text', 'plagscan_max_file_size', get_string('max_file_size', 'plagiarism_plagscan'));
          $mform->addHelpButton('plagscan_max_file_size', 'maxfilesize', 'plagiarism_plagscan');
          $mform->setDefault('plagscan_max_file_size', '1000000');
          $mform->addRule('plagscan_max_file_size', null, 'numeric', null, 'client');
         */

        $this->add_action_buttons(true);
        $mform->addElement('html', "</div>");
    }

}
