<?php
	function deleteUnnecessarySpacesFromString($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean the end
		$cleanString=preg_replace("/\s{1,}$/i",'',$cleanString);
		// clean middle spaces
		$cleanString=preg_replace("/\s{2,}/i",' ',$cleanString);
		// clean the beginning
		$cleanString=preg_replace("/^\s{1,}/i",'',$cleanString);

		return $cleanString;
	}

	function deleteAllSpacesFromString($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean the whole line
		$cleanString=preg_replace("/\s{1,}/i",'',$cleanString);

		return $cleanString;
	}

	function deleteSpacesFromProfileName($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean before dot
		$cleanString=preg_replace("/\s{1,}\./",'.',$cleanString);
    // clean after dot
		$cleanString=preg_replace("/\.\s{1,}/i",'. ',$cleanString);
		// clean the beginning
		$cleanString=preg_replace("/^\s{1,}/i",'',$cleanString);
		return $cleanString;
	}

	/* load profiles*/
	$bachelorProfileNameById=array();
	$bachelorProfileIdByName=array();
	
	$bachelorProfileIdByFullName=array();

	$bachelorProfileCodeById=array();
	$bachelorProfileCodeIdByCode=array();

	$stmt=$pdo->prepare("SELECT * FROM bachelor_profile_description");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$bachelorProfileNameById[$row['profile_description_id']]=$row['profile_name'];
		$bachelorProfileIdByName[$row['profile_name']]=$row['profile_description_id'];

		$bachelorProfileCodeById[$row['profile_description_id']]=$row['profile_code'];
		$bachelorProfileCodeIdByCode[$row['profile_code']]=$row['profile_description_id'];
		
		$bachelorProfileIdByFullName[$row['profile_code']." ".$row['profile_name']]=$row['profile_description_id'];
	}

	$magisterProfileNameById=array();
	$magisterProfileIdByName=array();

	$magisterProfileCodeById=array();
	$magisterProfileCodeIdByCode=array();

	$magisterProfileIdByFullName=array();
	$stmt=$pdo->prepare("SELECT * FROM magistracy_profile_description");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$magisterProfileNameById[$row['profile_description_id']]=$row['profile_name'];
		$magisterProfileIdByName[$row['profile_name']]=$row['profile_description_id'];

		$magisterProfileCodeById[$row['profile_description_id']]=$row['profile_code'];
		$magisterProfileCodeIdByCode[$row['profile_code']]=$row['profile_description_id'];
		
		$magisterProfileIdByFullName[$row['profile_code']." ".$row['profile_name']]=$row['profile_description_id'];
	}

	/* load faculties*/
	$facultyNameById=array();
	$facultyIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM faculties");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$facultyNameById[$row['faculty_id']]=$row['faculty_name'];
		$facultyIdByName[$row['faculty_name']]=$row['faculty_id'];
	}

	/* load budget*/
	$budgetNameById=array();
	$budgetIdByName=array();
	$budgetIdByAbbr=array();
	$budgetIdByInput=array();
	$stmt=$pdo->prepare("SELECT * FROM budgets");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$budgetNameById[$row['budget_id']]=$row['budget_name'];
		$budgetIdByName[$row['budget_name']]=$row['budget_id'];
		$budgetIdByAbbr[$row['budget_abbreviation']]=$row['budget_id'];
		$budgetIdByInput[$row['budget_input']]=$row['budget_id'];
	}

	/* load form*/
	$formNameById=array();
	$formIdByName=array();
	$formIdByAbbr=array();
	$formIdByInput=array();
	$stmt=$pdo->prepare("SELECT * FROM forms");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$formNameById[$row['form_id']]=$row['form_name'];
		$formIdByName[$row['form_name']]=$row['form_id'];
		$formIdByAbbr[$row['form_abbreviation']]=$row['form_id'];
		$formIdByInput[$row['form_input']]=$row['form_id'];
		
	}

	/* load special*/
	$specialNameById=array();
	$specialIdByName=array();
	$specialIdByInput=array();
	$specialAbbrById=array();
	$stmt=$pdo->prepare("SELECT * FROM specials");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$specialNameById[$row['special_id']]=$row['special_name'];
		$specialIdByName[$row['special_name']]=$row['special_id'];
		$specialIdByInput[$row['special_input']]=$row['special_id'];
		$specialAbbrById[$row['special_id']]=$row['special_abbreviation'];
	}

	/* load diploma type*/
	$diplomaNameById=array();
	$diplomaIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM diplomas");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$diplomaNameById[$row['diploma_type_id']]=$row['diploma_type_name'];
		$diplomaIdByName[$row['diploma_type_name']]=$row['diploma_type_id'];
	}

	/* load ege*/
	$egeNameById=array();
	$egeIdByName=array();

	$egeAbbrById=array();
	$egeIdByAbbr=array();

	$egeMinById=array();
	$egeIdByMin=array();
	$stmt=$pdo->prepare("SELECT * FROM ege_exams");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$egeNameById[$row['ege_id']]=$row['ege_name'];
		$egeIdByName[$row['ege_name']]=$row['ege_id'];

		$egeAbbrById[$row['ege_id']]=$row['ege_abbr'];
		$egeIdByAbbr[$row['ege_abbr']]=$row['ege_id'];

		$egeMinById[$row['ege_id']]=$row['ege_min'];
	}
?>
