<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
	{
		die("Неверный пароль");
	}*/

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	$stmt=$pdo->prepare("TRUNCATE TABLE faculties");
	$stmt->execute(array());

	include("./disconnect.php");
?>
