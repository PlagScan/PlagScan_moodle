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
 * Contains class backup_plagiarism_plagscan_plugin
 *
 * @package   plagiarism_plagscan
 * @copyright 2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @author    2020 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Class backup_plagiarism_plagscan_plugin
 *
 * @package   plagiarism_plagscan
 * @copyright 2017 Dan Marsden
 * @author    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @author    2020 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_plagiarism_plagscan_plugin extends backup_plagiarism_plugin {
    /**
     * Main plugin structure.
     */
    public function define_module_plugin_structure() {
           // Define the virtual plugin element without conditions as the global class checks already.
        $plugin = $this->get_plugin_element();

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        $plagscanconfigs = new backup_nested_element('plagscan_configs');
        $plagscanconfig = new backup_nested_element('plagscan_config', array('id'), [
                'upload',
                'cm',
                'complete',
                'username',
                'nondisclosure',
                'show_report_to_students',
                'show_students_links',
                'ownerid',
                'submissionid',
                'enable_online_text',
                'exclude_from_repository',
                'exclude_self_matches'
        ]);
        $pluginwrapper->add_child($plagscanconfigs);
        $plagscanconfigs->add_child($plagscanconfig);
        $plagscanconfig->set_source_table('plagiarism_plagscan_config', array('cm' => backup::VAR_PARENTID));

        return $plugin;
    }

    /**
     * Course plugin structure.
     */
    public function define_course_plugin_structure() {
        // Define the virtual plugin element without conditions as the global class checks already.
        $plugin = $this->get_plugin_element();

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        $plagscanconfigs = new backup_nested_element('plagscan_configs');
        $plagscanconfig = new backup_nested_element('plagscan_config', array('id'), [
                'upload',
                'cm',
                'complete',
                'username',
                'nondisclosure',
                'show_report_to_students',
                'show_students_links',
                'ownerid',
                'submissionid',
                'enable_online_text',
                'exclude_from_repository',
                'exclude_self_matches'
        ]);
        $pluginwrapper->add_child($plagscanconfigs);
        $plagscanconfigs->add_child($plagscanconfig);
        $plagscanconfig->set_source_table('config_plugins',
            array('name' => backup::VAR_PARENTID, 'plugin' => backup_helper::is_sqlparam('plagiarism_plagscan_course')));
        return $plugin;
    }
}