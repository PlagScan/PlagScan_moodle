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
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesus Prieto  <jprieto@plagscan.com> (Based on the work of Ruben Olmedo  <rolmedo@plagscan.com>)
 * @copyright   2019 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/plagiarism/plagscan/lib.php');
global $CFG, $DB, $PAGE;

$PAGE->set_url(new moodle_url('/plagiarism/plagscan/view.php'));

$pid = intval($_SERVER["QUERY_STRING"]);

$connection = new plagscan_connection();

$res = $connection->report_retrieve($pid, null, 1);

if (isset($res["indocLink"])) {
    redirect($res["indocLink"]);
} else if (isset($res["message"])) {
    $msg = $res["message"];
} else {
    $msg = get_string('report_retrieve_error', 'plagiarism_plagscan');
}

$return = new moodle_url('/course');
$return = urldecode($return);
redirect($return, $msg, 2, \core\output\notification::NOTIFY_ERROR);
