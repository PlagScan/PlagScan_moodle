<?php

// This file is part of the Plagscan plugin for Moodle - http://moodle.org/
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
 * assign_creation_completed.php
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\event;

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class assign_creation_completed extends \core\event\base {

    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'plagiarism_plagscan';
    }

    public static function get_name() {
        return get_string('event_assign_creation_completed', 'plagiarism_plagscan');
    }

    public function get_description() {
        $desc = 'The assignment ' . $this->objectid . ' creation in Plagscan completed';
        if (isset($this->other['submissionid']))
            $desc .= ' with id ' . $this->other['submissionid'];
        return $desc;
    }

}
