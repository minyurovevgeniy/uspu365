<?php
		session_start();
		if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

		/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
		{
			die("Неверный пароль");
		}*/
		date_default_timezone_set('Asia/Yekaterinburg');
		include("./connect.php");

    /*
    $courseId=$_GET['id'];
    $applicantName=$_GET['name'];
    $applicantEmail=$_GET['email'];
    */


    $courseId=$_POST['id'];
    $applicantName=iconv("utf-8","cp1251",$_POST['name']);
    $applicantEmail=iconv("utf-8","cp1251",mb_strtolower($_POST['email']));


    $studentInfo=array($applicantName,$applicantEmail);

    $stmt=$pdo->prepare("SELECT bachelor_course_student_id FROM bachelor_training_courses_students WHERE bachelor_course_student_email=?");
    $stmt->execute(array($applicantEmail));
    $row=$stmt->fetch(PDO::FETCH_LAZY);

    if ($row['bachelor_course_student_id']<1)
    {
      $stmt=$pdo->prepare("INSERT INTO bachelor_training_courses_students SET bachelor_course_student_name=?, bachelor_course_student_email=?");
      $stmt->execute($studentInfo);
    }

    $stmt=$pdo->prepare("SELECT bachelor_course_student_id FROM bachelor_training_courses_students WHERE bachelor_course_student_email=?");
    $stmt->execute(array($applicantEmail));
    $row=$stmt->fetch(PDO::FETCH_LAZY);
    $studentId=$row['bachelor_course_student_id'];

    $stmt=$pdo->prepare("SELECT bachelor_training_course_connection FROM bachelor_training_course_connections WHERE bachelor_training_course=? AND training_student=?");
    $stmt->execute(array($courseId,$studentId));
    $row=$stmt->fetch(PDO::FETCH_LAZY);
    $connectionId=$row['bachelor_training_course_connection'];

    if ($connectionId<1)
    {
      $stmt=$pdo->prepare("INSERT INTO bachelor_training_course_connections SET bachelor_training_course=?, training_student=?, enrollment_time=?");
      $stmt->execute(array($courseId,$studentId,time()));
    }

    echo json_encode(array("ok"=>"ok"));

		include("./disconnect.php");
  ?>
