<?php
	date_default_timezone_set('Asia/Yekaterinburg');


	$name=iconv("utf-8","cp1251",$_POST['name']);
	$surname=iconv("utf-8","cp1251",$_POST['surname']);
	$patronymic=iconv("utf-8","cp1251",$_POST['patronymic']);

/*
	$name=iconv("utf-8","cp1251",mb_strtolower($_POST['name']));
	$surname=iconv("utf-8","cp1251",mb_strtolower($_POST['surname']));
	$patronymic=iconv("utf-8","cp1251",mb_strtolower($_POST['patronymic']));
*/
/*
	$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
*/

	if(strlen($patronymic)<1)
	{
		$patronymic="null";
	}

	include("./connect.php");

	include("./loadData.php");

	$stmt=$pdo->prepare("SELECT `abiturient_id` FROM `bachelor_abiturients` WHERE `abiturient_name`=? AND `abiturient_surname`=? AND `abiturient_patronymic`	=?");
	$stmt->execute(array($name,$surname,$patronymic));
	$row=$stmt->fetch(PDO::FETCH_LAZY);
	$abiturientId=$row['abiturient_id'];

	//echo $abiturientId;

	$profileId=array();

	$stmt=$pdo->prepare("SELECT `profile` FROM `bachelor_requests` WHERE `abiturient`=?");
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
		$stmt=$pdo->prepare("SELECT `abiturient`, `diploma_type` FROM `bachelor_requests`, `bachelor_abiturients` WHERE `profile`=? AND `bachelor_requests`.`abiturient`=`bachelor_abiturients`.`abiturient_id` ORDER BY `score` DESC, `pre_sum` DESC, `individual` DESC, `ege_1` DESC, `ege_2` DESC, `ege_3` DESC, `abiturient_surname` ASC, `abiturient_name` ASC, `abiturient_patronymic` ASC");
		//$stmt=$pdo->prepare("SELECT abiturient, abiturient_surname, abiturient_name, abiturient_patronymic, diploma_type FROM bachelor_requests, bachelor_abiturients WHERE profile=? AND bachelor_requests.abiturient=bachelor_abiturients.abiturient_id ORDER BY score DESC, individual DESC, pre_sum DESC, ege_1 DESC, ege_2 DESC, ege_3 DESC, abiturient_surname ASC, abiturient_name ASC, abiturient_patronymic ASC");
		//$stmt=$pdo->prepare("SELECT abiturient, diploma_type FROM bachelor_requests WHERE profile=? ORDER BY score DESC, ege_1 DESC, ege_2 DESC, ege_3 DESC, pre_sum DESC, individual DESC");
		$stmt->execute(array($value));
		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			if ($abiturientId==$row['abiturient'])
			{
				break;
			}
			else
			{
				switch($row['diploma_type'])
				{
					case 2:$copiesCount++; break;
					case 1:$originalCount++; break;
					default:break;
				}
			}
		}

		$stmt=$pdo->prepare("SELECT `profile_description` FROM `bachelor_profiles` WHERE `profile_id`=?");
		$stmt->execute(array($value));
		$profileDescriptionId=$stmt->fetch(PDO::FETCH_LAZY);

		$stmt=$pdo->prepare("SELECT `profile_name`, `profile_code` FROM `bachelor_profile_description` WHERE `profile_description_id`=?");
		$stmt->execute(array($profileDescriptionId['profile_description']));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);

		$stmt=$pdo->prepare("SELECT `special`, `faculty`, `budget`, `form`, `capacity` FROM `bachelor_profiles` WHERE `profile_id`=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);

		$response["positions"][]=array
		(
			"copy"=>(string)$copiesCount,
			"original"=>(string)$originalCount,
			"profile_code"=>iconv("cp1251","utf-8",$profileDescription['profile_code']),
			"profile_name"=>iconv("cp1251","utf-8",$profileDescription['profile_name']),
			"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
			"budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
			"form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
			"special"=>iconv("cp1251","utf-8",$specialAbbrById[$extra['special']]),
			"capacity"=>(string)$extra['capacity']
		);
	}

	include("./disconnect.php");

	echo json_encode($response);
?>
