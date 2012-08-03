<?php

include_once "AuthUUID.php";
	
    $m = new Mongo();
    $collection = $m->weddingonsand->Locations;
        
    $uuid = $_REQUEST["uuid"];
    $doc = AuthUUID::validate($uuid);
    if (!$doc) {
            header('HTTP/1.0 401 Unauthorized');
    }
    else {
            $lat = $_REQUEST["lat"];
            $lon = $_REQUEST["lon"];
            $location_doc = array(
                "lat" => $lat,
                "lon" => $lon,
                "uuid" =>  $uuid
                );
            $collection->save($location_doc);
            var_dump($doc);
           
    }
?>
       