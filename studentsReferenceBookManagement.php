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
		<title>Справочник слушателей</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/studentsReferenceBookManagement.js"></script>
	</head>
	<body>
		<div id="header"><?php include("./header.php");?></div>
		<div id="content">
			<h1>Справочник слушателей</h1>

			<div id="student">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
					<tr><td>Ручное обновление</td><td><input type="checkbox" id="manual_mode"></td></tr>
				</table>
				<input type="button" id="refreshStudents" value="Обновить список слушателей">
				<input type="button" value="Удалить всех слушателей" id="deleteAllStudents">
				<div id="student-header">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">№</div>
            <div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name">Имя</div>
            <div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 email">Электронная почта</div>
            <div class="col-sm-4 col-md-4 col-sm-2 col-xs-2">Действия</div>
					</div>
				</div>
				<div id="student-list"></div>
			</div>
		</div>
		<div id="footer"></div>
	</body>
</html>
