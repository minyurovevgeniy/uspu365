$(function()
{

	$.ajax(
		{
			type: "GET",
			url: "../php/refreshStudentList.php",
			dataType: "json",
			success: function(response)
			{
				var items='';
				if (response.students)
				{
					var studentList=response.students;
					var maxIndex=studentList.length-1;
					for (var i=0;i<=maxIndex;i++)
					{
						items+='<div class="row" data-id="'+studentList[i].id+'">'+
  						'<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+studentList[i].id+'</div>'+
              '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name"><input type="text" class="name" data-id="'+studentList[i].id+'" value="'+studentList[i].name+'"></div>'+
              '<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 email"><input type="text" class="email" data-id="'+studentList[i].id+'" value="'+studentList[i].email+'"></div>'+
              '<div class="col-sm-4 col-md-4 col-sm-2 col-xs-2"><input type="button" class="save" data-id="'+studentList[i].id+'" value="Сохранить"><input type="button" class="delete" data-id="'+studentList[i].id+'" value="Удалить"></div>'+
  					'</div>';
					}
				}
				$("#student-list").html(items);
			},
			error:function(error)
			{
				alert("error");
			}
		});
//&& !$("#manual_mode").prop("checked")

  $('body').on("click","#refreshStudents",function()
  {
    $.ajax(
      {
        type: "GET",
        url: "../php/refreshStudentList.php",
        dataType: "json",
        success: function(response)
        {
          var items='';
          if (response.students)
          {
            var studentList=response.students;
            var maxIndex=studentList.length-1;
            for (var i=0;i<=maxIndex;i++)
            {
              items+='<div class="row" data-id="'+studentList[i].id+'">'+
                '<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+studentList[i].id+'</div>'+
                '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name"><input type="text" class="name" data-id="'+studentList[i].id+'" value="'+studentList[i].name+'"></div>'+
                '<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 email"><input type="text" class="email" data-id="'+studentList[i].id+'" value="'+studentList[i].email+'"></div>'+
                '<div class="col-sm-4 col-md-4 col-sm-2 col-xs-2"><input type="button" class="save" data-id="'+studentList[i].id+'" value="Сохранить"><input type="button" class="delete" data-id="'+studentList[i].id+'" value="Удалить"></div>'+
              '</div>';
            }
          }
          $("#student-list").html(items);
          alert("OK");
        },
        error:function(error)
        {
          alert("error");
        }
      });
  });

  $("body").on("input",".name, .email",function()
	{
		var id=$(this).attr("data-id");
		$("input.save[type=button][data-id="+id+"]").addClass("new");
	});

	$('body').on("click",".save",function()
	{
		var id=$(this).attr("data-id");
		var rowId=$(this).attr("data-id");
		var name=$(".name[data-id="+id+"]").val().replace(/\s/,'');
		var email=$(".email[data-id="+id+"]").val().replace(/\s/,'');
		var emailPattern=/^[-a-z0-9!#$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|ru|travel|[a-z]{2,})$/i;
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

				var dataToSend={id:id,name:name,email:email};
				$.ajax({
					type: "POST",
					data:dataToSend,
					url: "../php/saveCourseStudent.php",
					dataType: "json",
					success: function(response)
					{
            var items='';
            if (response.students && !$("#manual_mode").prop("checked"))
            {
              var studentList=response.students;
              var maxIndex=studentList.length-1;
              for (var i=0;i<=maxIndex;i++)
              {
                items+='<div class="row" data-id="'+studentList[i].id+'">'+
                  '<div class="col-sm-1 col-md-1 col-sm-1 col-xs-1 id">'+studentList[i].id+'</div>'+
                  '<div class="col-sm-3 col-md-3 col-sm-3 col-xs-3 name"><input type="text" class="name" data-id="'+studentList[i].id+'" value="'+studentList[i].name+'"></div>'+
                  '<div class="col-sm-4 col-md-4 col-sm-4 col-xs-4 email"><input type="text" class="email" data-id="'+studentList[i].id+'" value="'+studentList[i].email+'"></div>'+
                  '<div class="col-sm-4 col-md-4 col-sm-2 col-xs-2"><input type="button" class="save" data-id="'+studentList[i].id+'" value="Сохранить"><input type="button" class="delete" data-id="'+studentList[i].id+'" value="Удалить"></div>'+
                '</div>';
              }
              $("#student-list").html(items);
            }
            alert("OK");
            $("input.save[type=button][data-id="+rowId+"]").removeClass("new");
					},
					error:function(error)
					{
						alert("error");
					}
				});
			}
		}
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
			url: "../php/deleteCourseStudent.php",
			dataType: "json",
			success: function(response)
			{
				$(".row[data-id="+rowId+"]").remove();
				alert("Запись удалена!");
			},
			error:function(response){alert("error")}
		});

	});

	$('body').on("click","#deleteAllStudents",function()
	{
		$.ajax(
		{
			type: "POST",
			url: "../php/deleteAllStudents.php",
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
