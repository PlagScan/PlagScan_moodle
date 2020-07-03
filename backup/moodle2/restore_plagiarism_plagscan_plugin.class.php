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
 * Contains class restore_plagiarism_plagscan_plugin
 *
 * @package   plagiarism_plagscan
 * @copyright 2017 Dan Marsden
 * @author    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @author    2020 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Class restore_plagiarism_plagscan_plugin
 *
 * @package   plagiarism_plagscan
 * @copyright 2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @author    2020 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_plagiarism_plagscan_plugin extends restore_plagiarism_plugin {
    /**
     * Returns the paths to be handled by the plugin at question level.
     */
    protected function define_course_plugin_structure() {
        $paths = array();

        // Add own format stuff.
        $elename = 'plagscanconfig';
        $elepath = $this->get_pathfor('plagscan_configs/plagscan_config'); // We used get_recommended_name() so this works.
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths.
    }

    /**
     * Process the plagscan config data.
     * @param stdClass $data
     */
    public function process_plagscanconfig($data) {
        $data = (object)$data;

        set_config($this->task->get_courseid(), $data->value, $data->plugin);
    }

    /**
     * Returns the paths to be handled by the plugin at module level.
     */
    protected function define_module_plugin_structure() {
        $paths = array();

        // Add own format stuff.
        $elename = 'plagscanconfigmod';
        $elepath = $this->get_pathfor('plagscan_configs/plagscan_config'); // We used get_recommended_name() so this works.
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths.

    }

    /**
     * Process the plagscan config mod data.
     * @param stdClass $data
     */
    public function process_plagscanconfigmod($data) {
        global $DB;

        $data = (object)$data;

        // If multiaccount is configured get the submissionid from PlagScan.
        $multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');
        if ($multiaccount) {
            $data->submissionid = $this->get_submissionid_from_plagscan($data);
        }
        // Set the new cm after get the submissionid from plagscan
        $data->cm = $this->task->get_moduleid();

        $DB->insert_record('plagiarism_plagscan_config', $data);
    }

    /**
     * Creates the submission on PlagScan and returns the id.
     * @return int
     */
    private function get_submissionid_from_plagscan($data) {
        global $USER, $DB;

        require_once(__DIR__ . '/../../lib.php');
        require_once(__DIR__ . '/../../classes/plagscan_connection.php');
        
        $cmid = $data->cm;
        $module = get_coursemodule_from_id('assign', $cmid);

        $connection = new \plagiarism_plagscan\classes\plagscan_connection;
        $submissionid = $connection->create_submissionid($cmid, $module, $data, $USER);

        return $submissionid;
    }
}