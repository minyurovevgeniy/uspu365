<?php
		session_start();
		if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

		/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
		{
			die("Неверный пароль");
		}*/
		date_default_timezone_set('Asia/Yekaterinburg');
		include("./connect.php");

    $stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_students ORDER BY bachelor_course_student_name ASC");
    $stmt->execute();

    $response=array();
    while($row=$stmt->fetch(PDO::FETCH_LAZY))
    {
      $response['students'][]=
      array
      (
        "id"=>$row['bachelor_course_student_id'],
        "name"=>iconv("cp1251","utf-8",$row['bachelor_course_student_name']),
        "email"=>iconv("cp1251","utf-8",$row['bachelor_course_student_email'])
      );
    }

    echo json_encode($response);

		include("./disconnect.php");
  ?>
