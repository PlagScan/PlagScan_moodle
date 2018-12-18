<?php

// This file is part of Moodle - http://moodle.org/
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
 * Record the fact that uploading/checking process is now complete for a file on the server
 *
 * @package    plagiarism_plagscan
 * @subpackage plagiarism
 * @author     Jesús Prieto <jprieto@plagscan.com>
 * @copyright  2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');

//If the callback is from the convertion process
if(isset($_GET["checkCallback"]) && $_GET["checkCallback"] == true){
    
    require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');
    global $CFG, $DB;

    // Make sure multiple plagscan cron sessions don't overlap (as uploads could take a long time).
    set_config('plagscan_callbackworking', 1, 'plagiarism_plagscan');
    
    die();
}
else if(isset($_GET["docID"]) && isset($_GET["status"])){
    $pid = intval($_GET["docID"]);
    $status = $_GET["status"];
}
else { //if the callback is from the check process
    $pid = intval($_SERVER['QUERY_STRING']);
}

if (empty($pid) || $pid <= 0) {
    die(); // No PID or wrong - ignore the request
}

if (!$currentrecord = $DB->get_record('plagiarism_plagscan', array('pid' => $pid))) {
    die(); // Does not match any documents we have (or the document is already marked for updating) - ignore the request
}

if ($currentrecord->status == 3 && !is_null($currentrecord->pstatus)) {
    die(); // We already have the plagiarism % for this file
}

$upd = new stdClass();
$upd->id = $currentrecord->id;
$upd->updatestatus = 1;
if(isset($status)){ //If the callback is sent by the convertion process
    if($status == 254)
        $status = 1000;
    $upd->status = $status;
    
}
else{ //If the callback is sent by the check process that means it has finished 
    $upd->status = 3;
    require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');
    $connection = new plagscan_connection();

    $result = $connection->plaglevel_retrieve($pid);
     if($result >= 0){
        $upd->pstatus = $result;
     }
}
$DB->update_record('plagiarism_plagscan', $upd);