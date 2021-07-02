<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/vkWallManagement.js"></script>
	</head>
	<body>
		<div id="header"><?include("./header.php");?></div>
		<div id="content">
			<h1>Строка запроса к API VK</h1>
			<table style="width:100%;">
				<tr>
					<td>Строка запроса для получения стены из группы ВК "Шпаргалка абитуриента УрГПУ"</td>
				</tr>
				<tr>
					<td><input  type="text" id="request-string"></td>
				</tr>
				<tr>
					<td><input type="button" id="saveRequest" value="Сохранить"></td>
				</tr>
			</table>
		</div>
		<div id="footer">
		</div>
	</body>
</html>