<?php
	date_default_timezone_set('Asia/Yekaterinburg');

	$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
	
	include("./connect.php");
	
	include("./loadData.php");
	
	$stmt=$pdo->prepare("SELECT abiturient_id FROM abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
	$stmt->execute(array($name,$surname,$patronymic));
	$row=$stmt->fetch(PDO::FETCH_LAZY);
	$abiturientId=$row['abiturient_id'];
	
	//echo $abiturientId;
	
	$profileId=array();

	$stmt=$pdo->prepare("SELECT profile FROM requests WHERE abiturient=?");
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
		$stmt=$pdo->prepare("SELECT abiturient, diploma_type FROM requests WHERE profile=? ORDER BY score DESC");
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
		
		
		
		$stmt=$pdo->prepare("SELECT profile_description FROM profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$profileDescriptionId=$stmt->fetch(PDO::FETCH_LAZY);
		
		/*echo '<pre>';
		print_r($profileDescription);
		echo '</pre>';*/
		
		$stmt=$pdo->prepare("SELECT profile_name, profile_code FROM profile_description WHERE profile_description_id=?");
		$stmt->execute(array($profileDescriptionId['profile_description']));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);
		
		$stmt=$pdo->prepare("SELECT special FROM requests WHERE profile=? AND abiturient=?");
		$stmt->execute(array($value,$abiturientId));
		$special=$stmt->fetch(PDO::FETCH_LAZY);
		
		$stmt=$pdo->prepare("SELECT faculty, budget, form, outbox_education FROM profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);
				
		$response['positions'][]=array
		(
			"copy"=>$copiesCount,
			"original"=>$originalCount,
			"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
			"profile_code"=>iconv("cp1251","utf-8",$profileDescription['profile_code']),
			"profile_name"=>iconv("cp1251","utf-8",$profileDescription['profile_name']),
			"budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
			"form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
			"special"=>iconv("cp1251","utf-8",$specialNameById[$special['special']]),
			"outbox"=>iconv("cp1251","utf-8",$outboxEducationNameById[$extra['outbox_education']])
		);
	}
	
	include("./disconnect.php");
	
	echo json_encode($response);
?>