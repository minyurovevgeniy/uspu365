<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<title>Минимальные баллы ЕГЭ</title>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/common.css">
		<link rel="stylesheet" type="text/css" href="./css/minEGEManagement.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/minEGEManagement.js"></script>
	</head>
	<body>
		<div id="header">
			<?include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Минимальные баллы ЕГЭ</h1>

			<iframe src="./loadEGE.php"></iframe>
			<table>
				<tr><td>Пароль для изменения</td><td><input type="password" id="change_password"></td></tr>
				<tr><td>Пароль для удаления</td><td><input type="password" id="delete_password"></td></tr>
				<tr><td>Ручное обновление</td><td><input type="checkbox" id="manual_mode"></td></tr>
			</table>
			<div id="ege">
				<div id="ege-header">
					<input type="button" id="refreshEGE" value="Обновить список ЕГЭ">
					<div class="row">
						<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">id</div>
						<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Предмет</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Аббревиатура</div>
						<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">Минимальный балл</div>
						<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">Действия</div>
					</div>
				</div>
				<div id="ege-list"></div>
			</div>
		</div>
		<div id="footer"></div>
	</body>
</html>
