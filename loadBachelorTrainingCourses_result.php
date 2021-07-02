<?php
	include("./php/connect.php");
	header("Content-Type: text/html; charset=utf8");
	require_once './php/PHPExcel/Classes/PHPExcel.php';

	include("./php/loadData.php");

	$fileName=$_FILES['courses']['tmp_name'];
	$objPHPExcel = PHPExcel_IOFactory::load($fileName);


	$worksheet=$_POST['worksheet_number']-1;

	$trainingCourseNameColumn=$_POST['training_course_name_column']-1;
	$subjectNameColumn=$_POST['subject_name_column']-1;
	$trainingTotalTimeColumn=$_POST['training_total_time_column']-1;
	$trainingPeriodColumn=$_POST['training_period_column']-1;
	$trainingWeekDaysColumn=$_POST['training_week_days_column']-1;
	$trainingStartTimeColumn=$_POST['training_start_time_column']-1;
	$trainingEndTimeColumn=$_POST['training_end_time_column']-1;
	$trainingPriceColumn=$_POST['training_price_column']-1;

	$MIN_ROW=$_POST['min_row'];
	$MAX_ROW=$_POST['max_row'];

	$shouldEmpty=$_POST['shouldEmpty'];

	if (strtolower($shouldEmpty)=="да")
	{
		$stmt=$pdo->prepare("TRUNCATE TABLE bachelor_training_courses_description");
		$stmt->execute();
	}


	// load (!!!) BACHELOR (!!!) training courses
	$sheet=$objPHPExcel->getSheet($worksheet);
	for($rowNumber=$MIN_ROW;$rowNumber<=$MAX_ROW;$rowNumber++)
	{
		$trainingCourseName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingCourseNameColumn, $rowNumber)->getValue());
		$subjectName=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($subjectNameColumn, $rowNumber)->getValue());
		$trainingTotalTime=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingTotalTimeColumn, $rowNumber)->getValue());
		$trainingPeriod=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingPeriodColumn, $rowNumber)->getValue());
		$trainingWeekDays=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingWeekDaysColumn, $rowNumber)->getValue());
		$trainingStartTime=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingStartTimeColumn, $rowNumber)->getValue());
		$trainingEndTime=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingEndTimeColumn, $rowNumber)->getValue());
		$trainingPrice=iconv("utf-8","cp1251",$sheet->getCellByColumnAndRow($trainingPriceColumn, $rowNumber)->getValue());

		$trainingCourseName=deleteUnnecessarySpacesFromString($trainingCourseName);
		$subjectName=deleteUnnecessarySpacesFromString($subjectName);
		$trainingPeriod=deleteUnnecessarySpacesFromString($trainingPeriod);
		$trainingWeekDays=deleteUnnecessarySpacesFromString($trainingWeekDays);
		$trainingPrice=deleteUnnecessarySpacesFromString($trainingPrice);

		$trainingStartTime=deleteAllSpacesFromString($trainingStartTime);
		$trainingEndTime=deleteAllSpacesFromString($trainingEndTime);

		$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description WHERE bachelor_training_course_name=? AND bachelor_training_subject=? AND bachelor_training_total_time=? AND bachelor_training_period=? AND bachelor_training_week_days=? AND bachelor_training_start_time=? AND bachelor_training_end_time=? AND bachelor_training_price=?");

		$stmt->execute(array($trainingCourseName,$subjectName,$trainingTotalTime,$trainingPeriod,$trainingWeekDays,$trainingStartTime,$trainingEndTime,$trainingPrice));
		$bachelorTrainingCourseDescription=$stmt->fetch(PDO::FETCH_LAZY);

		$bachelorTrainingCourseDescriptionId=$bachelorTrainingCourseDescription['bachelor_training_course_id'];

		if($bachelorTrainingCourseDescriptionId<1)
		{
			$stmt=$pdo->prepare("INSERT INTO bachelor_training_courses_description SET bachelor_training_course_name=?, bachelor_training_subject=?,  bachelor_training_total_time=?, bachelor_training_period=?, bachelor_training_week_days=?, bachelor_training_start_time=?, bachelor_training_end_time=?, bachelor_training_price=?");
			$stmt->execute(array($trainingCourseName,$subjectName,$trainingTotalTime,$trainingPeriod,$trainingWeekDays,$trainingStartTime,$trainingEndTime,$trainingPrice));
		}
	}

	$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_description");
	$stmt->execute();
	$response=array();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$response['courses'][]=array
		(
			"id"=>iconv("cp1251","utf-8",$row['bachelor_training_course_id']),
			"name"=>iconv("cp1251","utf-8",$row['bachelor_training_course_name']),
			"subject"=>iconv("cp1251","utf-8",$row['bachelor_training_subject']),
			"total_time"=>iconv("cp1251","utf-8",$row['bachelor_training_total_time']),
			"period"=>iconv("cp1251","utf-8",$row['bachelor_training_period']),
			"week_days"=>iconv("cp1251","utf-8",$row['bachelor_training_week_days']),
			"start_time"=>iconv("cp1251","utf-8",$row['bachelor_training_start_time']),
			"end_time"=>iconv("cp1251","utf-8",$row['bachelor_training_end_time']),
			"price"=>iconv("cp1251","utf-8",$row['bachelor_training_price'])
		);
	}
	//echo json_encode($response);

	$myfile = fopen("./php/announcements_bachelor_training_courses.json", "w");
	fwrite($myfile,json_encode($response));
	fclose($myfile);

	include("./php/disconnect.php");

	echo '<a href="./loadBachelorTrainingCourses.php">Загрузить ещё</a>'
?>
