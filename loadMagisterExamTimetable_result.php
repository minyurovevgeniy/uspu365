<?php ?><?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*
	if ($_POST['input_password']!="MVS2Mv7SzojC1Ok")
	{
		die("Неверный пароль");
	}
	*/

	include("./php/connect.php");
	//include("./php/checkEvent.php");
	$event=$_SESSION['event'];

	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
//	include("./php/loadData.php");

	$backUrl='<a href="loadMagisterExamTimetable.php">Попробуйте ещё раз</a><br>';

	$fileName=$_FILES['timetable_file']['tmp_name'];

	if ($_FILES['timetable_file']['size']<=0)
	{
		echo $backUrl;
		die("Файл пустой");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	// Номер листа
	$worksheet=$_POST['worksheet_number']-1;

	$otherColumnNumber=$_POST["notes_column_number"]-1;
	$dateColumnNumber=$_POST["date_column_number"]-1;
	$startTimeColumnNumber=$_POST["start_time_column_number"]-1;
	$endTimeColumnNumber=$_POST["end_time_column_number"]-1;
	$roomColumnNumber=$_POST["room_column_number"]-1;
	
	$shouldEpmty=$_POST["shouldEpmty"];

	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];

	if (mb_strtolower($shouldEpmty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE magistracy_exam_timetable");
		$stmt->execute();
	}

	$sheet=$objPHPExcel->getSheet($worksheet);

	$nonDigitPattern='/\D/i';

	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$rowNumberReport="<br>Ошибка в строке №".$rowNumber.'<br>';

		$date=$sheet->getCellByColumnAndRow($dateColumnNumber, $rowNumber)->getValue();

		$dateDetailed=explode("_", $date);

		if (count($dateDetailed)!=3)
		{
			echo 'Дни, месяцы и годы должны быть разделены символом "_"<br>';
			echo $rowNumberReport;
			echo $backUrl;
			die("Ошибка");
		}
		else
		{
			$year=$dateDetailed[2];
			if (preg_match($nonDigitPattern,$year)>0 or (mb_strlen($year)>4) or (mb_strlen($year)<1))
			{
				echo 'Год '.$year.' должен содержать 4 цифры<br>';
				echo $rowNumberReport;
				echo $backUrl;
				die("Ошибка");
			}
			else
			{
				$month=$dateDetailed[1];
				if (preg_match($nonDigitPattern,$month)>0 or ($month>12) or ($month<1))
				{
					echo 'Месяц '.$month.' должен быть в диапазоне от 1 до 12 включительно и иметь ведущий 0 при необходимости<br>';
					echo $rowNumberReport;
					echo $backUrl;
					die("Ошибка");
				}
				else
				{
					$days=array(31,28,31,30,31,30,31,31,30,31,30,31);
					$day=$dateDetailed[0];
				  if ((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0))
					{
						$days[1]=29;
					}

					if (($day<1) or $day>$days[$month-1] or preg_match($nonDigitPattern,$day	)>0)
					{
						echo 'День месяца '.$day.' должен быть в диапазоне от 1 до '.$days[$month-1].' включительно<br>';
						echo $rowNumberReport;
						echo $backUrl;
						die("Ошибка");
					}
				}
			}
		}

		$dateToWrite=implode("-",array_reverse($dateDetailed));
		//echo $dateToWrite."<br>";

		//$weekday=iconv("utf-8","cp1251",mb_strtolower($sheet->getCellByColumnAndRow($weekdayColumnNumber, $rowNumber)->getValue()));

		//Convert the date string into a unix timestamp.
		$unixTimestamp = strtotime($dateToWrite);

		//Get the day of the week using PHP's date function.
		$weekday= date("N", $unixTimestamp);

		$startTime=$sheet->getCellByColumnAndRow($startTimeColumnNumber, $rowNumber)->getValue();

		$startTimeDetailed=explode("_",$startTime);

		if (count($startTimeDetailed)>2)
		{
			echo 'Время '.$startTime.' должно быть записано в формате ЧЧ_ММ<br>';
			echo $backUrl;
			echo $rowNumberReport;
			die("Ошибка");
		}

		$startTimeHour=$startTimeDetailed[0];
		$startTimeMinutes=$startTimeDetailed[1];

		if (preg_match($nonDigitPattern,$startTimeHour)>0 or ($startTimeHour>23) or ($startTimeHour<0))
		{
			echo 'Час начала занятия '.$startTimeHour.' должен быть в диапазоне от 0 до 23 включительно<br>';
			echo $rowNumberReport;
			echo $backUrl;
			die("Ошибка");
		}
		else
		{
			if (preg_match($nonDigitPattern,$startTimeMinutes)>0 or ($startTimeMinutes>59) or ($startTimeMinutes<0))
			{
				echo 'Минуты начала занятия '.$startTimeMinutes.' должны быть в диапазоне от 0 до 59 включительно<br>';
				echo $rowNumberReport;
				echo $backUrl;
				die("Ошибка");
			}
		}

		$startTimeToWrite=implode(":",$startTimeDetailed);
		//echo $startTimeToWrite."<br>";

		//$endTime=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($endTimeColumnNumber, $rowNumber)->getValue());
		$endTime=$sheet->getCellByColumnAndRow($endTimeColumnNumber, $rowNumber)->getValue();

		$endTimeDetailed=explode("_",$endTime);

		if (count($endTimeDetailed)!=2)
		{
			echo 'Время конца занятия '.$endTime.' должно быть записано в формате ЧЧ_ММ<br>';
			echo $rowNumberReport;
			echo $backUrl;
			die("Ошибка");
		}

		$endTimeHour=$endTimeDetailed[0];
		$endTimeMinutes=$endTimeDetailed[1];

		if (preg_match($nonDigitPattern,$endTimeHour)>0 or ($endTimeHour>23) or ($endTimeHour<0))
		{
			echo 'Час конца занятия '.$endTimeHour.' должен быть в диапазоне от 0 до 23 включительно<br>';
			echo $rowNumberReport;
			echo $backUrl;
			die("Ошибка");
		}
		else
		{
			if (preg_match($nonDigitPattern,$endTimeMinutes)>0 or ($endTimeMinutes>59) or ($endTimeMinutes<0))
			{
				echo 'Минуты конца занятия '.$endTimeMinutes.' должен быть в диапазоне от 0 до 59 включительно <br>';
				echo $rowNumberReport;
			}
		}

		$endTimeToWrite=implode(":",$endTimeDetailed);
		//echo $endTimeToWrite."<br>";

		if($endTimeToWrite<=$startTimeToWrite)
		{
			echo 'Время конца занятия должно быть больше времени начала занятия';
			echo $rowNumberReport;
			echo $backUrl;
			die("Ошибка");
		}

		$notes=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($otherColumnNumber, $rowNumber)->getValue());
		//$notes=$sheet->getCellByColumnAndRow($otherColumnNumber, $rowNumber)->getValue();

		//echo $notes.'<br>';

		$state=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($stateColumnNumber, $rowNumber)->getValue());
		$room=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($roomColumnNumber, $rowNumber)->getValue());
		
		//$stmt=$pdo->prepare("SELECT COUNT(*) FROM magistracy_exam_timetable WHERE magistracy_exam_date=? AND magistracy_exam_start_time=? AND magistracy_exam_end_time=?");
		//$stmt->execute(array($dateToWrite,$startTimeToWrite,$endTimeToWrite));
		//$row=$stmt->fetch(PDO::FETCH_LAZY);
		//if ($row['COUNT(*)']<=0)
		//{
			$stmt=$pdo->prepare("INSERT INTO magistracy_exam_timetable SET magistracy_exam_date=?, magistracy_exam_start_time=?, magistracy_exam_end_time=?, magistracy_exam_notes=?, magistracy_exam_room=?, is_cancelled=?");
			$stmt->execute(array($dateToWrite,$startTimeToWrite,$endTimeToWrite,$notes,$room,0));
		//}
	}

	/*
	
	$timetable=array();
  $stmt=$pdo->prepare("SELECT * FROM magistracy_exam_timetable ORDER BY magistracy_exam_date ASC, magistracy_exam_start_time ASC");
  $stmt->execute();

  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {

    $startTimestamp=strtotime($row['magistracy_exam_start_time']." ".$row['magistracy_exam_date']);
    $endTimestamp=strtotime($row['magistracy_exam_end_time']." ".$row['magistracy_exam_date']);
    $weekday="";
    switch (date("N",$startTimestamp))
    {
      case 1: $weekday="Понедельник";break;
      case 2: $weekday="Вторник";break;
      case 3: $weekday="Среда";break;
      case 4: $weekday="Четверг";break;
      case 5: $weekday="Пятница";break;
      case 6: $weekday="Суббота";break;
      case 7: $weekday="Воскресенье";break;

      default:
        $weekday="Проверьте день недели";
        break;
    }

    $shouldDisplay=1;

    $status="Ожидается";
    if ($time<$startTimestamp)
    {
      $status="Ожидается";
    }
    else
    {
      if (($time>=$startTimestamp) and ($time<=$endTimestamp))
      {
        $status="В процессе";
      }
      else
      {
        if ($time<=3600+$endTimestamp)
        {
          $status="Завершена ".floor(($time-$endTimestamp)/60)." минут (минуты) назад";
        }
        else
        {
          $status="Завершена";
          $shouldDisplay=0;
        }
      }
    }

    if ($row['is_cancelled']>0)
    {
      $status="Отменено";
    }


    if ($shouldDisplay>0)
    {

      $reversedDate=implode("-",array_reverse(explode("-",($row['magistracy_exam_date']))));
      $timetable['lessons'][]=
        array
        (
          'event'=>(string)$row['event'],
          'id'=>$row['magistracy_exam_id'],
          'date'=>$reversedDate,
          'weekday'=>$weekday,
          'start_time'=>$row['magistracy_exam_start_time'],
          'end_time'=>$row['magistracy_exam_end_time'],
          'notes'=>iconv("cp1251","utf8",$row['notes']),
          'is_cancelled'=>$status
        );
    }


  }

  include("./php/disconnect.php");
  $JsonInfo=json_encode($timetable);

  $myfile = fopen("./php/timetable.json", "w");
	fwrite($myfile,$JsonInfo);
	fclose($myfile);
*/

	echo 'Загрузка прошла успешно<br>';
	echo '<a href="loadMagisterExamTimetable.php">Загрузить ещё расписание</a><br>';
?>
