<?php
	date_default_timezone_set('Asia/Yekaterinburg');
	/*$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
	$email=iconv("utf-8","cp1251",$_GET['email']);
	$courseId=iconv("utf-8","cp1251",$_GET['id']);*/

	/*$name=iconv("utf-8","cp1251",$_REQUEST['name']);
	$surname=iconv("utf-8","cp1251",$_REQUEST['surname']);
	$patronymic=iconv("utf-8","cp1251",$_REQUEST['patronymic']);
	$email=iconv("utf-8","cp1251",$_REQUEST['email']);
	$courseId=iconv("utf-8","cp1251",$_REQUEST['id']);*/

	/*echo '<br>'.$name;
	echo '<br>'.$surname;
	echo '<br>'.$patronymic;
	echo '<br>'.$email;
	echo '<br>'.$courseId;

	echo '<br><br>'.$_GET['name'];
	echo '<br>'.$_GET['surname'];
	echo '<br>'.$_GET['patronymic'];
	echo '<br>'.$_GET['email'];
	echo '<br>'.$_GET['id'];*/

	$applicantName=iconv("utf8","cp1251",$_POST['name']);
	$email=iconv("utf8","cp1251",mb_strtolower($_POST['email']));
	$courseId=$_POST['courseId'];

	include("./connect.php");

	$stmt=$pdo->prepare("SELECT application_id FROM bachelor_training_courses_requests WHERE applicant_email=? AND training_course_to_apply=?");
	$stmt->execute(array($email,$courseId));
	$applicationId=$stmt->fetch(PDO::FETCH_LAZY);
	if ($applicationId['application_id']<1)
	{
		$stmt=$pdo->prepare("INSERT INTO bachelor_training_courses_requests SET applicant_name=?, applicant_email=?, training_course_to_apply=?, application_time=?");
		$stmt->execute(array($applicantName,$email,$courseId,time()));
	}

	include("./disconnect.php");

	$result=array("info"=>"OK");

	echo json_encode($result);

?>
