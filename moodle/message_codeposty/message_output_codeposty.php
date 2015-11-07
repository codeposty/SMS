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
require_once($CFG->dirroot . '/message/output/lib.php');

//require_once($CFG->dirroot . '/message/output/lib/nusoap.php');
/**
 * codeposty message processor version information
 *
 * @package    message_codeposty
 * @copyright  2015 codeposty.ir
 * @license    http://www.codeposty.ir
 */
class message_output_codeposty extends message_output {

  /**
   * Processes the message and sends a notification via codeposty
   *
   * @param stdClass $eventdata the event data submitted by the message sender plus $eventdata->savedmessageid
   * @return true if ok, false if error
   */
  function send_message($eventdata) {
    global $CFG;

    // Skip any messaging of suspended and deleted users.
    if ($eventdata->userto->auth === 'nologin' or $eventdata->userto->suspended or $eventdata->userto->deleted) {
      return true;
    }

    if (!empty($CFG->nosmsever)) {
      // hidden setting for development sites, set in config.php if needed
      debugging('$CFG->nosmsever is active, no codeposty message sent.', DEBUG_MINIMAL);
      return true;
    }

    if (PHPUNIT_TEST) {
      // No connection to external servers allowed in phpunit tests.
      return true;
    }

    //hold onto codeposty id preference because /admin/cron.php sends a lot of messages at once
    static $numbers = array();

    if (!array_key_exists($eventdata->userto->id, $numbers)) {
      $phone2 = $eventdata->userto->phone2;
      // validate $phone2
      //$phone2 = $this->mobileValidation($phone2);
      $numbers[$eventdata->userto->id] = $phone2;
    }

    $number = $numbers[$eventdata->userto->id];

    //calling s() on smallmessage causes codeposty to display things like &lt; codeposty != a browser
    $message = !empty($eventdata->smallmessage) ? $eventdata->smallmessage : $eventdata->fullmessage;
    $message = strip_tags($message);

    try {
      /*ini_set("soap.wsdl_cache_enabled", "0");
      $client = new SoapClient('http://5.9.76.186/SendService.svc?wsdl', array('encoding' => 'UTF-8'));
      $parameters['userName'] = $CFG->codepostyusername;
      $parameters['password'] = $CFG->codepostypassword;
      $parameters['fromNumber'] = $CFG->codepostynumber;
      $parameters['toNumbers'] = array($number);
      $parameters['messageContent'] = $message;
      $parameters['isFlash'] = false;
      $recId = array();
      $status = array();
      $parameters['recId'] = &$recId;
      $parameters['status'] = &$status;
      $client->SendSMS($parameters)->SendSMSResult;*/
	  ini_set("soap.wsdl_cache_enabled", "0");
    	$sms_client = new SoapClient('http://api.codeposty.ir/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));
    	
    	$parameters['username'] = $CFG->codepostyusername;
    	$parameters['password'] = $CFG->codepostypassword;
    	$parameters['to'] = $number;
    	$parameters['from'] = $CFG->codepostynumber;
    	$parameters['text'] = $message;
    	$parameters['isflash'] = false;
    	
    	$sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
    } catch (SoapFault $e) {
      debugging($e->getMessage());
      return false;
    }
    return true;
  }

  //define "98" to first of the numbet
  function mobileValidation($number) {
    $number = (int) $number;
    if (strpos($number, "98") === 0) {
      $number = substr($number, 2);
    }
    $final = "0" . $number;
    return $final;
  }

  /**
   * Creates necessary fields in the messaging config form.
   *
   * @param array $preferences An array of user preferences
   */
  function config_form($preferences) {
    global $CFG, $USER;

    if (!$this->is_system_configured()) {
      return get_string('notconfigured', 'message_codeposty');
    } else {
      return get_string('codepostymobilenumber', 'message_codeposty') . ': ' . $USER->phone2;
    }
  }

  /**
   * Parses the submitted form data and saves it into preferences array.
   *
   * @param stdClass $form preferences form class
   * @param array $preferences preferences array
   */
  function process_form($form, &$preferences) {
    
  }

  /**
   * Loads the config data from database to put on the form during initial form display
   *
   * @param array $preferences preferences array
   * @param int $userid the user id
   */
  function load_data(&$preferences, $userid) {
    
  }

  /**
   * Tests whether the codeposty settings have been configured
   * @return boolean true if codeposty is configured
   */
  function is_system_configured() {
    global $CFG;
    return (!empty($CFG->codepostynumber) && !empty($CFG->codepostyusername) && !empty($CFG->codepostypassword));
  }

  /**
   * Tests whether the codeposty settings have been configured on user level
   * @param  object $user the user object, defaults to $USER.
   * @return bool has the user made all the necessary settings
   * in their profile to allow this plugin to be used.
   */
  function is_user_configured($user = null) {
    global $USER;

    if (is_null($user)) {
      $user = $USER;
    }
    return (bool) $user->phone2;
  }

}

/*
 *
 *         $f = fopen('/tmp/event_codepostyx', 'a+');
        fwrite($f, date('l dS \of F Y h:i:s A')."\n");
        fwrite($f, "from: $message->userfromid\n");
        fwrite($f, "userto: $message->usertoid\n");
        fwrite($f, "subject: $message->subject\n");
        fclose($f);


$savemessage = new stdClass();
    $savemessage->useridfrom        = 3;
    $savemessage->useridto          = 2;
    $savemessage->subject           = 'IM';
    $savemessage->fullmessage       = 'full';
    $savemessage->timecreated       = time();


$a = new message_output_codeposty();

$a->send_message($savemessage);
* */

