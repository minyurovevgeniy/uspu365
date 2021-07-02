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
		<link type="text/css" rel="stylesheet" href="./css/timetableManagement.css">
		<title>Расписание</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/timetableSPOManagement.js"></script>
	</head>
	<body>
		<div id="header">
		<?include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Расписание вступительных испытаний в бакалавриате</h1>
			<iframe src="./loadSPOexamTimetable.php"></iframe>
			<div id="timetable">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
					<tr><td>Ручное обновление</td><td><input type="checkbox" id="manual_mode"></td></tr>
				</table>
				<div id="timetable-header">
					<input type="button" id="refreshTimetable" value="Обновить список экзаменов">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">№</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Название/Примечания</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 date">Дата</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 start_time">Время начала</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 end_time">Время окончания</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 weekday">День недели</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 room">Аудитория</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 is_cancelled">Отменено</div>
						<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Действия</div>
					</div>
				</div>
				<div id="exams-list">
					<?/*
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">1</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">12.22.22</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">12:23</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">14:34</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">День недели</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Отменено</div>
						<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Для опытных</div>
						<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Сохранить</div>
					</div>*/?>
				</div>
			</div>
		</div>
		<div id="footer">
		</div>
	</body>
</html>
