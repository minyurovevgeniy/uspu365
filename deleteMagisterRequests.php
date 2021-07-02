<?php
	include("./php/connect.php");
	
	$profilesToRemoveFromRequests=array();
	
	$stmt=$pdo->prepare("SELECT profile_id FROM magistracy_profiles WHERE budget=1");
	$stmt->execute();
	
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$profilesToRemoveFromRequests[]=$row['profile_id'];
	}
	
	foreach($profilesToRemoveFromRequests as $value)
	{
		$stmt=$pdo->prepare("DELETE FROM magistracy_requests WHERE profile=?");
		$stmt->execute(array($value));
	}
	
	include("./php/disconnect.php");
?>