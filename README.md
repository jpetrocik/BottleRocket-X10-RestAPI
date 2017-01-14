# x10-restapi

A php restful service to turn on and off X10 lights and devices for home automation. Since X10 doesn't report whether the light is off or on, the status is maintained via the code. 

Using this API you can develop richer home automation clients.  Currently, I've developed an Android widget and Alexa skill service that allows me to easily turn off and on lights using my phone or voice.


# Requirements

The X10 protocol sends messages through electrical wires.  To generate these message you need a few piece of inexpensive hardware along with the X10 switches and modules.  

### Firecracker And BottleRocket

Firecracker is an X10 serial module for controlling X10 devices with your computer.  The module sends RF signals to an X10 transceiver. BottleRocket is a Linux command line tool for controlling Firecracker.

https://www.amazon.com/FireCracker-Computer-Interface-CM17A-X10/dp/B008QHW8H2/ref=sr_1_1?ie=UTF8&qid=1484385667&sr=8-1&keywords=firecracker+x10

http://www.linuxha.com/bottlerocket/

### X10 Transceiver

The X10 Transceiver translates the RF signals sent by Firecracker into electrical messages, that cause the lights to turn on or off.


# Installing
Copy the index.php file to any apache server.  Make sure mod_php is enable on apache2.

# Using the API

Turn Lights/Device On

http://127.0.0.1/[path]/index.php?cmd=ON&device=[deviceId]

Turn Lights/Device Off

http://127.0.0.1/[path]/index.php?cmd=OFF&device=[deviceId]

Toggle Lights/Device On and Off

http://127.0.0.1/[path]/index.php?device=[deviceId]

Turn All Lights/Device On

http://127.0.0.1/[path]/index.php?cmd=ALL_ON

Turn All Lights/Device Off

http://127.0.0.1/[path]/index.php?cmd=ALL_OFF


# Future RestFul Endpoints

The current API calls are not very RESTFul.  I am working on a new version of the endpoints.

For controlling a specific device:

http://127.0.0.1/[path]/[house]/[device]

GET: Returns status

POST: Turns On

DELETE: Turns Off

PUT: Toggles On/Off

For turning on or off all devices

http://127.0.0.1/[path]/[house]

POST: Turns On

DELETE: Turns Off





