<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	date_default_timezone_set('Asia/Yekaterinburg');

	/*
	if ($_POST['password']!='xYcBtgAmLG7SmfS')
	{
		die("Неверный пароль");
	}
	*/

	include("./connect.php");


	$facultyId=$_POST['faculty_id'];
	$facultyName=iconv("utf8","cp1251",$_POST['faculty_name']);
	$facultyAbbr=iconv("utf8","cp1251",$_POST['faculty_abbr']);

	$stmt=$pdo->prepare("UPDATE faculties SET faculty_name=?, faculty_abbr=? WHERE faculty_id=?");
	$stmt->execute(array($facultyName,$facultyAbbr,$facultyId));
	
	include("./disconnect.php");

	echo json_encode(array('status'=>'Факультет изменен'));
?>
