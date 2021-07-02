<?php
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/index.js"></script>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<?/*
		<link rel="stylesheet" href="./css/bootstrap-grid.min.css">		
		<link rel="stylesheet" href="./css/bootstrap-reboot.min.css">
		<link rel="stylesheet" href="./css/common.css">*/?>
		<link rel="stylesheet" href="./css/index.css">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<h1>Здесь можно узнать, сколько оригиналов и копий документов было подано до Вас</h1>
			<div class="btn btn-primary tab-button" data-id="0"><h3>Бакалавриат</h3></div>
			<div class="btn btn-primary tab-button" data-id="1"><h3>Магистратура</h3></div>
			<div class="clear"></div>
			<table class="table table-striped table-condensed table-hover table-responsive">
				<tr>
					<td>Фамилия</td>
					<td><input type="text" id="surname"></td>
				</tr>
				<tr>
					<td>Имя</td>
					<td><input type="text" id="name"></td>
				</tr>
				<tr>
					<td>Отчество</td>
					<td><input type="text" id="patronymic"></td>
				</tr>
				
			</table>
			<input type="button" class="btn-primary btn" id="position" value="Узнать">
			<hr>
			<div id="rating">
				<div class="frame">
					<div class="tab" data-id="0">
						<div class="heading"><h3>Бакалавриат</h3></div>
						<div class="tab-content" data-id="0"  id="bachelor"></div>
					</div>
					<div data-id="1" class="tab">
						<div class="heading"><h3>Магистратура</h3></div>
						<div class="tab-content" data-id="1" id="magister"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div id="footer"></div>
	</body>
</html>