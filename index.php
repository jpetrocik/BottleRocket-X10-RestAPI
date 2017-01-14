<?php

//house	device	description
//G	1	living room ceilling lights
//G	2	landscape lights

//light on lock file created when on, delete when off
$lv_lock_file="/tmp/lv.light";

function lightsOff($lock_file) {
        exec('/usr/bin/br -x /dev/ttyS0 G ALL_OFF');
        unlink($lock_file);
}

function lightsOn($lock_file) {
        exec('/usr/bin/br -x /dev/ttyS0 G ALL_ON');
        touch($lock_file);
}

function checkLightStatus($lock_file){
    if (file_exists($lock_file)){

            //assume lights are off if file is old
            $fmtime = filemtime($lock_file);
            if (time() - $fmtime < 14400000) {
            	return true;
            }
    }

    return false;
}

$cmd = $_GET["cmd"];
if ($cmd === "ALL_OFF") {
    lightsOff($lv_lock_file);
	$light_on = false;
} elseif ($cmd === "ALL_ON") {
    lightsOn($lv_lock_file);
	$light_on = true;
} elseif ($cmd === "STATUS") {
    $light_on = checkLightStatus($lv_lock_file);
} else {  //toggle lights
    $light_on = checkLightStatus($lv_lock_file);

    if ($light_on) {
        lightsOff($lv_lock_file);
    } else {
        lightsOn($lv_lock_file);
    }
    $light_on = !$light_on;
}

$results = array('light' => $light_on?"on":"off");
echo json_encode($results);
?>
