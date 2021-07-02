<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	$tryOnceMore='<a href="./loadEGE.php">Попробовать ещё раз</a><br>';

	/*if ($_POST['input_password']!="VSH7tbo3x9KF26U")
	{
		echo $tryOnceMore;
		die("Неверный пароль");
	}*/

	include("./php/connect.php");
	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
	include("./php/loadData.php");

	$fileName=$_FILES['EGE']['tmp_name'];

	if ($_FILES['EGE']['size']<=0)
	{
		echo $tryOnceMore;
		die("Файл пустой");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	$worksheet=$_POST['worksheet_number']-1;
	$fullEGEnameColumn=$_POST['fullEGEname']-1;
	$abbreviationColumn=$_POST['abbreviation']-1;
	$minEGEvalueColumn=$_POST['minEGEvalue']-1;
	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];

	$shouldEmpty=$_POST['shouldEmpty'];


	if (mb_strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE ege_exams");
		$stmt->execute();

		$stmt=$pdo->prepare("TRUNCATE TABLE ege_sets");
		$stmt->execute();

		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profiles");
		$stmt->execute();

		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_profile_description");
		$stmt->execute();
	}


	$sheet=$objPHPExcel->getSheet($worksheet);

	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$fullEGEname=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($fullEGEnameColumn, $rowNumber)->getValue());
		$abbreviation=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($abbreviationColumn, $rowNumber)->getValue());
		$minEGEvalue=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($minEGEvalueColumn, $rowNumber)->getValue());

		$fullEGEname=deleteUnnecessarySpacesFromString($fullEGEname);
		$abbreviation=deleteAllSpacesFromString($abbreviation);
		$minEGEvalue=deleteAllSpacesFromString($minEGEvalue);

		if (preg_match('/\D/i',$minEGEvalue)>0 or mb_strlen($minEGEvalue)<1)
		{
			echo "Строка №".$rowNumber."<br>";
			echo $tryOnceMore;
			die("Минимальный балл ЕГЭ должен быть числом");
		}

		$stmt=$pdo->prepare("SELECT ege_id FROM ege_exams WHERE ege_name=?");
		$stmt->execute(array($fullEGEname));
		$row=$stmt->fetch(PDO::FETCH_LAZY);

		$ege_id=$row['ege_id'];

		if ($ege_id<1)
		{
			/*
			echo "Название ЕГЭ:".iconv("cp1251","utf-8",$fullEGEname)."<br>";
			echo "Сокращение:".iconv("cp1251","utf-8",$abbreviation)."<br>";
			echo "Минимальный балл	:".iconv("cp1251","utf-8",$minEGEvalue)."<br><br><br>";
			*/
			$stmt=$pdo->prepare("INSERT INTO ege_exams SET ege_name=?, ege_abbr=?, ege_min=?");
			$stmt->execute(array($fullEGEname,$abbreviation,$minEGEvalue));
		}
	}
	include("./php/disconnect.php");
	echo 'Готово!<br>';
	echo '<a href="./loadEGE.php">Загрузить ещё баллы ЕГЭ</a>';
?>
