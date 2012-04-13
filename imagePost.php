<?php


$temp_filename = $_FILES["file"]["tmp_name"];

$uploaded_by = "eric nelson";
$likes = 1;

$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29307/wedding");
$db = $m->Photos;

// GridFS
$grid = $db->getGridFS();

$storedfile = $grid->storeFile($temp_filename,
             array("metadata" => array("filename" => $temp_filename),
             "filename" => $temp_filename));

echo $storedfile;
?>
