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
 * Checks the callback configuration in the PlagScan administrator account
 *
 * @package    plagiarism_plagscan
 * @subpackage plagiarism
 * @author     Jesús Prieto <jprieto@plagscan.com>
 * @copyright  2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;

require(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_connection.php');
global $CFG, $DB;

$connection = new plagscan_connection();
$res = $connection->check_callback_config();

if ($res['httpcode'] == 204) {
    $msg = get_string('callback_setup', 'plagiarism_plagscan');
    $time = 5;
    $notification = \core\output\notification::NOTIFY_SUCCESS;
} else {
    if (isset($res['response']['error'])) {
        $msg = $res['response']['error']['message'];
    } else {
        $msg = $res['response'];
    }
    $time = 10;
    $notification = \core\output\notification::NOTIFY_ERROR;
}

redirect('./settings.php', $msg, $time, $notification);
