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

/* plagiarism/plagscan/submit Allows to trigger the submit action in case the 
 * file is not yet submitted to PlagScan and the did not plugin receive an ID.
 */

/**
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo  <rolmedo@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\handlers\file_handler;


require(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
global $CFG, $DB, $USER;
$PAGE->set_url(new moodle_url('/plagiarism/plagscan/reports/submit.php'));

require_login();

$cmid = required_param('cmid', PARAM_INT);
$pathnamehash = optional_param('pathnamehash', '',PARAM_RAW);
//$content = optional_param('content', '', PARAM_RAW);
//$objectid = optional_param('objectid', 0, PARAM_INT);
$userid = required_param('userid', PARAM_INT);
$return = required_param('return', PARAM_TEXT);

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_MODULE, $cmid);
} else {
    $context = context_module::instance($cmid);
}
$PAGE->set_context($context);

if (!(has_capability('plagiarism/plagscan:viewfullreport', $context) || has_capability('plagiarism/plagscan:control', $context))) {
    throw new moodle_exception('Permission denied! You do not have the right capabilities.', 'plagiarism_plagscan');
}

if (!get_config('plagiarism', 'plagscan_use')) {
    // Disabled at the site level
    print_error('disabledsite', 'plagiarism_plagscan');
}

$notification = \core\output\notification::NOTIFY_SUCCESS;

if(isset($pathnamehash) && !empty($pathnamehash)){
    $hashes = array();
    array_push($hashes, $pathnamehash);
    file_handler::instance()->file_uploaded_without_event($context,$userid, $hashes);

}

//if(isset($content) && !empty($content) && isset($objectid) && $objectid != 0){
//    file_handler::instance()->onlinetext_uploaded_without_event($context, $userid, $content, $objectid);
//}


$return = $return . "&action=grading";
$return = urldecode($return);
redirect($return);