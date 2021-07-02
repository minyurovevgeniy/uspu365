<?php
// API access key from Google API's Console
$API_ACCESS_KEY='AAAAksLu7lw:APA91bFw-2Zh9fdFRr3ERmgtJKXV1udOcvOT6CmeIfrcM63Qltl3ag_2czauJSzT_VvsmBHcN9tYiK9-mcXjOzVXaJJb4DOXNwDfsCbw-E5dTbIkzbxp4ADR_PDcQR0I1Y1XI0eoFUqg';

//$message=iconv("utf8","cp1251",$_REQUEST['message']);
$message="Greetings";
//$title=iconv("utf8","cp1251",$_REQUEST['title']);
$title="Hi!";

$registrationIds = array();

include("./connect.php");

$stmt=$pdo->prepare("SELECT bachelor_token FROM bachelor_tokens");
$stmt->execute();

while($row=$stmt->fetch(PDO::FETCH_LAZY))
{
	$registrationIds[]=$row['bachelor_token'];
}

include("./disconnect.php");

// prep the bundle
$msg = array
(
	'message' 	=> $message,
	'title'		=> $title
	/*'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'*/
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'notification'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . $API_ACCESS_KEY,
	'Content-Type: application/json'
);


$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
?>