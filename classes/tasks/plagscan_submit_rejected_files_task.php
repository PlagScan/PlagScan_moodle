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
 * plagscan_submit_rejected_files_task.php - Class that help to resubmit files rejected
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\tasks;

use core\task\scheduled_task;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\handlers\file_handler;

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_submit_rejected_files_task extends scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('submit_rejected_files_task', 'plagiarism_plagscan');
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        global $DB, $CFG;
        $params = ['status' => 2000];
        $sql = "SELECT psfile.id,            
            psfile.userid,        
            psfile.pid,           
            psfile.pstatus,       
            psfile.status,        
            psfile.cmid,          
            psfile.filehash,      
            psfile.updatestatus,  
            psfile.submissiontype
            FROM {plagiarism_plagscan} AS psfile
            WHERE psfile.status = :status
                LIMIT 10
                ";
        $records = $DB->get_records_sql($sql, $params);
        
        mtrace('PlagScan: Creating adhoc tasks to resubmit files rejected.');
        if($records){
            $connection = new plagscan_connection();
            $msg = 'PlagScan: Creating task for file with hash ';
            foreach($records as $record){
                $msg2 = $msg.' '.$record->filehash;
                if ($CFG->version < 2011120100) {
                    $context = get_context_instance(CONTEXT_MODULE, $record->cmid);
                } else {
                    $context = \context_module::instance($record->cmid);
                }
                $hashes = array();
                array_push($hashes, $record->filehash);
                file_handler::instance()->file_uploaded_without_event($context,$record->userid, $hashes);
                mtrace($msg2);
            }
        }
        else{
            mtrace('Plagscan: no files found that were rejected and queued to resubmit again.');
        }
    }

}