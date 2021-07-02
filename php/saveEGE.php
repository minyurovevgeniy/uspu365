<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	//if ($_POST['password']!="GugGuknRuFMPelJ") die("Неверный пароль");

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	//$egeId=$_GET['id'];
	$egeId=$_POST['id'];
	if ($egeId<1)
	{
		die("ok");
	}

  $name=iconv("utf-8","cp1251",$_POST['name']);
  $abbr=iconv("utf-8","cp1251",$_POST['abbr']);
  $min=$_POST['min'];

	$stmt=$pdo->prepare("UPDATE ege_exams SET ege_name=?, ege_abbr=?, ege_min=? WHERE ege_id=?");
	$stmt->execute(array($name,$abbr,$min,$egeId));

	$stmt=$pdo->prepare("SELECT * FROM ege_exams ORDER BY ege_name ASC");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['ege_exams'][]=
			array
			(
			'id'=>$row['ege_id'],
			'name'=>iconv("cp1251","utf-8",$row['ege_name']),
			'abbr'=>iconv("cp1251","utf-8",$row['ege_abbr']),
			'ege_min'=>$row['ege_min']
			);
	}

  $file=fopen("./minEGE.json","w");
  fwrite($file,json_encode($response));
  fclose($file);

	include("./disconnect.php");

	echo json_encode(array('status'=>'ЕГЭ сохранен'));
?>
