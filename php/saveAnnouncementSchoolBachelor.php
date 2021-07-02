<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	include("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');

/*
	if ($_POST['password']!="LV9PWUbu9sth3Mv")
	{
		die("Неверный пароль");
	}
*/
	$announcementId=$_POST['announcement_id'];
	$announcementText=iconv("utf8","cp1251",$_POST['announcement_text']);
	$stmt=$pdo->prepare("UPDATE bachelor_school_announcements SET announcement_text=? WHERE announcement_id=?");
	$stmt->execute(array($announcementText,$announcementId));

	$stmt=$pdo->prepare("SELECT * FROM bachelor_school_announcements ORDER BY announcement_time DESC");
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
			'text'=>iconv("cp1251","utf-8",$row['announcement_text'])
			);
	}

	$myfile = fopen("./bachelor_school_announcements.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	include("./disconnect.php");
?>
