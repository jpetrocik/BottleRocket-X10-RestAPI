<?php

openlog("x10", LOG_PID | LOG_PERROR, LOG_LOCAL0);

//lock file created when on, delete when off,
//used to indicate current status
//possible to get out of sync when lights are
//manually turned off
$x10_lock_dir = "/var/lock/x10/";

function sendCommand($args) {
	exec('/usr/bin/br -x /dev/ttyS0 ' . $args);
}

//turns on all devices
function allOff($house) {
	global $x10_lock_dir;

	syslog(LOG_INFO, "Turning all devices off at $house");
	sendCommand($house . ' ALL_OFF');
	$files = glob($x10_lock_dir . "*.on");
	foreach ($files as $value) {
		unlink($value);
	}
}

//turns off all devices
function allOn($house) {
	global $x10_lock_dir;

	syslog(LOG_INFO, "Turning all devices on at $house");
	sendCommand($house . ' ALL_ON');
	for ($i = 1; $i < 16; $i++) {
		touch($x10_lock_dir . $house . $i . '.on');
	}
}

//turns off a single device
function deviceOff($house, $device) {
	global $x10_lock_dir;

	syslog(LOG_INFO, "Turning device $house $device off");
	sendCommand($house . $device . ' OFF');
	unlink($x10_lock_dir . $house . $device . '.on');
}

//turns on a single device
function deviceOn($house, $device) {
	global $x10_lock_dir;

	syslog(LOG_INFO, "Turning device $house $device on");
	sendCommand($house . $device . ' ON');
	touch($x10_lock_dir . $house . $device . '.on');
}


function checkDeviceStatus($house, $device){
	global $x10_lock_dir;

	$lock_file = $x10_lock_dir . $house . $device . '.on';
	if (file_exists($lock_file)){

			//assume lights are off if file is old
			$fmtime = filemtime($lock_file);
			if (time() - $fmtime < 14400000) {
				return true;
			}
	}

	return false;
}

?>
