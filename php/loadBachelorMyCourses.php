<?php
	date_default_timezone_set('Asia/Yekaterinburg');

	$name=iconv("utf-8","cp1251",$_POST['name']);
	$email=iconv("utf-8","cp1251",$_POST['email']);

	include("./connect.php");

	//include("./loadData.php");

	$stmt=$pdo->prepare("SELECT bachelor_course_student_id FROM bachelor_training_courses_students WHERE 	bachelor_course_student_name=? AND 	bachelor_course_student_email=?");
	$stmt->execute(array($name,$email));
	$row=$stmt->fetch(PDO::FETCH_LAZY);
	$studentId=$row['bachelor_course_student_id'];

	$coursesIds=array();

	$stmt=$pdo->prepare("SELECT bachelor_training_course FROM bachelor_training_course_connections WHERE training_student=?");
	$stmt->execute(array($studentId));
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$coursesIds[]=$row['bachelor_training_course'];
	}

	$response=array();

	foreach($coursesIds as $value)
	{
		$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description WHERE bachelor_training_course_id=?");
		$stmt->execute(array($value));

		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			$response["courses"][]=array
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
	}


	echo json_encode($response);
	include("./disconnect.php");
?>
