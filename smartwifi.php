<?php

openlog("wifismart", LOG_PID | LOG_PERROR, LOG_LOCAL0);

function smart_sendCommand($args) {
	$request = new http\Client\Request("GET",$args);

	$client = new http\Client;
	$client->enqueue($request)->send();

	$response = $client->getResponse();
    return $response->getBody();
}

//turns off a single device
function smart_deviceOff($device) {
	syslog(LOG_INFO, "Turning device $house $device off");
	smart_sendCommand('http://192.168.1.' . $device . '/off');
}

//turns on a single device
function smart_deviceOn($device) {
	syslog(LOG_INFO, "Turning device $house $device on");
	smart_sendCommand('http://192.168.1.' . $device . '/on');
}


function smart_checkDeviceStatus($device){
	syslog(LOG_INFO, "Checking device $house $device status");
	$response = smart_sendCommand('http://192.168.1.' . $device . '/');
	$obj = json_decode('{"status":"OFF"}');
	if ($obj->{'status'} == 'on')
		return true;
	return false;
}

?>
