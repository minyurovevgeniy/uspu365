$(function ()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshMinEGE.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.ege_exams)
				{
					var row="";
					var ege=response.ege_exams;
					var length = ege.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+ege[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id-column">'+ege[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name-column"><input data-id="'+ege[i].id+'" type="text" class="name" value="'+ege[i].name+'"></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 abbr-column"><input data-id="'+ege[i].id+'" type="text" class="abbr" value="'+ege[i].abbr+'"></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 ege-min-column"><input data-id="'+ege[i].id+'" type="text" class="ege-min" value="'+ege[i].ege_min+'"></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+ege[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+ege[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#ege-list").html(row);
				}

			},
			error:function(xml){alert("error")}
		});


	$('body').on("click","#refreshEGE",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshMinEGE.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.ege_exams)
				{
					var row="";
					var ege=response.ege_exams;
					var length = ege.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+ege[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id-column">'+ege[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name-column"><input data-id="'+ege[i].id+'" type="text" class="name" value="'+ege[i].name+'"></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 abbr-column"><input data-id="'+ege[i].id+'" type="text" class="abbr" value="'+ege[i].abbr+'"></div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 ege-min-column"><input data-id="'+ege[i].id+'" type="text" class="ege-min" value="'+ege[i].ege_min+'"></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+ege[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+ege[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#ege-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});
	});

	$("body").on("input",".name, .abbr, .ege-min",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click",".save",function()
	{
		var egeId=$(this).attr("data-id");
		var inputId=$(this).attr("data-id");
		var name=$('.name[data-id='+egeId+']').val();
		var abbr=$('.abbr[data-id='+egeId+']').val();
		var min=$('.ege-min[data-id='+egeId+']').val();
		var passwordToSave=$("#save_password").val();
		var notDigits=/\D/igm;
		var dataToSend={id:egeId,name:name,abbr:abbr,min:min,password:passwordToSave};
		if (notDigits.test(min))
		{
			alert("Баллы должны быть числом");
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				data:dataToSend,
				url: "../php/saveEGE.php",
				dataType: "json",
				success: function(response)
				{
					$("input.save[type=button][data-id="+inputId+"]").removeClass("new");
					alert(response.status);
				},
				error:function(response){alert("error")}
			});
		}
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteEGE.php",
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

});
