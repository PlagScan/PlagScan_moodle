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
 * callback_received.php
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

class callback_received extends \core\event\base {

    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    public static function get_name() {
        return get_string('event_callback_received', 'plagiarism_plagscan');
    }

    public function get_description() {
        $desc = 'Callback received: ' . $this->other['action'];
        if (isset($this->other['pid']) && $this->other['pid'] > 0)
            $desc .= ' - pid ' . $this->other['pid'];
        return $desc;
    }

}
