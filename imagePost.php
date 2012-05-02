<?php
include_once 'Date.php';

$upload_file = $_FILES["photoData"]["tmp_name"];

$uuid = $_POST["uuid"];
$description = $_POST["description"];

$image_filename = basename($upload_file);
$images_dir = "/var/www/weddingonserver/images/";
$image_file = $images_dir . $image_filename;

//$www_images_dir = "/images/";
//$www_image_file = $www_images_dir . $image_filename;

move_uploaded_file($upload_file, $image_file);

//$thumb_filename = $image_filename . ".thumb";
$thumb_file = $image_file . ".thumb";
//$www_thumb_file = $www_images_dir . $thumb_filename;

$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");

$photos_collection = $m->weddingonsand->Photos;
$personCollection = $m->weddingonsand->Persons;
$uploaders_name = get_uploaders_name($uuid, $personCollection);

// Resize and Create thumbnail
$thumb_width = 75;
resize_image($image_file, $thumb_file, $thumb_width);
$thumb_imagesize = getimagesize($thumb_file);
$thumb_filesize = filesize($thumb_file);


// Resize and save image
$image_width = 1024;
$image = new Imagick($image_file); 
$d = $image->getImageGeometry(); 
$w = $d['width'];
if ($w > 1024) {
    resize_image($image_file, $image_file, $image_width);
}

$image_imagesize = getimagesize($image_file);
$image_filesize = filesize($image_file);
//$upload_time = date("m-d-Y g:i a");
$now = new Date('en');
$now->setGMTOffset(-6);
$upload_time = $now->shortDateHuman() . " " . $now->shortTimeHuman();
$upload_timestamp = time();
$image_md5 = md5_file($image_file); 


# Embedding image into documents
$image_doc = array(
    "upload_name" => $uploaders_name, 
    "upload_uuid" => $uuid,
    "description" => $description,
    "upload_timestamp" => $upload_timestamp,
    "upload_time" => $upload_time, 
    "thumb_width" => $thumb_imagesize[0],
    "thumb_height" => $thumb_imagesize[1],
    "thumb_filetype" => $thumb_imagesize[2],
    "thumb_filesize" => $thumb_filesize,
    "thumb_data" => new MongoBinData(file_get_contents($thumb_file)),
    "image_width" => $image_imagesize[0],
    "image_height" => $image_imagesize[1],
    "image_filetype" => $image_imagesize[2],
    "image_filesize" => $image_filesize,
    "image_md5" => $image_md5,
    "image_data" => new MongoBinData(file_get_contents($image_file)),
    );
$photos_collection->save($image_doc);


function get_uploaders_name($uuid, $collection) {
    
    $criteria = array('uuid' => $uuid);
    $fields = array('first_name', 'last_name');
    $doc = $collection->findOne($criteria, $fields);
    return $doc['first_name'] . " " . $doc['last_name'];
}
function RelativeTime($timestamp){
    $difference = time() - $timestamp;
    $periods = array("sec", "min", "hour", "day", "week",
    "month", "years", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");

    if ($difference > 0) { // this was in the past
    $ending = "ago";
    } else { // this was in the future
    $difference = -$difference;
    $ending = "to go";
    }
    for($j = 0; $difference >= $lengths[$j]; $j++)
    $difference /= $lengths[$j];
    $difference = round($difference);
    if($difference != 1) $periods[$j].= "s";
    $text = "$difference $periods[$j] $ending";
    return $text;
}

function resize_image($src,$dest,$desired_width)
{
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
