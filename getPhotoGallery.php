<?php

$m = new Mongo("mongodb://mongouser:ilikebigtits@10.183.5.47:29317/weddingonsand");
$photo_id = $_GET['photo_id'];
$photo_type = $_GET['photo_type'];

$photos_collection = $m->weddingonsand->Photos;

if ($photo_type == "thumbnail") {
    header( 'Content-Type: image/jpeg' );
    $photo = $photos_collection->findOne(array('_id' => new MongoId($photo_id)));
    echo $photo["thumbnail"]->bin;

}

elseif ($photo_type == "image") {
    header( 'Content-Type: image/jpeg' );
    $photo = $photos_collection->findOne(array('_id' => new MongoId($photo_id)));
    echo $photo["image"]->bin;
}
else {
    header('Content-type: application/json');
    $photos_cursor = $photos_collection->find();
    $photos_cursor->sort(array('upload_timestamp' => -1));
    $response['status']['status'] = "ok";
    $response['photos'] = NULL;
    foreach ($photos_cursor as $photo) {
        $response['photos'][] = $photo;

    }
    
    print_r(json_encode($response));
}
?>
