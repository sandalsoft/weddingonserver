<?php

class Date {
    var $gmtoffset;
    var $year;
    var $month;
    var $day;
    var $hour;
    var $minute;
    var $second;
    var $idioma;
   function Date($lang) {
        //setlocale (LC_TIME,en_US);
        list($this->year, $this->month, $this->day) = split("-", gmdate("Y-m-d"));
        list($this->hour, $this->minute, $this->second) = split(":", gmdate("g:i:s"));
        $this->gmtoffset = 0;
        $this->idioma=$lang;
    }
    function getYear() {
        return $this->year;
    }
    function setYear($year) {
        $year = intval($year);
        if($year >= 0) {
            $this->year = $year;
        } else {
            //throw new Exception("Invalid year! Prior to 0 A.D.!");
        }
        return true;
    }
    function getMonth() {
        return $this->month;
    }
    function setMonth($month) {
        $month = intval($month);
        if(($month >= 1) && ($month <= 12)) {
            $this->month = $month;
        } else {
            //throw new Exception("Invalid month! Not between 1 and 12!");
        }
        return true;
    }
    function getDay() {
        return $this->day;
    }
    function setDay($day) {
        $day = intval($day);
        if(($day >= 1) && ($day <= 31)) {
            $this->day = $day;
        } else {
            //throw new Exception("Invalid day! Not between 1 and 31!");
        }
        return true;
    }
    function getHour() {
        return $this->hour;
    }
    function setHour($hour) {
        $hour = intval($hour);
        if(($hour >= 0) && ($hour <= 23)) {
            $this->hour = $hour;
        } else {
            //throw new Exception("Invalid hour! Not between 0 & 23!");
        }
        return true;
    }
    function getMinute() {
        return $this->minute;
    }
    function setMinute($minute) {
        $minute = intval($minute);
        if(($minute >= 0) && ($minute <= 59)) {
            $this->minute = $minute;
        } else {
            //throw new Exception("Invalid minute! Not between 0 and 59!");
        }
        return true;
    }
    function getSecond() {
        return $this->second;
    }
    function setSecond($second) {
        $second = intval($second);
        if(($second >= 0) && ($second <= 59)) {
            $this->second = $second;
        } else {
            //throw new Exception("Invalid second! Not between 0 and 59!");
        }
        return true;
    }
    function getGMTOffset() {
        return $this->gmtoffset;
    }
    function setGMTOffset($gmtoffset) {
        $gmtoffset = intval($gmtoffset);
        if(($gmtoffset >= -12) && ($gmtoffset <= 12)) {
            $this->gmtoffset = $gmtoffset;
        } else {
            //throw new Exception("Invalid GMT offset! Not between -12 and 12!");
        }
        return true;
    }
    function setDate($year, $month, $day) {
        $this->setYear($year);
        $this->setMonth($month);
        $this->setDay($day);
        return true;
    }
    function setTime($hour, $minute, $second, $gmtoffset = 0) {
        $this->setHour($hour);
        $this->setMinute($minute);
        $this->setSecond($second);
        $this->setGMTOffset($gmtoffset);
        return true;
    }
    function setDateTime($year, $month, $day, $hour, $minute, $second, $gmtoffset) {
        $this->setDate($year, $month, $day);
        $this->setTime($hour, $minute, $second, $gmtoffset);
        return true;
    }
    function timestamp() {
        # This function returns a user's correct timezone in the form
        # of a unix timestamp.
        return mktime($this->hour + $this->gmtoffset,
                      $this->minute,
                      $this->second,
                      $this->month,
                      $this->day,
                      $this->year);
    }
    function longDateTimeHuman() {
        # Returns a date string like "Saturday, November 5, 2005 3:25 PM".
        return date("l, j F, Y g:i A", $this->timestamp());
    }
     function diaSemana(){
        # Returns a day string like "Saturday".
          return date("l", $this->timestamp());
    }
    function mes(){
        # retorna un string del mes "November".
          return date("F", $this->timestamp());
    }
    function diaSemana_es($diaen){
        switch($diaen)
    {
            case "Saturday": return("Sábado");break;
            case "Sunday": return("Domingo");break;
        case "Monday": return("Lunes");break;
            case "Tuesday": return("Martes");break;
            case "Wednesday": return("Miércoles");break;
        case "Thursday": return("Jueves");break;
            case "Friday": return("Viernes");break;
    }
   }
    function mes_es($mesen){
        switch($mesen)
    {      case "January": return(_JAN);break;
            case "February": return(_FEB);break;
        case "March": return(_MAR);break;
            case "April": return(_APR);break;
            case "May": return(_MAY);break;
        case "June": return(_JUN);break;
        case "July": return(_JUL);break;
        case "August": return(_AUG);break;
        case "September": return(_SEP);break;
        case "October": return(_OCT);break;
        case "November": return(_NOV);break;
            case "December": return(_DEC);break;
    }
   }
   function longDateHuman() {
        # Returns a date string like "Saturday, November 5, 2005".
         if($this->idioma=="en")
            return date("l, j F , Y", $this->timestamp());
             else
         {
             return "".$this->diaSemana_es($this->diaSemana()).", ".$this->mes_es($this->mes())." ".$this->day.", ".$this->year;
         }
    }
   function shortDateHuman() {
        # Returns a date string like "November 5, 2005".
        return date("F j, Y", $this->timestamp());
    }
   function longTimeHuman() {
        # Returns a time like "3:32:56 PM". F j of Y, g:i a
        return date("g:i:s A", $this->timestamp());
       // return date("F j of Y", $this->timestamp());
    }
    function shortTimeHuman() {
        # Returns a time like "3:32 PM".
        return date("g:ia", $this->timestamp());
    }
    function militaryTime() {
        # Returns a time like "15:34:24".
        return date("h:i:s", $this->timestamp());
    }
    function SQLDate() {
        return date("Y-m-d", $this->timestamp());
    }
    function SQLDate_convertir($timestamp){
    //  echo date("Y-m-d", $timestamp);
        //  echo  $timestamp;
      //  $aux=getdate($timestamp);
       // $aux=mktime($timestamp);
     //  $aux=gmstrftime($timestamp);
       //echo 
      // print_r(getdate($timestamp));
  //    $aux=$timestamp;
         //$aux=date("Y-m-d", $timestamp);
         $aux=split(" ",$timestamp);
         //print_r($aux);
         return $aux[0];
    }
    function SQLTime() {
        return date("h:i:s", $this->timestamp());
    }
    function SQLDateTime() {
        return date("Y-m-d h:i:s", $this->timestamp());
    }
}
?>
