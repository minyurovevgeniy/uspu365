<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  date_default_timezone_set('Asia/Yekaterinburg');
	require_once("./connect.php");

	include("./loadData.php");

	$trainingCoursesDescription=array();
	$stmt=$pdo->prepare("SELECT bachelor_training_course_name, bachelor_training_course_id, bachelor_training_subject, bachelor_training_week_days, bachelor_training_period FROM bachelor_training_courses_description");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$trainingCoursesDescription[$row['bachelor_training_course_id']]=iconv("cp1251","utf-8",$row['bachelor_training_course_name']." (".$row['bachelor_training_subject']." ".$row['bachelor_training_week_days']." ".$row['bachelor_training_period'].")");
	}

	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_course_connections");
	$stmt->execute();

  $coursesConnection=array();
  $response=array();
  while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$coursesConnection[$row['bachelor_training_course']][$row['training_student']]=date("H:i:s d.m.Y",$row['enrollment_time']);
	}

  //ksort($coursesConnection);
	/*
  echo '<pre>';
  print_r($coursesConnection);
  echo '</pre>';
	*/
  $students=array();
  $stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_students ORDER BY bachelor_course_student_name ASC");
  $stmt->execute();
  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {
    $students[$row['bachelor_course_student_id']]=
    array
    (
      "id"=>$row['bachelor_course_student_id'],
      "name"=>iconv("cp1251","utf-8", $row['bachelor_course_student_name']),
      "email"=>$row['bachelor_course_student_email']
    );
  }

	/*
	echo '<pre>';
  print_r($students);
  echo '</pre>';
	*/

  $coursesStudents=array();
  foreach ($coursesConnection as $courseId => $connectionInfo)
  {
    foreach ($connectionInfo as $student => $enrollmentTime)
    {
      $coursesStudents[]=
      array
      (
				"course_id"=>$courseId,
				"course_name"=>$trainingCoursesDescription[$courseId],
				"student_id"=>$student,
				"id"=>$students[$student]['id'],
        "name"=>$students[$student]['name'],
        "email"=>$students[$student]['email'],
        "enrollment_time"=>$enrollmentTime
      );
    }
  }

  /*
	echo '<pre>';
  print_r($coursesStudents);
  echo '</pre>';
	*/

  echo json_encode(array("students"=>$coursesStudents));
	require_once("./disconnect.php");
?>
