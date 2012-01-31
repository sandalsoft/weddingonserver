<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once "AuthUUID.php";

$uuid = $_REQUEST["uuid"];
$doc = AuthUUID::validate($uuid);
if (!$doc) {
    header('HTTP/1.0 401 Unauthorized');
} else {
    
     # determine which album or if albums will be used at all
    # accept file upload and place in album
   $images_dir =  "photos/images/album/";
   $uploaded_photo_filename = $uuid . "-" . $_FILES["file"]["name"];
   $thumbs_dir = "photos/thumbs/album/";
   if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 200000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
  
    if (file_exists($images_dir . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $images_dir . $uuid . "-" . $_FILES["file"]["name"]);
      #echo "Stored in: " . $images_dir . $_FILES["file"]["name"];
      
      # create thumbnail
      $wwwroot = "/var/www/weddingonserver/";
      make_thumb($wwwroot . $images_dir . $uploaded_photo_filename, $wwwroot . $thumbs_dir . $uploaded_photo_filename, 75);
     
      
      # open metadata xml file
      	   
      $file = "photos/thumbs/album/desc.xml";
      $xml = simplexml_load_file($file);

      $image = $xml->addChild('image');
      $image->addChild('name', $uuid . "-" . $_FILES["file"]["name"]);
      $image->addChild('text', $_REQUEST['image_description']);
      
      echo $xml->asXML($file);
      
      
    
      
        // get document element
        
      # add metadata
      # send complete message. 
      
      
      }
    }
  }
else
  {
  echo "Invalid file";
  }
  
}

function make_thumb($src,$dest,$desired_width)
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
