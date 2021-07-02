$(function()
{

	$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesList.php",
			dataType: "json",
			success: function(response)
			{
				var items='<option value="0">Выберите курс</option>';
				if (response.courses_list)
				{
					var coursesList=response.courses_list;
					var maxIndex=coursesList.length-1;
					for (var i=0;i<=maxIndex;i++)
					{
						items+='<option value="'+coursesList[i].id+'">'+coursesList[i].name+'</option>';
					}
				}
				$("#course-to-choose").html(items);
			},
			error:function(error)
			{
				alert("error");
			}
		});

	$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesStudents.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.students)
				{
					var data="";
					var students=response.students;
					var length = students.length;
					var coursesNames=[];
					var coursesIds=[];
					for (var i=0;i<length;i++)
					{
						if (coursesIds.indexOf(students[i].course_id)<0)
						{
							coursesNames.push(students[i].course_name);
							coursesIds.push(students[i].course_id);
						}
					}

					var coursesLength=coursesIds.length;
					for (var i=0;i<coursesLength;i++)
					{
						data+='<div class="course">'+
							'<div class="course-name">'+coursesNames[i]+'</div>';
						for (var j=0;j<length;j++)
						{
							if (students[j].course_name==coursesNames[i])
							{
								data+='<div class="row" data-id="'+students[j].id+'_'+coursesIds[i]+'">'+
	 		                '<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+coursesIds[i]+'</div>'+
	 		                '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name">'+students[j].name+'('+students[j].student_id+')</div>'+
	 		                '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 email">'+students[j].email+'</div>'+
	 		                '<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 enrollment_time">'+students[j].enrollment_time+'</div>'+
	 		                '<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+
	 		                  '<input class="delete" type="button" data-id="'+students[j].id+'_'+coursesIds[i]+'" value="Отчислить">'+
	 		                '</div>'+
	 		              '</div>';
							}

						}
						data+='</div>';
					}
					$("#studentGroups-list").html(data);
				}
			},
			error:function(xml){alert("error")}
		});

	$('body').on("click","#add-student",function()
	{
		var course=$("#course-to-choose").val();
		var name=$("#applicant-name").val().replace(/\s/,'');
		var email=$("#applicant-email").val().replace(/\s/,'');
		var emailPattern=/^[-a-z0-9!#$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|ru|travel|[a-z]{2,})$/i;
		var password=$("#save_password").val();
		if (course<1)
		{
			alert("Выберите курс!");
		}
		else
		{
			if (name.length<1)
			{
				alert("Введите имя!");
			}
			else
			{
				if (!emailPattern.test(email))
				{
					alert("Введите корректную электронную почту!");
				}
				else
				{
					var dataToSend={id:course,name:name,email:email,password:password};
					$.ajax({
						type: "POST",
						data:dataToSend,
						url: "../php/addStudentManually.php",
						dataType: "json",
						success: function(response)
						{
							alert("Готово! Обновите список!");
						},
						error:function(error)
						{
							alert("error");
						}
					});
				}
			}
		}
	});

	$('body').on("click","#refreshTrainingCourseStudents",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesStudents.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.students)
				{
					var data="";
					var students=response.students;
					var length = students.length;
					var coursesNames=[];
					var coursesIds=[];
					for (var i=0;i<length;i++)
					{
						if (coursesIds.indexOf(students[i].course_id)<0)
						{
							coursesNames.push(students[i].course_name);
							coursesIds.push(students[i].course_id);
						}
					}

					var coursesLength=coursesIds.length;
					for (var i=0;i<coursesLength;i++)
					{
						data+='<div class="course">'+
							'<div class="course-name">'+coursesNames[i]+'</div>';
						for (var j=0;j<length;j++)
						{
							if (students[j].course_name==coursesNames[i])
							{
								data+='<div class="row" data-id="'+students[j].id+'_'+coursesIds[i]+'">'+
	 		                '<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+coursesIds[i]+'</div>'+
	 		                '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name">'+students[j].name+'('+students[j].student_id+')</div>'+
	 		                '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 email">'+students[j].email+'</div>'+
	 		                '<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 enrollment_time">'+students[j].enrollment_time+'</div>'+
	 		                '<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+
	 		                  '<input class="delete" type="button" data-id="'+students[j].id+'_'+coursesIds[i]+'" value="Отчислить">'+
	 		                '</div>'+
	 		              '</div>';
							}
						}
						data+='</div>';
					}
					$("#studentGroups-list").html(data);
					alert("OK");
				}
			},
			error:function(xml){alert("error")}
		});
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var rowId=$(this).attr("data-id");
		var password=$("#delete_password").val();
		var dataToSend={id:id,password:password};

		$.ajax(
			{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteCourseStudentConnection.php",
			dataType: "json",
			success: function(response)
			{
				$(".row[data-id="+rowId+"]").remove();
				alert("Запись удалена!");
			},
			error:function(response){alert("error")}
		});

	});

	$('body').on("click","#deleteAllTrainingCourseStudents",function()
	{
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteAllCoursesStudentsConnections.php",
			dataType: "json",
			success: function(response)
			{
				$("#coursesRequests-list").html("");
				alert("OK!");
			},
			error:function(response){alert("error")}
		});
	});

});
