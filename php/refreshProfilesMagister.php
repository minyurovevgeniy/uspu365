<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	require_once("./connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	include("./loadData.php");
	$stmt=$pdo->prepare("SELECT * FROM magistracy_profiles");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['profiles'][]=
		array
		(
			'id'=>$row['profile_id'],
			"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$row['faculty']]),
			"form"=>iconv("cp1251","utf-8",$formNameById[$row['form']]),
			"budget"=>iconv("cp1251","utf-8",$budgetNameById[$row['budget']]),
			"profile_desc"=>iconv("cp1251","utf-8",$magisterProfileNameById[$row['profile_description']]),
			"capacity"=>$row['capacity'],
			"special"=>iconv("cp1251","utf-8",$specialAbbrById[$row['special']])
		);
	}
	echo json_encode($response);
	require_once("./disconnect.php");
?>