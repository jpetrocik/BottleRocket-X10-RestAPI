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
	syslog(LOG_INFO, "Turning device $device off");
	smart_sendCommand('http://' . $device . '.local/off');
}

//turns on a single device
function smart_deviceOn($device) {
	syslog(LOG_INFO, "Turning device $device on");
	smart_sendCommand('http://' . $device . '.local/on');
}


function smart_checkDeviceStatus($device){
	syslog(LOG_INFO, "Checking device $device status");
	$response = smart_sendCommand('http://' . $device . '.local/');
	$obj = json_decode($response);
	if ($obj->{'status'} == 'ON')
		return true;
	return false;
}

?>
