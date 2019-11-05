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
use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\event\callback_received;

require(__DIR__ . '/../../config.php');

$checkcallback = optional_param('checkCallback', 0, PARAM_BOOL);
$docid = optional_param('docID', 0, PARAM_INT);
$status = optional_param('mode', -1, PARAM_INT);
$error = optional_param('error', '', PARAM_TEXT);

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
//If the callback is from the setup check method
if (!empty($checkcallback) && $checkcallback == true) {

    require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
    global $CFG, $DB;

    // Make sure multiple plagscan cron sessions don't overlap (as uploads could take a long time).
    set_config('plagscan_callbackworking', 1, 'plagiarism_plagscan');
    $c = 'Callback set up';
    $pid = 0;
} else if (isset($docid) && $docid > 0 && isset($status)) {//If the callback is sent by the convertion process
    $pid = $docid;
    if(isset($error) && strlen($error) >0)
        $c = 'Check error: '. $error;
    else
        $c = 'Upload status ' . $status;
} else { //if the callback is from the check process
    $pid = intval($_SERVER['QUERY_STRING']);
    $c = 'Check';
}

callback_received::create(array(
    'context' => \context_system::instance(),
    'other' => [
        'action' => $c,
        'pid' => $pid
    ]
))->trigger();

if (empty($pid) || $pid <= 0) {
    die(); // No PID or wrong - ignore the request
}

if (!$currentrecord = $DB->get_record('plagiarism_plagscan', array('pid' => $pid))) {
    die(); // Does not match any documents we have (or the document is already marked for updating) - ignore the request
}

if ($currentrecord->status == 3 && !is_null($currentrecord->pstatus)) {
    die(); // We already have the plagiarism % for this file
}

$upd = new \stdClass();
$upd->id = $currentrecord->id;
$upd->updatestatus = 1;
if (isset($docid) && $docid > 0 && isset($status)) { //If the callback is sent by the convertion process
    if ($status == 254) {
        $status = 1000;
    }
    if($status != -1)
        $upd->status = $status;
    if(isset($error) && strlen($error) >0 && $error == "NOCRED")
        $upd->pstatus = -2;
} else { //If the callback is sent by the check process that means it has finished 
    $upd->status = plagscan_file::STATUS_FINISHED;
    require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
    $connection = new plagscan_connection();

    $res = $connection->plaglevel_retrieve($pid);
    
    if (isset($res["response"]["data"]["plagLevel"]) && $res["response"]["data"]["plagLevel"] >= 0) {
        $upd->pstatus = $res["response"]["data"]["plagLevel"];
    }
}

$DB->update_record('plagiarism_plagscan', $upd);
