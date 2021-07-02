<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	/*
	if ($_POST['password']!="GugGuknRuFMPelJ")
	{
		die("Неверный пароль");
	}
	*/
	include("./connect.php");

	date_default_timezone_set('Asia/Yekaterinburg');

  $id=$_POST['id'];

  $idPair=explode("_",$id);
  foreach ($idPair as $value)
  {
    if (preg_match('/\D/im',$value))
    {
      die("OK!");
    }
    else
    {
      if ($value<1)
      {
        die("OK!!");
      }
    }
  }


  $stmt=$pdo->prepare("DELETE FROM bachelor_training_course_connections WHERE training_student=? AND bachelor_training_course=?");
  $stmt->execute($idPair);

	echo json_encode(array("status"=>"OK"));
	include("./disconnect.php");
?>
