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
 * plagscan_userconfig_form.php - allows to configure plagscan settings for individual account
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Jesús Prieto <jprieto@plagscan.com> (Based on the work of Daniel Gockel  <dgockel@plagscan.com>)
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\classes;

use plagiarism_plagscan\classes\plagscan_connection;
use moodleform;

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir . '/formslib.php');

class plagscan_userconfig_form extends moodleform {

    /**
     * Defines the user config form
     */
    public function definition() {
        $mform = $this->_form;

        $languageoptions = array(0 => get_string('english', 'plagiarism_plagscan'), 1 => get_string('german', 'plagiarism_plagscan'), 2 => get_string('spanish', 'plagiarism_plagscan'), 3 => get_string('french', 'plagiarism_plagscan'));
        $emailoptions = array(0 => get_string('never', 'plagiarism_plagscan'), 1 => get_string('always', 'plagiarism_plagscan'), 2 => get_string('if_plagiarism_level', 'plagiarism_plagscan'));
        //$dataoptions = array( 0 => get_string('noone', 'plagiarism_plagscan'), 1 => get_string('noonedocs', 'plagiarism_plagscan'), 2 => get_string('myinstitution', 'plagiarism_plagscan'), 3 => get_string('generaldatabase', 'plagiarism_plagscan'));
        $autostartoptions = array(0 => get_string('no'), 1 => get_string('yes'));
        $autodel = array(0 => get_string('week', 'plagiarism_plagscan'), 1 => get_string('weeks', 'plagiarism_plagscan'), 2 => get_string('months', 'plagiarism_plagscan'), 3 => get_string('neverdelete', 'plagiarism_plagscan'));
        $docx = array(0 => get_string('docxemail', 'plagiarism_plagscan'),
            1 => get_string('docxgenerate', 'plagiarism_plagscan'),
            2 => get_string('docxnone', 'plagiarism_plagscan'));
        $ssty = array(0 => get_string('sstylow', 'plagiarism_plagscan'),
            1 => get_string('sstymedium', 'plagiarism_plagscan'),
            2 => get_string('sstyhigh', 'plagiarism_plagscan'));
        $yellow = array(1 => '1 %',
            2 => '2 %',
            3 => '3 %',
            4 => '4 %',
            5 => '5 %',
            6 => '6 %',
            7 => '7 %',
            8 => '8 %',
            9 => '9 %',
            10 => '10 %'
        );
        $red = array(5 => '5 %',
            6 => '6 %',
            7 => '7 %',
            8 => '8 %',
            9 => '9 %',
            10 => '10 %',
            11 => '11 %',
            12 => '12 %',
            13 => '13 %',
            14 => '14 %',
            15 => '15 %'
        );

        $mform->addElement('select', 'plagscan_language', get_string("api_language", "plagiarism_plagscan"), $languageoptions);
        $mform->setDefault('plagscan_language', '0');


        $mform->addElement('select', 'plagscan_email_policy', get_string("email_policy", "plagiarism_plagscan"), $emailoptions);
        $mform->setDefault('plagscan_email_policy', '0');

        $mform->addElement('select', 'plagscan_docx', get_string('handledocx', 'plagiarism_plagscan'), $docx);
        $mform->setDefault('plagscan_docx', 0);

        //$mform->addElement('select', 'plagscan_data_policy', get_string("data_policy", "plagiarism_plagscan"), $dataoptions);
        //$mform->disabledIf('plagscan_data_policy', 'plagscan_use', 'eq', 0);
        //$mform->addHelpButton('plagscan_data_policy', 'datapolicyhelp', 'plagiarism_plagscan');
        $mform->addElement('checkbox', 'plagscan_web', get_string("plagscan_web_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_own_workspace', get_string("plagscan_own_workspace_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_own_repository', get_string("plagscan_own_repository_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_orga_repository', get_string("plagscan_orga_repository_policy", "plagiarism_plagscan"));

        $mform->addElement('checkbox', 'plagscan_plagiarism_prevention_pool', get_string("plagscan_ppp_policy", "plagiarism_plagscan"));


        $mform->addElement('select', 'plagscan_autodel', get_string("autodel", "plagiarism_plagscan"), $autodel);
        $mform->setDefault('plagscan_autodel', '3');

        //$mform->addElement('advcheckbox', 'plagscan_web', get_string('webonly', 'plagiarism_plagscan'), '', array('group' => 1), array(0, 1));

        $mform->addElement('select', 'plagscan_ssty', get_string("ssty", "plagiarism_plagscan"), $ssty);
        $mform->setDefault('plagscan_ssty', 1);

        $mform->addElement('select', 'plagscan_yellow', get_string("yellow", "plagiarism_plagscan"), $yellow);

        $mform->addElement('select', 'plagscan_red', get_string("red", "plagiarism_plagscan"), $red);
        /*
          $radioarray=array();
          $radioarray[] =& $mform->createElement('radio', 'yesno', '', $share->0 , 1, 1);
          $radioarray[] =& $mform->createElement('radio', 'yesno', '', $share->0, 0, 2);
          $mform->addGroup($radioarray, 'radioar', '', array(' '), false);
         */
        $this->add_action_buttons(false);
    }

}
