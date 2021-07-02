<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<?//<script type="text/javascript" src="./js/loadRating.js"></script>?>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form action="./loadMagisterRatingMass_result.php" method="post" enctype="multipart/form-data">
				<br>
				<table>
					<tr>
						<td>Файл для загрузки</td><td><input type="file" name="rating_list"></td>
					</tr>
					<tr>
						<td>Пароль для ввода</td><td><input type="password" name="input_password"></td>
					</tr>
					<tr>
						<td>Номер листа</td><td><input value="1" type="text" name="worksheet_number"></td>
					</tr>
				</table>
				<input type="submit" value="Загрузить" id="upload-files">
			</form>
		</div>
		<div id="footer"></div>
	</body>
</html>
