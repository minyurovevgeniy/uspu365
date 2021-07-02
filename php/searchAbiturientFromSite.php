<?php
	/*$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);*/
	
	/*if($_GET['cp1251']=='y')
	{
		$name=$_GET['name'];
		$surname=$_GET['surname'];
		$patronymic=$_GET['patronymic'];
	}
	else
	{*/
		$name=iconv("utf-8","cp1251",$_GET['name']);
		$surname=iconv("utf-8","cp1251",$_GET['surname']);
		$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
	//}
	
	
	include("./connect.php");
	
	include("./loadData.php");
	
	$stmt=$pdo->prepare("SELECT abiturient_id FROM abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
	$stmt->execute(array($name,$surname,$patronymic));
	$row=$stmt->fetch(PDO::FETCH_LAZY);
	$abiturientId=$row['abiturient_id'];
	
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
					case 1:$copiesCount++; break;
					case 2:$originalCount++; break;
					default:break;
				}
			}
			else
			{
				break;
			}
		}
		
		$stmt=$pdo->prepare("SELECT special FROM requests WHERE profile=? AND abiturient=?");
		$stmt->execute(array($value,$abiturientId));
		$special=$stmt->fetch(PDO::FETCH_LAZY);
		
		$stmt=$pdo->prepare("SELECT faculty, budget, form, outbox_education FROM profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);
				
		/*if($_GET['cp1251']=='y')
		{
			$response['positions'][]=array
			(
				"copy"=>$copiesCount,
				"original"=>$originalCount,
				"faculty"=>$facultyNameById[$extra['faculty']],
				"profile"=>$profileNameById[$value],
				"budget"=>$budgetNameById[$extra['budget']],
				"form"=>$formNameById[$extra['form']],
				"special"=>$specialNameById[$special['special']],
				"outbox"=>$outboxEducationNameById[$extra['outbox_education']]
			);
		}
		else
		{
			$response['positions'][]=array
			(
				"copy"=>$copiesCount,
				"original"=>$originalCount,
				"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
				"profile"=>iconv("cp1251","utf-8",$profileNameById[$value]),
				"budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
				"form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
				"special"=>iconv("cp1251","utf-8",$specialNameById[$special['special']]),
				"outbox"=>iconv("cp1251","utf-8",$outboxEducationNameById[$extra['outbox_education']])
			);
		}*/
	
		$response['positions'][]=array
		(
			"copy"=>$copiesCount,
			"original"=>$originalCount,
			"faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
			"profile"=>iconv("cp1251","utf-8",$profileNameById[$value]),
			"budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
			"form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
			"special"=>iconv("cp1251","utf-8",$specialNameById[$special['special']]),
			"outbox"=>iconv("cp1251","utf-8",$outboxEducationNameById[$extra['outbox_education']])
		);
	}
	
	include("./disconnect.php");
	
	echo json_encode($response);
?>