<?php

include_once "AuthUUID.php";

$uuid = $_REQUEST["uuid"];
$doc = AuthUUID::validate($uuid);
if (!$doc) {
    header('HTTP/1.0 401 Unauthorized');
    die;
}
$m = Db::getDb();
$collection = $m->weddingonsand->Persons;

//echo "AUTH OK";
$cursor = $collection->find();

$return = array();
$i = 0;
while ($cursor->hasNext()) {

    $return[$i] = $cursor->getNext();
    $return[$i++]['_id'] = $cursor->key;
}
print_r(json_encode($return));

?>
