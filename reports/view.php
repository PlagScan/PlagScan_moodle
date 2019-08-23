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

/* plagiarism/plagscan/view helps in generating report view the plaglevel and other details; 
 * It allows a interactive report view with a lot of details.
 * visible to students if the teacher gives permission;
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

require(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
global $CFG, $DB, $USER;

$pid = intval(required_param('pid', PARAM_TEXT));
$type = 6;
$return = required_param('return', PARAM_TEXT);

require_login();
$plagscan = $DB->get_record('plagiarism_plagscan', array('pid' => $pid), '*', MUST_EXIST);

$cmid = $plagscan->cmid;
if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_MODULE, $cmid);
} else {
    $context = context_module::instance($cmid);
}
$PAGE->set_context($context);

if (!(has_capability('plagiarism/plagscan:viewfullreport', $context) || has_capability('plagiarism/plagscan:control', $context))) {
    $instanceconfig = plagscan_get_instance_config($cmid);
    if ($instanceconfig->show_students_links != plagiarism_plugin_plagscan::SHOWS_LINKS) {
        throw new moodle_exception('Permission denied! You do not have the right capabilities.', 'plagiarism_plagscan');
    }
}

if (!get_config('plagiarism', 'plagscan_use')) {
    // Disabled at the site level
    print_error('disabledsite', 'plagiarism_plagscan');
}

$instanceconfig = plagscan_get_instance_config($cmid);
if ($instanceconfig->upload == plagiarism_plugin_plagscan::RUN_NO) {
    // Disabled for this module
    print_error('disabledmodule', 'plagiarism_plagscan');
}

$connection = new plagscan_connection();
//$connection->set_username($instanceconfig->username);
//$connection->send_report($plagscan, $type);

$is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');
$is_teacher = has_capability('plagiarism/plagscan:control', $context);

$psuserid = $connection->find_user($USER);

if (!$is_multiaccount || $instanceconfig->submissionid == null || $instanceconfig->submissionid == 'ownerid') {
    $mode = 7;
} else {
    $mode = 10;
}

$res = $connection->report_retrieve($pid, $psuserid, $mode);

if (isset($res["reportLink"])) {
    redirect($res["reportLink"]);
} else if (isset($res["message"])) {
    $msg = $res["message"];
} else {
    $msg = get_string('report_retrieve_error', 'plagiarism_plagscan');
}

$return = $return . "&action=grading";
$return = urldecode($return);
redirect($return, $msg, 2, \core\output\notification::NOTIFY_ERROR);
