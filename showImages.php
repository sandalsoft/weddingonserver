<?php


$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");
$db = $m->weddingonsand;    


// GridFS
$gridFS = $db->getGridFS();     

// Find image to stream
$cursor = $gridFS->find();

$response['images'] = NULL;
$response['status']['status'] = "ok";

foreach ($cursor as $filedata) {
      $response['images'][] = $filedata;
}

print_r(json_encode($response));

//// Stream image to browser
////header('Content-type: image/jpeg');
//header('Content-type: image/jpeg');
//foreach ($images["thumbnail"] as $thumb) {
//    echo ($thumb->getBytes());
//}

?>
