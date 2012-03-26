<?php

/**
 * Description of Db
 *
 * @author Eric
 */
class Db {
    public static function getDB() {
        $m = new Mongo("mongodb://mongohqdba:ilikebigtits@staff.mongohq.com:10004/weddingonsand");
        return $m;
    }
}

?>
