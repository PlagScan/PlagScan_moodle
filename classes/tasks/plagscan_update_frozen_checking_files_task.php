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
 * plagscan_update_frozen_checking_files_task.php - Class that help to update the status of the files frozen as checking or in progress.
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

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_update_frozen_checking_files_task extends scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('update_frozen_checking_files_task', 'plagiarism_plagscan');
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;
        $params = ['status' => plagscan_file::STATUS_CHECKING, 'status2' => plagscan_file::STATUS_ONGOING, 'pid' => 0];
        $sql = "SELECT *
            FROM {plagiarism_plagscan} AS psfile
            WHERE ( psfile.status = :status OR psfile.status = :status2 ) AND psfile.pid > :pid
                LIMIT 50
                ";
        $records = $DB->get_records_sql($sql, $params);
        
        mtrace('PlagScan: starting task to update status of frozen files.');
        if($records){
            $connection = new plagscan_connection();
            $msg = 'PlagScan: Updating status of file with PlagScan ID ';
            foreach($records as $record){
                $msg2 = $msg.' '.$record->pid;
                $result = plagscan_file::update_status($record);
                mtrace($msg2);
            }
        }
        else{
            mtrace('Plagscan: no frozen files found needed to update the status.');
        }
    }

}