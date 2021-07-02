<?php
	include("./connect.php");
	
	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description");
	$stmt->execute();
	
	$response=array();
	
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['bachelor_training_courses'][]=array
		(
			"id"=>iconv("cp1251","utf-8",$row['bachelor_training_course_id']),
			"start_time"=>iconv("cp1251","utf-8",$row['bachelor_training_course_start_time']),
			"end_time"=>iconv("cp1251","utf-8",$row['bachelor_training_course_end_time']),
			"title"=>iconv("cp1251","utf-8",$row['bachelor_training_course_title']),
			"shedule"=>iconv("cp1251","utf-8",$row['bachelor_training_course_shedule'])
		);
		
	}
	//echo json_encode($response);
	
	$myfile = fopen("./announcements_bachelor_training_courses.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	
	include("./disconnect.php");
?>