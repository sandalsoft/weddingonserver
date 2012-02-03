<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$m = new Mongo();
        $collection = $m->weddingonsand->Persons;
        
        //echo "AUTH OK";
        $cursor = $collection->find();
        header('Content-Type: text/javascript');

     foreach ($cursor as $id => $value) {
         
        echo json_encode( $value );
}
?>
