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
 * settings.php - allows the admin to configure plagiarism stuff
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Daniel Gockel  <dgockel@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/plagiarismlib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/classes/plagscan_settings_form.php');

use plagiarism_plagscan\classes\plagscan_connection;

require_login();

$url = new moodle_url('/plagiarism/plagscan/settings.php');
$PAGE->set_url($url);

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}
require_capability('moodle/site:config', $context, $USER->id, true, "nopermissions");

$PAGE->set_context($context);

//require form
$mform = new \plagiarism_plagscan\classes\plagscan_settings_form();
$plagiarismsettings = (array) get_config('plagiarism_plagscan');

$connection = new plagscan_connection();
$apimapping = $connection->get_user_settings_mapping();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/plagiarism/plagscan/settings.php');
    $PAGE->set_url($url);
}

echo $OUTPUT->header();
// user clicked on save changes
if (($data = $mform->get_data()) && confirm_sesskey()) {

    //plagscan_use will not be send if it's false
    if (!isset($data->plagscan_use)) {
        $data->plagscan_use = 0;
    }
    if (!isset($data->plagscan_email_notification_account)) {
        $data->plagscan_email_notification_account = 0;
    }

    set_config('plagscan_use', $data->plagscan_use, 'plagiarism');
    set_config('plagscan_use', $data->plagscan_use, 'plagiarism_plagscan');

    // Save all local only settings first (as these could affect the server connection parameters).
    $localonlysettings = array('plagscan_id' => true,
        'plagscan_key' => true,
        'plagscan_server' => true,
        'plagscan_student_disclosure' => false,
        'plagscan_studentpermission' => false,
        'plagscan_multipleaccounts' => false,
        'plagscan_nondisclosure_notice_email' => false,
        'plagscan_email_notification_account' => false,
        'plagscan_groups' => true,
        'plagscan_defaults_exclude_self_matches' => false,
        'plagscan_defaults_exclude_from_repository' => false,
        'plagscan_defaults_online_text' => false,
        'plagscan_defaults_show_to_students' => false,
        'plagscan_defaults_show_students_links' => false
    );

    //copy submitted localonlysettings to local copy (plagiarism_plagscan)
    $fullserverupdate = false;
    foreach ($localonlysettings as $field => $requirefullupdate) {
        if ( ($field == 'plagscan_defaults_exclude_self_matches' || $field == 'plagscan_defaults_exclude_from_repository') && (!isset($data->$field) || $data->$field == null) ) {
            $data->$field = 0;
        }

        $value = $data->$field;
        if (isset($plagiarismsettings->$field) && $plagiarismsettings->$field == $value) { //local property copy is equal to submitted property
            continue; //Setting unchanged
        }

        // Save the setting
        if($field == 'plagscan_server'){
            $value = rtrim($value, '/');
        }
        set_config($field, $value, 'plagiarism_plagscan');

        // Check if changing this setting means a full update of server settings is required
        if ($requirefullupdate) {
            $fullserverupdate = true;
        }
    }

    //set autostart for plagscan analysis
    //$connection->enable_auto_analysis();
    //END set autostart for plagscan analysis
    // Links the local setting name to the server setting name
    $result = true; //Plagscan API parameters
    $updatesettings = new \stdClass();

    foreach ($apimapping as $field => $serverfield) {
        if (!isset($data->$field) || $data->$field == null) {
            $data->$field = 0;
        }

        $value = $data->$field;
        if (isset($plagiarismsettings->$field) && $plagiarismsettings->$field == $value) {
            if (!$fullserverupdate) {
                continue; // Setting is unchanged - don't update / send to server
            }
        }

        // Save the config setting locally
        set_config($field, $value, 'plagiarism_plagscan');

        // Send the new value to the server
        if ($serverfield != "redLevel" && $serverfield != "yellowLevel") {
            $updatesettings->$serverfield = $value;
        }
    }
    
    $try_connection = $connection->check_connection_to_plagscan_server();
    if($try_connection['httpcode'] != 200)
        echo $OUTPUT->notification(get_string('connectionfailed', 'plagiarism_plagscan'), 'notifyerror');

    $token = $connection->get_access_token($data->plagscan_id, $data->plagscan_key);
    if ($token == NULL)
        echo $OUTPUT->notification(get_string('badcredentials', 'plagiarism_plagscan'), 'notifywarning');

    if (get_config('plagiarism_plagscan', 'plagscan_multipleaccounts') == 0) {
        $user = $DB->get_record("user", array("email" => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
        if ($user != false && $token != NULL) {
            $serversettings = (array) $connection->get_user_settings($user);

            foreach ($apimapping as $field => $serverfield) {
                if (isset($serversettings[$serverfield])) {
                    $value = $serversettings[$serverfield];
                    if ($serverfield == "redLevel" || $serverfield == "yellowLevel") {
                        $value = $value / 10;
                    }

                    $plagiarismsettings[$field] = $value;
                }
            }
        }
    }

    if ($data->plagscan_multipleaccounts == 0 && isset($data->plagscan_admin_email)) {

        $admin_email = filter_var($data->plagscan_admin_email, FILTER_VALIDATE_EMAIL);
        $user = $DB->get_record('user', array('email' => $admin_email));
        if ($user != false && $token != NULL) {
            $result = $connection->set_user_settings($user, $updatesettings);
            set_config('plagscan_admin_email', $data->plagscan_admin_email, 'plagiarism_plagscan');
        } else {
            echo $OUTPUT->notification(get_string('savedapiconfigerror_admin_email', 'plagiarism_plagscan'), 'notifyerror');
            $result = false;
        }
    }
    //satus message
    if (!$result) {
        echo $OUTPUT->notification(get_string('savedapiconfigerror', 'plagiarism_plagscan'), 'notifyerror');
    } else {
        echo $OUTPUT->notification(get_string('savedconfigsuccess', 'plagiarism_plagscan'), 'notifysuccess');
    }
}

$mform->set_data($plagiarismsettings);
//get configuration from server and save it local
/*
  try {
  $tempconnection = new plagscan_connection(true);
  $serversettings = (array)$tempconnection->get_user_settings();
  $apimapping = $tempconnection->get_user_settings_mapping();
  foreach ($apimapping as $field => $serverfield) {
  if (isset($serversettings[$serverfield])) {
  $value = $serversettings[$serverfield];
  $plagiarismsettings->$field = $value;
  }
  }
  } catch (moodle_exception $e) {
  // Ignore any connection problems.
  }
 */


echo $OUTPUT->box_start('generalbox boxaligncenter', 'intro');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
