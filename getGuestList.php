<?php

include_once "AuthUUID.php";
	
    $uuid = $_REQUEST["uuid"];
    $doc = AuthUUID::validate($uuid);
    if (!$doc) {
            header('HTTP/1.0 401 Unauthorized');
    }
    else {
        $m = Db::getDb();
        $collection = $m->weddingonsand->Persons;

        //echo "AUTH OK";
        $cursor = $collection->find();
        header('Content-Type: application/json');
        echo "{\"Persons\":[";
         foreach ($cursor as $id => $value) {
            echo "{";
            echo "\"_id\":" . "\""   . $id . "\",";
            echo "\"address\":"     .  "\"" . $value['address'] . "\",";
            echo "\"app_auth_code\":"     .  "\"" . $value['app_auth_code'] . "\",";
            echo "\"email\":"       . "\"" .  $value['email'] . "\",";
            echo "\"facebook_url\":"       . "\"" .  $value['facebook_url'] . "\",";
            echo "\"first_name\":"       . "\"" .  $value['first_name'] . "\",";
            echo "\"has_app\":"     .  $value['has_app'] . ",";
            echo "\"is_attending\":"    . $value['is_attending'] . ",";
            echo "\"is_sharing_location\":"    . $value['is_sharing_location'] . ",";
            echo "\"last_name\":"   .  "\"" . $value['last_name'] . "\",";
            echo "\"latitude\":"   .  $value['latitude'] . ",";
            echo "\"longitude\":"   .   $value['longitude'] . ",";
            echo "\"phone_number\":"   .  "\"" . $value['phone_number'] . "\",";
            echo "\"twitter_handle\":"   .  "\"" . $value['twitter_handle'] . "\",";
            echo "\"uuid\":"        .  "\"" . $value['uuid'] . "\",";
            echo "\"wedding_role\":"   .  "\"" . $value['wedding_role'] . "\",";
            echo "}";
            if ($cursor->hasNext()) {
                echo  ",";
            }
    }
    echo "]}";  
    }
?>
