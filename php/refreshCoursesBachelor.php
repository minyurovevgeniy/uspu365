<?php
	require_once("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['courses'][]=array
		(
			"id"=>iconv("cp1251","utf-8",$row['bachelor_training_course_id']),
			"name"=>iconv("cp1251","utf-8",$row['bachelor_training_course_name']),
			"subject"=>iconv("cp1251","utf-8",$row['bachelor_training_subject']),
			"total_time"=>iconv("cp1251","utf-8",$row['bachelor_training_total_time']),
			"period"=>iconv("cp1251","utf-8",$row['bachelor_training_period']),
			"week_days"=>iconv("cp1251","utf-8",$row['bachelor_training_week_days']),
			"start_time"=>iconv("cp1251","utf-8",$row['bachelor_training_start_time']),
			"end_time"=>iconv("cp1251","utf-8",$row['bachelor_training_end_time']),
			"price"=>$row['bachelor_training_price']
		);
	}
	echo json_encode($response);
	
	$myfile = fopen("./announcements_bachelor_training_courses.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	require_once("./disconnect.php");
?>