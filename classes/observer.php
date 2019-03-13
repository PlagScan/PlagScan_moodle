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

require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');

use plagiarism_plagscan\handlers\file_handler;


class plagiarism_plagscan_observer {
    
    /**
     * Controls the file upload event
     * 
     * @param \assignsubmission_file\event\assessable_uploaded $event
     */
    public static function assignsubmission_file_uploaded( 
        \assignsubmission_file\event\assessable_uploaded $event){
        
        file_handler::instance()->file_uploaded($event);
    }
    
    /**
     * Controls the onlinetext upload event
     * 
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     */
    public static function assignsubmission_onlinetext_uploaded( 
        \assignsubmission_onlinetext\event\assessable_uploaded $event){
        
        file_handler::instance()->onlinetext_uploaded($event);
    }
}