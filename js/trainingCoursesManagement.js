$(function()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesBachelor.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.courses)
				{
					var row="";
					var courses=response.courses;
					var length = courses.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+courses[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+courses[i].id+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].name+'" class="name" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].subject+'" class="subject" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].total_time+'" class="total_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].period+'" class="period" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].week_days+'" class="week_days" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].start_time+'" class="start_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].end_time+'" class="end_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].price+'" class="price" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">'+
									'<input class="save" type="button" data-id="'+courses[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+courses[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#courses-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});

	$("body").on("input",".name, .subject, .total_time, .period, .week_days, .start_time, .end_time, .price",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click","#refreshCourses",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesBachelor.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.courses)
				{
					var row="";
					var courses=response.courses;
					var length = courses.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+courses[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+courses[i].id+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].name+'" class="name" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].subject+'" class="subject" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].total_time+'" class="total_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].period+'" class="period" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].week_days+'" class="week_days" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].start_time+'" class="start_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].end_time+'" class="end_time" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1"><input type="text" value="'+courses[i].price+'" class="price" data-id="'+courses[i].id+'"></div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">'+
									'<input class="save" type="button" data-id="'+courses[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+courses[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#courses-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});
	});

	$('body').on("click",".save",function()
	{
		var id=$(this).attr("data-id");
		var inputId=$(this).attr("data-id");
		var name=$('.name[data-id='+id+']').val();
		var subject=$('.subject[data-id='+id+']').val();
		var total_time=$('.total_time[data-id='+id+']').val();
		var period=$('.period[data-id='+id+']').val();
		var week_days=$('.week_days[data-id='+id+']').val();
		var start_time=$('.start_time[data-id='+id+']').val();
		var end_time=$('.end_time[data-id='+id+']').val();
		var price=$('.price[data-id='+id+']').val();
		var password=$("#save_password").val();

		var splitTime="";

		var noDigitsPattern=/\D/ig;
		var TimePattern=/^\d\d:\d\d$/i;
		if (noDigitsPattern.test(total_time) || parseInt(total_time)==0)
		{
			alert("Число часов должно быть натуральным числом");
		}
		else
		{
			if (noDigitsPattern.test(price) || parseInt(price)==0)
			{
				alert("Стоимость должна быть натуральным числом");
			}
			else
			{
				if (!(TimePattern.test(start_time)))
				{
					alert("Время начала должно быть записано в формате ЧЧ:ММ");
				}
				else
				{
					splitTime=start_time.split(":");
					splitTime[0]=parseInt(splitTime[0]);
					splitTime[1]=parseInt(splitTime[1]);
					if (splitTime[0]<0 || splitTime[0]>23)
					{
						alert("Час времени начала должен быть в диапазоне от 0 до 23");
					}
					else
					{
						if (splitTime[1]<0 || splitTime[1]>59)
						{
							alert("Минуты времени начала должны быть в диапазоне от 0 до 59");
						}
						else
						{
							if (!(TimePattern.test(end_time)))
							{
								alert("Время окончания должно быть записано в формате ЧЧ:ММ");
							}
							else
							{
								splitTime=end_time.split(":");
								splitTime[0]=parseInt(splitTime[0]);
								splitTime[1]=parseInt(splitTime[1]);
								if (splitTime[0]<0 || splitTime[0]>23)
								{
									alert("Час времени окончания должен быть в диапазоне от 0 до 23");
								}
								else
								{
									if (splitTime[1]<0 || splitTime[1]>59)
									{
										alert("Минуты времени окончания должны быть в диапазоне от 0 до 59");
									}
									else
									{
										var dataToSend={id:id,name:name,subject:subject,total_time:total_time,period:period,week_days:week_days,start_time:start_time,end_time:end_time,price:price,password:password};

										$.ajax({
												type:"POST",
												data:dataToSend,
												url: "../php/saveCoursesBachelor.php",
												dataType: "json",
												success: function(response)
												{
													alert("Запись изменена");
													$("input.save[type=button][data-id="+inputId+"]").removeClass("new");
												},
												error:function(response){alert("error")}
											});

									}
								}
							}
						}
					}
				}
			}
		}
	});


	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var password=$("#delete_password").val();
		var dataToSend={id:id,password:password};

		$.ajax(
			{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteCourseBachelor.php",
			dataType: "json",
			success: function(response)
			{
				$(".row[data-id="+id+"]").remove();
				alert("OK!");
			},
			error:function(response){alert("error")}
		});

	});

	$('body').on("click","#deleteAllCourses",function()
	{
		var id=$(this).attr("data-id");
		var password=$("#delete_password").val();
		var dataToSend={id:id,password:password};

		$.ajax(
			{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteAllCourses.php",
			dataType: "json",
			success: function(response)
			{
				$(".row").remove();
				alert("OK!");
			},
			error:function(response){alert("error")}
		});

	});



});
