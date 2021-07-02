<?
	/* load education level of abiturient*/
	$inboxEducationNameById=array();
	$inboxEducationIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM inbox_education");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$inboxEducationNameById[$row['inbox_education_id']]=$row['inbox_education_name'];
		$inboxEducationIdByName[$row['inbox_education_name']]=$row['inbox_education_id'];
	}
	
	/* load education level of graduation*/
	$outboxEducationNameById=array();
	$outboxEducationIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM outbox_education");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$outboxEducationNameById[$row['outbox_education_id']]=$row['outbox_education_name'];
		$outboxEducationIdByName[$row['outbox_education_name']]=$row['outbox_education_id'];
	}
	
	/* load profiles*/
	$profileNameById=array();
	$profileIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM profiles");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$profileNameById[$row['profile_id']]=$row['profile_name'];
		$profileIdByName[$row['profile_name']]=$row['profile_id'];
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
	$stmt=$pdo->prepare("SELECT * FROM budgets");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$budgetNameById[$row['budget_id']]=$row['budget_name'];
		$budgetIdByName[$row['budget_name']]=$row['budget_id'];
	}
	
	/* load form*/
	$formNameById=array();
	$formIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM forms");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$formNameById[$row['form_id']]=$row['form_name'];
		$formIdByName[$row['form_name']]=$row['form_id'];
	}
	
	/* load special*/
	$specialNameById=array();
	$specialIdByName=array();
	$stmt=$pdo->prepare("SELECT * FROM specials");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_LAZY))
	{
		$specialNameById[$row['special_id']]=$row['special_name'];
		$specialIdByName[$row['special_name']]=$row['special_id'];
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
?>