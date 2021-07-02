<?php
	date_default_timezone_set('Asia/Yekaterinburg');
	$fileName="./requestString.txt";
	$fileSize=filesize($fileName);
	/*echo $fileSize.'<br>';
	echo strlen("https://api.vk.com/method/wall.get?owner_id=-144067716&count=10&v=5.52&access_token=fe755b8dfe755b8dfe755b8d8efe298181ffe75fe755b8da73e2208ed32030817df6bcc").'<br>';
	*/
	
	$myfile = fopen($fileName, "r");
	$request=urldecode(fread($myfile,$fileSize));
	fclose($myfile);
	echo json_encode(array("request"=>$request));
?>