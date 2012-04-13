<?php

include_once "AuthUUID.php";
	
    $uuid = $_REQUEST["uuid"];
    $doc = AuthUUID::validate($uuid);
    if (!$doc) {
            header('HTTP/1.0 401 Unauthorized');
    }
    else {
        $m = new Mongo();
        $collection = $m->weddingonsand->Persons;
        
        //echo "AUTH OK";
        $cursor = $collection->find();
        header('Content-Type: text/javascript');

     foreach ($cursor as $id => $value) {
         
        echo json_encode( $value );
}
      
 
    }
?>
