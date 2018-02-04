<?php
include 'x10.php';
include 'smartwifi.php';
include 'scripts.php';
include 'auth.php';

//house	device	description
//G	1	living room ceilling lights
//G	2	landscape lights

$default_house = "G";

$cmd = $_GET["cmd"];

$device = $_GET["device"];
if (!isset($device))
	$device = 1;

$house = $_GET["house"];
if (!isset($house))
	$house = $default_house;


if (function_exists($device)) {
	$device($cmd);
	$status = true;
} elseif ($cmd === "ALL_OFF") {
	allOff($house);
	$status = false;
} elseif ($cmd === "ALL_ON") {
	allOn($house);
	$status = true;
} elseif ($cmd === "OFF") {
	if ($device < 16)
		deviceOff($house, $device);
	else 
		smart_deviceOff($device);
	$status = false;
} elseif ($cmd === "ON") {
	if ($device < 16)
		deviceOn($house, $device);
	else 
		smart_deviceOn($device);
	$status = true;
} elseif ($cmd === "STATUS") {
	if ($device < 16)
		$status = checkDeviceStatus($house, $device);
	else 
		$status = smart_checkDeviceStatus($device);
} else {  //toggle lights
	$status = checkDeviceStatus($house, $device);

	if ($status) {
		deviceOff($house, $device);
	} else {
		deviceOn($house, $device);
	}
	$status = !$status;
}

closelog();

$results = array('house' => $house, 'device' => $device, 'status' => $status?"on":"off");
echo json_encode($results);
?>
