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

require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_api.php');

/**
* plagscan_connection.php - Class that defines some of the functionalities of the PlagScan Plagiarism plugin
*
* @package      plagiarism_plagscan
* @subpackage   plagiarism
* @author       Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo <rolmedo@plagscan.com>) 
* @copyright    2016 PlagScan GmbH {@link https://www.plagscan.com/}
* @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
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
        return array('plagscan_language' => 'lang',
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
            return $this->config->plagscan_username; // Admin request - always send the admin user.
        }

        if (!empty($originaluser)) {
            return $originaluser; // File already has a user associated with it - use this.
        }

        if (empty($this->config->plagscan_multipleaccounts) && !$this->nondisclosure) {
            // Using the global user account.
            if (!$tryfallback) { // Fallback = try local account instead.
                return $this->config->plagscan_username;
            }
        }

        // Check the local username is OK
        /*if ($this->username === -1) {
            throw new coding_exception("Must call 'set_username' if associated with a particular instance");
        }*/

        if (empty($this->username)) {
            return $this->config->plagscan_username; // No local username - just return the global account.
        }

        if (!$tryfallback || empty($this->config->plagscan_multipleaccounts)) {
            return $this->username; // Default for 'use local username' + fallback for 'use global account'
        } else {
            return $this->config->plagscan_username; // Fallback for 'use local username'
        }
    }

    /**
     * Update the module config and status
     * 
     * @param int $cmid
     */
    public function update_module_status($cmid) {
        global $DB,$CFG;
        require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_file.php');
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
        $url = plagscan_api::API_FILES."/$pid?access_token=".$access_token;
        
        $res = plagscan_api::instance()->request($url, "DELETE", null);

        if($res["httpcode"] != 204)
            return false;

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
	
        $url = plagscan_api::API_USERS."/$psuserid?access_token=".$access_token;
            
        $res = plagscan_api::instance()->request($url, "PATCH", null);

        return $res["response"]["data"];
    }

    /**
     * Sets the PlagScan settings from the user
     * 
     * @param int $user
     * @param array $settings
     * @return boolean
     */
  public function set_user_settings($user,$settings) {
        // Send the setting to the plagscan server
      
        $psuserid = $this->find_user($user);
        
        $access_token = $this->get_access_token();
        
        $url = plagscan_api::APIUSERS."/$psuserid?access_token=".$access_token;
        
	$res = plagscan_api::instance()->request($url, "PATCH", $settings, null, true);
                
        if($res["httpcode"] != 200 || !isset($res["response"]["data"]))
            return false;
        
        
        return true;
    } 

    /**
     * Get an access token to make request to the API
     * 
     * @return string
     */
    function get_access_token(){
        $data = ["client_id" => $this->config->plagscan_id, "client_secret" => $this->config->plagscan_key]; 
            
        $res = plagscan_api::instance()->request(plagscan_api::API_TOKEN, "POST", $data);
        
        return $res["response"]["access_token"];
    }
    
    /**
     * Submits a document into a PlagScan submission
     * 
     * @param array $filedata
     * @param array $submissionType
     * @return int
     */
    function submit_into_submission($filedata, $submissionType) {
        $docid = -1;
        
        $access_token= $this->get_access_token();
      
        $submissionid = $filedata["submissionid"];

        $data= ["submissionID" => $submissionid,
                        "ownerID" => $filedata["ownerid"],
                        "submitterID" => $filedata["submitterid"],
                        "title" => $filedata["filename"], 
                        "firstname" => $filedata["firstname"], 
                        "lastname" => $filedata["lastname"], 
                        "email" => $filedata["email"],
                        "sendResults" => "0",
                        "toRepository" => false];

        if($submissionType == 1){
            $files = array($filedata["file"]);
        }
        else{
            $data["textname"] = $filedata["filename"];
            $data["textdata"] = $filedata["content"];
            $files = null;
        }

        $url = plagscan_api::API_SUBMISSIONS."/".$submissionid."?access_token=".$access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data, $files);
        
        if($res["httpcode"] == 201)
            $docid = $res["response"]["data"]["docID"];
        
        return $docid;
    }
    
    /**
     * Submits a single document into PlagScan
     * 
     * @param array $filedata
     * @param array $submissionType
     * @return int
     */
    function submit_single_file($filedata, $submissionType){
        $docid = -1;
        
        $access_token= $this->get_access_token();
      
        $data= ["userID" => $filedata["ownerid"],
                        "toRepository" => false];

        if($submissionType == 1){
            $files = array($filedata["file"]);
        }
        else{
            $data["textname"] = $filedata["filename"];
            $data["textdata"] = $filedata["content"];
            $files = null;
        }

        $url = plagscan_api::API_FILES."?access_token=".$access_token;

        $res = plagscan_api::instance()->request($url, "POST", $data, $files);

        if($res["httpcode"] == 201)
            $docid = $res["response"]["data"]["docID"];
        
        return $docid;
    }
    
    /**
     * Analyzes the document checking for plagiarism and generates the report
     * 
     * @param string $access_token
     * @param int $pid
     * @return boolean
     */    
    function analyze( $pid) {
        global $DB;
        
        $access_token= $this->get_access_token();
        
      $url = plagscan_api::API_FILES."/".$pid."/check?access_token=".$access_token;
      
      $res = plagscan_api::instance()->request($url, "PUT", null);
      
      if($res["httpcode"] == 204 ) {
        $current = $DB->get_record('plagiarism_plagscan', array('pid' => $pid));
        $current->status = 1;
        $DB->update_record('plagiarism_plagscan', $current);
        
      }
      
      return true;
    } 
    
   /**
    * Retrieves the plagiarism percentage result from the report
    * 
    * @param int $pid
    * @return int
    */
   function plaglevel_retrieve($pid){
        
        $access_token = $this->get_access_token();
        
        $url= plagscan_api::API_FILES."/$pid/retrieve?access_token=$access_token&mode=0";
        
        $res = plagscan_api::instance()->request($url, "GET", null);
        
        $httpcode = $res["httpcode"];
        
        if($httpcode != 200)
            $plaglevel = -1;
        else
            $plaglevel = $res["response"]["data"]["plagLevel"];
        
        
        return $plaglevel;
       
   }
   
   /**
    * Retrieves the link to access to the report 
    * 
    * @param int $pid
    * @param \stdClass $user
    * @param \stdClass $assign
    * @return array
    */
   function report_retrieve($pid, $user, $assign) {
        
        if($assign->submissionid == null)
            $mode = 7;
        else
            $mode = 10;
        
        $access_token= $this->get_access_token();
        
        $url= plagscan_api::API_FILES."/$pid/retrieve?mode=".$mode."&access_token=$access_token";
        
        if($mode == 10)
            $url .= "&userID=".$user->userid;
        
        $res = plagscan_api::instance()->request($url, "GET", null);
        
        if($res["httpcode"] != 200){
            if(isset($res["response"]["error"]))
                return $res["response"]["error"];
            else
                return null;
        }
        else
            return $res["response"]["data"];
        
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
       $modulesql = 'SELECT m.id, m.name, cm.instance'.
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
        if($psuserid == null) 
            $psuserid = $this->add_new_user( $user);
        
       $title = $module->name;
       $maxuplaods = '100';
       $share = 1;
       $checkdeadline = 0;
       $notifydeadline = 0;
       $enableresub = 1; 
       $checkonupload = 0;
       $type = 1;
       
    //check date
       if($module->duedate > 0){
           $endtime= date('d-m-Y', $module->duedate);
       }
       
       
    //start manually   
    if($config->upload == 1){
       $checkdeadline = 0;
       $notifydeadline = 0;
       $checkonupload = 0;
    }
    //start immediately
    elseif($config->upload == 3){
       $checkonupload = 1;
     }
     
    //start after due date
    elseif($config->upload == 4){
       $checkdeadline = 1;
    }
    
       
       $data = ["ownerID" => $psuserid, 
           "title" => $title, 
           "endTime" => "".$endtime, 
           "maxUploads" => $maxuplaods, 
           "share" => $share, 
           "checkDeadline" => $checkdeadline, 
           "notifyDeadline" => $notifydeadline, 
           "enableResubmission" => $enableresub, 
           "checkOnUpload" => $checkonupload, 
           "type" => $type];
       
       
       $access_token= $this->get_access_token();
       
       $url = plagscan_api::API_SUBMISSIONS."?access_token=".$access_token;
       
       $res = plagscan_api::instance()->request($url, "POST", $data);
        
       return $res["response"]["data"]["submissionID"];;
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
       $modulesql = 'SELECT m.id, m.name, cm.instance'.
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
        
        if($psuserid == null) 
            $psuserid = $this->add_new_user( $user);
        
       $title = $module->name;
       $checkdeadline = 0;
       $notifydeadline = 0;
       $enableresub = 1; 
       $checkonupload = 0;
       
    //check date
       if($module->duedate > 0){
           $endtime= date('d-m-Y', $module->duedate);
       }
       
       
    //start manually   
    if($config->upload == 1){
       $checkdeadline = 0;
       $notifydeadline = 0;
       $checkonupload = 0;
    }
    //start immediately
    elseif($config->upload == 3){
       $checkonupload = 1;
     }
     
    //start after due date
    elseif($config->upload == 4){
       $checkdeadline = 1;
    }
    
       
       $data = ["ownerID" => $psuserid, 
           "title" => $title, 
           "endTime" => "".$endtime, 
           "checkDeadline" => $checkdeadline, 
           "notifyDeadline" => $notifydeadline, 
           "enableResubmission" => $enableresub, 
           "checkOnUpload" => $checkonupload];
       
        $access_token= $this->get_access_token();
       
       $url = plagscan_api::API_SUBMISSIONS."/$assign_id?access_token=".$access_token;
       
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
        
        $data = ["email" => $user->email, "username" => $user->email, "firstname" => $user->firstname, "lastname" => $user->lastname];   

        $url = plagscan_api::API_USERS."?access_token=".$access_token;
        
        $res = plagscan_api::instance()->request($url, "POST", $data);
        
        $psid = $res["response"]["data"]["userID"];
        
        $insert = new stdClass();
        $insert->id = $user->id;
        $insert->userid = $psid;

        $DB->insert_record('plagiarism_plagscan_user', $insert);

        return $psid; 
    }
      
    /**
     * Checks if the user exist already in PlagScan
     * 
     * @param stdClass $user
     * @return int
     */
    function find_user($user) {
        global $DB;
        
        //First check if the user is registered in the Moodle DB with the PS id
        $psuser = $DB->get_record("plagiarism_plagscan_user", array("id" => $user->id));
        $psuserid = null;
        
        if($psuser){
            $psuserid = $psuser->userid;
        }
        else{
            $access_token = $this->get_access_token();
            $url = plagscan_api::API_USERS."/users?access_token=$access_token&searchByEmail=$user->email";

            $res = plagscan_api::instance()->request($url, "GET", null);

            $psuserid = $res["response"]["data"]["userID"];
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
    public function is_assistant($context,$assignment, $user){
        $is_assistant = false;
        
        if(has_capability('plagiarism/plagscan:control', $context) && $user->id != $assignment->ownerid){
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
     * @return boolean
     * @throws moodle_exception
     */
    public function involve_assistant($assign,$assign_psownerid, $involved_user){
        $access_token = $this->get_access_token();
        
        $involved_psuserid = $this->find_user($involved_user);
        
        //die();
        $url = plagscan_api::API_SUBMISSIONS."/$assign->submissionid/involve?userID=$involved_psuserid&ownerID=$assign_psownerid&access_token=".$access_token;
        
        $res = plagscan_api::instance()->request($url, "GET", null);
        
        $is_involved = $res["response"]["data"]["involved"];
        
        if(!$is_involved){
            $res = plagscan_api::instance()->request($url, "PUT", null);
        
            if($res["httpcode"] == 400){
                throw new moodle_exception('errorinvolvingassistant', 'plagiarism_plagscan');
                return false;
            }
        }
        
        return true;
    }
    
}