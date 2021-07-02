	$(function()
{
	$("body").on("click","#submit",function()
	{
		var login=$("#login").val();
		var password=$("#password").val();
		var dataToLoad={login:login,password:password};
		//="+login+"&password="+password,
		$.ajax
		({
			type: "POST",
			url: "./php/checkData.php",
			dataType: "xml",
			data:dataToLoad,
			success: function(xml)
			{
				location="./facultiesManagement.php";
			},
			error:function(xml){alert("Ошибка")}
		});
	});
})
