<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace plagiarism_plagscan\handlers;

use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\classes\plagscan_connection;

class file_handler {
    
    protected $filesqueue = array();
    
    protected static $instance = null;
    
    public static function instance(){
        if(self::$instance === null){
            self::$instance = new file_handler();
        }
        
        return self::$instance;
    }
    
    public function file_uploaded(
            \assignsubmission_file\event\assessable_uploaded $event){
        
        foreach ($event->other['pathnamehashes'] as $pathnamehash) {
            $file = get_file_storage()->get_file_by_hash($pathnamehash);
            if ($file && !$file->is_directory()) {
                array_push($this->filesqueue, $file);
            }
        }
        $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
    }
    
    private function handle_files_queue($cmid, $userid){
        global $DB;
        
        $connection = new plagscan_connection();
        $instanceconfig = plagscan_get_instance_config($cmid);
        
        //Check if the assignment was created from a previous versions without creating it on PS too
        if($instanceconfig->ownerid != null){
            $assign_owner = $DB->get_record('user', array("id" => $instanceconfig->ownerid));
            $assign_psownerid = $connection->find_user($assign_owner);
        }
        else{
            $assign_owner = $DB->get_record('user', array("email" => $instanceconfig->username));
            $assign_psownerid = $connection->find_user($assign_owner);
        }
        
        $is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');
        if($is_multiaccount){
            $submitter_user = $DB->get_record("user", array("id" => $userid));
        }
        else {
            $submitter_user = $DB->get_record("user", array("email" => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
        }

       $submitter_userid = $connection->find_user($submitter_user);

        if($submitter_userid == null) 
               $submitter_userid = $connection->add_new_user($submitter_user);
                
        foreach ($this->filesqueue as $file){
            
            if(!plagscan_file::find($cmid,$userid,$file->get_contenthash())){
                $filedata = array(
                    'submissionid' => $instanceconfig->submissionid,
                    'ownerid' => $assign_psownerid,
                    'submitterid' => $submitter_userid,
                    'email' => $submitter_user->email,
                    'firstname' => $submitter_user->firstname,
                    'lastname' => $submitter_user->lastname);

                $filedata['filename'] = $file->get_filename();
                $filedata['file'] = $file;
                $filedata['mimetype'] = $file->get_mimetype();



                $psfile = new \stdClass();
                $psfile->userid = $userid;
                $psfile->cmid = $cmid;
                $psfile->filehash = $file->get_contenthash();
                $psfile->submissiontype = '1';

                plagscan_file::submit($psfile,$filedata);
            }
        }
    }
}