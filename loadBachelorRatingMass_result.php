<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	date_default_timezone_set('Asia/Yekaterinburg');
	$backUrl='<a href="./loadBachelorRatingMass.php">Попробовать ещё раз</a><br>';

/*
	if ($_POST['input_password']!="xV8lXyzTnzniRly")
	{
		echo $backUrl;
		die("Неверный пароль");
	}
*/
	include("./php/connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
	include("./php/loadData.php");

	/*echo '<pre>'; 	print_r($_POST); 	echo '</pre>';*/

	$fileName=$_FILES['rating_list']['tmp_name'];

	if ($_FILES['rating_list']['size']<=0)
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
	$profileIdColumnNumber=0;
	$FIO_columnNumber=1;
	$scoreEge1ColumnNumber=2;
	$scoreEge2ColumnNumber=3;
	$scoreEge3ColumnNumber=4;
	$PreSumColumnNumber=5;
	$individualColumnNumber=6;
	$scoreColumnNumber=7;
	$diplomaColumnNumber=9;

	/*$profileId=$_POST['profileIdToSend'][$i];
	if ($profileId<1) die("Укажите направление подготовки");*/


	$worksheet=$_POST['worksheet_number']-1;
	$rowNumber=1;
	//$profileStep=9;
	$FIO=array();
	$abiturientId=0;
	$specialContest=0;
	$profileString=0;

	$nonDigitsPattern="/\D/i";
	// load abiturients to database
	$sheet=$objPHPExcel->getSheet($worksheet);

	/*$dimentionToUnmerge=$sheet->calculateWorksheetDimension();

	$sheet->unmergeCells($dimentionToUnmerge);*/

	while(true)
	{
		$special=4;
		
		$profileName="";
		while($profileName[0]!="Направление подготовки/специальность")
		{
			$profileName=explode(" - ",$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue());
			$rowNumber++;
		}	
	
		//$profileName=deleteSpacesFromProfileName($profileName);
		//echo $profileName."<br>";		
		$profileDescriptionId=$bachelorProfileIdByFullName[iconv("utf-8","cp1251",deleteUnnecessarySpacesFromString($profileName[1]))];

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
		
		$specialId=$specialIdByInput[iconv("utf-8","cp1251",deleteUnnecessarySpacesFromString($specialName[1]))];
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

		$stmt=$pdo->prepare("SELECT profile_id FROM bachelor_profiles WHERE special=? AND form=? AND profile_description=? AND budget=?");
		$stmt->execute(array($specialId,$formId,$profileDescriptionId,$budgetId));
		$row=$stmt->fetch(PDO::FETCH_LAZY);
		$profileId=$row['profile_id'];

		//echo "№ направления: ".$profileId.'<br>';

		while($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="№")
		{
			$rowNumber++;
		}

		$stmt=$pdo->prepare("DELETE FROM bachelor_requests WHERE profile=?");
		$stmt->execute(array($profileId));
		$rowNumber+=1;

		while(/*$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="" and */ $sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="конец" and $sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()!="Списки поступающих")
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
			$ege1=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($scoreEge1ColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$ege1)>0 or mb_strlen($ege1)<1 or $ege1<1 or $ege1>100)
			{
				$ege1=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("ЕГЭ №1 должно быть от 0 до 100");
				*/
			}

			$ege2=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($scoreEge2ColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$ege2)>0 or mb_strlen($ege2)<1 or $ege2<1 or $ege2>100)
			{
				$ege2=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("ЕГЭ №2 должно быть от 0 до 100");
				*/
			}

			$ege3=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($scoreEge3ColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$ege3)>0 or mb_strlen($ege3)<1 or $ege3<1 or $ege3>100)
			{
				$ege3=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("ЕГЭ №3 должно быть от 0 до 100");
				*/
			}

			$preSum=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($PreSumColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$preSum)>0 or mb_strlen($preSum)<1)
			{
				$preSum=0;
				/*
				echo $backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Предварительный балл должен быть натуральным числом");
				*/
			}

			$individual=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($individualColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$individual)>0 or mb_strlen($individual)<1)
			{
				$individual=0;
				/*
				echo backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Балл за индивидуальные достижения должен быть натуральным числом");
				*/
			}

			//$score=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($scoreColumnNumber, $rowNumber)->getValue());
			$score=deleteAllSpacesFromString($sheet->getCellByColumnAndRow($scoreColumnNumber, $rowNumber)->getValue());
			if (preg_match($nonDigitsPattern,$score)>0 or mb_strlen($score)<1)
			{
				$score=0;
				/*
				echo backUrl;
				echo "Строка №".$rowNumber.'<br>';
				die("Суммарный балл должен быть натуральным числом");
				*/
			}

			$diplomaType=deleteAllSpacesFromString(iconv("utf-8","cp1251",mb_strtolower($sheet->getCellByColumnAndRow($diplomaColumnNumber, $rowNumber)->getValue())));

			$stmt=$pdo->prepare("SELECT abiturient_id FROM bachelor_abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
			$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));
			$row=$stmt->fetch(PDO::FETCH_LAZY);

			$abiturientId=$row['abiturient_id'];

			if ($abiturientId<1)
			{
				$stmt=$pdo->prepare("INSERT INTO bachelor_abiturients SET abiturient_name=?, abiturient_surname=?, abiturient_patronymic=?");
				$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));

				$stmt=$pdo->prepare("SELECT abiturient_id FROM bachelor_abiturients WHERE abiturient_name=? AND abiturient_surname=? AND abiturient_patronymic=?");
				$stmt->execute(array($abiturientName,$abiturientSurname,$abiturientPatronymic));
				$row=$stmt->fetch(PDO::FETCH_LAZY);
				$abiturientId=$row['abiturient_id'];
			}

			$stmt=$pdo->prepare("INSERT INTO bachelor_requests SET abiturient=?, diploma_type=?, profile=?, score=?, ege_1=?, ege_2=?, ege_3=?, pre_sum=?, individual=?");
			$stmt->execute(array($abiturientId,$diplomaIdByName[$diplomaType],$profileId,$score,$ege1,$ege2,$ege3,$preSum,$individual));

			$rowNumber+=1;
		}
		if ($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()=="конец") break;
	}

	echo "Готово!<br>";
	echo '<a href="./loadBachelorRatingMass.php">Загрузить ещё рейтинг</a><br>';
	include("./php/disconnect.php");
?>
