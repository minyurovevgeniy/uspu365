<?php

	include("./connect.php");
	
	$stmt=$pdo->prepare("SELECT * FROM ege_exams ORDER BY ege_name ASC");
	$stmt->execute();
	
	$response=array();
	
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['ege_info'][]=array
		(
			"exam"=>$row['ege_min'].'_'.iconv("cp1251","utf8",$row['ege_name'])
		);
	}
	
	echo json_encode($response);
	
	include("./disconnect.php");

?>