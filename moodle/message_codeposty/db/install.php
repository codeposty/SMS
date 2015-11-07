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
 * codeposty message processor version information
 *
 * @package    message_codeposty
 * @copyright  2015 codeposty.ir
 * @license    http://www.codeposty.ir
 */

/**
 * Install the codeposty message processor
 */
function xmldb_message_codeposty_install(){
    global $DB;

    $result = true;

    $provider = new stdClass();
    $provider->name  = 'codeposty';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
