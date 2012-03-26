<?php

include_once "Db.php";
class AuthUUID {

    public static function validate($uuid) {
        $m = Db::getDb();
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
    public static function validate_generic($uuid) {
        $m = Db::getDb();
        $collection = $m->weddingonsand->Persons;
	$doc = $collection->findOne(array('uuid' => $uuid), array());
//        var_dump($doc);
        if ($doc) { 
            return TRUE;
        }
        else  { 
            return FALSE;
        }
    }
}
