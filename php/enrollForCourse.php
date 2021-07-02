<?php
  // Зачисление на подготовительный курс
  session_start();
  if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  /*
	if ($_POST['password']!="GugGuknRuFMPelJ")
	{
		die("Неверный пароль");
	}
	*/
  date_default_timezone_set('Asia/Yekaterinburg');
  include("./connect.php");


  $requestId=$_POST['id'];
	if ($requestId<1)
	{
		die("OK");
	}


  //$requestIdInfo=array(15);
  $requestIdInfo=array($requestId);

  // check if request exists
  $stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_requests WHERE application_id=?");
  $stmt->execute($requestIdInfo);
  $row=$stmt->fetch(PDO::FETCH_LAZY);

  if (!isset($row)) { die("OK"); }

  $name=$row['applicant_name'];
  $email=$row['applicant_email'];
  $trainingCourseToApply=$row['training_course_to_apply'];
  $applicationTime=$row['application_time'];

  $studentInfo=array($name,$email);

  // check if current student exists
  $stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_training_courses_students WHERE bachelor_course_student_email=?");
  $stmt->execute(array($email));
  $row=$stmt->fetch(PDO::FETCH_LAZY);
  if ($row['COUNT(*)']<1)
  {
    $stmt=$pdo->prepare("INSERT INTO bachelor_training_courses_students SET bachelor_course_student_name=?, bachelor_course_student_email=?");
    $stmt->execute($studentInfo);
  }

  // find id of current student
  $stmt=$pdo->prepare("SELECT bachelor_course_student_id FROM bachelor_training_courses_students WHERE bachelor_course_student_email=?");
  $stmt->execute(array($email));
  $row=$stmt->fetch(PDO::FETCH_LAZY);
  $studentId=$row['bachelor_course_student_id'];
  if ($studentId>0)
  {
    $stmt=$pdo->prepare("SELECT bachelor_training_course_connection FROM bachelor_training_course_connections WHERE bachelor_training_course=? AND training_student=?");
    $stmt->execute(array($trainingCourseToApply,$studentId));
    $row=$stmt->fetch(PDO::FETCH_LAZY);
    $courseConnectionId=$row['bachelor_training_course_connection'];

    if ($courseConnectionId<1)
    {
      // insert connection of student and training course
      $stmt=$pdo->prepare("INSERT INTO bachelor_training_course_connections SET bachelor_training_course=?, training_student=?, enrollment_time=?");
      $stmt->execute(array($trainingCourseToApply,$studentId,time()));
    }
  }


  $stmt=$pdo->prepare("DELETE FROM bachelor_training_courses_requests WHERE application_id=?");
  $stmt->execute($requestIdInfo);

  echo json_encode(array("response"=>"OK"));

	include("./disconnect.php");
?>
