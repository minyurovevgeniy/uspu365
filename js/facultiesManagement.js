$(function ()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshFaculties.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.faculties)
				{
					var row="";
					var faculties=response.faculties;
					var length = faculties.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+faculties[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+faculties[i].id+'</div>'+
								'<div class="col-sm-5 col-md-5 col-sm-5 col-xs-5"><textarea name="faculty_name" class="faculty-name" cols="40" data-id="'+faculties[i].id+'">'+faculties[i].name+'</textarea></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2"><input type="text" class="faculty-abbr" data-id="'+faculties[i].id+'" value="'+faculties[i].abbr+'"></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+faculties[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+faculties[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#faculties-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});


	$('body').on("click","#refreshFaculties",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshFaculties.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.faculties)
				{
					var row="";
					var faculties=response.faculties;
					var length = faculties.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+faculties[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+faculties[i].id+'</div>'+
								'<div class="col-sm-5 col-md-5 col-sm-5 col-xs-5"><textarea name="faculty_name" cols="40" class="faculty-name" data-id="'+faculties[i].id+'">'+faculties[i].name+'</textarea></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2"><input type="text" class="faculty-abbr" data-id="'+faculties[i].id+'" value="'+faculties[i].abbr+'"></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+faculties[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+faculties[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#faculties-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});
	});

	$("body").on("input",".faculty_name, .faculty-abbr",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click",".save",function()
	{
		var id=$(this).attr("data-id");
		var inputId=$(this).attr("data-id");
		var name=$('.faculty-name[data-id='+id+']').val();
		var abbr=$('.faculty-abbr[data-id='+id+']').val();
		var passwordToSave=$('#save_password').val();
		console.log(passwordToSave);
		var dataToSave={faculty_id:id,faculty_name:name,faculty_abbr:abbr,password:passwordToSave};
		$.ajax(
		{
			type: "POST",
			data: dataToSave,
			url: "../php/saveFaculty.php",
			dataType: "json",
			success: function(response)
			{
				alert(response.status);
			},
			error:function(response){alert("error")}
		});
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var deleteId=$(this).attr("data-id");
		if (parseInt(id)<1)
		{
			alert("Некорректный идентификатор учебного подразделения");
			return;
		}
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={faculty_id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteFaculty.php",
			dataType: "json",
			success: function(response)
			{
				alert(response.status);
				$(".row[data-id="+deleteId+"]").remove();
			},
			error:function(response)
			{
				alert("Ошибка");
			}
		});
	});


	$('body').on("click","#deleteAllFaculties",function()
	{
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteAllFaculties.php",
			dataType: "json",
			success: function(response)
			{
				$("#faculties-list").html("");
			},
			error:function(response)
			{
				alert("Ошибка");
			}
		});
	});
});
