<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	if ($_POST['password']!='4w3v3ZSv6L7G7Zj') die("Неверный пароль");


	require_once("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	$announcementId=$_POST['id'];

	// send

	$stmt=$pdo->prepare("SELECT announcement_text FROM bachelor_school_announcements WHERE announcement_id=?");
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
	$API_ACCESS_KEY='AAAAbOtnUXg:APA91bGkWhsPD3Zjl79moD5bx5WLVK4VFbF8A46PvKvgt-bYmdKu_ySjcU8UDD_DlWCSbcxsLmCNnCj135vb_8VkePuoHC4x7hVt5pHP0qMnpxmh2f1_ZlzQs-Ri-hsChn3gs2pqfGTI';
	//$API_ACCESS_KEY='AAAAbOtnUXg:APA91bFyhNN6bHu9PrlNHuOdw7oN1h8qvLEz2KpaZHs3WRhKRBMRngJ9zlyjDzRydGrOdO0qxOb-WdqzQ4EudZk9M034zztcywyb_3ML2q_5ruzaUQsmgIrr5lkypjMabWfCBntLksoH';
	//$API_ACCESS_KEY='AIzaSyCUoG7jsZymSwn4dwvlmAJfatXwxrrUjfI';



	$registrationIds = array();

	$stmt=$pdo->prepare("SELECT bachelor_token FROM bachelor_tokens");
	$stmt->execute();

	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$registrationIds[]=$row['bachelor_token'];
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
	$stmt=$pdo->prepare("UPDATE bachelor_announcements SET announcement_notification_status=? WHERE announcement_id=?");
	$stmt->execute(array($newNotificationStatus,$announcementId));

	$stmt=$pdo->prepare("SELECT * FROM bachelor_announcements ORDER BY announcement_time DESC");
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

	$stmt=$pdo->prepare("SELECT * FROM bachelor_school_announcements ORDER BY announcement_time DESC LIMIT 5");
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

	$myfile = fopen("./bachelor_school_announcements.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);

	require_once("./disconnect.php");
?>
