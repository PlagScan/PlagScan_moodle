<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  File to receive the AJAX call for checking the file status
 * 
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Ruben Olmedo  <rolmedo@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */
define('AJAX_SCRIPT', true);

require(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');

use plagiarism_plagscan\classes\plagscan_connection;

$data = optional_param('data', array(), PARAM_RAW);

require_login();

$data = json_decode($data);

if ($data == null) {
    die('No data sent');
}

if (!is_array($data->psreports)) {
    die('Reports ids are not sent properly');
}

$psreports = array_filter($data->psreports, 'ctype_digit');

$viewlinks = filter_var($data->viewlinks, FILTER_VALIDATE_BOOLEAN);
$showlinks = filter_var($data->showlinks, FILTER_VALIDATE_BOOLEAN);
$viewreport = filter_var($data->viewreport, FILTER_VALIDATE_BOOLEAN);

$ps_yellow_level = filter_var($data->ps_yellow_level, FILTER_VALIDATE_INT);
$ps_red_level = filter_var($data->ps_red_level, FILTER_VALIDATE_INT);

$pageurl = filter_var(urldecode($data->pageurl), FILTER_SANITIZE_URL);

$cmid = $data->cmid;
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

$connection = new plagscan_connection();

$results = $connection->check_report_status($data->psreports, $context, $viewlinks, $showlinks, $viewreport, $ps_yellow_level, $ps_red_level, $pageurl);

echo json_encode($results, true);
die;
