<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	date_default_timezone_set('Asia/Yekaterinburg');
	$backUrl='<a href="./loadMagisterProfiles.php">Попробовать ещё раз</a><br>';

	/*if ($_POST['password']!="yGMgOgrckYl4Eoa")
	{
		echo $backUrl;
		die("Неверный пароль");
	}*/

	$backUrl='<a href="./loadMagisterProfiles.php">Попробовать ещё раз</a><br>';

	include("./php/connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';

	include("./php/loadData.php");

	$fileName=$_FILES['profiles']['tmp_name'];

	if ($_FILES['profiles']['size']<=0)
	{
		echo $backUrl;
		die("Файл пустой");
	}

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

	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];

	$shouldEmpty=$_POST['shouldEmpty'];

	if (mb_strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE magistracy_profiles");
		$stmt->execute();
		$stmt=$pdo->prepare("TRUNCATE TABLE magistracy_profile_description");
		$stmt->execute();
	}

	// load (!!!) MAGISTRACY (!!!) profiles to database and connecting with faculties
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

		$facultyName=deleteUnnecessarySpacesFromString($facultyName);
		$profileCode=deleteAllSpacesFromString($profileCode);
		$profileName=deleteSpacesFromProfileName($profileName);
		$profileBudget=deleteAllSpacesFromString($profileBudget);
		$profileForm=deleteAllSpacesFromString($profileForm);
		$profileSpecial=deleteUnnecessarySpacesFromString($profileSpecial);
		$profileCapacity=deleteAllSpacesFromString($profileCapacity);

		if (preg_match('/\D/i',$profileCapacity)>0)
		{
			echo "Строка №".$rowNumber."<br>";
			echo $backUrl;
			die("Количество баллов должно быть числом");
		}

		$stmt=$pdo->prepare("SELECT profile_description_id FROM magistracy_profile_description WHERE profile_name=? AND profile_code=?");
		$stmt->execute(array($profileName,$profileCode));
		$profileDescription=$stmt->fetch(PDO::FETCH_LAZY);

		$newProfileDescriptionId=$profileDescription['profile_description_id'];

		if($newProfileDescriptionId<1)
		{
			$stmt=$pdo->prepare("INSERT INTO magistracy_profile_description SET profile_name=?, profile_code=?");
			$stmt->execute(array($profileName,$profileCode));
		}

		$stmt=$pdo->prepare("SELECT profile_description_id FROM magistracy_profile_description WHERE profile_name=? AND profile_code=?");
		$stmt->execute(array($profileName,$profileCode));
		$row=$stmt->fetch(PDO::FETCH_LAZY);
		$newProfileDescriptionId=$row['profile_description_id'];

		$facultyId=$facultyIdByName[$facultyName];

		$stmt=$pdo->prepare("SELECT COUNT(*) FROM magistracy_profiles WHERE faculty=? AND profile_description=? AND budget=? AND form=? AND special=? AND capacity=?");
		$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$specialIdByName[$profileSpecial],$profileCapacity));
		$row=$stmt->fetch(PDO::FETCH_LAZY);

		if ($row['COUNT(*)']<1)
		{
			$stmt=$pdo->prepare("INSERT INTO magistracy_profiles SET faculty=?, profile_description=?, budget=?, form=?, special=?, capacity=?");
			$stmt->execute(array($facultyId,$newProfileDescriptionId,$budgetIdByName[$profileBudget],$formIdByName[$profileForm],$specialIdByName[$profileSpecial],$profileCapacity));
		}
	}
	include("./php/disconnect.php");

	echo 'Готово!<br>';
	echo '<a href="./loadMagisterProfiles.php">Загрузить ещё</a>';
?>
