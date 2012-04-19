<?php


$upload_file = $_FILES["imageData"]["tmp_name"];

$uuid = $_POST["uuid"];
$comments = $_POST["description"];

$image_filename = basename($upload_file);
$images_dir = "/var/www/weddingonserver/images/";
$image_file = $images_dir . $image_filename;

$www_images_dir = "/images/";
$www_image_file = $www_images_dir . $image_filename;

move_uploaded_file($upload_file, $image_file);

$thumb_filename = $image_filename . ".thumb";
$thumb_file = $image_file . ".thumb";
$www_thumb_file = $www_images_dir . $thumb_filename;

$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");
$db = $m->weddingonsand;
$personCollection = $m->weddingonsand->Persons;
$uploaders_name = get_uploaders_name($uuid, $personCollection);

// Resize images and Create thumbnail
$thumbnail_width = 120;
$image_width = 800;
resize_image($image_file, $thumb_file, $thumbnail_width);

$image = new Imagick($image_file); 
$d = $image->getImageGeometry(); 
$w = $d['width'];
if ($w > 800) {
    resize_image($image_file, $image_file, $image_width);
}



$thumb_md5 = md5_file($thumb_file); 

// GridFS
$gridFS = $db->getGridFS();




$storedfile = $gridFS->storeFile($image_file, 
        array("metadata" => array("file_url" => $www_image_file,  "thumb_url" => $www_thumb_file, "thumbnail_md5" => $thumb_md5, "upload_name" => $uploaders_name, "upload_uuid" => $uuid, "comments" => $comments)));



function get_uploaders_name($uuid, $collection) {
    
    $criteria = array('uuid' => $uuid);
    $fields = array('first_name', 'last_name');
    $doc = $collection->findOne($criteria, $fields);
    return $doc['first_name'] . " " . $doc['last_name'];
}

function resize_image($src,$dest,$desired_width)
{
    
//       
	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	
	/* copy source image at a resized size */
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image,$dest);
}


?>
