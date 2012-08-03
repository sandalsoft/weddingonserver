<?php

include_once "AuthUUID.php";


$uuid = $_REQUEST["uuid"];
$doc = AuthUUID::validate($uuid);


if (!$doc) {
    header('Content-type: application/fuckoff');
    header('HTTP/1.0 401 Unauthorized');
    die;
}


$m = Db::getDb();
$collection = $m->weddingonsand->Rsvps;

header('Content-type: application/json');

//echo "AUTH OK";
$cursor = $collection->find();

$response = array();

//$i = 0;
//while ($cursor->hasNext()) {
//
//    $response[$i] = $cursor->getNext();
//    $response[$i++]['_id'] = $cursor->key;
//}

foreach ($cursor as $guest) {

//    $response['persons'][] = $request;

//    print_r(json_encode($person['_id']->__toString()));

    $guest['_id'] = $guest['_id']->__toString();
    $response['guests'][] = $guest;
    
}

    print_r(json_encode($response));

?>
