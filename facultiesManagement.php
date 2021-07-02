<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<title>Учебные подразделения</title>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<link rel="stylesheet" href="./css/faculties.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/facultiesManagement.js"></script>
	</head>
	<body>
		<div id="header"><?php include("./header.php"); ?></div>
		<div id="content">
			<h1>Учебные подразделения</h1>

			<iframe src="./loadFaculties.php"></iframe>

			<div id="faculties">
				<table>
					<tr><td>Пароль для изменения</td><td><input type="password" id="save_password"></td></tr>
					<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
					<tr><td>Ручное обновление</td><td><input type="checkbox" id="manual_mode"></td></tr>
				</table>
				<div id="faculties-header">
					<input type="button" id="refreshFaculties" value="Обновить список учебных подразделений">
					<br>
					<input type="button" id="deleteAllFaculties" value="Удалить все учебные подразделения">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№</div>
						<div class="col-sm-5 col-md-5 col-sm-5 col-xs-5">Название</div>
						<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">Действия</div>
					</div>
				</div>
				<div id="faculties-list"></div>
			</div>
		</div>
		<div id="footer">
		</div>
	</body>
</html>
