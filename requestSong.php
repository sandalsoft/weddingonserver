<?php
include_once "AuthUUID.php";
include_once "Db.php";

header('Content-type: application/json');

 $uuid = $_POST["uuid"];
// error_log($uuid);
 if (!AuthUUID::validate($uuid)){
       header('HTTP/1.0 401 Unauthorized');
       die;
 }
  $m = Db::getDb();
  $collection = $m->weddingonsand->SongRequests;
   
  $criteria = array(
    'uuid' => $uuid,
    'trackId' => $_POST['trackId']
  );
  $repeat_request = $collection->findOne($criteria);
  
 if ($repeat_request) {
//    header('HTTP/1.0 401 Unauthorized');
    $response['status']['status'] = "error";
    $response['status']['status_code'] = 450;
    $response['status']['status_message'] = "Duplicate Request";
    print_r(json_encode($response));
    die;
  }
  
  /*
  # check how many song requests a user has.  
  $user_cursor = $collection->find(array('uuid'=>$uuid));
  #echo "$uuid has " . $user_cursor->count() . "requests";
    if ($user_cursor->count() > 20) {
      # return status message and don't insert record
      $status = array("status" => "too many requests");
  }
 * 
 */
  
//  error_log(json_encode($song_request));
  $result = $collection->insert($_POST);
  if ($result == 1) {
    $response['status']['status'] = "ok";
    print_r(json_encode($response));
  } 
  else {
      $response['status']['status'] = "error";
      $response['status']['status_code'] = "444";
      $response['status']['status_messagae'] = "Error inserting sone request into db";
      $err = "Error inserting sone request into db: " . $_POST; 
      errlog($err);
  }
  
  
// #Song request profile
//  $song_request = array(
//      'uuid'=>$uuid,
//      'trackId'=>$trackId,
//  );
//  
//  # create output status 
//  $status = array();
//  
//  # if request for specific song from specific user returns a record
//  $cursor = $collection->find($song_request);
//  if ($cursor->count() > 0) {
//      # return status message and don't insert record
//      $status = array("status" => "duplicate");
//  }
//      
//  else {    
//      #song request doesn't exist, insert it and return ok status
//      $collection->insert($song_request);
//      $status = array("status" => "ok");
//  }
  

?>

