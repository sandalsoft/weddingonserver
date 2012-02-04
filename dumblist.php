<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    $m = new Mongo();
    $collection = $m->weddingonsand->Persons;
        
    //echo "AUTH OK";
    $cursor = $collection->find();
    header('Content-Type: application/json');
    echo "{\"Persons\":[";
     foreach ($cursor as $id => $value) {
        echo "{";
       // echo "\"Person\": {";
        echo "\"id\":" . "\""   . $id . "\",";
        echo "\"address\":"     .  "\"" . $value['address'] . "\",";
        echo "\"app_auth_code\":"     .  "\"" . $value['app_auth_code'] . "\",";
        echo "\"email\":"       . "\"" .  $value['email'] . "\",";
        echo "\"facebook_url\":"       . "\"" .  $value['facebook_url'] . "\",";
        echo "\"first_name\":"       . "\"" .  $value['first_name'] . "\",";
        echo "\"has_app\":"     .  "\"" . $value['has_app'] . "\",";
        echo "\"is_attending\":"     .  "\"" . $value['is_attending'] . "\",";
        echo "\"is_sharing_location\":"     .  "\"" . $value['is_sharing_location'] . "\",";
        echo "\"last_name\":"   .  "\"" . $value['last_name'] . "\",";
        echo "\"latitude\":"   .  "\"" . $value['latitude'] . "\",";
        echo "\"longitude\":"   .  "\"" . $value['longitude'] . "\",";
        echo "\"phone_number\":"   .  "\"" . $value['phone_numer'] . "\",";
        echo "\"twitter_handle\":"   .  "\"" . $value['twitter_handle'] . "\",";
        echo "\"uuid\":"        .  "\"" . $value['uuid'] . "\",";
        echo "\"wedding_role\":"   .  "\"" . $value['wedding_role'] . "\",";
        echo "}";
        if ($cursor->hasNext()) {
            echo  ",";
        }
    }
    echo "]}";
?>
