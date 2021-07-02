<?php
	date_default_timezone_set('Asia/Yekaterinburg');
	/*
	1.  english_choice
	2.  biology_choice
	3.  geography_choice
	4.  it_choice
	5.  spanish_choice
	6.  history_choice
	7.  literature_choice
	8.  german_choice
	9.  society_choice
	10.  french_choice
	11. physics_choice
	12. chemistry_choice;
	*/

	$subjectsRaw=$_GET['subjects'];
	$subjectsArray=explode("_",$subjectsRaw);


	include("./connect.php");
	include("./loadData.php");


	$foundProfilesId=array();
	$profiles=array();

	$profileId=0;

	foreach($subjectsArray as $key=>$subjectNumber)
	{
		if ($subjectNumber>0)
		{
			$stmt=$pdo->prepare("SELECT * FROM ege_and_profile WHERE ege_id=?");
			$stmt->execute(array($key+1));
			while($row=$stmt->fetch(PDO::FETCH_LAZY))
			{
				$profileId=$row['profile_id'];
				if (!in_array($profileId,$foundProfilesId))
				{
					$foundProfilesId[]=$profileId;
				}
			}
		}
	}

	foreach($foundProfilesId as $key=>$value)
	{
		$stmt=$pdo->prepare("SELECT faculty, budget, form, outbox_education FROM profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);

		$response['profiles'][]=array
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
?>
