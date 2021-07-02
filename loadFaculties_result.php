<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*
	if ($_POST['input_password']!="VSH7tbo3x9KF26U")
	{
		die("Неверный пароль");
	}
	*/

	include("./php/connect.php");
	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
	include("./php/loadData.php");

	$fileName=$_FILES['faculties']['tmp_name'];
	if ($_FILES['faculties']['size']<=0)
	{
		echo '<a href="./loadFaculties.php">Попробовать ещё раз</a><br>';
		die("Файл пустой");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	$worksheet=$_POST['worksheet_number']-1;
	$fullNameColumn=$_POST['full_name_column']-1;
	$abbreviationColumn=$_POST['abbreviation']-1;
	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];
	$shouldEmpty=$_POST['shouldEmpty'];

	if (strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE faculties");
		$stmt->execute();
	}

	$sheet=$objPHPExcel->getSheet($worksheet);

	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$fullName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($fullNameColumn, $rowNumber)->getValue());
		$abbreviation=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($abbreviationColumn, $rowNumber)->getValue());

		$fullName=deleteUnnecessarySpacesFromString($fullName);
		$abbreviation=deleteAllSpacesFromString($abbreviation);

		$stmt=$pdo->prepare("SELECT faculty_id FROM faculties WHERE faculty_name=? AND faculty_abbr=?");
		$stmt->execute(array($fullName,$abbreviation));
		$row=$stmt->fetch(PDO::FETCH_LAZY);

		$facultyId=$row['faculty_id'];

		if ($facultyId<1)
		{
			$stmt=$pdo->prepare("INSERT INTO faculties SET faculty_name=?, faculty_abbr=?");
			$stmt->execute(array($fullName,$abbreviation));
		}
	}
	include("./php/disconnect.php");

	echo '<a href="./loadFaculties.php">Загрузить ещё информацию о подразделениях</a>';
?>
