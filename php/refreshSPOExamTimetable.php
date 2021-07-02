<?php
  session_start();
  if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  include("./connect.php");

  header("Content-Type: text/html; charset=utf-8");
  date_default_timezone_set('Asia/Yekaterinburg');


  $timetable=array();

  $time=time();

  $stmt=$pdo->prepare("SELECT * FROM spo_exam_timetable ORDER BY spo_exam_date DESC, spo_exam_start_time DESC");
  $stmt->execute();

  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {
    $startTimestamp=strtotime($row['spo_exam_start_time']." ".$row['spo_exam_date']);
    //echo $row['spo_exam_start_time']." ".$row['spo_exam_date'].':'.$startTimestamp.'<br>';
    //echo date("H:i:s Y-m-d",$startTimestamp).'<br><br>';

    $endTimestamp=strtotime($row['spo_exam_end_time']." ".$row['spo_exam_date']);
    //echo $row['spo_exam_end_time']." ".$row['spo_exam_date'].':'.$endTimestamp.'<br>';
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

    if ($row['is_cancelled']>0)
    {
      $cancelled="checked";
    }
    else
    {
      $cancelled="";
    }

    $reversedDate=implode("-",array_reverse(explode("-",($row['spo_exam_date']))));
	
	$startTime=explode(":",(string)$row['spo_exam_start_time']);
	unset($startTime[count($startTime)-1]);
	$endTime=explode(":",$row['spo_exam_end_time']);
	unset($endTime[count($endTime)-1]);
	
    $timetable['exams'][]=
      array
      (
        'id'=>$row['spo_exam_id'],
        'date'=>$reversedDate,
        'weekday'=>$weekday,
        'start_time'=>implode(":",$startTime),
        'end_time'=>implode(":",$endTime),
        'room'=>iconv("cp1251","utf8",$row['spo_exam_room']),
        'notes'=>iconv("cp1251","utf8",$row['spo_exam_notes']),
        'is_cancelled'=>$cancelled
      );
  }


  echo json_encode($timetable);
  /*echo '<pre>';
  print_r($timetable);
  echo '</pre>';
*/
  include("./disconnect.php");
?>
