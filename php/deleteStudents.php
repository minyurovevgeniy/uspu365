<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
	{
		die("Неверный пароль");
	}*/

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");


  $stmt=$pdo->prepare("TRUNCATE TABLE bachelor_training_courses_students");
  $stmt->execute();

  $stmt=$pdo->prepare("TRUNCATE TABLE bachelor_training_course_connections");
	$stmt->execute();

  echo json_encode(array("response"=>"ok"));

	include("./disconnect.php");
?>
