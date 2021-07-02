<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<link type="text/css" rel="stylesheet"  href="./css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet"  href="./css/common.css">
		<link type="text/css" rel="stylesheet"  href="./css/trainingCourses.css">
		<title>Заявки на подготовительные курсы</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/trainingCoursesRequestsManagement.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="header"><?php include('./header.php'); ?></div>
			<div id="content">
				<h1>Заявки на подготовительные курсы</h1>
				<div id="coursesRequests">
					<table>
						<tr><td>Пароль для зачисления</td><td><input type="password" id="enrollment_password"></td></tr>
						<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
					</table>
					<input type="button" value="Обновить список заявок" id="refreshCoursesRequests">
					<input type="button" value="Удалить все заявки" id="deleteAllCoursesRequests">
					<div id="coursesRequests-header">
						<div class="row">
							<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№ заявки</div>
							<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Заявленный курс</div>
							<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Время подачи заявки</div>
							<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Имя</div>
							<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Электронная почта</div>
							<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Действия</div>
						</div>
					</div>
					<div id="coursesRequests-list"></div>
				</div>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>
