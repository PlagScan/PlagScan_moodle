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
 * check the current status of one or more files uploaded to PlagScan
 *
 * @package    plagiarism_plagscan
 * @subpackage plagiarism
 * @author     Jesús Prieto <jprieto@plagscan.com>
 * @copyright  2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;

require(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
global $CFG, $DB;

$cmid = optional_param('cmid', 0, PARAM_INT);
$pid = optional_param('pid', 0, PARAM_INT);
$return = required_param('return', PARAM_TEXT);

require_login();

if (!$cmid && !$pid) {
    print_error('nocmorid', 'plagiarism_plagscan');
}

if ($pid) {
    $plagscan = $DB->get_record('plagiarism_plagscan', array('pid' => $pid), '*', MUST_EXIST);
    $cmid = $plagscan->cmid;
}

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_MODULE, $cmid);
} else {
    $context = context_module::instance($cmid);
}
$PAGE->set_context($context);

if (!(has_capability('plagiarism/plagscan:viewfullreport', $context) || has_capability('plagiarism/plagscan:control', $context))) {
    throw new moodle_exception('Permission denied!', 'plagiarism_plagscan');
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
$connection->update_module_status($cmid);
if ($pid) {
    $msg = get_string('filechecked', 'plagiarism_plagscan');
} else {
    $msg = get_string('allfileschecked', 'plagiarism_plagscan');
}
$return = $return . "&action=grading";
$return = urldecode($return);
redirect($return, $msg, 2);
