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

 /*
 *   
  # check how many song requests a user has.  
  $user_cursor = $collection->find(array('uuid'=>$uuid));
  #echo "$uuid has " . $user_cursor->count() . "requests";
    if ($user_cursor->count() > 20) {
      # return status message and don't insert record
      $status = array("status" => "too many requests");
  }
 * 
 */
  
 #Song request profile
  $song_request = array(
      'uuid'=>$uuid,
      'trackId'=>$trackId,
  );
  
  # create output status 
  $status = array();
  
  # if request for specific song from specific user returns a record
  $cursor = $collection->find($song_request);
  if ($cursor->count() > 0) {
      # return status message and don't insert record
      $status = array("status" => "duplicate");
  }
      
  else {    
      #song request doesn't exist, insert it and return ok status
      $collection->insert($song_request);
      $status = array("status" => "ok");
  }
  
  print_r(json_encode($status));
  
?>

