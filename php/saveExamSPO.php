<?php
  session_start();
  if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  header("Content-Type: text/json; charset=utf-8");
  date_default_timezone_set('Asia/Yekaterinburg');

  /*
  if ($_POST['password']!="4mgQC464hq3CvH1")
  {
    die("Неверный пароль");
  }
  */
  $time=time();

  include("./connect.php");

  $exam=$_POST['exam'];
  $date=implode("-",array_reverse(explode("-",$_POST['date'])));
  $start_time=$_POST['start_time'];
  $end_time=(string)$_POST['end_time'];
  $is_cancelled=$_POST['is_cancelled'];
  $room=iconv("utf-8","cp1251",$_POST['room']);
  $notes=iconv("utf-8","cp1251",$_POST['notes']);

  $unixTimestamp = strtotime($date);
  $weekdayNumber= date("N", $unixTimestamp);

  $stmt=$pdo->prepare("UPDATE spo_exam_timetable SET spo_exam_date=?, spo_exam_start_time=?, spo_exam_end_time=?, is_cancelled=?, spo_exam_notes=?, spo_exam_room=? WHERE spo_exam_id=?");
  $stmt->execute(array($date,$start_time,$end_time,$is_cancelled,$notes,$room,$exam));

  include("./disconnect.php");
  echo json_encode(array('status'=>'Экзамен изменён'));
?>
