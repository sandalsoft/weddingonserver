<?php

include_once "AuthUUID.php";

$uuid = $_REQUEST["uuid"];
header('Content-type: application/json');
$doc = AuthUUID::validate($uuid);
if (!$doc) {
    header('HTTP/1.0 401 Unauthorized');
    $response['status']['status'] = "error";
    $response['status']['status_code'] = 401;
    $response['status']['status_message'] = "unauthorized access";
    print_r(json_encode($response));
    die;
}
$m = Db::getDb();
$collection = $m->weddingonsand->SongRequests;

//echo "AUTH OK";
$cursor = $collection->find();
$response['song_requests'] = NULL;
$response['status']['status'] = "ok";

foreach ($cursor as $person) {

    $response['song_requests'][] = $person;

}


print_r(json_encode($response));


?>
