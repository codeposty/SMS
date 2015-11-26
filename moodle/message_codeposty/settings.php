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
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree){
	$settings->add(new admin_setting_configtext('codepostynumber', get_string('codepostynumber', 'message_codeposty'), 
		get_string('configcodepostynumber', 'message_codeposty'), '', PARAM_RAW));
	$settings->add(new admin_setting_configtext('codepostyusername', get_string('codepostyusername', 'message_codeposty'), 
		get_string('configcodepostyusername', 'message_codeposty'), '', PARAM_RAW));
	$settings->add(new admin_setting_configpasswordunmask('codepostypassword', get_string('codepostypassword', 'message_codeposty'), 
		get_string('configcodepostypassword', 'message_codeposty'), ''));
}
