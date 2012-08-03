<?php
include_once "Db.php";
require("Postmark.php");

define('POSTMARKAPP_API_KEY', '7789230f-b288-415a-8443-20ea99c089ac');


//$m = Db::getDb();
 $m = new Mongo("mongodb://mongouser:ilikebigtits@ds029317.mongolab.com:29317/weddingonsand");
$rsvps = $m->weddingonsand->Rsvps;
$salt = "tits";



$rsvp = array(  "attending" => $_POST['attending'],
                "email" => $_POST['email'],
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "guest_first_name" => $_POST['guest_first_name'],
                "guest_last_name" => $_POST['guest_last_name'],
                "note" => $_POST['note'],
                "iphone_app_auth_code" => substr(md5($_POST['email'] . $salt), 0, 8),
            );
$rsvps->insert($rsvp);

  
$name = $_POST['first_name'] . $_POST['last_name'];
$html_response = file_get_contents("rvsp_response.html");

$rsvp_notify = "beach@julieandericswedding.com";
 
// Create a "Sender signature", then use the "From Email" here.
// POSTMARKAPP_MAIL_FROM_NAME is optional, and can be overridden
// with Mail_Postmark::fromName()
define('POSTMARKAPP_MAIL_FROM_ADDRESS', 'beach@julieandericswedding.com');
define('POSTMARKAPP_MAIL_FROM_NAME', 'Julie and Eric');

// Create a message and send it
Mail_Postmark::compose()
    ->addTo($_POST['email'], $name)
    ->subject('RSVP Confirmation')
    ->tag("rsvp")
    ->messageHtml($html_response)
    ->send();




$rsvp_notify_message = "

<html>
	<head>
		<title>HTML Online Editor Sample</title>
	</head>
	<body>
		<h1>
			New RSVP</h1>
		<ul>
			<li>
				" . $_POST['first_name'] . " " . $_POST['last_name'] . "</li>
			<li>
				" . $_POST['email']  . "</li>
			<li>
				" . $_POST['guest_first_name'] .  " " . $_POST['guest_last_name'] . "</li>
			<li>
				" . $_POST['note'] . "</li>
		</ul></body>
</html>
";
        
        
Mail_Postmark::compose()
    ->addTo($rsvp_notify)
    ->subject('New RSVP')
    ->tag("rsvp_notification")
    ->messageHtml($rsvp_notify_message)
    ->send();


echo '<HEAD> <meta HTTP-EQUIV="REFRESH" content="2; url=http://www.julieandericswedding.com/registry.html"></HEAD>';
echo '<BODY><h1>Thanks for RSVPing!  We got your info and will be in touch soon...';

//if ($_POST['attending'] == "yes") {
//     header('Location: http://www.julieandericswedding.com/travel--cottages.html');
//    
//}
// else {
//       header('Location: http://www.julieandericswedding.com/registry.html');
//}


?>


