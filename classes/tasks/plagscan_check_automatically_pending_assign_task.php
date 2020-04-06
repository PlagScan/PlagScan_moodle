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
 * plagscan_check_automatically_pending_assign_task.php - Class that help to check files pending from assignment with the option automatically check
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2019 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\tasks;

use core\task\scheduled_task;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\classes\plagscan_connection;

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_check_automatically_pending_assign_task extends scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('check_automatically_pending_assign_task', 'plagiarism_plagscan');
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;
        $params = ['upload' => 3, 'status' => plagscan_file::STATUS_NOT_STARTED, 'error_no_cred' => -2];
        $sql = "SELECT psfile.id,            
            psfile.userid,        
            psfile.pid,           
            psfile.pstatus,       
            psfile.status,        
            psfile.cmid,          
            psfile.filehash,      
            psfile.updatestatus,  
            psfile.submissiontype
            FROM {plagiarism_plagscan} AS psfile, {plagiarism_plagscan_config} AS psassign
            WHERE psassign.upload = :upload AND psfile.cmid = psassign.cm AND psfile.status = :status AND psfile.pstatus != :error_no_cred
            LIMIT 50";
        $records = $DB->get_records_sql($sql, $params);
        
        mtrace('PlagScan: starting task to check files from assignments configured  with start check automatically.');
        if($records){
            $connection = new plagscan_connection();
            $msg = 'PlagScan: Checking file with PlagScan ID ';
            foreach($records as $record){
                $msg2 = $msg.' '.$record->pid;
                if($record->pid > 0){
                    $result = $connection->analyze($record->pid);
                    if($result == null) {
                        mtrace($msg2.' started.');
                        $record->status = plagscan_file::STATUS_CHECKING;
                        $record = plagscan_file::update($record);
                    }
                    else if ($result == "This document has a report already"){
                        mtrace($msg2.', but it has already a report, updating status.');
                        plagscan_file::update_status($record);
                    }
                    else {
                        mtrace($msg2.' failed - '.$result);
                    }
                } else {
                    mtrace($msg2.' failed - The document has no PlagScan ID, updating status.');
                    $record->status = plagscan_file::STATUS_FAILED_UNKNOWN;
                    $record = plagscan_file::update($record);
                }                    
                
            }
        }
        else{
            mtrace('Plagscan: no assignments found with pending files to check automatically.');
        }
    }

}