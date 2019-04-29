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
* plagscan_file_upload_task.php - Class that defines the adhoc task for uploading files
*
* @package      plagiarism_plagscan
* @subpackage   plagiarism
* @author       Jesús Prieto <jprieto@plagscan.com>
* @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
* @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

namespace plagiarism_plagscan\tasks;

use core\task\adhoc_task;
use core\task\manager;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\classes\plagscan_connection;

require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}



class plagscan_file_upload_task extends adhoc_task {
     
    /**
     * Add the task to the adhoc queue with the data 
     * 
     * @param array $data
     * @return int
     */
    public static function add_task($data){
        $task = new static();
        $task->set_component('plagiarism_plagscan');
        $task->set_custom_data($data);
        
        return manager::queue_adhoc_task($task);
    }
    
    public function execute() {
        $data = $this->get_custom_data();
        $psfile = $data->psfile;
        $filedata = json_decode(json_encode($data->filedata),true);
        
        $file = get_file_storage()->get_file_by_hash($data->pathnamehash);
        $filedata['filename'] = $file->get_filename();
        $filedata['file'] = $file;
        $filedata['mimetype'] = $file->get_mimetype();
        
        
        plagscan_log('Executing task for file upload '.$filedata['filename'].'');
        
        mtrace('PlagScan: Uploading file '.$filedata['filename'].'');
        
        try {
            $result = plagscan_file::submit($psfile,$filedata);
        } catch (moodle_exception $e) {
            mtrace($e->getMessage());
        }
        
        $mtracemsg = '';
        switch($result){
            case plagscan_connection::SUBMIT_UNSUPPORTED:
                $mtracemsg = 'PlagScan: '.$filedata['filename'].' is a type of file not supported by the PlagScan server';
                break;
            case plagscan_connection::SUBMIT_OPTOUT:
                $mtracemsg = 'Plagscan: User '.$filedata->userid.' has opted-out of plagiarism detection - '.$filedata['filename'].' not uploaded';
                break;
            case plagscan_connection::SUBMIT_FAILED_BY_CONNECTION:
                $mtracemsg = 'PlagScan: '.$filedata['filename'].' failed on upload process';
                break;
            case plagscan_connection::SUBMIT_OK:
                $mtracemsg = 'PlagScan: '.$filedata['filename'].' sucessfully uploaded';
                break;
        }
        mtrace($mtracemsg);
        plagscan_log($mtracemsg);
        plagscan_log('Finished task for file upload '.$filedata['filename'].'');
    }
}