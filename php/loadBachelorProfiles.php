<?php
	//session_start();
	//if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<link rel="stylesheet" type="type/css" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/loadRating.js"></script>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form action="./loadBachelorProfiles_result.php" method="post" enctype="multipart/form-data">
					Загрузите файл типа *.txt с направлениям подготовки размером не более 32 Мб
					<div class="custom-file">
						<span>Загрузить текст</span>
						<input data-file-name="0" type="file" name="profiles">
					</div>
					<input type="submit" value="Загрузить" id="upload-files">
				</form>
				<span id="message"></span>
		</div>
		<div id="footer"></div>
	</body>
</html>