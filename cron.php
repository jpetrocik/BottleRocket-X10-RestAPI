<?php
include 'x10.php';

/*
* Stores a file with next on and off times
*
* [landscape]
* on=17:35
* off=22:00
*/
function landscapeLights() {

	//check status
	$status = checkDeviceStatus('G', 2);

	//check the current status and determin whether
	//were should turn the lights on or off
	if ($status) {
		$now = time();
		$offTime = gmmktime(06, 30, 00);
		if ($now > $offTime) {
			deviceOff('G',2);
		}
	} else {
		$now = time();
		$onTime = gmmktime(01, 44, 00);
		if ($now > $onTime) {
			deviceOn('G',2);
		}
	}

}

landscapeLights();

?>
