<?php
	session_start();
	date_default_timezone_set('Asia/Yekaterinburg');
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<?//<script type="text/javascript" src="./js/loadBachelorRatingMass.js"></script>?>
	</head>
	<body>
		<div id="header"><?include("./header.php"); ?></div>
		<div id="content">
			<h1>Удаление заявок в бакалавриате</h1>
			<form action="./deleteBachelorRequestsByProfiles_result.php" method="post" enctype="multipart/form-data">
				<br>
				<table>
					<tr>
						<td>Файл для удаления заявок по заданным направлениям</td><td><input type="file" name="profiles_list"></td>
					</tr>
					<tr>
						<td>Пароль для ввода</td><td><input type="password" name="input_password"></td>
					</tr>
					<tr>
						<td>Номер листа</td><td><input type="text" name="worksheet_number"></td>
					</tr>
				</table>
				<input type="submit" value="Загрузить" id="upload-files">
			</form>
		</div>
		<div id="footer"></div>
	</body>
</html>