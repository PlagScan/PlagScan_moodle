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
 * Wipes the PlagScan Plugin User table cache
 *
 * @package    plagiarism_plagscan
 * @subpackage plagiarism
 * @author     Jesús Prieto <jprieto@plagscan.com>
 * @copyright  2020 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;

require(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_connection.php');
global $CFG, $DB, $USER;

require_login();

$url = new moodle_url('/plagiarism/plagscan/wipe_plagscan_user_cache.php');
$PAGE->set_url($url);

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}
require_capability('moodle/site:config', $context, $USER->id, true, "nopermissions");

$result = $DB->execute('DELETE FROM {plagiarism_plagscan_user}');

if ($result) {
    $msg = get_string('wipe_plagscan_user_cache_done', 'plagiarism_plagscan');
    $time = 5;
    $notification = \core\output\notification::NOTIFY_SUCCESS;
} else {
    $msg = get_string('wipe_plagscan_user_cache_error', 'plagiarism_plagscan');
    $time = 10;
    $notification = \core\output\notification::NOTIFY_ERROR;
}

redirect('./settings.php', $msg, $time, $notification);
