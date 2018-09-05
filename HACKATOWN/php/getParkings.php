<?php
/**
 * Created by PhpStorm.
 * User: MagicHack
 * Date: 2018-01-20
 * Time: 22:23
 */

require_once ('config.php');
require_once ('checkConnection.php');


if(!$_SESSION['isConnected']){
    echo '{"message" : "Not connected"}';
    exit();
}
elseif (isset($_GET['lon']) && isset($_GET['lat']) && !empty($_GET['lon']) && !empty($_GET['lat'])){
    $output = [];
    $scriptPath = "/var/www/html/Hackatown/Getlocation.py";
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
    // get json from the python script
    $command = "python3 $scriptPath " . floatval($lon) . ' ' . floatval($lat) . ' 2>&1';
    if(exec($command)){
        $dataPath = "/var/www/html/Hackatown/map.json";
        $result =  file_get_contents($dataPath);
        if($result === false){
            echo '{"message" : "Error sending map"}';
        }
        else{
            echo $result;
        }
    }
    else{
        echo '{"message" : "Something went wrong..."}';
    }
}
else{
    echo '{"message" : "Wrong params"}';
}