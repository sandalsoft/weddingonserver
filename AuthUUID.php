<?php
class AuthUUID {

    public static function validate($uuid) {

        $m = new Mongo("mongodb://mongohqdba:ilikebigtits@staff.mongohq.com:10004/weddingonsand");
        $collection = $m->weddingonsand->Persons;
	$doc = $collection->findOne(array('uuid' => $uuid), array());
//        var_dump($doc);
        if ($doc) { 
            return $doc;
        }
        else  { 
            return NULL;
        }
    }
}
