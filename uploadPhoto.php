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
    
   $images_dir = "photos/images/album/";
   $thumbs_dir = "photos/thumbs/album/";
   
   // This seems unnecessary?
   //$uploaded_file = $_FILES["file"]["name"];
   
   $image_file = $_FILES["file"]["tmp_name"];
   $permanaent_filename = md5_file($image_file) . ".PNG";
  

   
//   if ($_FILES["file"]["size"] < 200000)
//  {
  if ($_FILES["file"]["error"] > 0)  {
    echo "ERROR: " . $_FILES["file"]["error"];
    }
  else  {
    if (file_exists($images_dir . $permanaent_filename))  {
      echo $permanaent_filename . " already exists. ";
      var_dump($permanaent_filename . "already exists");
      }
    else  {
      # File doesn't exit, move tmp file to permanent images dir 
      move_uploaded_file($image_file,
            $images_dir . $permanaent_filename);
      #echo "Stored in: " . $images_dir . $permanaent_filename;
      
      # create thumbnail
      $wwwroot = "/var/www/weddingonserver/";
      make_thumb($wwwroot . $images_dir . $permanaent_filename,         
                    $wwwroot . $thumbs_dir . $permanaent_filename, 75);
     
      
      # open metadata xml file
      	   
      $file = "photos/thumbs/album/desc.xml";
      $xml = simplexml_load_file($file);

      $image = $xml->addChild('image');
      $image->addChild('name', $permanaent_filename);
      $image->addChild('text', $_REQUEST['image_description']);
      $image->addChild('uuid', $_REQUEST['uuid']);
      
      echo $xml->asXML($file);
      
      }
    }
//  }
//else
//  {
//  echo "Invalid file: " . $_FILES["file"]["name"];
//  }
  
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
