<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
	{
		die("Неверный пароль");
	}*/
	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	$courseId=$_POST['id'];
	//$courseId=0;
	if ($courseId<1)
	{
		die("OK");
	}

	$courseInfo=array($courseId);

	$stmt=$pdo->prepare("DELETE FROM bachelor_training_courses_description WHERE bachelor_training_course_id=?");
	$stmt->execute($courseInfo);

  $stmt=$pdo->prepare("DELETE FROM bachelor_training_courses_requests WHERE training_course_to_apply=?");
	$stmt->execute($courseInfo);

  $stmt=$pdo->prepare("DELETE FROM bachelor_training_course_connections WHERE bachelor_training_course=?");
	$stmt->execute($courseInfo);

	echo json_encode(array("response"=>"ok"));

	include("./disconnect.php");
?>
