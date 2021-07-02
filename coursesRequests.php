<html>
	<head>
		<link type="text/css" rel="stylesheet"  href="./css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet"  href="./css/common.css">
	</head>
	<body>
		<div style="width:900px; margin:0px auto">
			<?php
				include("./php/connect.php");
				
				$stmt=$pdo->prepare("SELECT * FROM bachelor_training_courses_application");
				$stmt->execute();
				
				while($row=$stmt->fetch(PDO::FETCH_LAZY))
				{
					?>
					<div class="row">
						<div class="col-sm-2 col-md-2"><?php echo iconv("cp1251","utf-8",$row['applicant_surname']);?></div>
						<div class="col-sm-2 col-md-2"><?php echo iconv("cp1251","utf-8",$row['applicant_name']);?></div>
						<div class="col-sm-2 col-md-2"><?php echo iconv("cp1251","utf-8",$row['applicant_patronymic']);?></div>
						<div class="col-sm-2 col-md-2"><?php echo iconv("cp1251","utf-8",$row['applicant_email']);?></div>
						<div class="col-sm-2 col-md-2"><?php echo iconv("cp1251","utf-8",$row['training_course_to_apply']);?></div>
					</div>
					<?php
				}
				include("./php/disconnect.php");
			?>
		</div>
	</body>
</html>