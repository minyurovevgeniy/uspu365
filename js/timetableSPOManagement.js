$(function ()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshSPOExamTimetable.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.exams)
				{
					var row="";
					var exams=response.exams;
					var length = exams.length;
					for (var i=0;i<length;i++)
					{
						row+=
              '<div class="row" data-id="'+exams[i].id+'">'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+exams[i].id+'</div>'+
							'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 notes"><textarea data-id="'+exams[i].id+'" class="notes_value">'+exams[i].notes+'</textarea></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 date"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].date+'" class="date_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 start_time"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].start_time+'" class="start_time_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 end_time"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].end_time+'" class="end_time_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 weekday">'+exams[i].weekday+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 room"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].room+'" class="room"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 is_cancelled"><input class="is_cancelled_value" type="checkbox" data-id="'+exams[i].id+'" '+exams[i].is_cancelled+'></div>'+
    						'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 actions">'+
                  '<input class="save" type="button" data-id="'+exams[i].id+'" value="Сохранить">'+
                  '<input class="delete" type="button" data-id="'+exams[i].id+'" value="Удалить">'+
                '</div>'+
    					'</div>';
					}
						$("#exams-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});

	$("body").on("input",".date_value, .start_time_value, .end_time_value, .is_cancelled_value, .notes_value",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click","#refreshTimetable",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshSPOExamTimetable.php",
			dataType: "json",
			success: function(response)
			{
				var row="";
				console.log(response);
				if (response.exams)
				{

					var exams=response.exams;
					var length = exams.length;
					for (var i=0;i<length;i++)
					{
						row+=
              '<div class="row" data-id="'+exams[i].id+'">'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+exams[i].id+'</div>'+
							'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 notes"><textarea data-id="'+exams[i].id+'" class="notes_value">'+exams[i].notes+'</textarea></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 date"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].date+'" class="date_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 start_time"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].start_time+'" class="start_time_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 end_time"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].end_time+'" class="end_time_value"></div>'+
    						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 weekday">'+exams[i].weekday+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 room"><input type="text" data-id="'+exams[i].id+'" value="'+exams[i].room+'" class="room"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 is_cancelled"><input class="is_cancelled_value" type="checkbox" data-id="'+exams[i].id+'" '+exams[i].is_cancelled+'></div>'+
    						'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 actions">'+
                  '<input class="save" type="button" data-id="'+exams[i].id+'" value="Сохранить">'+
                  '<input class="delete" type="button" data-id="'+exams[i].id+'" value="Удалить">'+
                '</div>'+
    					'</div>';
					}

				}
				$("#exams-list").html(row);
				alert("OK!");
			},
			error:function(xml){alert("error")}
		});
	});

	$('body').on("click",".save",function()
	{
		var id=$(this).attr("data-id");

		var date=$(".date_value[data-id="+id+"]").val();
		var dateDetailed=date.split("-");
		var year,month,day;

		var start_time=$(".start_time_value[data-id="+id+"]").val();
		var startTimeDetailed=start_time.split(":");
		var start_hour,start_minutes,start_seconds;
		var startTimestamp=0;

		var end_time=$(".end_time_value[data-id="+id+"]").val();
		var endTimeDetailed=end_time.split(":");
		var end_hour,end_minutes,end_seconds;
		var endTimestamp=0;

		var is_cancelled= ($(".is_cancelled_value[data-id="+id+"]").prop("checked"))? 1 : 0 ;
		var notes=$(".notes_value[data-id="+id+"]").val();
		var notesLength=notes.length;
		console.log("Cancelled: "+is_cancelled);

		var passwordToSave=$("#save_password").val();

		var room=$(".room[data-id="+id+"]").val();

		if ((/^\d\d-\d\d-\d\d\d\d$/gi).test(date))// parse date
		{
			//alert("В дате есть что-то кроме чисел");
			year=parseInt(dateDetailed[2]);
			if(year>0 && Math.floor(year)==year)
			{
				month=parseInt(dateDetailed[1]);
				if (month>=1 && month<=12)
				{
					day=parseInt(dateDetailed[0]);
					days=[31,28,31,30,31,30,31,31,30,31,30,31];
					if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0))
					{
						days[1]=29;
					}

					if ((day>=1) && (day<=days[month-1]))
					{
						if ((/^\d\d:\d\d$/gi).test(start_time)) // parse start time
						{
							start_hour=parseInt(startTimeDetailed[0]);

							if (start_hour>=0 && start_hour<=23)
							{
								start_minutes=parseInt(startTimeDetailed[1]);
								if (start_minutes>=0 && start_minutes<=59)
								{
									start_seconds=parseInt(startTimeDetailed[2]);

										if ((/^\d\d:\d\d$/gi).test(end_time))  // parse end time
										{
											end_hour=parseInt(endTimeDetailed[0]);
											if (end_hour>=0 && end_hour<=23)
											{
												end_minutes=parseInt(endTimeDetailed[1]);
												if (end_minutes>=0 && end_minutes<=59)
												{
														month--;
														startTimestamp=new Date();
														startTimestamp.setFullYear(year);
														startTimestamp.setMonth(month);
														startTimestamp.setDate(day);
														startTimestamp.setHours(start_hour);
														startTimestamp.setMinutes(start_minutes);
														startTimestamp.setSeconds(0);
														console.log("Начало :"+startTimestamp.getTime());

														endTimestamp=new Date();
														endTimestamp.setFullYear(year);
														endTimestamp.setMonth(month);
														endTimestamp.setDate(day);
														endTimestamp.setHours(end_hour);
														endTimestamp.setMinutes(end_minutes);
														endTimestamp.setSeconds(0);
														console.log("Конец  :"+endTimestamp.getTime());

														if (startTimestamp.getTime()<=endTimestamp.getTime())
														{
															if (notesLength>=1 && notesLength<=30)
															{
																var dataToSend={exam:id,date:date,start_time:start_time,end_time:end_time,is_cancelled:is_cancelled,notes:notes,room:room,password:passwordToSave};

																$.ajax(
																	{
																	type: "POST",
																	url: "../php/saveExamSPO.php",
																	data:dataToSend,
																	dataType: "json",
																	success: function(response)
																	{
																		alert(response.status);
																		$(".save[type=button][data-id="+id+"]").removeClass("new");
																		alert("Запись изменена");

																	},
																	error:function(response){alert("error")}
																});
															}
															else
															{
																alert("Количество знаков в примечании должно быть от 1 до 30");
															}
														}
														else
														{
															alert("Время начала должно быть меньше времени конца");
														}
												}
												else
												{
													alert("Минуты конца занятия должны быть в диапазоне от 0 до 59 включительно");
												}
											}
											else
											{
												alert("Час конца занятия должен быть в диапазоне от 0 до 23 включительно");
											}
										}
										else
										{
											alert("Время конца занятия должно быть в формате ЧЧ:ММ");
										}
								}
								else
								{
									alert("Минуты начала занятия должны быть в диапазоне от 0 до 59 включительно");
								}
							}
							else
							{
								alert("Час начала занятия должен быть в диапазоне от 0 до 23 включительно");
							}
						}
						else
						{
							alert("Время начала занятия должно быть в формате ЧЧ:ММ");
						}
					}
					else
					{
						alert("День месяца должен быть в диапазоне от 1 до "+days[month-1]+" включительно");
					}
				}
				else
				{
					alert("Месяц должен быть в диапазоне от 1 до 12 включительно");
				}
			}
			else
			{
				alert("Год должен быть записан целым натуральным числом");
			}
		}
		else
		{
			alert("Дата должна быть записана в формате ДД-ММ-ГГГГ");
		}
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={lesson_id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteLesson.php",
			dataType: "json",
			data:dataToSend,
			success: function(response)
			{
				$(".row[data-id="+id+"]").remove();
				alert("OK!");
			},
			error:function(response){alert("error")}
		});
	});

})
