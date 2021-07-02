<?php
	//session_start();
	//if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
?>
<html>
	<head>
		<link rel="stylesheet" type="type/css" href="./css/bootstrap.css">
		<link rel="stylesheet" type="type/css" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/loadRating.js"></script>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form action="./loadBachelorTrainingCourses_result.php" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td>Номер листа</td><td><input type="text" name="worksheet_number"></td>
						</tr>
						<tr>
							<td>Номер первой строки</td><td><input type="text" name="min_row"></td>
						</tr>
						<tr>
							<td>Номер последней строки</td><td><input type="text" name="max_row"></td>
						</tr>
						<tr>
							<td>Номер колонки с названием курса</td>
							<td><input type="text" name="training_course_name_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с предметом</td>
							<td><input type="text" name="subject_name_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с количеством учебных часов</td>
							<td><input type="text" name="training_total_time_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с учебным периодом</td>
							<td><input type="text" name="training_period_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с днями недели</td>
							<td><input type="text" name="training_week_days_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с началом занятия</td><td>
							<input type="text" name="training_start_time_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с концом занятия</td><td>
							<input type="text" name="training_end_time_column"></td>
						</tr>
						<tr>
							<td>Номер колонки с ценой</td><td>
							<input type="text" name="training_price_column"></td>
						</tr>
						<tr>
							<td>Очистить таблицу (Да/Нет)</td>
							<td><input type="text" name="shouldEmpty"></td>
						</tr>
					</table>
					<div class="custom-file">
						<span>Загрузить текст</span>
						<input data-file-name="0" type="file" name="courses">
					</div>
					<input type="submit" value="Загрузить" id="upload-files">
				</form>
				<span id="message"></span>
		</div>
		<div id="footer"></div>
	</body>
</html>