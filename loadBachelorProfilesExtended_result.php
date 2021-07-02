<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	date_default_timezone_set('Asia/Yekaterinburg');

	$backUrl='<a href="./loadBachelorProfilesExtended.php">Попробовать ещё раз</a><br>';
	/*
	if ($_POST['input_password']!="UMoatTvRLZwyPLT")
	{
		echo $backUrl;
		die('Неверный пароль');
	}*/

	include("./php/connect.php");
	require_once './php/PHPExcel/Classes/PHPExcel.php';

	include("./php/loadData.php");

	$fileName=$_FILES['profiles']['tmp_name'];

	if ($_POST['worksheet_number']<1)
	{
		echo $backUrl;
		die("Укажите корректный номер листа");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	$worksheet=$_POST['worksheet_number']-1;
	$facultyNameColumn=$_POST['faculty_name_column']-1;
	$profileCodeColumn=$_POST['profile_code_column']-1;
	$profileNameColumn=$_POST['profile_name_column']-1;
	$profileBudgetColumn=$_POST['profile_budget_column']-1;
	$profileFormColumn=$_POST['profile_form_column']-1;
	$profileCapacityColumn=$_POST['profile_capacity_column']-1;
	$profileSpecialColumn=$_POST['profile_special_column']-1;
	$egeSetColumn=$_POST['ege_set_column']-1;

	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];
	$shouldEmpty=$_POST['shouldEmpty'];

	if (mb_strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profiles");
		$stmt->execute();

		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profile_description");
		$stmt->execute();

		$stmt=$pdo->prepare("TRUNCATE TABLE ege_sets");
		$stmt->execute();
	}

	$previousEgeSet=array();
	$currentEgeSet=array();

	// load (!!!) BACHELOR (!!!) profiles to database and connecting with faculties
	$sheet=$objPHPExcel->getSheet($worksheet);
	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$nextEgeSet=array();
		$previousEgeSet=array();
		$currentEgeSet=array();

		$facultyName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($facultyNameColumn, $rowNumber)->getValue());
		$profileCode=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileCodeColumn, $rowNumber)->getValue());
		$profileName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileNameColumn, $rowNumber)->getValue());
		$profileBudget=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileBudgetColumn, $rowNumber)->getValue());
		$profileForm=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileFormColumn, $rowNumber)->getValue());
		$profileSpecial=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileSpecialColumn, $rowNumber)->getValue());
		$profileCapacity=$sheet->getCellByColumnAndRow($profileCapacityColumn, $rowNumber)->getValue();
		$egeSet=explode(";",deleteAllSpacesFromString(iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($egeSetColumn, $rowNumber)->getValue())));

		$egeCount=count($egeSet);

		$facultyName=deleteUnnecessarySpacesFromString($facultyName);
		$profileCode=deleteAllSpacesFromString($profileCode);
		$profileName=deleteSpacesFromProfileName($profileName);
		$profileBudget=deleteUnnecessarySpacesFromString($profileBudget);
		$profileSpecial=deleteUnnecessarySpacesFromString($profileSpecial);
		$profileCapacity=deleteAllSpacesFromString($profileCapacity);


		$stmt=$pdo->prepare("SELECT * FROM ege_sets WHERE ege=?");
		$stmt->execute(array($egeIdByAbbr[$egeSet[0]]));
		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			$nextEgeSet[]=$row['ege_set_id'];
		}

		$currentEgeSet=array();
		foreach ($egeSet as $value)
		{
			$stmt=$pdo->prepare("SELECT COUNT(*) FROM ege_exams WHERE ege_id=?");
			$stmt->execute(array($egeIdByAbbr[$value]));

			$row=$stmt->fetch(PDO::FETCH_LAZY);
			if ($row['COUNT(*)']<1)
			{
				echo $backUrl;
				die("Сокращение ".iconv("cp1251","utf-8",$value)." не найдено");
			}
			$previousEgeSet=$nextEgeSet;
			$nextEgeSet=array();

			//echo $egeIdByAbbr[$value].'<br>';

			$stmt=$pdo->prepare("SELECT * FROM ege_sets WHERE ege=?");
			$stmt->execute(array($egeIdByAbbr[$value]));
			while($row=$stmt->fetch(PDO::FETCH_LAZY))
			{
				$currentEgeSet[]=$row['ege_set_id'];
			}

			foreach ($currentEgeSet as $curEgeSet)
			{
				if (in_array($curEgeSet,$previousEgeSet))
				{
					$nextEgeSet[]=$curEgeSet;
				}
			}
			$currentEgeSet=array();
		}

		/*
		echo '<pre>';
		print_r($nextEgeSet);
		echo '</pre>';
		*/

		$nextEgeSetId=$nextEgeSet[0];

		/*
		echo $nextEgeSetId.'<br>';
		echo '<br>';
		*/

		if (count($nextEgeSet)<=0)
		{
			// find max ege_set_id
			$stmt=$pdo->prepare("SELECT MAX(ege_set_id) FROM ege_sets");
			$stmt->execute();
			$row=$stmt->fetch(PDO::FETCH_LAZY);
			$nextEgeSetId=$row['MAX(ege_set_id)']+1;
			//echo $nextEgeSetId.'<br>';
			foreach ($egeSet as $value)
			{
				$stmt=$pdo->prepare("INSERT INTO ege_sets SET ege_set_id=?, ege=?");
				$stmt->execute(array($nextEgeSetId, $egeIdByAbbr[$value]));
			}
		}

		$stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_profile_description WHERE profile_name=? AND profile_code=?");
		$stmt->execute(array($profileName,$profileCode));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);

		$newProfileDescriptionId=$profileDescription['COUNT(*)'];

		if($newProfileDescriptionId<1)
		{
			$stmt=$pdo->prepare("INSERT INTO bachelor_profile_description SET profile_name=?, profile_code=?");
			$stmt->execute(array($profileName,$profileCode));
		}

		$stmt=$pdo->prepare("SELECT profile_description_id FROM bachelor_profile_description WHERE profile_name=? AND profile_code=?");
		$stmt->execute(array($profileName,$profileCode));
		$row=$stmt->fetch(PDO::FETCH_LAZY);
		$newProfileDescriptionId=$row['profile_description_id'];

		$facultyId=$facultyIdByName[$facultyName];

		$stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_profiles WHERE faculty=? AND profile_description=? AND budget=? AND form=? AND special=? AND capacity=? AND ege_set=?");
		$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$specialIdByName[$profileSpecial],$profileCapacity,$nextEgeSetId));
		$row=$stmt->fetch(PDO::FETCH_LAZY);


    if ($row['COUNT(*)']<1)
		{
			$stmt=$pdo->prepare("INSERT INTO bachelor_profiles SET faculty=?, profile_description=?, budget=?, form=?, capacity=?, special=?, ege_set=?");
			$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$profileCapacity,$specialIdByName[$profileSpecial],$nextEgeSetId));
		}
	}
	include("./php/disconnect.php");

	echo 'Готово!<br>';
	echo '<a href="./loadBachelorProfilesExtended.php">Загрузить ещё</a>';
?>
