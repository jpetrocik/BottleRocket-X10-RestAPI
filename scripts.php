<?php

/*
 script that perform a sequences of sX10 operations.  To invoke the 
 script the device in the x10 request is the function name;
 */

function movie($cmd){
	if ($cmd === "ON") {
		deviceOn("G", "3");
		sleep(1);
		deviceOff("G", "1");
	}
}
