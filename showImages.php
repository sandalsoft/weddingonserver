<?php


$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");
$db = $m->weddingonsand;    

// GridFS
$gridFS = $db->getGridFS();     

// Find image to stream
$images = $gridFS->find();

// Stream image to browser
//header('Content-type: image/jpeg');
header('Content-type: image/jpeg');
foreach ($images["thumbnail"] as $thumb) {
    echo ($thumb->getBytes());
}

?>
