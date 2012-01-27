<?php

include_once "AuthUUID.php";
	
    $m = new Mongo();
    $collection = $m->weddingonsand->Persons;
        
    $uuid = $_REQUEST["uuid"];
    $doc = AuthUUID::validate($uuid);
    if (!$doc) {
            header('HTTP/1.0 401 Unauthorized');
    }
    else {
            $lat = $_REQUEST["lat"];
            $lon = $_REQUEST["lon"];
            $location = array("lat" => $lat, "lon" => $lon);
            $doc['last_location'] = $location;
            $collection->save($doc);
            var_dump($doc);
           
    }
?>
       