<?php
		session_start();
		if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

		/*if ($_POST['password']!="oGKGGn5AxbgEy8Y")
		{
			die("Неверный пароль");
		}*/
		date_default_timezone_set('Asia/Yekaterinburg');
		include("./connect.php");

    $response=array();

		$stmt=$pdo->prepare("SELECT bachelor_training_course_id, bachelor_training_course_name, bachelor_training_subject, bachelor_training_period, bachelor_training_week_days FROM bachelor_training_courses_description ORDER BY bachelor_training_course_name ASC, bachelor_training_subject ASC, bachelor_training_period ASC, bachelor_training_week_days ASC");
		$stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_LAZY))
		{
			$response["courses_list"][]=
      array
      (
        "id"=>$row['bachelor_training_course_id'],
        "name"=>iconv("cp1251","utf-8","(".$row['bachelor_training_course_id'].") ".$row['bachelor_training_course_name']." (".$row['bachelor_training_subject']." ".$row['bachelor_training_period']." ".$row['bachelor_training_week_days'].")")
      );
		}

    include("./disconnect.php");
		echo json_encode($response);
?>
