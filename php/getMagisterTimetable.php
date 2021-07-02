<?php
  include("./connect.php");

  header("Content-Type: text/html; charset=utf-8");
  date_default_timezone_set('Asia/Yekaterinburg');

  $status="";

  $timetable=array();

  $stmt=$pdo->prepare("SELECT * FROM magistracy_exam_timetable ORDER BY magistracy_exam_date ASC, magistracy_exam_start_time ASC");
  $stmt->execute();

  $time=time();
  //$time=1505221200;
  //$time=1505304000+3600+3600+3599;
  //$time=1505221200-3600;//+3600+3600+3599;
  //$time=1505221200+3600+3600+3600+3599+1+1;
  //echo 'Сейчас: '.date("H:i:s Y-m-d",$time).'<br><br>';

  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {
    $startTimestamp=strtotime($row['magistracy_exam_start_time']." ".$row['magistracy_exam_date']);
    //echo $row['magistracy_exam_start_time']." ".$row['magistracy_exam_date'].':'.$startTimestamp.'<br>';
    //echo date("H:i:s Y-m-d",$startTimestamp).'<br><br>';

    $endTimestamp=strtotime($row['magistracy_exam_end_time']." ".$row['magistracy_exam_date']);
    //echo $row['magistracy_exam_end_time']." ".$row['magistracy_exam_date'].':'.$endTimestamp.'<br>';
    //echo date("H:i:s Y-m-d",$endTimestamp).'<br><br>';

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
          $status="Завершена ".floor(($time-$endTimestamp)/60)." минут(-ы) назад";
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
      $timetable['exams'][]=
        array
        (
          'date'=>(string)$reversedDate,
          'weekday'=>(string)$weekday,
          'start_time'=>(string)$row['magistracy_exam_start_time'],
          'end_time'=>(string)$row['magistracy_exam_end_time'],
          'room'=>(string)iconv("cp1251","utf8",$row['magistracy_exam_room']),
          'notes'=>(string)iconv("cp1251","utf8",$row['magistracy_exam_notes']),
          'is_cancelled'=>(string)$status
        );
    }
  }
  include("./disconnect.php");

  /*
  echo '<pre>';
  print_r($timetable);
  echo '</pre>';
  */
  echo json_encode($timetable);
?>
