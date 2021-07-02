<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	$backErrorUrl='<a href="./announcements_school_bachelor.php">Попробовать ещё раз</a><br>';

	/*
	if ($_POST['input_password']!="ND31LmxehY7Aje0")
	{
		echo $backErrorUrl;
		die("Неверный пароль");
	}
	*/

	$announcementText=iconv("utf-8","cp1251",$_POST['announcement_text']);
	if (strlen($announcementText)<1)
	{
		echo $backErrorUrl;
		die("Введите текст объявления!");
	}

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./php/connect.php");

	$stmt=$pdo->prepare("INSERT INTO bachelor_school_announcements SET announcement_time=?, announcement_text=?, announcement_notification_status=?");
	$stmt->execute(array(time(),$announcementText,iconv("utf-8","cp1251","Отправить")));

	$stmt=$pdo->prepare("SELECT * FROM bachelor_school_announcements ORDER BY announcement_time DESC LIMIT 5");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['announcements'][]=
			array
			(
			'time'=>date("G:i:s d.m.Y",$row['announcement_time']),
			'text'=>iconv("cp1251","utf-8",$row['announcement_text'])
			);
	}

	include("./php/disconnect.php");
	$myfile = fopen("./php/bachelor_school_announcements.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	echo 'OK!<br>';
	echo '<a href="./announcements_school_bachelor.php">Добавить ещё одно объявление</a>';
?>
