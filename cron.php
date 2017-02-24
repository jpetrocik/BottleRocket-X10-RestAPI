<?php
require_once 'Config/Lite.php';
include 'x10.php';

$config = new Config_Lite('config.ini');

date_default_timezone_set('America/Los_Angeles');
/*
 * Turns the light on or off based on a time window.  Lights will
 * only get turned off if they are on between a 10 minute window
 * of the off time.  This allows for the lights to be turned 
 * on outside of this timer window.
 */
function lightTimer($light){
	global $config;

	$offTime = $config->get($light, 'nextOffTime');
	$onTime = $config->get($light, 'nextOnTime');
	$house = $config->get($light, 'house');
	$device = $config->get($light, 'device');

	$status = checkDeviceStatus($house, $device);

	$now = time();

	if ( $now > $offTime ) {

		//turn the lights on if they are off
		if ($status) {
			deviceOff($house, $device);
		}

		//updated next offTime
		$offTime += (24 * 60 * 60);
		$config->set($light, 'nextOffTime', $offTime);
		$config->save();


	} elseif ($now > $onTime) {

		//turn the lights off if they are on
		if (!$status) {
			deviceOn($house, $device);
		}

		//updated next onTime
		$onTime += (24 * 60 * 60);
		$config->set($light, 'nextOnTime', $onTime);
		$config->save();
	} else {
		if (!$status) {
				syslog(LOG_INFO, "$light lights will turn on at " . date(DATE_RFC2822, $onTime));
			} else {
				syslog(LOG_INFO, "$light lights will turn off at " . date(DATE_RFC2822, $offTime));
			}
	}
}

/*
* Truns off and on landscape lights based on
* config.ini landscape settings
*/
function landscapeLights() {
	lightTimer("Landscape");
}

landscapeLights();



?>
