$(function()
{
	
	$('body').on("click",".tab-button",function()
	{
		var width=900;
		var tabId=$(this).attr("data-id");
		$(".frame").animate({"marginLeft":-(tabId)*width},800);
	});
	
	$('body').on("click","#position",function()
	{
		var surname=$("#surname").val();
		var name=$("#name").val();
		var patronymic=$("#patronymic").val();
		
		
		$.ajax
		({
			type: "GET",
			url: "./php/searchMagisterFromSite.php?name="+name+"&surname="+surname+"&patronymic="+patronymic,
			dataType: "json",
			success: function(response)
			{	
				console.log(response);
				if (response.positions.length>0)
				{
					$("#magister").html("");
					var ratingItem="";
					$.each(response.positions,function(index, value)
					{
						ratingItem=
						'<div class="position">'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Уровень образования:</h4></div>'
							+'<div class="outbox-education col-sm-8 col-xs-8"><h4>'+value.outbox+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Учебное подразделение:</h4></div>'
							+'<div class="faculty col-sm-8 col-xs-8"><h4>'+value.faculty+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Направление:</h4></div>'
							+'<div class="profile col-sm-8 col-xs-8"><h4>'+value.profile+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Бюджет:</h4></div>'
							+'<div class="budget col-sm-8 col-xs-8"><h4>'+value.budget+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Конкурс:</h4></div>'
							+'<div class="special col-sm-8 col-xs-8"><h4>'+value.special+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Оригиналов:</h4></div>'
							+'<div class="original col-sm-8 col-xs-8"><h4>'+value.original+'</h4></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="col-sm-4 col-xs-4"><h4>Копий:</h4></div>'
							+'<div class="copies col-sm-8 col-xs-8"><h4>'+value.copy+'</h4></div>'
						+'</div>'
						+'</div>';
						$("#magister").append(ratingItem);
					});
				}
				
			},
			error:function(xml){alert("error")}
		});
		
		$.ajax
		({
			type: "GET",
			url: "./php/searchBachelorFromSite.php?name="+name+"&surname="+surname+"&patronymic="+patronymic,
			dataType: "json",
			success: function(response)
			{	
				console.log(response);
				if (response.positions.length>0)
				{
					$("#bachelor").html("");
					var ratingItem="";
					$.each(response.positions,function(index, value)
					{
						ratingItem=
						'<div class="position">'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Уровень образования:</h4></div>'
								+'<div class="outbox-education col-sm-8 col-xs-8"><h4>'+value.outbox+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Учебное подразделение:</h4></div>'
								+'<div class="faculty col-sm-8 col-xs-8"><h4>'+value.faculty+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Направление:</h4></div>'
								+'<div class="profile col-sm-8 col-xs-8"><h4>'+value.profile+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Бюджет:</h4></div>'
								+'<div class="budget col-sm-8 col-xs-8"><h4>'+value.budget+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Конкурс:</h4></div>'
								+'<div class="special col-sm-8 col-xs-8"><h4>'+value.special+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Оригиналов:</h4></div>'
								+'<div class="original col-sm-8 col-xs-8"><h4>'+value.original+'</h4></div>'
							+'</div>'
							+'<div class="row">'
								+'<div class="col-sm-4 col-xs-4"><h4>Копий:</h4></div>'
								+'<div class="copies col-sm-8 col-xs-8"><h4>'+value.copy+'</h4></div>'
							+'</div>'
						+'</div>';
						console.log(value.copy);
						$("#bachelor").append(ratingItem);
					});
				}
				
			},
			error:function(xml){alert("error")}
		});
	});
})