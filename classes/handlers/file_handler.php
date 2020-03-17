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
 * file_handler.php - Class that controls the file observer events
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\handlers;

use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\tasks\plagscan_file_upload_task;

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class file_handler {

    /**
     * Queue of files to be submitted
     * 
     * @var array 
     */
    protected $filesqueue = array();

    /**
     *
     * @var file_handler 
     */
    protected static $instance = null;

    /**
     * Create a singleton instance
     * 
     * @return file_handler
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new file_handler();
        }

        return self::$instance;
    }

    /**
     * Controls the assesable_upload event and fill the queue with the files received
     * 
     * @param \assignsubmission_file\event\assessable_uploaded $event
     */
    public function file_uploaded(
    \assignsubmission_file\event\assessable_uploaded $event) {
        foreach ($event->other['pathnamehashes'] as $pathnamehash) {
            $file = get_file_storage()->get_file_by_hash($pathnamehash);
            if ($file && !$file->is_directory()) {
                array_push($this->filesqueue, $file);
            }
        }
        $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
    }

    /**
     * Controls the assesable_submitted event and fill the queue with the files received
     * 
     * @param \mod_assign\event\assessable_submitted $event
     */
    public function file_submitted(
        \mod_assign\event\assessable_submitted $event) {
            $context = \context_module::instance($event->contextinstanceid);

            if ($files = get_file_storage()->get_area_files($context->id, 'assignsubmission_file',
            ASSIGNSUBMISSION_FILE_FILEAREA, $event->objectid, 'id', false)) {
                foreach ($files as $file) {
                    array_push($this->filesqueue, $file);
                }
            }
            
            $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
        }
    
    /**
     * Fill the queue to upload files from received pathnamehashes
     * 
     * @param int $cmid
     * @param int $userid
     * @param array $pathnamehashes
     */
    public function file_uploaded_without_event($context, $userid, $pathnamehashes, $showlog = false){
        foreach ($pathnamehashes as $pathnamehash) {
            $file = get_file_storage()->get_file_by_hash($pathnamehash);
            if ($file && !$file->is_directory()) {
                array_push($this->filesqueue, $file);
            }
            else {
                if($showlog){
                    mtrace('PlagScan: Creating task for file with hash '.$pathnamehash.' - Error: file does not exist anymore.');
                }
                $file = plagscan_file::find($context->instanceid, $userid, $pathnamehash);
                $file->status = plagscan_file::STATUS_FILE_DOES_NOT_EXIST_IN_STORAGE_ANYMORE;
                $file = plagscan_file::update($file);
            }
        }
        $this->handle_files_queue($context->instanceid, $userid, $showlog);
    }

    /**
     * Controls the assesable_upload event and fill the queue with the content received
     * 
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     */
    public function onlinetext_uploaded(
    \assignsubmission_onlinetext\event\assessable_uploaded $event) {
        $file = $this->create_file_from_onlinetext_content($event);

        if ($file != null) {
            array_push($this->filesqueue, $file);
        }

        $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
    }
    
    /**
     * Fill the queue to upload files from received content
     * 
     * @param context $context
     * @param int $userid
     * @param String $content
     * @param int $objectid
     */
    public function onlinetext_uploaded_without_event($context, $userid, $content, $objectid){
        $file = $this->create_file_from_onlinetext_content_without_event($context, $userid, $content, $objectid);

        if ($file != null) {
            array_push($this->filesqueue, $file);
        }

        $this->handle_files_queue($context->instanceid, $userid);
    }

    /**
     * Handles the queue of files and trigger the upload
     * 
     * @global stdClass $DB
     * @param int $cmid
     * @param int $userid
     */
    private function handle_files_queue($cmid, $userid, $showlog = false) {
        global $DB;

        $connection = new plagscan_connection();
        $instanceconfig = plagscan_get_instance_config($cmid);
        
        $submissionid = null;

        $is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');
        
        //Check if the assignment was created from a previous versions without creating it on PS too
        if(!$is_multiaccount) {
            $assign_owner = $DB->get_record('user', array('email' => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
        } else if (isset($instanceconfig->ownerid) && $instanceconfig->ownerid != null && intval($instanceconfig->ownerid) > 0) {
            $assign_owner = $DB->get_record('user', array("id" => $instanceconfig->ownerid));
        } else {
            $assign_owner = $DB->get_record('user', array("email" => $instanceconfig->username));
        }
        
        if ($assign_owner == null) {
            $assign_psownerid = null;
        } else {
            $assign_psownerid = $connection->find_user($assign_owner);
        }
        
        if ($is_multiaccount) {
            $submitter_user = $DB->get_record('user', array('id' => $userid));
            $submissionid = $instanceconfig->submissionid;
        } else {
            $submitter_user = $DB->get_record('user', array('email' => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
        }

        if ($submitter_user == null) {
            $submitter_userid = null;
        }
        else{
            $submitter_userid = $connection->find_user($submitter_user);

            if ($submitter_userid == null) {
                $submitter_userid = $connection->add_new_user($submitter_user);
            }
        }

        foreach ($this->filesqueue as $key => $file) {

            if($showlog) {
                mtrace('PlagScan: Creating task for file - Preparing to add to the queue');
                mtrace('PlagScan: Creating task for file with hash '.$file->get_pathnamehash().' - Getting ownerID '.$assign_psownerid);        
                mtrace('PlagScan: Creating task for file with hash '.$file->get_pathnamehash().' - Getting submitterID '.$submitter_userid);        
                mtrace('PlagScan: Creating task for file with hash '.$file->get_pathnamehash().' - Getting submissionID if exist '.$submissionid);
            }
            
            $previous_psfile = plagscan_file::find($cmid, $userid, $file->get_pathnamehash());
            if(!$previous_psfile){
                $previous_psfile = plagscan_file::find($cmid, $userid, $file->get_contenthash());
            }
            
            if (!$previous_psfile || $previous_psfile->status >= plagscan_file::STATUS_FAILED) {
                
                if($showlog) {
                    mtrace('PlagScan: Creating task for file with hash '.$file->get_pathnamehash().' - Adding to the queue.');
                }
                
                $psfile = new \stdClass();
                $psfile->userid = $userid;
                $psfile->cmid = $cmid;
                $psfile->filehash = $file->get_pathnamehash();

                $psfile->pid = 0;
                $psfile->pstatus = '';
                
                if($submitter_userid == null || $submitter_userid == 0){
                    $psfile->status = plagscan_file::STATUS_FAILED_USER_CREATION;
                } 
                else if($assign_psownerid == null){
                    $psfile->status = plagscan_file::STATUS_ASSIGN_OWNER_IN_MOODLE_DOES_NOT_EXIST_ANYMORE;
                }
                else {
                    $psfile->status = plagscan_file::STATUS_SUBMITTING;
                }
                
                if(!$previous_psfile){
                    $psfile->id = plagscan_file::save($psfile);
                }
                else {
                    $psfile->id =$previous_psfile->id;
                    plagscan_file::update($psfile);
                }
                
                if( $psfile->status == plagscan_file::STATUS_SUBMITTING){
                    $filedata = array(
                        'submissionid' => $submissionid,
                        'ownerid' => $assign_psownerid,
                        'submitterid' => $submitter_userid,
                        'email' => $submitter_user->email,
                        'firstname' => $submitter_user->firstname,
                        'lastname' => $submitter_user->lastname);

                    plagscan_file_upload_task::add_task(array(
                        'psfile' => $psfile,
                        'filedata' => $filedata,
                        'pathnamehash' => $file->get_pathnamehash()));
                    
                    if($showlog) {
                        mtrace('PlagScan: Creating task for file with hash '.$file->get_pathnamehash().' - Added to the queue.');
                    }
                }
            }
            unset($this->filesqueue[$key]);
                    
        }
    }

    /**
     * Creates a file in the storage folder with the content from the event
     * 
     * @global \plagiarism_plagscan\handlers\stdClass $DB
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     * @return stored_file
     */
    public function create_file_from_onlinetext_content($event) {
        global $DB;

        $content = $event->other['content'];

        if (empty($content)) {
            return null;
        }

        $author = $DB->get_record('user', array('id' => $event->userid));

        $filedata = array(
            'component' => 'plagiarism_plagscan',
            'contextid' => $event->contextid,
            'filearea' => $event->objecttable,
            'filepath' => '/',
            'itemid' => $event->objectid,
            'filename' => 'onlinetext_' . $event->contextid . '_' . $event->get_context()->instanceid . '_' . $event->objectid . "_" . $author->lastname . ".html",
            'userid' => $event->userid,
            'author' => $author->firstname . ' ' . $author->lastname,
            'license' => 'allrightsreserved'
        );
        
        $filestorage = get_file_storage();
        
        $previousfile = $filestorage->get_file($filedata['contextid'], $filedata['component'], $filedata['filearea'], $filedata['itemid'], $filedata['filepath'], $filedata['filename']
        );

        if ($previousfile) {
            if ($previousfile->get_contenthash() == sha1($content)) {
                return $previousfile;
            }

            $previousfile->delete();
            $cmid = $event->get_context()->instanceid;
            $userid = $event->userid;
            $psfile = plagscan_file::find($cmid, $userid, $previousfile->get_pathnamehash());
            if(!$psfile)
                $psfile = plagscan_file::find($cmid, $userid, $previousfile->get_contenthash());
            
            if($psfile)           
                plagscan_file::delete($psfile);
        }

        return $filestorage->create_file_from_string($filedata, $content);
    }
    
    /**
     * 
     * 
     * @global \plagiarism_plagscan\handlers\stdClass $DB
     * @param context $context
     * @param int $userid
     * @param String $content
     * @param int $objectid
     * @return stored_file
     */
    public function create_file_from_onlinetext_content_without_event($context, $userid, $content, $objectid) {
        global $DB;

        if (empty($content)) {
            return null;
        }

        $author = $DB->get_record('user', array('id' => $userid));

        $filedata = array(
            'component' => 'plagiarism_plagscan',
            'contextid' => $context->id,
            'filearea' => "assign_submission",
            'filepath' => '/',
            'itemid' => $objectid,
            'filename' => 'onlinetext_' . $context->id . '_' . $context->instanceid . '_' . $objectid . "_" . $author->lastname . ".html",
            'userid' => $userid,
            'author' => $author->firstname . ' ' . $author->lastname,
            'license' => 'allrightsreserved'
        );
        
        $filestorage = get_file_storage();
        
        $previousfile = $filestorage->get_file($filedata['contextid'], $filedata['component'], $filedata['filearea'], $filedata['itemid'], $filedata['filepath'], $filedata['filename']
        );

        if ($previousfile) {
            if ($previousfile->get_contenthash() == sha1($content)) {
                return $previousfile;
            }

            $previousfile->delete();
            $cmid = $context->instanceid;
            $userid = $userid;
            $psfile = plagscan_file::find($cmid, $userid, $previousfile->get_pathnamehash());
            if(!$psfile)
                $psfile = plagscan_file::find($cmid, $userid, $previousfile->get_contenthash());
            
            if($psfile)           
                plagscan_file::delete($psfile);
        }

        return $filestorage->create_file_from_string($filedata, $content);
    }

}
