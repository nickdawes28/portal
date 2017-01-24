<?php
include 'libraries/httpful.phar';
$test = "This is an automated message from Glacier Guides.";

$url = "https://rest.textmagic.com/api/v2/messages";
$server_response_total_participants = \Httpful\Request::post($url)
    ->sendsJson()
    ->body('
        {
            "text": "'.$test.'",
            "phones": 3548206720
        }
    ')
    ->addHeaders(array(
        'X-TM-Username' => "nickdawes",
        'X-TM-Key' => "aMuRsZPMFt46rWhyorRdQnH4H5SdOB",
    ))
    ->send();
$server_response_total_participants_array = json_decode($server_response_total_participants, true);
var_dump($server_response_total_participants);
echo "<br><br><br>";
var_dump($server_response_total_participants_array);
echo $test;
?>