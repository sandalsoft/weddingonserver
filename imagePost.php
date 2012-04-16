<?php


$temp_filename = $_FILES["imageData"]["tmp_name"];
error_log($temp_filename);
//$uploaded_by = "eric nelson";
//$likes = 1;

$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");
$db = $m->weddingonsand;

// GridFS
$gridFS = $db->getGridFS();

$path = "/tmp";

$storedfile = $gridFS->storeFile($temp_filename, 
        array("metadata" => array("filename" => $temp_filename),
             "filename" => $temp_filename));

         error_log($storedfile);
?>
