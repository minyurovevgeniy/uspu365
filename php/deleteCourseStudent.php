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

  $studentId=$_POST['id'];


  $stmt=$pdo->prepare("DELETE FROM bachelor_training_course_connections WHERE training_student=?");
  $stmt->execute(array($studentId));

  $stmt=$pdo->prepare("DELETE FROM bachelor_training_courses_students WHERE bachelor_course_student_id=?");
  $stmt->execute(array($studentId));

	echo json_encode(array("status"=>"OK"));
	include("./disconnect.php");
?>
