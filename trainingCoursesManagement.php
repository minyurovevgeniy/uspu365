<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<link type="text/css" rel="stylesheet" href="./css/trainingCourses.css">
		<title>Образовательные программы</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/trainingCoursesManagement.js"></script>
	</head>
	<body>
		<div id="header"><?php include("./header.php");?></div>
		<div id="content">
			<h1>Образовательные программы</h1>
			<iframe src="./loadBachelorTrainingCourses.php"></iframe>

			<div id="courses">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
				</table>
				<input type="button" id="refreshCourses" value="Обновить список курсов">
				<input type="button" value="Удалить все курсы" id="deleteAllCourses">
				<div id="courses-header">

					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Вид/Название курса</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Предмет</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Кол-во учебных часов</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Учебный период</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Дни недели</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Начало</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Конец</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Цена</div>
						<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Действия</div>
					</div>
				</div>
				<div id="courses-list"></div>
			</div>

		</div>
		<div id="footer"></div>
	</body>
</html>
