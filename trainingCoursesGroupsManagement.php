<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="./css/common.css">
		<link type="text/css" rel="stylesheet" href="./css/trainingCourses.css">
		<title>Слушатели подготовительных курсов</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/trainingCoursesGroupsManagement.js"></script>
	</head>
	<body>
		<div id="header"><?php include("./header.php");?></div>
		<div id="content">
			<h1>Группы подготовительных курсов</h1>

			<div id="studentGroups">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
				</table>
				<div class="row">
					<div class="col-sm-6 col-md-6 col-sm-6 col-xs-6"><select id="course-to-choose"></select></div>
					<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2"><input type="text" id="applicant-name" placeholder="Имя"></div>
					<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2"><input type="text" id="applicant-email" placeholder="Электронная почта"></div>
					<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="button" id="add-student" value="Добавить слушателя"></div>
				</div>
				<input type="button" id="refreshTrainingCourseStudents" value="Обновить список слушателей">
				<input type="button" value="Удалить всех слушателей" id="deleteAllTrainingCourseStudents">
				<div id="studentGroups-header">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">№</div>
            <div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name">Имя</div>
            <div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 email">Электронная почта</div>
            <div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 time">Время зачисления</div>
            <div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Действия</div>
					</div>
				</div>
				<div id="studentGroups-list"></div>
			</div>
		</div>
		<div id="footer"></div>
	</body>
</html>
