<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	require_once("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	$stmt=$pdo->prepare("SELECT * FROM ege_exams ORDER BY ege_name ASC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['ege_exams'][]=
			array
			(
			'id'=>$row['ege_id'],
			'name'=>iconv("cp1251","utf-8",$row['ege_name']),
			'abbr'=>iconv("cp1251","utf-8",$row['ege_abbr']),
			'ege_min'=>$row['ege_min']
			);
	}
	echo json_encode($response);


	$stmt=$pdo->prepare("SELECT * FROM ege_exams ORDER BY ege_name ASC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['ege_exams'][]=
			array
			(
			'id'=>$row['ege_id'],
			'name'=>iconv("cp1251","utf-8",$row['ege_name']),
			'abbr'=>iconv("cp1251","utf-8",$row['ege_abbr']),
			'ege_min'=>$row['ege_min']
			);
	}

	$myfile = fopen("./minEGE.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);
	require_once("./disconnect.php");
?>
