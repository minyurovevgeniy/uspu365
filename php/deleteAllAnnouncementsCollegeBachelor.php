<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
	{
		die("Неверный пароль");
	}*/

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_college_announcements");
	$stmt->execute();

	$stmt=$pdo->prepare("SELECT * FROM bachelor_college_announcements ORDER BY announcement_time DESC LIMIT 5");
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

	echo json_encode($response);

	$myfile = fopen("./bachelor_college_announcements.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);

	include("./disconnect.php");
?>
