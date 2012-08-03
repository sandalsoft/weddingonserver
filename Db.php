<?php

/**
 * Description of Db
 *
 * @author Eric
 */
class Db {
    public static function getDB() {
        
        // mongoHq
        $m = new Mongo("mongodb://mongohqdba:ilikebigtits@staff.mongohq.com:10004/weddingonsand");
        
        //mongolab
//        $m = new Mongo("mongodb://mongouser:ilikebigtits@ds029317.mongolab.com:29317/weddingonsand");
        
        // demo mongolab user: weddingdemodba  pass: pleasemakememoney
        return $m;
    }
}

?>
