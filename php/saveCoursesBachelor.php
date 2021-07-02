<?php
	include("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');

	$courseId=$_POST['id'];
	$name=iconv("utf8","cp1251",$_POST['name']);
	$subject=iconv("utf8","cp1251",$_POST['subject']);
	$totalTime=iconv("utf8","cp1251",$_POST['total_time']);
	$period=iconv("utf8","cp1251",$_POST['period']);
	$weekDays=iconv("utf8","cp1251",$_POST['week_days']);
	$startTime=iconv("utf8","cp1251",$_POST['start_time']);
	$endTime=iconv("utf8","cp1251",$_POST['end_time']);
	$price=$_POST['price'];

	$stmt=$pdo->prepare("UPDATE bachelor_training_courses_description SET bachelor_training_course_name=?, bachelor_training_subject=?,  bachelor_training_total_time=?, bachelor_training_period=?, bachelor_training_week_days=?, bachelor_training_start_time=?, bachelor_training_end_time=?, bachelor_training_price=? WHERE bachelor_training_course_id=?");
	$stmt->execute(array($name,$subject,$totalTime,$period,$weekDays,$startTime,$endTime,$price,$courseId));

	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['courses'][]=array
		(
			"id"=>$row['bachelor_training_course_id'],
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
	include("./disconnect.php");
?>
