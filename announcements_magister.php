<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<script type="script/javascript" src="./js/jquery.js"></script>
		<script type="script/javascript" src="./js/index.js"></script>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form id="announcements_load_form" action="./announcements_magister_result.php"  method="post">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-3">
						Текст
					</div>
					<div class="col-md-9 col-sm-9 col-xs-9">
						<textarea cols="30" rows="5" name="announcement_text"></textarea>
					</div>
				</div>
				<div class="row">
					<div class=" col-md-12 col-sm-12 col-xs-12">
						<input type="submit" value="Сохранить">
					</div>
				</div>
				<table>
					<tr><td>Пароль для ввода</td><td><input type="password" name="input_password"></td></tr>
				</table>
			</form>
		</div>
		<div id="footer"></div>
	</body>
</html>
