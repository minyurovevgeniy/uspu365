<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<title>Объявления СО бакалавриата</title>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<link rel="stylesheet" href="./css/announcements.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/announcementsManagementSchoolBachelor.js"></script>
	</head>
	<body>
		<div id="header">
		<?include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Объявления СО бакалавриата</h1>

			<iframe src="./announcements_school_bachelor.php"></iframe>

			<div id="announcements">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
				</table>
				<input type="button" id="deleteAllAnnouncements" value="Удалить все объявления">
				<div id="announcements-header">
					<input type="button" id="refreshAnnouncements" value="Обновить список объявлений">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-xs-1">№</div>
						<div class="col-sm-3 col-md-3 col-xs-3">Время</div>
						<div class="col-sm-4 col-md-4 col-xs-4">Текст</div>
						<div class="col-sm-4 col-md-4 col-xs-4">Действия</div>
					</div>
				</div>
				<div id="announcements-list"></div>
			</div>
		</div>
		<div id="footer">
		</div>
	</body>
</html>
