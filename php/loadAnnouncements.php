<?php
	header("Content-Type: text/json; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
	
	include("./connect.php");
	$stmt=$pdo->prepare("SELECT * FROM announcements ORDER BY announcement_time DESC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['announcements'][]=
			array
			(
			'time'=>date("d.m.Y G:i:s",$row['announcement_time']),
			'text'=>iconv("cp1251","utf-8",$row['announcement_text'])
			//'text'=>$row['announcement_text']
			);
	}
	include("./disconnect.php");
	
	$myfile = fopen("announcements.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	
	//echo json_encode($response)
?>