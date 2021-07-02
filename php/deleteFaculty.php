<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	if ($_POST['password']!="GugGuknRuFMPelJ")
	{
		die("Неверный пароль");
	}

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");
	
	$facultyId=$_POST['faculty_id'];
	if ($facultyId<1)
	{
		die("ok");
	}
	
	
	$stmt=$pdo->prepare("DELETE FROM faculties WHERE faculty_id=?");
	$stmt->execute(array($facultyId));
	
	echo json_encode(array('status'=>"Факультет удален"));
	
	include("./disconnect.php");
?>