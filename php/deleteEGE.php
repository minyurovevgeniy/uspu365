<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	if ($_POST['password']!="GugGuknRuFMPelJ")
	{
		die("Неверный пароль");
	}

	date_default_timezone_set('Asia/Yekaterinburg');
	include("./connect.php");

	$examId=$_POST['id'];
	if ($examId<1)
	{
		die("ok");
	}

	$egeSets=array();

	$stmt=$pdo->prepare("SELECT ege_set_id FROM ege_sets WHERE ege=?");
	$stmt->execute(array($examId));
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$egeSets[]=$row['ege_set_id'];
	}

	foreach ($egeSets as $value)
	{
		$stmt=$pdo->prepare("DELETE FROM bachelor_profiles WHERE ege_set=?");
		$stmt->execute($value);
	}

	$stmt=$pdo->prepare("DELETE FROM ege_sets WHERE ege=?");
	$stmt->execute(array($examId));

	$stmt=$pdo->prepare("DELETE FROM ege_exams WHERE ege_id=?");
	$stmt->execute(array($examId));

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
	echo json_encode($response);

  $file=fopen("./minEGE.json","w+");
  fwrite($file,json_encode($response));
  fclose($file);

	include("./disconnect.php");
?>
