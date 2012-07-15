<?php
include_once "AuthUUID.php";
include_once "Db.php";

header('Content-type: application/json');

 $uuid = $_POST["uuid"];
 $trackId = $_POST['trackId'];
 error_log($uuid);
 if (!AuthUUID::validate($uuid)){
    header('HTTP/1.0 401 Unauthorized');
    $response['status']['status'] = "error";
    $response['status']['status_code'] = 401;
    $response['status']['status_message'] = "unauthorized access";
    print_r(json_encode($response));
    die;
 }
 
 
  $m = Db::getDb();
  $collection = $m->weddingonsand->SongRequests;
   
  $repeat_criteria = array(
    'uuid' => $uuid,
    'trackId' => $trackId
  );
  
  
  $repeat_request = $collection->findOne($repeat_criteria);
  
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
    
$exists_criteria = array('trackId' => $trackId);
 
$song_request_doc = $collection->findOne(array('trackId' => $trackId), array());  


//  $collection->update(array("action" => $action, "day" => $day),array('$inc' => array("count" => 1)),array("upsert" => true));)

if ($song_request_doc) {
    $err = "updating $trackId";
    error_log($err);
    $update_criteria = array("trackId" => $trackId);
    $update_object = array('$push' => array("requestors" => $uuid), '$inc' => array("requests" => 1)); 

    $collection->update($update_criteria, $update_object, array("upsert" => true));
    
}
else {
    error_log("inserting");
    $song_request = $_POST;
    $song_request['requestors'][] = $uuid;
    $song_request['requests'] = 1;
    $result = $collection->insert($song_request);
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

}

?>
