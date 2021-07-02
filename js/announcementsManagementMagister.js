$(function()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshAnnouncementsMagister.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.announcements)
				{
					var row="";
					var ann=response.announcements;
					var length = ann.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+ann[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+ann[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 time">'+ann[i].time+'</div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 "><textarea class="ann-text" data-id="'+ann[i].id+'">'+ann[i].text+'</textarea></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+ann[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+ann[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#announcements-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});


	$('body').on("click","#refreshAnnouncements",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshAnnouncementsMagister.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				var row="";
				if (response.announcements)
				{
					var ann=response.announcements;
					var length = ann.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+ann[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+ann[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 time">'+ann[i].time+'</div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 "><textarea class="ann-text" data-id="'+ann[i].id+'">'+ann[i].text+'</textarea></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+ann[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+ann[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#announcements-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});
	});

	$("body").on("input",".ann-text",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click",".save",function()
	{
		var id=$(this).attr("data-id");
		var inputId=$(this).attr("data-id");
		var text=$('.ann-text[data-id='+id+']').val();
		var passwordToSave=$("#save_password").val();
		var dataToSend={announcement_id:id,announcement_text:text,password:passwordToSave};

		$.ajax(
		{
			type: "POST",
			data:dataToSend,
			url: "../php/saveAnnouncementMagister.php",
			dataType: "json",
			success: function(response)
			{
				alert("Объявление сохранено!");
				$("input.save[type=button][data-id="+inputId+"]").removeClass("new");
			},
			error:function(response){alert("error")}
		});
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={announcement_id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			data:dataToSend,
			url: "../php/deleteAnnouncementMagister.php",
			dataType: "json",
			success: function(response)
			{
				$(".row[data-id="+id+"]").remove();
				alert("Объявление удалено!");
			},
			error:function(response){alert("error")}
		});
	});

	$('body').on("click","#deleteAllAnnouncements",function()
	{
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteAllAnnouncementsMagister.php",
			dataType: "json",
			success: function(response)
			{
				$("#announcements-list").html("");
				alert("OK!");
			},
			error:function(response){alert("error")}
		});
	});

	$('body').on("click","#deleteAllRecepients",function()
	{
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteRecipientsMagister.php",
			dataType: "json",
			success: function(response)
			{
				alert("OK!");
			},
			error:function(response){alert("error")}
		});
	});

	$('body').on("click",".send",function()
	{
		var id=$(this).attr("data-id");
		var passwordToNotify=$("#notify_password").val();
		var dataToSend={id:id,password:passwordToNotify};
		$.ajax(
		{
			type: "POST",
			url: "../php/sendAnnouncementMagister.php",
			dataType: "json",
			data: dataToSend,
			success: function(response)
			{
				if (response.announcements)
				{
					$("#announcements-list").html("");
					var row="";
					var ann=response.announcements;
					var length = ann.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+ann[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 time">'+ann[i].time+'</div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 "><textarea class="ann-text" data-id="'+ann[i].id+'">'+ann[i].text+'</textarea></div>'+
								'<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4">'+
									'<input class="save" type="button" data-id="'+ann[i].id+'" value="Сохранить">'+
									'<input class="delete" type="button" data-id="'+ann[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#announcements-list").html(row);
					alert("Отправлено!");
				}
			},
			error:function(response){alert("error")}
		});
	});

});
