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
		<?php//<script type="text/javascript" src="./js/loadBachelorRatingMass.js"></script>?>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form action="./loadBachelorRatingMass_result.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Файл для загрузки</td><td><input type="file" name="rating_list"></td>
					</tr>
					<tr>
						<td>Пароль для ввода</td><td><input type="password" name="input_password"></td>
					</tr>
					<tr>
						<td>Номер листа</td><td><input type="text" value="1" name="worksheet_number"></td>
					</tr>
				</table>
				<input type="submit" value="Загрузить" id="upload-files">
			</form>
		</div>
		<div id="footer"></div>
	</body>
</html>
