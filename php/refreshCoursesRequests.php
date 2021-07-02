<?php
		session_start();
		if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

		/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
		{
			die("Неверный пароль");
		}*/
		date_default_timezone_set('Asia/Yekaterinburg');
		include("./connect.php");

		$courseNameById=array();
		$courseSubjectById=array();
		$trainingPeriodById=array();
		$trainingWeekDaysById=array();

		$stmt=$pdo->prepare("SELECT bachelor_training_course_id, bachelor_training_course_name, bachelor_training_subject, bachelor_training_period, bachelor_training_week_days FROM bachelor_training_courses_description");
		$stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			$courseNameById[$row['bachelor_training_course_id']]=$row['bachelor_training_course_name'];
			$courseSubjectById[$row['bachelor_training_course_id']]=$row['bachelor_training_subject'];
			$trainingPeriodById[$row['bachelor_training_course_id']]=$row['bachelor_training_period'];
			$trainingWeekDaysById[$row['bachelor_training_course_id']]=$row['bachelor_training_week_days'];
		}

		$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_requests ORDER BY application_time DESC");
		$stmt->execute();

		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			$trainingCourseToApply=$courseNameById[$row['training_course_to_apply']]."<br>(".$courseSubjectById[$row['training_course_to_apply']]." ".$trainingPeriodById[$row['training_course_to_apply']]." ".$trainingWeekDaysById[$row['training_course_to_apply']].")";
			$response['requests'][]=array
			(
				"id"=>iconv("cp1251","utf-8",$row['application_id']),
				"applicant_name"=>iconv("cp1251","utf-8",$row['applicant_name']),
				"applicant_email"=>iconv("cp1251","utf-8",$row['applicant_email']),
				"training_course_to_apply"=>iconv("cp1251","utf-8",$trainingCourseToApply),
				"application_time"=>date("H:i:s d.m.Y",$row['application_time'])
			);
		}

		echo json_encode($response);
		/*
		$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_application");
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
		echo json_encode($response);*/

		include("./disconnect.php");
?>
