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
 * plagscan_file.php - This class help to manage the documents submitted to PlagScan through the plugin
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>  
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\classes;

use plagiarism_plagscan\classes\plagscan_connection;
use moodle_exception;

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_file {

    /**
     * STATUS_NOT_STARTED
     */
    const STATUS_NOT_STARTED = 0;

    /**
     * STATUS_CHECKING
     */
    const STATUS_CHECKING = 1;

    /**
     * STATUS_ONGOING
     */
    const STATUS_ONGOING = 2;

    /**
     * STATUS_FINISHED
     */
    const STATUS_FINISHED = 3;

    /**
     * STATUS_QUEUED
     */
    const STATUS_QUEUED = 4;

    /**
     * STATUS_SUBMITTING
     */
    const STATUS_SUBMITTING = 100;

    /**
     * STATUS_FAILED
     */
    const STATUS_FAILED = 1000;

    /**
     * STATUS_FAILED_FILETYPE
     */
    const STATUS_FAILED_FILETYPE = 1001;

    /**
     * STATUS_FAILED_UNKNOWN
     */
    const STATUS_FAILED_UNKNOWN = 1002;

    /**
     * STATUS_FAILED_OPTOUT
     */
    const STATUS_FAILED_OPTOUT = 1003;

    /**
     * STATUS_FAILED_CONNECTION
     */
    const STATUS_FAILED_CONNECTION = 1004;
    
    /**
     * STATUS_FAILED_USER_CREATION
     */
    const STATUS_FAILED_USER_CREATION = 1005;
    
    /**
     * STATUS_FAILED_USER_DOES_NOT_BELONG_TO_THE_INSTITUTION
     */
    const STATUS_FAILED_USER_DOES_NOT_BELONG_TO_THE_INSTITUTION = 1006;
    
    /**
     * STATUS_FAILED_DOCUMENT_DOES_NOT_BELONG_TO_THE_INSTITUTION
     */
    const STATUS_FAILED_DOCUMENT_DOES_NOT_BELONG_TO_THE_INSTITUTION = 1007;

     /**
     * STATUS_ASSIGN_OR_OWNER_DOES_NOT_EXIST_OR_BELONG
     */
    const STATUS_FAILED_ASSIGN_OR_OWNER_DOES_NOT_EXIST_OR_BELONG = 1008;

    /**
     * STATUS_USER_NOT_EXIST
     */
    const STATUS_FAILED_USER_DOES_NOT_EXIST = 1009;
    
    /**
     * STATUS_NEED_TO_BE_RESUBMITED
     */
    const STATUS_NEED_TO_BE_RESUBMITED = 2000;
    
    /**
     * STATUS_FILE_DOES_NOT_EXIST_IN_STORAGE_ANYMORE
     */
    const STATUS_FILE_DOES_NOT_EXIST_IN_STORAGE_ANYMORE = 3000;
    
    /**
     * STATUS_CM_DOES_NOT_EXIST_ANYMORE
     */
    const STATUS_CM_DOES_NOT_EXIST_ANYMORE = 3001;
    
    /**
     * STATUS_USER_IN_MOODLE_DOES_NOT_EXIST_ANYMORE
     */
    const STATUS_USER_IN_MOODLE_DOES_NOT_EXIST_ANYMORE = 3002;
    
    /**
     * STATUS_ASSIGN_OWNER_IN_MOODLE_DOES_NOT_EXIST_ANYMORE
     */
    const STATUS_ASSIGN_OWNER_IN_MOODLE_DOES_NOT_EXIST_ANYMORE = 3003;
    
    /**
     * REPORT_STATS
     */
    const REPORT_STATS = 0;

    /**
     * REPORT_LINKS
     */
    const REPORT_LINKS = 1;

    /**
     * REPORT_SOURCES
     */
    const REPORT_SOURCES = 2;

    /**
     * REPORT_DOCX
     */
    const REPORT_DOCX = 3;

    /**
     * REPORT_HTML
     */
    const REPORT_HTML = 4;

    /**
     * REPORT_MATCHES
     */
    const REPORT_MATCHES = 5;

    /**
     * REPORT_PS
     */
    const REPORT_PS = 6;

    /**
     * NEW_REPORT
     */
    const NEW_REPORT = 7;
    //const REPORT_RESERVED = 7;
    /**
     * REPORT_PDFHTML
     */
    const REPORT_PDFHTML = 8;

    /**
     * REPORT_PDFREPORT
     */
    const REPORT_PDFREPORT = 9;

    /**
     * REPORT_HIGHLIGHT
     */
    const REPORT_HIGHLIGHT = 25;

    /**
     * REPORT_GETSOURCE
     */
    const REPORT_GETSOURCE = 26;

    /**
     * Check if the file/online text content exist on the PlagScan table
     * 
     * @param int $cmid
     * @param int $userid
     * @param string $filehash
     * @return \stdClass
     */
    public static function find($cmid, $userid, $filehash) {
        global $DB;

        return $DB->get_record('plagiarism_plagscan', array('cmid' => $cmid,
                    'userid' => $userid,
                    'filehash' => $filehash));
    }

    public static function find_by_psids($ids) {
        global $DB;

        return $DB->get_records_list('plagiarism_plagscan', 'id', $ids);
    }

    /**
     * Saves the file data on the PlagScan table
     * 
     * @param \stdClass $file
     * @return int
     */
    public static function save($file) {
        global $DB;

        return $DB->insert_record('plagiarism_plagscan', $file);
    }

    /**
     * Updates the file data on the PlagScan table
     * 
     * @param \stdClass $file
     * @return int
     */
    public static function update($file) {
        global $DB;

        return $DB->update_record('plagiarism_plagscan', $file);
    }
    
    /**
     * Deltes the file data on the PlagScan table
     * 
     * @param \stdClass $file
     * @return int
     */
    public static function delete($file){
        global $DB;
        
        return $DB->delete_records('plagiarism_plagscan', array('id' => $file->id));
    }

    /**
     * Returns an array with the supported filetypes in PlagScan
     * 
     * @param string $filename
     * @return bool
     */
    public static function plagscan_supported_filetype($filename) {
        $allowedtypes = array('docx', 'doc', 'pdf', 'txt', 'html', 'wps', 'wpd', 'ppt', 'pptx',
            'odt', 'ott', 'rtf', 'sdw', 'sxw', 'xml', 'pdb', 'ltx', 'pages', 'key', 'numbers',
            'xls', 'xlsx', 'pptx');
        $extn = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return in_array($extn, $allowedtypes);
    }

    /**
     * Submit a file/online text content to PlagScan
     * 
     * @param \stdClass $psfile
     * @param array $filedata
     * @return int
     * @throws moodle_exception
     */
    public static function submit($psfile, $filedata) {
        global $DB, $CFG;

        $connection = new plagscan_connection();
        

        if (!self::plagscan_supported_filetype($filedata['filename'])) {
            self::set_status($psfile, self::STATUS_FAILED_FILETYPE);
            return plagscan_connection::SUBMIT_UNSUPPORTED; // Unsupported file type.
        }

        if (plagscan_user_opted_out($psfile->userid)) {
            self::set_status($psfile, self::STATUS_FAILED_OPTOUT);
            return plagscan_connection::SUBMIT_OPTOUT; // User has opted-out of PlagScan uploads.
        }

        /* // Delete any existing reports / records for this file 
          // mostly works with re_submit
          $oldrecords = $DB->get_records('plagiarism_plagscan', array('cmid' => $psfile->cmid,
          'userid' => $psfile->userid,
          'filehash' => $psfile->filehash, 'submissiontype' => $psfile->submissiontype), 'id');

          foreach ($oldrecords as $oldrecord) {
          self::delete_reports($psfile->cmid, $oldrecord->id);

          if (!$connection->delete_submitted_file($oldrecord->pid)) {
          throw new moodle_exception('oldsubmission_notdeleted', 'plagiarism_plagscan');
          }
          $DB->delete_records('plagiarism_plagscan', array('id' => $oldrecord->id));
          } */

        try {
            //Check if the assignment was created from a previous versions without creating it on PS too
            if ($filedata['submissionid'] == null || $filedata['submissionid'] == 'ownerid') {
                $result = $connection->submit_single_file($filedata);
            } else {
                $result = $connection->submit_into_submission($filedata);
            }
        } catch (moodle_exception $e) {
            self::set_status($psfile, self::STATUS_FAILED_CONNECTION);
        }


        if ($result <= 0) {
            if ($result == -2){
                self::set_status($psfile, self::STATUS_FAILED_USER_DOES_NOT_BELONG_TO_THE_INSTITUTION);
            }
            else if ($result == -3){
                self::set_status($psfile, self::STATUS_FAILED_ASSIGN_OR_OWNER_DOES_NOT_EXIST_OR_BELONG);
            }
            else {
                self::set_status($psfile, self::STATUS_FAILED_UNKNOWN);
            }
            return plagscan_connection::SUBMIT_FAILED_BY_CONNECTION;
        }

        $psfile->pid = intval($result);
        self::update($psfile);

        return plagscan_connection::SUBMIT_OK;
    }
   

    /**
     * Deletes previously saved reports for the file
     * 
     * @global \stdClass $CFG
     * @param int $cmid
     * @param int $pid
     */
    protected static function delete_reports($cmid, $pid = false) {
        global $CFG;

        if ($CFG->version < 2011120100) {
            $context = get_context_instance(CONTEXT_MODULE, $cmid);
        } else {
            $context = \context_module::instance($cmid);
        }

        $fs = get_file_storage();
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_DOCX), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_HTML), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_MATCHES), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_PS), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_PDFHTML), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_PDFREPORT), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_HIGHLIGHT), $pid);
        $fs->delete_area_files($context->id, 'plagiarism_plagscan', self::file_area_from_type(self::REPORT_GETSOURCE), $pid);
    }

    /**
     * Returns an array with the file area mapping from type of report
     * 
     * @param int $reporttype
     * @return string
     */
    protected static function file_area_from_type($reporttype) {
        $mapping = array(self::REPORT_DOCX => 'reportdocx',
            self::REPORT_HTML => 'reporthtml',
            self::REPORT_MATCHES => 'reportmatches',
            self::REPORT_PS => 'reportps',
            self::REPORT_PDFHTML => 'reportpdfhtml',
            self::REPORT_PDFREPORT => 'reportpdfreport',
            self::REPORT_HIGHLIGHT => 'reporthighlight',
            self::REPORT_GETSOURCE => 'reportgetsource',
            self::NEW_REPORT => 'new_report');

        return $mapping[$reporttype];
    }

    /**
     * Set the status of a file
     * 
     * @param \stdClass $psfile
     * @param \stdClass $status
     */
    protected static function set_status($psfile, $status) {
        global $DB;

        $current = $DB->get_record('plagiarism_plagscan', array('userid' => $psfile->userid,
            'cmid' => $psfile->cmid,
            'filehash' => $psfile->filehash));
        if ($current) {
            if ($status != $current->status) {
                $upd = new \stdClass();
                $upd->id = $current->id;
                $upd->status = $status;
                $DB->update_record('plagiarism_plagscan', $upd);
            }
        } else {
            $psfile->status = $status;
            $psfile->pid = 0;
            $psfile->id = $DB->insert_record('plagiarism_plagscan', $psfile);
        }
    }

    /**
     * Updates the status of a file
     * 
     * @param \stdClass $psfile
     * @return boolean
     */
    public static function update_status($psfile) {
        global $DB;
        if ($psfile->status == self::STATUS_FINISHED && !is_null($psfile->pstatus) && !$psfile->updatestatus) {
            // Don't retrieve status if already finished
            return false;
        }

        $pid = $psfile->pid;
        if ($pid <= 0) {
            // File was not submitted properly in the first place - skip it.
            return false;
        }

        $connection = new plagscan_connection();
        $res = $connection->plaglevel_retrieve($pid);
        
        if ($res["httpcode"] != 200) {
            $result = -1;
        } else {
            $result = $res["response"]["data"]["plagLevel"];
        }

        $pstatus = null;
        if (intval($result) >= 0) {
            $status = self::STATUS_FINISHED;
            if (empty($result)) {
                $pstatus = null;
            } else {
                $pstatus = floatval($result) / 10;
            }
        } else {
            $update = new \stdClass();
            $update->pid = $psfile->pid;
            $update->id = $psfile->id;
            
            if(isset($res["response"]["error"]["message"])){
                $status = plagscan_file::get_status_from_api_error_msg($res["response"]["error"]["message"]);
                if($status >= 0){
                    $update->status = $status;
                    self::update($update);
                }
            }
            return false;
        }
            
        if ($status == $psfile->status && $pstatus == $psfile->pstatus && !$psfile->updatestatus) {
            return false; // Nothing has changed
        }

        $update = new \stdClass();
        $update->status = $status;
        $update->pstatus = $result;
        $update->pid = $psfile->pid;
        $update->updatestatus = 0;

        if (isset($psfile->id)) {
            $update->id = $psfile->id;
            self::update($update);

            // Ready to be returned
            $update->userid = $psfile->userid;
            $update->cmid = $psfile->cmid;
            $update->filehash = $psfile->filehash;
        } else {
            $update->userid = $psfile->userid;
            $update->cmid = $psfile->cmid;
            $update->filehash = $psfile->filehash;
            $update->id = self::save($update);
        }

        return true;
    }
    
    /**
     * Returns the file status that corresponds to the api error message.
     * 
     * @param String $errormsg
     * @return int
     */
    static function get_status_from_api_error_msg($errormsg){
        $status = -1;
        switch($errormsg){
            case plagscan_api::API_ERROR_MSG_DOCUMENT_DOES_NOT_BELONG_TO_INST:
                $status = self::STATUS_FAILED_DOCUMENT_DOES_NOT_BELONG_TO_THE_INSTITUTION;
                break;
            case plagscan_api::API_ERROR_MSG_NO_REPORT:
                $status = self::STATUS_NOT_STARTED;
                break;
            case plagscan_api::API_ERROR_MSG_DOCUMENT_REJECTED:
                $status = self::STATUS_FAILED;
                break;
            case plagscan_api::API_ERROR_MSG_DOCUMENT_DELETED:
                $status = self::STATUS_FILE_DOES_NOT_EXIST_IN_STORAGE_ANYMORE;
                break;
            case plagscan_api::API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST:
                $status = self::STATUS_FAILED_USER_DOES_NOT_BELONG_TO_THE_INSTITUTION;
                break;
        }
        
        return $status;
    }

}
