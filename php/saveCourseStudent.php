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
  $email=iconv("utf-8","cp1251",$_POST['email']);
  $name=iconv("utf-8","cp1251",$_POST['name']);

  $stmt=$pdo->prepare("UPDATE bachelor_training_courses_students SET bachelor_course_student_name=?, bachelor_course_student_email=? WHERE bachelor_course_student_id=?");
  $stmt->execute(array($name,$email,$studentId));

	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_students ORDER BY bachelor_course_student_name ASC");
	$stmt->execute();

	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['students'][]=
		array
		(
			"id"=>$row['bachelor_course_student_id'],
			"name"=>iconv("cp1251","utf-8",$row['bachelor_course_student_name']),
			"email"=>iconv("cp1251","utf-8",$row['bachelor_course_student_email'])
		);
	}

	echo json_encode($response);

	include("./disconnect.php");
?>
