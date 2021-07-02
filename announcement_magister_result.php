<?php
	$announcementText=$_POST['announcement_text'];
	date_default_timezone_set('Asia/Yekaterinburg');
	include("./php/connect.php");
	
	$stmt=$pdo->prepare("INSERT INTO magistracy_announcements SET announcement_time=?, announcement_text=?");
	$stmt->execute(array(time(),$announcementText));
	
	$stmt=$pdo->prepare("SELECT * FROM magistracy_announcements ORDER BY announcement_time DESC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['announcements'][]=
			array
			(
			'time'=>date("d.m.Y G:i:s",$row['announcement_time']),
			'text'=>iconv("cp1251","utf-8",$row['announcement_text'])
			);
	}
	
	$myfile = fopen("./php/announcements_magister.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	include("./php/disconnect.php");
?>