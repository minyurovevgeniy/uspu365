$(function ()
{
	$.ajax(
		{
			type: "GET",
			url: "../php/vkRequestRefresh.php",
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.request)
				{
					$("#request-string").val(response.request);
				}
			},
			error:function(xml){alert("error")}
		});
	
	
	$('body').on("click","#saveRequest",function()
	{
		$.ajax(
		{
			type: "GET",
			url: '../php/vkRequestSave.php?request='+encodeURIComponent($("#request-string").val()),
			dataType: "json",
			success: function(response)
			{
				console.log(response);
				if (response.request)
				{
					$("#request-string").val(response.request);
					alert("OK");
				}
			},
			error:function(xml){alert("error")}
		});
	});
});