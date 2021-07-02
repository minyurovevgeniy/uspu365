<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/common.css">
		<link rel="stylesheet" type="text/css" href="./css/profilesManagementBachelor.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/profilesManagementBachelor.js"></script>
	</head>
	<body>
		<div id="header">
			<?include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Программы в бакалавриате</h1>
			<iframe src="./loadBachelorProfilesExtended.php"></iframe>
			<table>
				<tr><td>Пароль для изменения</td><td><input type="password" id="change_password"></td></tr>
				<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
			</table>
			<div id="profiles">
				<div id="profiles-header">
					<input type="button" id="refreshProfiles" value="Обновить список направлений">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">id</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Подразделение</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Профиль</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Форма</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Бюджет</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Категория приёма</div>
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Мест</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Набор ЕГЭ</div>
					</div>
				</div>
				<div id="profiles-list"></div>
			</div>
		</div>
		<div id="footer"></div>
	</body>
</html>
