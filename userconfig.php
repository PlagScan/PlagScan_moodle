<?php

// This file is part of the PlagScan plugin for Moodle - http://moodle.org/
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
 * userconfig.php - update a specific user's settings
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Daniel Gockel  <dgockel@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\classes\plagscan_userconfig_form;

require(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_userconfig_form.php');

$url = new moodle_url('/plagiarism/plagscan/userconfig.php');
$PAGE->set_url($url);
if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}
$PAGE->set_context($context);

require_login();
//require_sesskey();

if (!get_config('plagiarism_plagscan', 'plagscan_multipleaccounts')) {
    print_error('nomultipleaccounts', 'plagiarism_plagscan');
}

global $USER;
$connection = new plagscan_connection();
//$connection->set_username($USER->email);
$serversettings = (array) $connection->get_user_settings($USER);

$settings = new stdClass();
$apimapping = $connection->get_user_settings_mapping();

foreach ($apimapping as $field => $serverfield) {
    if (isset($serversettings[$serverfield])) {
        $value = $serversettings[$serverfield];
        if ($serverfield == "redLevel" || $serverfield == "yellowLevel") {
            $value = $value / 10;
        }
        
        $settings->$field = $value;
    }
}

$form = new plagscan_userconfig_form();
$form->set_data($settings);

$msg = '';
if ($data = $form->get_data()) {
    //set autostart for plagscan analysis
    //$connection->enable_auto_analysis();
    //END set autostart for plagscan analysis

    $result = true;
    $updatesettings = new stdClass();
    // Send settings back to the server.
    foreach ($apimapping as $field => $serverfield) {
        //if (isset($data->$field) && $data->$field != $settings->$field) {
        // Setting has changed - update the server.

        if (!isset($data->$field) || $data->$field == null) {
            $data->$field = 0;
        }

        $updatesettings->$serverfield = $data->$field;

        //$result = $connection->set_user_setting($USER, $serverfield, $data->$field) & $result;
        //}
    }

    $result = $connection->set_user_settings($USER, $updatesettings);


    if ($result) {
        $msg = get_string('savedconfigsuccess', 'plagiarism_plagscan');
        $msgclass = 'notifysuccess';
    } else {
        $msg = get_string('savedapiconfigerror', 'plagiarism_plagscan');
        $msgclass = 'notifyerror';
    }
}

$username = fullname($USER) . " ({$USER->email})";

$PAGE->set_title(get_string('pluginname', 'plagiarism_plagscan'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('settingsfor', 'plagiarism_plagscan', $username));
if ($msg) {
    echo html_writer::tag('p', $msg, array('class' => $msgclass));
}
$form->display();
echo $OUTPUT->footer();
