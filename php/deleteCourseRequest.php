<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*
	if ($_POST['password']!="GugGuknRuFMPelJ")
	{
		die("Неверный пароль");
	}
	*/
	include("./connect.php");

	date_default_timezone_set('Asia/Yekaterinburg');

  $id=$_POST['id'];
	if ($id<1)
	{
		die("OK");
	}

  $stmt=$pdo->prepare("DELETE FROM bachelor_training_courses_requests WHERE application_id=?");
  $stmt->execute(array($id));

	$courseNameById=array();
	$courseSubjectById=array();

	$stmt=$pdo->prepare("SELECT bachelor_training_course_id, bachelor_training_course_name, bachelor_training_subject FROM bachelor_training_courses_description");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$courseNameById[$row['bachelor_training_course_id']]=$row['bachelor_training_course_name'];
		$courseSubjectById[$row['bachelor_training_course_id']]=$row['bachelor_training_subject'];
	}

	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_requests");
	$stmt->execute();

	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$trainingCourseToApply=$courseNameById[$row['training_course_to_apply']]."<br>(".$courseSubjectById[$row['training_course_to_apply']].")";
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
	include("./disconnect.php");
?>
