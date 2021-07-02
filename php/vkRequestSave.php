<?php
	date_default_timezone_set('Asia/Yekaterinburg');
	$request=urlencode($_GET['request']);
	//echo $request.'<br>';
	if (strlen($request)<1)
	{
		die("ok");
	}
	$fileName="./requestString.txt";
	
	$myfile = fopen($fileName, "w");
	fwrite($myfile,$request);
	fclose($myfile);

	echo json_encode(array("request"=>urldecode($request)));
?>