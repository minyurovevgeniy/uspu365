<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<title>Загрузка рейтинга в магистратуре</title>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/ratingManagementMagister.js"></script>
	</head>
	<body>
		<div id="header">
		<?php include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Загрузка рейтинга в магистратуре</h1>
			<iframe style="height:auto;" src="./loadMagisterRatingMass.php"></iframe>
			<table>
				<tr>
					<td>Пароль для удаления</td>
					<td><input type="password" id="delete_password"></td>
					<td><input type="button" id="deleteMagisterRating" value="Удалить весь рейтинг магистратуры"></td>
				</tr>
				<tr>
					<td>Номер направления</td><td><input type="text" id="profileId"></td>
					<td><input type="button" id="deleteOneMagisterRating" value="Удалить рейтинг для заданного направления магистратуры"></td>
				</tr>
			</table>
		<div id="footer">
		</div>
	</body>
</html>
