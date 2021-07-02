<html>
	<head>
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/common.css">
		<link rel="stylesheet" href="./css/courses.css">
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/trainingCoursesManagementBachelor.js"></script>
	</head>
	<body>
		<div id="header"><?php include("./header.php");?></div>
		<div id="content">
			<h1>Подготовительные курсы для абитуриентов</h1>
			<iframe src="./loadBachelorTrainingCourses.php"></iframe>
			
			<div id="courses-tabs">
				<div id="courses-labels">
					<?php
						$labels=array('Курсы','Заявки');
						foreach($labels as $key=>$value)
						{
							?>
								<div class="courses-label" data-id="<?php echo $key;?>"><?php echo $value;?></div>
							<?php
						}
					?>
				</div>
				<div class="clear"></div>
			</div>
			<br>
			<div id="courses-tabs">
				<div data-id="0" class="course-tab course-tab-selected">
					<div id="courses">
						<div id="courses-header">
							<input type="button" id="refreshCourses" value="Обновить список курсов">
							<div class="row">
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Вид/Название курса</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Предмет</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Кол-во учебных часов</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Учебный период</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Дни недели</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Начало</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Конец</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">Цена</div>
								<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">Действия</div>
							</div>
						</div>
						<div id="courses-list"></div>
					</div>
				</div>
				<div data-id="1" class="course-tab">
					<div class="course-requests">
						<input type="button" id="refreshCoursesRequests" value="Обновить список заявок">
						<div id="requests-header">
							<div class="row">
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№ курса</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-6">ФИО</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-5">email</div>
							</div>
						</div>
						<div id="requests-list">
							<div class="row">
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">№ курса</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-6">ФИО</div>
								<div class="col-sm-1 col-md-1 col-sm-1 col-xs-5">email</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div id="footer"></div>
	</body>
</html>