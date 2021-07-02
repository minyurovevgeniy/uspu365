<?php
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Yekaterinburg');
?>
<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<link rel="stylesheet" href="./css/refreshIntervalManagement.css">
		<title>Интервал обновления</title>
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/refreshIntervalManagement.js"></script>
	</head>
	<body>
		<div id="header">
		<?include("./header.php"); ?>
		</div>
		<div id="content">
			<h1>Интервал обновления</h1>
			<table>
				Пароль для изменения:&nbsp<input type="password" id="save_password"></td></tr>
			</table>
			<br>
			<div id="tabs">
			<?php
				$tabs=
					array
					(
						0 => "Объявления для СО",
						1 => "Объявления для СПО",
						2 => "Объявления для магистратуры",
						3 => "Минимальные баллы ЕГЭ"
					);
				$fields=
					array
					(
            'Дни' =>'days',
						'Часы' => 'hours',
						'Минуты' => 'minutes',
						'Секунды' => 'seconds'
					);
					?>
					<div class="clear"></div>
					<?php
					foreach ($tabs as $tabId => $name)
					{
						?>
					<div data-id="<?php echo $tabId;?>" class="tab-content">
						<div class="tab-name"><?php echo $name;?></div>
						<table>
							<?php
								foreach($fields as $name=>$class)
								{
									?>
										<tr>
											<td>
												<?php echo $name; ?>
											</td>
											<td>
												<input type="text" data-id="<?php echo $tabId?>" class="<?php echo $class;?>">
											</td>
										</tr>
									<?php
								}
							?>
						</table>
						<input data-id="<?php echo $tabId;?>" type="button" value="Сохранить" class="saveRefreshInterval">
					</div>

					<?php
					}
			?>
				<div class="clear"></div>

			</div>
		</div>
		<div id="footer">
		</div>
	</body>
</html>
