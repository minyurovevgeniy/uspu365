<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	if ($_POST['password']!="fo004Hn9hUlyyUG")	die("Неверный пароль");


	include("./connect.php");
    date_default_timezone_set('Asia/Yekaterinburg');
	$announcementId=$_POST['id'];
	//$announcementId=$_GET['id'];

	$stmt=$pdo->prepare("SELECT announcement_text FROM magistracy_announcements WHERE announcement_id=?");
	$stmt->execute(array($announcementId));
	$row=$stmt->fetch(PDO::FETCH_LAZY);

	$message=iconv("cp1251","utf-8",$row['announcement_text']);

	if (strlen($message)<1)
	{
		die("empty string");
	}
	else
	{
		$title=substr($message,0,30)."...";
	}

	// API access key from Google API's Console
	$API_ACCESS_KEY='AAAADcpFdRs:APA91bF3Ii1_ZhS7lVpuO1ECpYpl4zIPMhoJXopridYee5D0HxfarF_5ORuKOWBCgbuWa6-g5GMsi9GL6BvglfWmGYz2txLA03WWurOVlZxgIAXGNR7PzFNs9L3HV0kzeTAA18eeNaGh';


	$registrationIds = array();

	$stmt=$pdo->prepare("SELECT magister_token FROM magistracy_tokens");
	$stmt->execute();

	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$registrationIds[]=$row['magister_token'];
	}

	// prep the bundle
	$msg = array
	(
		'message' 	=> $message,
		'title'		=> $title,
		/*'subtitle'	=> 'This is a subtitle. subtitle',
		'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
		'vibrate'	=> 1,*/
		'sound'		=> "default"
		/*'largeIcon'	=> 'large_icon',
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
	//$result =
	curl_exec($ch );
	curl_close( $ch );
	//echo $result;

	// update notification
	$newNotificationStatus=iconv("utf-8","cp1251","Отправить повторно");
	$stmt=$pdo->prepare("UPDATE magistracy_announcements SET announcement_notification_status=? WHERE announcement_id=?");
	$stmt->execute(array($newNotificationStatus,$announcementId));

	$stmt=$pdo->prepare("SELECT * FROM magistracy_announcements ORDER BY announcement_time DESC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['announcements'][]=
			array
			(
			'id'=>$row['announcement_id'],
			'time'=>date("G:i:s d.m.Y",$row['announcement_time']),
			'text'=>iconv("cp1251","utf-8",$row['announcement_text']),
			'notification_status'=>iconv("cp1251","utf-8",$row['announcement_notification_status'])
			);
	}
	echo json_encode($response);

	include("./disconnect.php");
?>
