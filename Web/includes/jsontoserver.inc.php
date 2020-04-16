<?php
$device = $_GET["device"]; # This needs to have input validation! Fortunately the Pi should has some, but that's not enough...
$command = $_GET["command"];
$value = $_GET["value"];
$data;
$data_string;
try
{
    if ($device === "motor")
        $data = array("device" => $device, "command" => "move", "value" => intval($value));         
    else if ($device === "light" && $command === "switch")
        $data = array("device" => "light", "command" => "switch", "value" => boolval($value));         
    else if ($device === "light" && $command === "timer")
        $data = array("device" => "light", "command" => "timer", "value" => floatval($value));         
    else
    {
        # echo '{"message" : "Invalid Input!"}'
        exit();
    }
    $data_string = json_encode($data);
    $ch = curl_init('http://75.168.242.3:5000/api/device/ '); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                                                                                                                      
    curl_exec($ch); # Change to: echo curl_exec($ch); This can be used to return a value to the client, thus establishing a two-way communication.
    curl_close($ch);
} catch(Exception $e)
{
#    echo '{"message" : ' . $e->getMessage() . '}'; # Use this to send the JSON {"message":"error message goes here"} which is what the web server sends as an error.
}


?>
