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

namespace plagiarism_plagscan\classes;

use html_writer;
use moodle_url;
use plagiarism_plagscan\classes\plagscan_api;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\event\user_creation_completed;
use plagiarism_plagscan\event\user_creation_started;
use plagiarism_plagscan\event\user_creation_failed;
use plagiarism_plagscan\event\user_search_started;
use plagiarism_plagscan\event\user_search_completed;

require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_api.php');

/**
 * plagscan_connection.php - Class that defines some of the functionalities of the PlagScan Plagiarism plugin
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo <rolmedo@plagscan.com>) 
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_connection {

    /**
     * SUBMIT_OK
     */
    const SUBMIT_OK = 0;

    /**
     * SUBMIT_UNSUPPORTED
     */
    const SUBMIT_UNSUPPORTED = 1;

    /**
     * SUBMIT_OPTOUT
     */
    const SUBMIT_OPTOUT = 2;

    /**
     * SUBMIT_FAILED_BY_CONNECTION
     */
    const SUBMIT_FAILED_BY_CONNECTION = 3;

    /**
     *  Defines the configuration of the module or assignment
     * 
     * @var array 
     */
    protected $config;

    /**
     * Username of the user using the plugin
     * 
     * @var string
     */
    protected $username = -1;

    /**
     *
     * @var bool
     */
    protected $nondisclosure = false;

    /**
     * Constructor of the plagscan_connection class
     * 
     * @param bool $notinstance
     */
    function __construct($notinstance = false) {
        $this->config = get_config('plagiarism_plagscan');
        if ($notinstance) {
            $this->username = false;
        }
    }

    /**
     * Returns an array with the mapped user settings for PlagScan
     * 
     * @return array
     */
    public function get_user_settings_mapping() {
        return array('plagscan_language' => 'language',
            'plagscan_email_policy' => 'emailPolicy',
            'plagscan_web' => 'checkWeb',
            'plagscan_own_workspace' => 'checkOwnWorkspace',
            'plagscan_own_repository' => 'checkOwnRepository',
            'plagscan_orga_repository' => 'checkOrgaRepository',
            'plagscan_plagiarism_prevention_pool' => 'checkPS',
            'plagscan_autodel' => 'cleanupPolicy',
            'plagscan_docx' => 'docxPolicy',
            'plagscan_ssty' => 'detailPolicy',
            'plagscan_red' => 'redLevel',
            'plagscan_yellow' => 'yellowLevel');
    }

    /**
     * Enables nondisclosure
     */
    public function enable_nondisclosure() {
        $this->nondisclosure = true;
    }

    /**
     * Set username
     * 
     * @param string $username
     */
    public function set_username($username) {
        $this->username = $username;
    }

    /**
     * Get username
     * 
     * @param bool $adminuser
     * @param string $originaluser
     * @param bool $tryfallback
     * @return string
     */
    protected function get_username($adminuser = false, $originaluser = '', $tryfallback = false) {
        if ($adminuser) {
            return $this->config->plagscan_admin_email; // Admin request - always send the admin user.
        }

        if (!empty($originaluser)) {
            return $originaluser; // File already has a user associated with it - use this.
        }

        if (empty($this->config->plagscan_multipleaccounts) && !$this->nondisclosure) {
            // Using the global user account.
            if (!$tryfallback) { // Fallback = try local account instead.
                return $this->config->plagscan_admin_email;
            }
        }

        // Check the local username is OK
        /* if ($this->username === -1) {
          throw new coding_exception("Must call 'set_username' if associated with a particular instance");
          } */

        if (empty($this->username)) {
            return $this->config->plagscan_admin_email; // No local username - just return the global account.
        }

        if (!$tryfallback || empty($this->config->plagscan_multipleaccounts)) {
            return $this->username; // Default for 'use local username' + fallback for 'use global account'
        } else {
            return $this->config->plagscan_admin_email; // Fallback for 'use local username'
        }
    }

    /**
     * Update the module config and status
     * 
     * @param int $cmid
     */
    public function update_module_status($cmid) {
        global $DB, $CFG;

        $files = $DB->get_records_select('plagiarism_plagscan', 'cmid = ? AND (status != ? OR pstatus IS null)', array($cmid, plagscan_file::STATUS_FINISHED));
        foreach ($files as $file) {
            plagscan_file::update_status($file);
        }
    }

    /**
     * Deletes the document already submitted and overwrites it for the new one.
     * 
     * @param int $pid
     * @return boolean
     */
    public function delete_submitted_file($pid) {

        $access_token = $this->get_access_token();
        $url = plagscan_api::API_FILES . "/$pid?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "DELETE", null);

        if ($res["httpcode"] != 204) {
            return false;
        }

        return true;
    }

    /**
     * Returns the PlagScan settings from the user
     * 
     * @param \stdClass $user
     * @return array
     */
    public function get_user_settings($user) {

        $psuserid = $this->find_user($user);

        $access_token = $this->get_access_token();

        $url = plagscan_api::API_USERS . "/$psuserid?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "PATCH", null);
        
        if (isset($res["response"]["data"])){        
            return $res["response"]["data"];
        }
        else {
            return null;
        }
    }

    /**
     * Sets the PlagScan settings from the user
     * 
     * @param int $user
     * @param array $settings
     * @return boolean
     */
    public function set_user_settings($user, $settings) {
        // Send the setting to the plagscan server

        $psuserid = $this->find_user($user);

        if ($psuserid == NULL) {
            $psuserid = $this->add_new_user($user);
        }

        $access_token = $this->get_access_token();

        $url = plagscan_api::API_USERS . "/$psuserid?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "PATCH", $settings, null, true);

        if ($res["httpcode"] != 200 || !isset($res["response"]["data"])) {
            return false;
        }


        return true;
    }

    /**
     *  Get an access token to make request to the API
     * 
     * @param int $psclient
     * @param string $pskey
     * @return string
     */
    function get_access_token($psclient = null, $pskey = null) {
        if ($psclient == null) {
            $psclient = get_config('plagiarism_plagscan', 'plagscan_id');
        }
        if ($pskey == null) {
            $pskey = get_config('plagiarism_plagscan', 'plagscan_key');
        }

        $data = ["client_id" => $psclient, "client_secret" => $pskey];
        $token = NULL;

        $res = plagscan_api::instance()->request(plagscan_api::API_TOKEN, "POST", $data);
        if (isset($res["response"]["access_token"])) {
            $token = $res["response"]["access_token"];
        }

        return $token;
    }

    /**
     * Submits a document into a PlagScan submission
     * 
     * @param array $filedata
     * @return int
     */
    function submit_into_submission($filedata) {
        $docid = -1;

        $access_token = $this->get_access_token();

        $submissionid = $filedata["submissionid"];

        $data = ["submissionID" => $submissionid,
            "ownerID" => $filedata["ownerid"],
            "submitterID" => $filedata["submitterid"],
            "title" => $filedata["filename"],
            "firstname" => $filedata["firstname"],
            "lastname" => $filedata["lastname"],
            "email" => $filedata["email"],
            "sendResults" => "0",
            "toRepository" => false];

        $files = array($filedata["file"]);


        $url = plagscan_api::API_SUBMISSIONS . "/" . $submissionid . "?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data, $files);

        if ($res["httpcode"] == 201) {
            $docid = $res["response"]["data"]["docID"];
        }
        else if ($res["httpcode"] >= 400) {
            $msg = $res["response"]["error"]["message"];
            if ($msg == plagscan_api::API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST) {
                $docid = -2;
            }
            else if ($msg == plagscan_api::API_ERROR_MSG_SUBMISSION_DOES_NOT_EXIST){
                $docid = -3;
            }
        }

        return $docid;
    }

    /**
     * Submits a single document into PlagScan
     * 
     * @param array $filedata
     * @return int
     */
    function submit_single_file($filedata) {
        $docid = -1;

        $access_token = $this->get_access_token();

        $data = ["userID" => $filedata["ownerid"],
            "toRepository" => false];


        $files = array($filedata["file"]);


        $url = plagscan_api::API_FILES . "?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data, $files);

        if ($res["httpcode"] == 201) {
            $docid = $res["response"]["data"]["docID"];
        }

        return $docid;
    }

    /**
     * Analyzes the document checking for plagiarism and generates the report
     * 
     * @param string $access_token
     * @param int $pid
     * @return string
     */
    function analyze($pid) {
        global $DB;

        $access_token = $this->get_access_token();

        $url = plagscan_api::API_FILES . "/" . $pid . "/check?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "PUT", null);

        $current = $DB->get_record('plagiarism_plagscan', array('pid' => $pid));
        if ($res["httpcode"] == 204) {
            $current->status = 1;
            $DB->update_record('plagiarism_plagscan', $current);
            return null;
        } else {
            plagscan_file::update_status($current);
            if (isset($res["response"]["error"])) {
                return $res["response"]["error"]["message"];
            } else {
                return $res["response"];
            }
        }
    }

    /**
     * Retrieves the plagiarism percentage result from the report
     * 
     * @param int $pid
     * @return int
     */
    function plaglevel_retrieve($pid) {

        $access_token = $this->get_access_token();

        $url = plagscan_api::API_FILES . "/$pid/retrieve?access_token=$access_token&mode=0";

        $res = plagscan_api::instance()->request($url, "GET", null);

        return $res;
    }

    /**
     * Retrieves the link to access to the report 
     * 
     * @param int $pid
     * @param \stdClass $psuserid
     * @param int $mode
     * @return array
     */
    function report_retrieve($pid, $psuserid, $mode) {
        $access_token = $this->get_access_token();

        $url = plagscan_api::API_FILES . "/$pid/retrieve?mode=" . $mode . "&access_token=$access_token";

        if ($mode == 10) {
            $url .= "&userID=" . $psuserid;
        }

        $res = plagscan_api::instance()->request($url, "GET", null);

        if ($res["httpcode"] != 200) {
            if (isset($res["response"]["error"])) {
                return $res["response"]["error"];
            } else {
                return null;
            }
        } else {
            return $res["response"]["data"];
        }
    }

    /**
     * Creates the submission on PlagScan
     * 
     * @param int $cmid
     * @param \stdClass $module
     * @param \stdClass $config
     * @param \stdClass $user
     * @return int
     */
    function create_submissionid($cmid, $module, $config, $user) {
        global $DB, $CFG;
        //733-745lines are repeated from function get_links()     
        $modulesql = 'SELECT m.id, m.name, cm.instance' .
                ' FROM {course_modules} cm' .
                ' INNER JOIN {modules} m on cm.module = m.id ' .
                'WHERE cm.id = ?';
        $moduledetail = $DB->get_record_sql($modulesql, array($cmid));
        if (!empty($moduledetail)) {
            $sql = "SELECT * FROM " . $CFG->prefix . $moduledetail->name . " WHERE id= ?";
            $module = $DB->get_record_sql($sql, array($moduledetail->instance));
            // print_r($module);

            $data = $DB->get_record('plagiarism_plagscan_config', array('cm' => $cmid));
            //  print_r($data);
        }

        $psuserid = $this->find_user($user);
        if ($psuserid == null) {
            $psuserid = $this->add_new_user($user);
            if($psuserid == 0){
                return false;
            }
        }

        $title = $module->name;
        $maxuplaods = '100';
        $share = 1;
        $checkdeadline = 0;
        $enableresub = 1;
        $checkonupload = 0;
        $type = 1;

        //start manually   
        if ($config->upload == 1) {
            $checkdeadline = 0;
            $checkonupload = 0;
        }
        //start immediately
        else if ($config->upload == 3) {
            $checkonupload = 1;
        }


        $endtime = null;
        //start after due date
        if ($config->upload == 2 || $config->upload == 4) {
            $checkdeadline = 1;
            //check date
            if ($config->upload == 2 && $module->duedate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->duedate);
            } else if ($module->cutoffdate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->cutoffdate);
            } else if ($module->duedate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->duedate);
            }
        }

        $data = ["ownerID" => $psuserid,
            "title" => $title,
            "endTime" => "" . $endtime,
            "maxUploads" => $maxuplaods,
            "share" => $share,
            "checkDeadline" => $checkdeadline,
            "enableResubmission" => $enableresub,
            "checkOnUpload" => $checkonupload,
            "type" => $type,
            "excludeSelfMatches" => $config->exclude_self_matches,
            "excludeFromRepository" => $config->exclude_from_repository];


        $access_token = $this->get_access_token();

        $url = plagscan_api::API_SUBMISSIONS . "?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data);
        
        if (isset($res["response"]["data"]["submissionID"])){
            return $res["response"]["data"]["submissionID"];
        }
        else{
            if($res["httpcode"] >= 400 && isset($res["response"]["error"]["message"])){
                if($res["response"]["error"]["message"] == plagscan_api::API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST)
                    return -1;
            }
            return 0;
        }
    }

    /**
     * Updates the submission in PlagScan
     * 
     * @param int $cmid
     * @param \stdClass $module
     * @param \stdClass $config
     * @param int $assign_id
     * @param \stdClass $user
     * @return bool
     */
    function update_submission($cmid, $module, $config, $assign_id, $user) {
        global $DB, $CFG;
        //733-745lines are repeated from function get_links()     
        $modulesql = 'SELECT m.id, m.name, cm.instance' .
                ' FROM {course_modules} cm' .
                ' INNER JOIN {modules} m on cm.module = m.id ' .
                'WHERE cm.id = ?';
        $moduledetail = $DB->get_record_sql($modulesql, array($cmid));
        if (!empty($moduledetail)) {
            $sql = "SELECT * FROM " . $CFG->prefix . $moduledetail->name . " WHERE id= ?";
            $module = $DB->get_record_sql($sql, array($moduledetail->instance));
            // print_r($module);

            $data = $DB->get_record('plagiarism_plagscan_config', array('cm' => $cmid));
            //  print_r($data);
        }

        $psuserid = $this->find_user($user);

        $title = $module->name;
        $checkdeadline = 0;
        $enableresub = 1;
        $checkonupload = 0;

        //start manually   
        if ($config->upload == 1) {
            $checkdeadline = 0;
            $checkonupload = 0;
        }
        //start immediately
        else if ($config->upload == 3) {
            $checkonupload = 1;
        }


        $endtime = null;
        //start after due date
        if ($config->upload == 2 || $config->upload == 4) {
            $checkdeadline = 1;
            //check date
            if ($config->upload == 2 && $module->duedate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->duedate);
            } else if ($module->cutoffdate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->cutoffdate);
            } else if ($module->duedate > 0) {
                $endtime = date('d-m-Y H:i:s', $module->duedate);
            }
        }

        $data = ["ownerID" => $psuserid,
            "title" => $title,
            "endTime" => "" . $endtime,
            "checkDeadline" => $checkdeadline,
            "enableResubmission" => $enableresub,
            "checkOnUpload" => $checkonupload,
            "excludeSelfMatches" => $config->exclude_self_matches,
            "excludeFromRepository" => $config->exclude_from_repository];

        $access_token = $this->get_access_token();

        $url = plagscan_api::API_SUBMISSIONS . "/$assign_id?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "PATCH", $data, null, true);

        return true;
    }

    /**
     * Creates the user in PlagScan
     * 
     * @param \stdClass $user
     * @return int
     */
    function add_new_user($user) {
        global $DB;

        $access_token = $this->get_access_token();

        $userlog = array(
            'context' => \context_system::instance(),
            'userid' => $user->id
        );

        user_creation_started::create($userlog)->trigger();

        $data = ["email" => $user->email, "username" => $user->email, "firstname" => $user->firstname, "lastname" => $user->lastname];

        $url = plagscan_api::API_USERS . "?access_token=" . $access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data);

        $psid = 0;
        if (isset($res["response"]["data"]["userID"])) {
            $psid = intval($res["response"]["data"]["userID"]);
        }
        else { //In case it fails on the creation, try to create with a different username in PlagScan
            $data["username"] = get_config('plagiarism_plagscan', 'plagscan_id') . ":" . $user->email;
            $res = plagscan_api::instance()->request($url, "POST", $data);
            if (isset($res["response"]["data"]["userID"])) {
                $psid = intval($res["response"]["data"]["userID"]);
            }
        }

        
        if ($psid > 0) {
            $insert = new \stdClass();
            $insert->userid = $user->id;
            $insert->psuserid = $psid;

            $DB->insert_record('plagiarism_plagscan_user', $insert);
            $userlog['other']['psuserid'] = $psid;
            user_creation_completed::create($userlog)->trigger();
        }
        else {
            user_creation_failed::create($userlog)->trigger();
        }
        
        return $psid;
    }

    /**
     * Checks if the user exist already in PlagScan
     * 
     * @param \stdClass $user
     * @return int
     */
    function find_user($user) {
        global $DB;
        //First check if the user is registered in the Moodle DB with the PS id
        $psuser = $DB->get_record("plagiarism_plagscan_user", array("userid" => $user->id));
        $psuserid = null;

        if ($psuser) {
            $psuserid = $psuser->psuserid;
        } else {
            $access_token = $this->get_access_token();

            $userlog = array(
                'context' => \context_system::instance(),
                'userid' => $user->id
            );

            user_search_started::create($userlog)->trigger();

            $url = plagscan_api::API_USERS . "?access_token=$access_token&searchByEmail=$user->email";

            $res = plagscan_api::instance()->request($url, "GET", null);

            if (isset($res["response"]["data"]["userID"])) {
                $psuserid = $res["response"]["data"]["userID"];
            }

            if ($psuserid != null && intval($psuserid) > 0) {
                $insert = new \stdClass();
                $insert->userid = $user->id;
                $insert->psuserid = $psuserid;
                $DB->insert_record('plagiarism_plagscan_user', $insert);

                $userlog['other']['psuserid'] = $psuserid;
                user_search_completed::create($userlog)->trigger();
            }
        }

        return $psuserid;
    }

    /**
     * Check if the user is involved in the PlagScan submission
     * 
     * @param \stdClass $context
     * @param \stdClass $assignment
     * @param \stdClass $user
     * @return boolean
     */
    public function is_assistant($context, $assignment, $user) {
        $is_assistant = false;

        if (has_capability('plagiarism/plagscan:control', $context) && $user->id != $assignment->ownerid) {
            $is_assistant = true;
        }

        return $is_assistant;
    }

    /**
     * Involves the user in the PlagScan submission
     * 
     * @param \stdClass $assign
     * @param int $assign_psownerid
     * @param \stdClass $involved_user
     * @return array
     */
    public function involve_assistant($assign, $assign_psownerid, $involved_user) {
        $access_token = $this->get_access_token();

        $involved_psuserid = $this->find_user($involved_user);

        $involved = array( 
            "psuserid" => 0,
            "result" => 0 );

        if ($involved_psuserid == null) {
            $involved_psuserid = $this->add_new_user($involved_user);
        }
        
        if ($involved_psuserid == 0){
            return $involved;
        }
        else {
            $involved["psuserid"] = $involved_psuserid;
        }

        $url = plagscan_api::API_SUBMISSIONS . "/$assign->submissionid/involve?userID=$involved_psuserid&ownerID=$assign_psownerid&shareMode=4&access_token=" . $access_token;
        
        $res = plagscan_api::instance()->request($url, "GET", null);

        if(isset( $res["response"]["data"]["involved"])){
            $is_involved = $res["response"]["data"]["involved"];

            if (!$is_involved) {
                $res = plagscan_api::instance()->request($url, "PUT", null);
                if ($res["httpcode"] == 204){
                    $involved["result"] = 1;
                }
            }
            else{
                $involved["result"] = 1;
            }
        }
        
        if($res["httpcode"] >= 400 && isset($res["response"]["error"]["message"])){
            $error = $res["response"]["error"]["message"];
            if ($error == plagscan_api::API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST){
                $involved["result"] = -1;
            }
            else if ($error == plagscan_api::API_ERROR_MSG_SUBMISSION_DOES_NOT_EXIST){
                $involved["result"] = -2;
            }
        }

        return $involved;
    }

    /**
     * Send a request to check the callback configuration from the PlagScan admin account
     */
    public function check_callback_config() {
        $access_token = $this->get_access_token();

        $url = plagscan_api::API_CHECK_CALLBACK . "?access_token=$access_token";

        return plagscan_api::instance()->request($url, "PUT", null);
    }
    
    /**
     * Send a request to check the connection is with the PlagScan API
     */
    public function check_connection_to_plagscan_server(){
        $url = "/ping";
        
        return plagscan_api::instance()->request($url, "GET", null);
    }

    /**
     * Check the status of the files from an array of PlagScan file ids. It returns an array with one pair, file id and message/content
     * 
     * @param array $psfiles
     * @param \stdClass
     * @return array
     */
    public function check_report_status($psfiles, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, $pageurl = null) {

        $psfiles = plagscan_file::find_by_psids($psfiles);

        $results = array();

        foreach ($psfiles as $psfile) {
            $message = $this->get_message_view_from_report_status($psfile, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, null, $pageurl);
            if ($message != "") {
                array_push($results, array("id" => $psfile->id, "content" => $message));
            }
        }
        return $results;
    }
    
    /**
     * Return a message in html format to show inside the moodle interface from a linkarray
     * 
     * @global stdClass $PAGE
     * @param array $linkarray
     * @param context $context
     * @param boolean $viewlinks
     * @param boolean $showlinks
     * @param boolean $viewreport
     * @param int $ps_yellow_level
     * @param int $ps_red_level
     * @return String
     */
    public function get_message_view_from_linkarray($linkarray, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, $pageurl = null){
        global $PAGE;
        
        if($pageurl == null){
            $pageurl = $PAGE->url;
        }
        
        $userid = $linkarray['userid'];
        $cmid = $linkarray['cmid'];
        $is_file = isset($linkarray['file']);
        $is_content = isset($linkarray['content']);
        
        if ($is_file) {
            $file = $linkarray['file'];
            $filehash = $file->get_pathnamehash();
        } else if ($is_content) {
//            $filehash = sha1($linkarray['content']);
            $assign = new \assign($context, false, false);
            $user_submission = $assign->get_user_submission($userid,false);
            $files = get_file_storage()->get_area_files($context->id,
            'plagiarism_plagscan', 'assign_submission', $user_submission->id, null, false
            );
            $file = array_shift($files);
            $filehash = $file->get_pathnamehash();
        }
        
        if (plagscan_user_opted_out($userid)) {
            return get_string('useroptedout', 'plagiarism_plagscan');
        }

        // Find the plagscan entry for this file
        $psfile = plagscan_file::find($cmid, $userid, $filehash);
        
        if(!$psfile && $is_file){
            $psfile = plagscan_file::find($cmid, $userid, $file->get_contenthash());
        }
        
        //create $message 
        if (!$psfile) {
            $message = get_string('notsubmitted', 'plagiarism_plagscan');
            if ($viewlinks) {
                if($is_file){
                    $message .= html_writer::empty_tag('br');
                    $params = array('cmid' => s($cmid), 
                        'userid' => s($userid), 
                        'return' => urlencode($pageurl),
                        'pathnamehash' => s($file->get_pathnamehash()));

                    $submiturl = new moodle_url('/plagiarism/plagscan/reports/submit.php', $params);
                    $message .= html_writer::link($submiturl, get_string('submit', 'plagiarism_plagscan'));
                    $message .= html_writer::empty_tag('br');
                }
            }
        } else {
            $message = $this->get_message_view_from_report_status($psfile, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, $linkarray, $pageurl);
        }
        
        return $message;
    }

    /**
     * Return a message in html format to show inside the moodle interface from a PlagScan file
     * 
     * @global \plagiarism_plagscan\classes\stdClass $PAGE
     * @param stdClass $psfile
     * @param stdClass $linkarray
     * @param context $context
     * @param boolean $viewlinks
     * @param boolean $showlinks
     * @param bolean $viewreport
     * @param int $ps_yellow_level
     * @param int $ps_red_level
     * @return string
     */
    public function get_message_view_from_report_status($psfile, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, $linkarray = null, $pageurl = null) {
        global $PAGE;
        
        if($pageurl == null){
            $pageurl = $PAGE->url;
        }
        
        $message = "";
        
        $message .= "<div class='psreport pid-" . s($psfile->id) . "'>";

        if ($psfile->status >= plagscan_file::STATUS_FAILED) {
            if ($psfile->status == plagscan_file::STATUS_FAILED_FILETYPE) {
                $message .= get_string('unsupportedfiletype', 'plagiarism_plagscan');
            } elseif ($psfile->status == plagscan_file::STATUS_FAILED_OPTOUT) {
                $message .= get_string('wasoptedout', 'plagiarism_plagscan');
            } else if ($psfile->status == plagscan_file::STATUS_FAILED_CONNECTION) {
                $message .= get_string('serverconnectionproblem', 'plagiarism_plagscan');
            } else if ($psfile->status == plagscan_file::STATUS_FAILED_USER_CREATION) {
                $message .= get_string('error_submit', 'plagiarism_plagscan');
                $message .= html_writer::tag('i', '', array('title' => get_string('error_user_creation','plagiarism_plagscan'),
                    'class' => 'fa fa-exclamation-triangle', 'style' => 'color:#f0ad4e'));
            } else if ($psfile->status == plagscan_file::STATUS_FAILED_USER_DOES_NOT_BELONG_TO_THE_INSTITUTION) {
                $message .= get_string('error_submit', 'plagiarism_plagscan');
                $message .= html_writer::tag('i', '', array('title' => get_string('error_user_does_not_belong_to_the_institution','plagiarism_plagscan'),
                    'class' => 'fa fa-exclamation-triangle', 'style' => 'color:#f0ad4e'));
            } else if ($psfile->status == plagscan_file::STATUS_FAILED_DOCUMENT_DOES_NOT_BELONG_TO_THE_INSTITUTION) {
                $message .= get_string('error_refresh_status', 'plagiarism_plagscan');
                $message .= html_writer::tag('i', '', array('title' => get_string('error_document_does_not_belong_to_the_institution','plagiarism_plagscan'),
                    'class' => 'fa fa-exclamation-triangle', 'style' => 'color:#f0ad4e'));
            } else if ($psfile->status == plagscan_file::STATUS_FAILED_ASSIGN_OR_OWNER_DOES_NOT_EXIST_OR_BELONG){
                $message .= get_string('error_submit', 'plagiarism_plagscan');
                $message .= html_writer::tag('i', '', array('title' => get_string('error_assignment_or_owner_does_not_exist_or_belong','plagiarism_plagscan'),
                    'class' => 'fa fa-exclamation-triangle', 'style' => 'color:#f0ad4e'));
            } else { // STATUS_FAILED_UNKNOWN
                $message .= get_string('serverrejected', 'plagiarism_plagscan');
            }

            if ($viewlinks) {
                if(isset($linkarray['file'])){
                    $message .= html_writer::empty_tag('br');
                    $params = array('cmid' => s($linkarray['cmid']), 
                        'userid' => s($linkarray['userid']), 
                        'return' => urlencode($pageurl),
                        'pathnamehash' => s($linkarray['file']->get_pathnamehash()));

                    $submiturl = new moodle_url('/plagiarism/plagscan/reports/submit.php', $params);
                    $message .= html_writer::link($submiturl, get_string('resubmit', 'plagiarism_plagscan'));
                    $message .= html_writer::empty_tag('br');
                }
            }

        } else if ($psfile->status != plagscan_file::STATUS_FINISHED) {

            if ($psfile->status == plagscan_file::STATUS_SUBMITTING || $psfile->status == plagscan_file::STATUS_CHECKING || $psfile->status == plagscan_file::STATUS_ONGOING || $psfile->status == plagscan_file::STATUS_QUEUED) {
                if ($viewreport || $viewlinks) {
                    $message .= "<span class='psfile_progress'>";
                    if ($psfile->status == plagscan_file::STATUS_SUBMITTING) {
                        $message .= get_string('process_uploading', 'plagiarism_plagscan');
                    } else {
                        $message .= get_string('process_checking', 'plagiarism_plagscan');
                    }
                    $message .= "<label style='background-image:url(" . new moodle_url('/plagiarism/plagscan/images/loader.gif') . ");width: 16px;height: 16px;'></label>";
                    $message .= html_writer::empty_tag('br');
                    $message .= "</span>";
                }
            } else {
                $message .= get_string('notprocessed', 'plagiarism_plagscan');


                if ($viewlinks) {
                    //  $message .= html_writer::empty_tag('br');
                    //$message .= ' '.html_writer::link($checkurl, get_string('checkstatus', 'plagiarism_plagscan')); if($psfile->pstatus == -2)
                    if($psfile->pstatus == -2)
                        $message.=html_writer::tag('i', '', array('title' => get_string('report_check_error_cred','plagiarism_plagscan'), 
                    'class' => 'fa fa-exclamation-triangle', 'style' => 'color:#f0ad4e'));
                    $message .= html_writer::empty_tag('br');
                    $submiturl = new moodle_url('/plagiarism/plagscan/reports/analyze.php', array('pid' => s($psfile->pid),
                        'return' => urlencode($pageurl)));
                    $message .= html_writer::link($submiturl, get_string('check', 'plagiarism_plagscan'));

                    $message .= html_writer::empty_tag('br');
                }
            }

            if ($psfile->pid > 0) {
                $checkurl = new moodle_url('/plagiarism/plagscan/reports/check_status.php', array('pid' => s($psfile->pid), 'return' => urlencode($pageurl)));
                if ($viewlinks) {
                    $message .= ' ' . html_writer::link($checkurl, get_string('checkstatus', 'plagiarism_plagscan'));
                }
            }
        } else {
            $percent = '';
            if (!is_null($psfile->pstatus)) {
                $percentclass = 'plagscan_good';
                if ($psfile->pstatus > ($ps_red_level / 10)) {
                    $percentclass = 'plagscan_bad';
                } else if ($psfile->pstatus > ($ps_yellow_level / 10)) {
                    $percentclass = 'plagscan_warning';
                }
                // $percent = html_writer::tag('span', sprintf('%0.1f%%', $psfile->pstatus), array('class' => $percentclass));
            }
            $psurl = new moodle_url('/plagiarism/plagscan/reports/view.php', array('pid' => s($psfile->pid), 'return' => urlencode($pageurl)));
            $pslink = html_writer::link($psurl, html_writer::tag('span', sprintf('%0.1f%%', $psfile->pstatus), array('id' => s($psfile->pid), 'class' => $percentclass)), array('target' => '_blank'));
            $pslink .= "<div style='    margin-left: -8px;'></div>";

            if (($viewlinks || has_capability('plagiarism/plagscan:viewfullreport', $context))) {
                $message .= $pslink;
            } else {
                if (!$showlinks) {
                    $message .= html_writer::tag('span', sprintf('%0.1f%%', s($psfile->pstatus)), array('class' => $percentclass));
                } else {
                    $message .= $pslink;
                }
            }
            $message .= html_writer::empty_tag('br');
        }
        $message .="</div>";


        return $message;
    }

}
