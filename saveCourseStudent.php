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
  $email=$_POST['email'];
  $name=$_POST['name'];

  $stmt=$pdo->prepare("UPDATE bachelor_training_courses_students SET bachelor_course_student_name=?, bachelor_course_student_emal=? WHERE bachelor_course_student_id=?");
  $stmt->execute(array($name,$email,$studentId));

	echo json_encode(array("status"=>"OK"));
	include("./disconnect.php");
?>
