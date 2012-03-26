<?php
include_once "AuthUUID.php";
include_once "Db.php";

 $uuid = $_POST["uuid"];
 $trackId = intval($_POST['trackId']); 
// var_dump($uuid);
 if (!AuthUUID::validate($uuid)){
       header('HTTP/1.0 401 Unauthorized');
       die;
 }
  $m = Db::getDb();
  $collection = $m->weddingonsand->SongRequests;
  
 # User already requested this song
  $criteria = array(
      'uuid'=>$uuid,
      'trackId'=>$trackId,
  );
  
  $status = array();
  $cursor = $collection->find($criteria);
  if ($cursor->count() > 0) {
      $status = array("status" => "duplicate");
      
  }
      
  else {    
      $collection->insert($criteria);
      $status = array("status" => "ok");
  }
  
  print_r(json_encode($status));
  
//  $return = array();
//    $i=0;
//    while( $cursor->hasNext() )
//    {
//
//        $return[$i] = $cursor->getNext();
//        $return[$i++]['_id'] = $cursor->key;
//    }
//    print_r(json_encode($return));
?>

