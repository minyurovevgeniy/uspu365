<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
	{
		die("Неверный пароль");
	}*/
	$profileId=$_POST['id'];

	if (preg_match("/\D/i",$profileId)>0)
	{
		die("OK");
	}

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	$stmt=$pdo->prepare("DELETE FROM magistracy_requests WHERE profile=?");
	$stmt->execute(array($profileId));

	include("./disconnect.php");
?>
