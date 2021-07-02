<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	date_default_timezone_set('Asia/Yekaterinburg');

	if ($_POST['input_password']!="UMoatTvRLZwyPLT")
	{
		echo '<a href="./loadBachelorProfiles.php">Попробовать ещё раз</a>';
		die('Неверный пароль');
	}

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

	if (strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profiles");
		$stmt->execute();
		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profile_description");
		$stmt->execute();
	}

	include("./php/loadData.php");

	// load (!!!) BACHELOR (!!!) profiles to database and connecting with faculties
	$sheet=$objPHPExcel->getSheet($worksheet);
	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$facultyName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($facultyNameColumn, $rowNumber)->getValue());
		$profileCode=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileCodeColumn, $rowNumber)->getValue());
		$profileName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileNameColumn, $rowNumber)->getValue());
		$profileBudget=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileBudgetColumn, $rowNumber)->getValue());
		$profileForm=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileFormColumn, $rowNumber)->getValue());
		$profileSpecial=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($profileSpecialColumn, $rowNumber)->getValue());
		$profileCapacity=$sheet->getCellByColumnAndRow($profileCapacityColumn, $rowNumber)->getValue();
		$egeSet=$sheet->getCellByColumnAndRow($egeSetColumn, $rowNumber)->getValue();

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

		$stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_profiles WHERE faculty=? AND profile_description=? AND budget=? AND form=? AND special=? AND capacity=?");
		$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$specialIdByName[$profileSpecial],$profileCapacity));
		$row=$stmt->fetch(PDO::FETCH_LAZY);

		if ($row['COUNT(*)']<1)
		{
			$stmt=$pdo->prepare("INSERT INTO bachelor_profiles SET faculty=?, profile_description=?, budget=?, form=?, capacity=?, special=?, ege_set=?");
			$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$profileCapacity,$specialIdByName[$profileSpecial],$egeSet));
		}
	}
	include("./php/disconnect.php");

	echo '<a href="./loadBachelorProfiles.php">Загрузить ещё</a>';
?>
