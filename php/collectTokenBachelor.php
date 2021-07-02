<?php
	$token=iconv("utf8","cp1251",$_POST['token']);
	$instanceId=iconv("utf8","cp1251",$_POST['instanceId']);

	include("./connect.php");

	$stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_tokens WHERE bachelor_token=?");
	$stmt->execute(array($token));
	$row=$stmt->fetch(PDO::FETCH_LAZY);

	if ($row['COUNT(*)']<1)
	{
		$stmt=$pdo->prepare("INSERT INTO bachelor_tokens SET bachelor_token=?, bachelor_instance=?");
		$stmt->execute(array($token,$instanceId));
	}

	$stmt=$pdo->prepare("SELECT COUNT(*) FROM bachelor_tokens");
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_LAZY);

	$maxRows=1000;
	$limit=$row['COUNT(*)']-$maxRows;
	if ($limit>0)
	{
		$stmt=$pdo->prepare("DELETE FROM bachelor_tokens LIMIT ?");
		$stmt->bindValue(1, $limit, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	include("./disconnect.php");
?>