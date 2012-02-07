<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once "AuthUUID.php";
$imageMD5 = $_REQUEST["imageMD5"];

$uuid = $_REQUEST["uuid"];
$doc = AuthUUID::validate($uuid);
if (!$doc) {
    header('HTTP/1.0 401 Unauthorized');
} else {
    
   $images_dir = "photos/images/album/";
   $permanaent_filename = $imageMD5 . ".PNG";
  
    if (file_exists($images_dir . $permanaent_filename))  {
      echo "YES";
      }
    else {
        echo "NO";
    }
      
      
}
?>
