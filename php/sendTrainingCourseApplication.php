<?php

	include("./connect.php");
	
	$name=iconv("utf-8","cp1251",$_GET['name']);
	$surname=iconv("utf-8","cp1251",$_GET['surname']);
	$patronymic=iconv("utf-8","cp1251",$_GET['patronymic']);
	$email=iconv("utf-8","cp1251",$_GET['email']);
	$courseId=iconv("utf-8","cp1251",$_GET['id']);
	
	// find student in table
	$stmt=$pdo->prepare("SELECT bachelor_training_courses_applications_id FROM bachelor_training_courses_applications
						WHERE bachelor_applicant_name=? AND bachelor_applicant_surname=? AND bachelor_applicant_patronymic=?
						AND bachelor_applicant_email=? AND bachelor_training_course_to_apply=?");
	$stmt->execute(array($name,$surname,$patronymic,$email,$courseId));
	$applicationId=$stmt->fetch(PDO::FETCH_LAZY);
	if ($applicationId<1)
	{
		$stmt=$pdo->prepare("INSERT INTO bachelor_training_courses_applications
						SET bachelor_applicant_name=?, bachelor_applicant_surname=?, bachelor_applicant_patronymic=?,
						bachelor_applicant_email=?, bachelor_training_course_to_apply=?");
	$stmt->execute(array($name,$surname,$patronymic,$email,$courseId));
	}
	
	include("./disconnect.php");

?>