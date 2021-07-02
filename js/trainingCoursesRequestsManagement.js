$(function ()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/refreshCoursesRequests.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.requests)
				{
					var row="";
					var requests=response.requests;
					var length = requests.length;
					for (var i=0;i<length;i++)
					{
						row+='<div class="row" data-id="'+requests[i].id+'">'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+requests[i].id+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 course">'+requests[i].training_course_to_apply+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-3 time">'+requests[i].application_time+'</div>'+
								'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 name">'+requests[i].applicant_name+'</div>'+
								'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 email">'+requests[i].applicant_email+'</div>'+
								'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">'+
									'<input class="enroll" type="button" data-id="'+requests[i].id+'" value="Зачислить">'+
									'<input class="delete" type="button" data-id="'+requests[i].id+'" value="Удалить">'+
								'</div>'+
							'</div>';
					}
					$("#coursesRequests-list").html(row);
				}

			},
			error:function(xml){alert("error")}
		});


	$('body').on("click","#refreshCoursesRequests",function()
	{
    $.ajax(
  		{
  			type: "GET",
  			url: "../php/refreshCoursesRequests.php",
  			dataType: "json",
  			success: function(response)
  			{
  				console.log(response);
  				if (response.requests)
  				{
  					var row="";
  					var requests=response.requests;
  					var length = requests.length;
  					for (var i=0;i<length;i++)
  					{
							row+='<div class="row" data-id="'+requests[i].id+'">'+
									'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+requests[i].id+'</div>'+
									'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 course">'+requests[i].training_course_to_apply+'</div>'+
									'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-3 time">'+requests[i].application_time+'</div>'+
									'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 name">'+requests[i].applicant_name+'</div>'+
									'<div class="col-sm-2 col-md-2 col-sm-2 col-xs-2 email">'+requests[i].applicant_email+'</div>'+
									'<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3">'+
										'<input class="enroll" type="button" data-id="'+requests[i].id+'" value="Зачислить">'+
										'<input class="delete" type="button" data-id="'+requests[i].id+'" value="Удалить">'+
									'</div>'+
								'</div>';
  					}
  					$("#coursesRequests-list").html(row);
  				}

  			},
  			error:function(xml){alert("error")}
  		});
	});

	$('body').on("click",".delete",function()
	{
		var id=$(this).attr("data-id");
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteCourseRequest.php",
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

	$('body').on("click",".enroll",function()
	{
		var id=$(this).attr("data-id");
		var passwordToDelete=$("#delete_password").val();
		var dataToSend={id:id,password:passwordToDelete};
		$.ajax(
		{
			type: "POST",
			url: "../php/enrollForCourse.php",
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

	$('body').on("click","#deleteAllCoursesRequests",function()
	{
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteAllCoursesRequests.php",
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
