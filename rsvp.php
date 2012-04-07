<?php
include_once "Db.php";
$m = Db::getDb();
$rsvps = $m->weddingonsand->Rsvps;
$salt = "tits";



$rsvp = array(  "attending" => $_POST['attending'],
                "bringing_guest" => $_POST['bringing_guest'],
                "email" => $_POST['email'],
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "guest_email" => $_POST['guest_email'],
                "guest_first_name" => $_POST['guest_first_name'],
                "guest_last_name" => $_POST['guest_last_name'],
                "note" => $_POST['note'],
                "iphone_app_notify" => $_POST['iphone_app_notify'],
                "iphone_app_auth_code" => substr(md5($_POST['email'] . $salt), 0, 8),
            );
$rsvps->insert($rsvp);


echo '<HEAD> <meta HTTP-EQUIV="REFRESH" content="3; url=http://www.julieandericswedding.com/registry.html"></HEAD>';
echo '<BODY><h1>Thanks for RSVPing!  We got your info and will be in touch soon...';

//if ($_POST['attending'] == "yes") {
//     header('Location: http://www.julieandericswedding.com/travel--cottages.html');
//    
//}
// else {
//       header('Location: http://www.julieandericswedding.com/registry.html');
//}

?>

