<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	date_default_timezone_set('Asia/Yekaterinburg');
	$backUrl='<a href="./loadMagisterRatingMass.php">Попробовать ещё раз</a><br>';

	/*if ($_POST['input_password']!="yiXXtqRYiCYPaNA")
	{
		echo $backUrl;
		die("Неверный пароль");
	}*/

	include("./php/connect.php");
	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
	include("./php/loadData.php");

	$fileName=$_FILES['rating_list']['tmp_name'];

	if ($_FILES['rating_list']['size']<=0)
	{
		echo $backUrl;
		die("Файл пустой");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	$abiturientId=0;

	if ($_POST['worksheet_number']<1)
	{
		echo $backUrl;
		die("Укажите корректный номер листа");
	}

	// Номер листа
	$worksheet=$_POST['worksheet_number']-1;

	$profileIdColumnNumber=0;
	$FIO_columnNumber=1;
	$profileTestColumnNumber=2;
	$baseTestColumnNumber=3;
	$PreSumColumnNumber=4;
	$individualColumnNumber=5;
	$scoreColumnNumber=6;
	$diplomaColumnNumber=8;
	$rowNumber=1;

	$stmt=$pdo->prepare("DELETE FROM magistracy_requests WHERE profile=?");
	$stmt->execute(array($profileId));

	// load abiturients to database
	$sheet=$objPHPExcel->getSheet($worksheet);

	$nonDigitsPattern="/\D/i";

	while(true)
	{
		$profileName="";
		while($profileName[0]!="Направление подготовки/специальность")
		{
			$profileName=explode(" - ",$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue());
			$rowNumber++;
		}	
	
		//$profileName=deleteSpacesFromProfileName($profileName);
		//echo $profileName."<br>";		
		$profileDescriptionId=$magisterProfileIdByFullName[iconv("utf-8","cp1251",deleteUnnecessarySpacesFromString($profileName[1]))];

		//echo "Описание направления:".$profileDescriptionId."<br>";
		
		$rowNumber++;

		
		// чтение формы
		$formString=explode(" - ",$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue());
		$formId=$formIdByInput[iconv("utf-8","cp1251",$formString[1])];
		//echo "Форма".$formId."<br>";
		
		$rowNumber++;
		
		// чтение основание поступления
		$specialName=explode(" - ",$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue());
		/*echo '<pre>';
		print_r($specialName);
		echo '</pre>';*/
		
		$specialId=$specialIdByInput[iconv("utf-8","cp1251",$specialName[1])];
		//echo "Особое: ".$specialId."<br>";
		$budgetId=1;
		
		if ($specialId!=5)
		{
			$budgetId=1;
		}
		else 
		{
			$budgetId=2;
		}
		//echo "Бюджет".$budgetId."<br>";

		$stmt=$pdo->prepare("SELECT profile_id FROM magistracy_profiles WHERE special=? AND form=? AND profile_description=? AND budget=?");
		$stmt->execute(array($specialId,$formId,$profileDescriptionId,$budgetId));
		$row=$stmt->fetch(PDO::FETCH_LAZY);
		$profileId=$row['profile_id'];

/*
		echo "Название профиля: (".$profileDescriptionId.")".$profileName."<br>";
		echo "Бюджет (".$budgetId."): ".$contestGroupDetails[$detailIndex]."<br>";
		echo "№ направления: ".$profileId.'<br>';
	*/

		while($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="№")
		{
			$rowNumber+=1;
		}

		$stmt=$pdo->prepare("DELETE FROM magistracy_requests WHERE profile=?");
		$stmt->execute(array($profileId));

		$rowNumber+=1;
		while($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="" and $sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="конец" and $sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="Списки поступающих")
		{
			$abiturientFIO=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($FIO_columnNumber, $rowNumber)->getValue());

			//echo $rowNumber.":".$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()." ".$sheet->getCellByColumnAndRow($FIO_columnNumber, $rowNumber)->getValue()."<br>";

			$FIO=explode(' ',$abiturientFIO);
			$abiturientSurname=$FIO[0];
			$abiturientName=$FIO[1];

			if(isset($FIO[2]))
			{
				$abiturientPatronymic=$FIO[2];
			}
			else
			{
				$abiturientPatronymic="null";
			}

			$profileTest=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($profileTestColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$profileTest)>0 or mb_strlen($profileTest)<1)
			{
				$profileTest=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Профильный тест должен быть натуральным числом");
				*/
			}

			$baseTest=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($baseTestColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$baseTest)>0 or mb_strlen($baseTest)<1)
			{
				$baseTest=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Базовый тест должен быть натуральным числом");
				*/
			}

			$preSum=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($PreSumColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$preSum)>0 or mb_strlen($preSum)<1)
			{
				$preSum=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Предварительная сумма должна быть натуральным числом");
				*/
			}

			$individual=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($individualColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$individual)>0 or mb_strlen($individual)<1)
			{
				$individual=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Индивидуальные достижения должны быть натуральным числом");
				*/
			}

			$score=deleteAllSpacesFromString(iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($scoreColumnNumber, $rowNumber)->getValue()));
			if (preg_match($nonDigitsPattern,$score)>0 or mb_strlen($score)<1)
			{
				$score=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Сумма баллов должна быть натуральным числом");
				*/
			}

			$diplomaType=deleteAllSpacesFromString(iconv("utf-8","cp1251",mb_strtolower($sheet->getCellByColumnAndRow($diplomaColumnNumber, $rowNumber)->getValue())));

			$stmt=$pdo->prepare("SELECT abiturient_id FROM magistracy_abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
			$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));
			$row=$stmt->fetch(PDO::FETCH_LAZY);

			$abiturientId=$row['abiturient_id'];

			if ($abiturientId<1)
			{
				$stmt=$pdo->prepare("INSERT INTO magistracy_abiturients SET abiturient_name=?, abiturient_surname=?, abiturient_patronymic=?");
				$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));

				$stmt=$pdo->prepare("SELECT abiturient_id FROM magistracy_abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
				$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));
				$row=$stmt->fetch(PDO::FETCH_LAZY);
				$abiturientId=$row['abiturient_id'];
			}

			$stmt=$pdo->prepare("INSERT INTO magistracy_requests SET abiturient=?, diploma_type=?, profile=?, score=?, profile_test=?, base_test=?, pre_sum=?, individual=?");
			$stmt->execute(array($abiturientId,$diplomaIdByName[$diplomaType],$profileId,$score,$profileTest,$baseTest,$preSum,$individual));

			$rowNumber+=1;
		}
		if ($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()=="конец") break;
	}

	echo 'Готово!<br>';
	echo 	'<a href="./loadMagisterRatingMass.php">Загрузить ещё рейтинг</a><br>';
	include("./php/disconnect.php");
?>
