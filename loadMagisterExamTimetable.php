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
			<form action="./loadMagisterExamTimetable_result.php" method="post" enctype="multipart/form-data">
					<?php
						$fields=
							array
							(
								'Номер листа'=>"worksheet_number",
								'Номер первой строки'=>"min_row",
								'Номер последней строки'=>"max_row",
								'Номер колонки с названием/примечанием'=>"notes_column_number",
								'Номер колонки с датой'=>"date_column_number",
								'Номер колонки с временем начала'=>"start_time_column_number",
								'Номер колонки с временем конца'=>"end_time_column_number",
								'Номер колонки с аудиторией'=>"room_column_number",
								'Требуется очистка? (да/нет)' =>"shouldEpmty"
							);
					?>
					<table>
						<?php
							foreach ($fields as $key => $value)
							{
								?>
									<tr>
										<td><?php echo $key;?></td><td><input type="text" name="<?php echo $value;?>"></td>
									</tr>
								<?php
							}
						?>
						<tr>
							<td>Пароль для ввода</td><td><input type="password" name="input_password"></td>
						</tr>
					</table>
					<input type="file" name="timetable_file"><br>
					<input type="hidden" id="profileId" name="profileIdToSend" value="1">
					<input type="submit" value="Загрузить" id="upload-files">
				</form>
				<span id="message"></span>
		</div>
		<div id="footer"></div>
	</body>
</html>
