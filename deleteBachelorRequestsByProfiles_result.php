<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

	if ($_POST['input_password']!="4mgQC464hq3CvH1") die("Неверный пароль");
	
	include("./php/connect.php");
	date_default_timezone_set('Asia/Yekaterinburg');
	require_once './php/PHPExcel/Classes/PHPExcel.php';
	include("./php/loadData.php");

	/*echo '<pre>'; 	print_r($_POST); 	echo '</pre>';*/
	
	$fileName=$_FILES['profiles_list']['tmp_name'];
	if ($_FILES['profiles_list']['size']<=0)
	{
		die("Файл пустой");
	}
	$objPHPExcel = PHPExcel_IOFactory::load($fileName);
	
	$profileIdColumnNumber=0;
	
	if ($_POST['worksheet_number'][$i]-1<0) die("Укажите номер листа");

	$worksheet=$_POST['worksheet_number']-1;	
	$rowNumber=1;
	
	// load abiturients to database
	$sheet=$objPHPExcel->getSheet($worksheet);
	
	while(true)
	{
		$profileId=$sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue();
		$stmt=$pdo->prepare("DELETE FROM bachelor_requests WHERE profile=?");
		$stmt->execute(array($profileId));
		$rowNumber+=1;
		if ($sheet->getCellByColumnAndRow($profileIdColumnNumber, $rowNumber)->getValue()=="finish") break;
	}
	include("./php/disconnect.php");
?>