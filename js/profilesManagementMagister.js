$(function()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshProfilesMagister.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.profiles)
				{
					var row="";
					var profiles=response.profiles;
					var length = profiles.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+profiles[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].id+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].faculty+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].profile_desc+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].form+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].budget+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].special+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].capacity+'</div>'+
							'</div>';
					}
					$("#profiles-list").html(row);
				}
			},
			error:function(xml){alert("error")}
		});


	$('body').on("click","#refreshProfiles",function()
	{
		$.ajax(
		{
			type: "GET",
			url: "../php/refreshProfilesMagister.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				var row="";
				if (response.profiles)
				{
					var profiles=response.profiles;
					var length = profiles.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+profiles[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].id+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].faculty+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].profile_desc+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].form+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].budget+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2">'+profiles[i].special+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1">'+profiles[i].capacity+'</div>'
							'</div>';
					}
				}
				$("#profiles-list").html(row);
			},
			error:function(xml){alert("error")}
		});
	});
});
