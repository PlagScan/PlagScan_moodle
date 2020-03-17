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
 * plagiarism_plagscan_observer.php - Class for the observer event of Moodle
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

use plagiarism_plagscan\handlers\file_handler;

class plagiarism_plagscan_observer {

    /**
     * Controls the file upload event
     * 
     * @param \assignsubmission_file\event\assessable_uploaded $event
     */
    public static function assignsubmission_file_uploaded(
    \assignsubmission_file\event\assessable_uploaded $event) {
        global $DB;

        $instanceconfig = plagscan_get_instance_config($event->get_context()->instanceid);
        
        if(isset($instanceconfig->upload) && $instanceconfig->upload >= plagiarism_plugin_plagscan::RUN_MANUAL && $instanceconfig->upload <= plagiarism_plugin_plagscan::RUN_DUE){
            file_handler::instance()->file_uploaded($event);
        } else if(isset($instanceconfig->upload) && $instanceconfig->upload == plagiarism_plugin_plagscan::RUN_SUBMIT_ON_CLOSED_SUBMISSION){
            $course = $DB->get_record('course_modules', array('id' => $event->get_context()->instanceid));
            if(!empty($course)){
                $assign = $DB->get_record('assign', array('id' => $course->instance));
                if(!empty($assign)){
                    if($assign->submissiondrafts == 0){
                        file_handler::instance()->file_uploaded($event);
                    }
                    else {
                        return;
                    }
                }
                else{
                    return;
                }
            }
            else{
                return;
            }
        }
        else{
            return;
        }
    }

    /**
     * Controls the assessable submitted event
     * 
     * @param \mod_assign\event\assessable_submitted $event
     */
    public static function mod_assign_assessable_submitted(
        \mod_assign\event\assessable_submitted $event) {
    
            $instanceconfig = plagscan_get_instance_config($event->get_context()->instanceid);
            
            if(isset($instanceconfig->upload) && $instanceconfig->upload == plagiarism_plugin_plagscan::RUN_SUBMIT_ON_CLOSED_SUBMISSION ){
                file_handler::instance()->file_submitted($event);
            } else{
                return;
            }
        }

    /**
     * Controls the onlinetext upload event
     * 
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     */
    public static function assignsubmission_onlinetext_uploaded(
    \assignsubmission_onlinetext\event\assessable_uploaded $event) {

        $instanceconfig = plagscan_get_instance_config($event->get_context()->instanceid);
        
        if(isset($instanceconfig->upload) && $instanceconfig->upload >= plagiarism_plugin_plagscan::RUN_MANUAL && $instanceconfig->upload <= plagiarism_plugin_plagscan::RUN_DUE){
            file_handler::instance()->onlinetext_uploaded($event);
        } else{
            return;
        }
    }

}
