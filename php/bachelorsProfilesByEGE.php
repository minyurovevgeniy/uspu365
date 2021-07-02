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

	//$subjectsRaw=$_GET['subjects'];
	$subjectsRaw=$_POST['subjects'];
	$subjectsArray=explode("_",$subjectsRaw);

	include("./connect.php");
	include("./loadData.php");


	$foundProfilesId=array();

	$profileId=0;

	foreach($subjectsArray as $key=>$subjectNumber)
	{
		if ($subjectNumber>0)
		{
			$stmt=$pdo->prepare("SELECT profile_id FROM bachelor_profiles WHERE ege_set=?");
			$stmt->execute(array($subjectNumber));
			while($row=$stmt->fetch(PDO::FETCH_LAZY))
			{
				$foundProfilesId[]=$row['profile_id'];
			}
		}
	}

	$budgetValue=0;
	$nonBudgetValue=0;

	$response=array();
	foreach($foundProfilesId as $key=>$value)
	{
		$stmt=$pdo->prepare("SELECT faculty, budget, capacity, form, special, profile_description FROM bachelor_profiles WHERE profile_id=?");
		$stmt->execute(array($value));
		$extra=$stmt->fetch(PDO::FETCH_LAZY);

		$stmt=$pdo->prepare("SELECT profile_code, profile_name FROM bachelor_profile_description WHERE profile_description_id=?");
		$stmt->execute(array($extra['profile_description']));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);


		/*
		$stmt=$pdo->prepare("SELECT price_value FROM profile_and_price WHERE profile_id=?");
		$stmt->execute(array($value));
		$price=$stmt->fetch(PDO::FETCH_LAZY);

		$priceValue=0;
		if ($price['price_value']>0)
		{
			$priceValue=$price['price_value'];
		}*/

		$response['profiles'][]=array
		(
			"profile_code"=>$profileDescription['profile_code'],
			"profile_name"=>iconv("cp1251","utf-8",$profileDescription['profile_name']),
			"profile_form"=>iconv("cp1251","utf-8",$formNameById[$extra['form']]),
			"profile_capacity"=>$extra['capacity'],
			"profile_budget"=>iconv("cp1251","utf-8",$budgetNameById[$extra['budget']]),
			"profile_faculty"=>iconv("cp1251","utf-8",$facultyNameById[$extra['faculty']]),
			"profile_special"=>iconv("cp1251","utf-8",$specialAbbrById[$extra['special']])
		);
	}

	echo json_encode($response);
	include("./disconnect.php");
?>
