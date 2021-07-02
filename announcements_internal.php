<?
	session_start();
	if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");
?>
<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
	</head>
	<body>
		<div id="header"></div>
		<div id="content">
			<form id="announcements_load_form" action="./announcement_internal_result.php"  method="post">
				<div class="row">	
					<div class="col-md-3 col-sm-3 col-xs-3">
						Текст
					</div>
					<div class="col-md-9 col-sm-9 col-xs-9">
						<textarea cols="30" rows="5" name="announcement_text"></textarea>
					</div>
				</div>
				<div class="row">	
					<div class="col-md-offset-6 col-sm-offset-6 col-xs-offset-6 col-md-6 col-sm-6 col-xs-6">
						<input class="btn" type="submit" value="Сохранить">
					</div>
				</div>
			</form>
		</div>
		<div id="footer">
		</div>
	</body>
</html>