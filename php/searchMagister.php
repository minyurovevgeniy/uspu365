<?php
	date_default_timezone_set('Asia/Yekaterinburg');

	/*
	$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
	*/

	$name=iconv("utf-8","cp1251",$_POST['name']);
	$surname=iconv("utf-8","cp1251",$_POST['surname']);
	$patronymic=iconv("utf-8","cp1251",$_POST['patronymic']);


	if(strlen($patronymic)<1)
	{
		$patronymic="null";
	}

	include("./connect.php");

	include("./loadData.php");

	$stmt=$pdo->prepare("SELECT abiturient_id FROM magistracy_abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
	$stmt->execute(array($name,$surname,$patronymic));
	$row=$stmt->fetch(PDO::FETCH_LAZY);
	$abiturientId=$row['abiturient_id'];

	//echo $abiturientId;

	$profileId=array();

	$stmt=$pdo->prepare("SELECT profile FROM magistracy_requests WHERE abiturient=?");
	$stmt->execute(array($abiturientId));
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$profileId[]=$row['profile'];
	}

	$response=array();
	$copiesCount=0;
	$originalCount=0;
	$profiles=array();
	$faculty="";

	foreach($profileId as $value)
	{
		$copiesCount=0;
		$originalCount=0;
		$stmt=$pdo->prepare("SELECT abiturient, diploma_type FROM magistracy_requests, magistracy_abiturients WHERE profile=? AND magistracy_requests.abiturient=magistracy_abiturients.abiturient_id ORDER BY score DESC, pre_sum DESC, profile_test DESC, base_test DESC,abiturient_surname ASC, abiturient_name ASC, abiturient_patronymic ASC");
		//$stmt=$pdo->prepare("SELECT abiturient, abiturient_surname, abiturient_name, abiturient_patronymic, diploma_type FROM magistracy_requests, magistracy_abiturients WHERE profile=? AND magistracy_requests.abiturient=magistracy_abiturients.abiturient_id ORDER BY score DESC, pre_sum DESC, individual DESC, profile_test DESC, base_test DESC,abiturient_surname ASC, abiturient_name ASC, abiturient_patronymic ASC");
		$stmt->execute(array($value));
		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			if ($abiturientId!=$row['abiturient'])
			{
				switch($row['diploma_type'])
				{
					case 2:$copiesCount++; break;
					case 1:$originalCount++; break;
					default:break;
				}
			}
			else
			{
				break;
			}
		}

		$stmt=$pdo->prepare("SELECT profile_description FROM magistracy_profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$profileDescriptionId=$stmt->fetch(PDO::FETCH_LAZY);

		/*echo '<pre>';
		print_r($profileDescription);
		echo '</pre>';*/

		$stmt=$pdo->prepare("SELECT profile_name, profile_code FROM magistracy_profile_description WHERE profile_description_id=?");
		$stmt->execute(array($profileDescriptionId['profile_description']));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);

		$stmt=$pdo->prepare("SELECT budget, form, faculty, special, capacity FROM magistracy_profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);

		$response['positions'][]=array
		(
			"copy"=>(string)$copiesCount,
			"original"=>(string)$originalCount,
			"profile_code"=>iconv("cp1251","utf-8",$profileDescription['profile_code']),
			"profile_name"=>iconv("cp1251","utf-8",$profileDescription['profile_name']),
			"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
			"budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
			"form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
			"special"=>iconv("cp1251","utf-8",$specialAbbrById[$extra['special']]),
			"capacity"=>$extra['capacity']
		);
	}

	include("./disconnect.php");

	echo json_encode($response);
?>
