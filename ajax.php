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

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__).'/lib.php');

$data = optional_param('data', array(), PARAM_RAW);

$data = json_decode($data);

require_login();
require_sesskey();

$cmid = $data->cmid;
if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_MODULE, $cmid);
} else {
    $context = context_module::instance($cmid);
}
$PAGE->set_context($context);
if (!(has_capability('plagiarism/plagscan:viewfullreport', $context) || has_capability('plagiarism/plagscan:control', $context))) {
    $instanceconfig = plagscan_get_instance_config($cmid);
    if ($instanceconfig->show_students_links != plagiarism_plugin_plagscan::SHOWS_LINKS){
        throw new moodle_exception('Permission denied! You do not have the right capabilities.', 'plagiarism_plagscan');
    }    
}


$connection = new plagscan_connection();

$results = $connection->check_report_status($data->psreports);

echo json_encode($results,true);
die;