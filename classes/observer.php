<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');

use plagiarism_plagscan\handlers\file_handler;


class plagiarism_plagscan_observer {
    
    public static function assignsubmission_file_uploaded( 
        \assignsubmission_file\event\assessable_uploaded $event){
        plagscan_log("here in the file uploaded event");
        
        file_handler::instance()->file_uploaded($event);
    }
    
    public static function assignsubmission_onlinetext_uploaded( 
        \assignsubmission_onlinetext\event\assessable_uploaded $event){
        plagscan_log("here in the onlinetext event");
        
        file_handler::instance()->onlinetext_uploaded($event);
    }
}