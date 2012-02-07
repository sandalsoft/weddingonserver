<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
