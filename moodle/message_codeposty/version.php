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

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2013110501; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires = 2013110500; // Requires this Moodle version.
$plugin->component = 'message_codeposty'; // Full name of the plugin (used for diagnostics).
$plugin->maturity = MATURITY_STABLE;
$plugin->release = 'v2.9-r2'; // Our first release for moodle 2.9.x branch.
