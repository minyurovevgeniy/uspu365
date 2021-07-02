<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	require_once("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	$stmt=$pdo->prepare("SELECT * FROM faculties ORDER BY faculty_name ASC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['faculties'][]=
			array
			(
			'id'=>$row['faculty_id'],
			'name'=>iconv("cp1251","utf-8",$row['faculty_name']),
			'abbr'=>iconv("cp1251","utf-8",$row['faculty_abbr'])
			);
	}
	echo json_encode($response);
	require_once("./disconnect.php");
?>