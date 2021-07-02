$(function()
  {
    $('body').on("click","#deleteMagisterRating",function()
    {
      var password=$("#delete_password").val();
      var dataToSend={password:password};
  		$.ajax(
  		{
  			type: "POST",
  			url: "../php/deleteRatingMagister.php",
  			dataType: "json",
  			data:dataToSend,
  			success: function(response)
  			{
          alert("Готово!");
  			},
  			error:function(response){alert("error")}
  		});
    });

    $('body').on("click","#deleteOneMagisterRating",function()
    {
      var id=$("#profileId").val();
      var password=$("#delete_password").val();
      var dataToSend={id:id,password:password};
      var nonDigitsPattern=/\D/ig;
      if (nonDigitsPattern.test(id) || id.length<1)
      {
        alert("Номер направления должен быть натуральным числом");
      }
      else
      {
        $.ajax(
    		{
    			type: "POST",
    			url: "../php/deleteOneMagisterRating.php",
    			dataType: "json",
    			data:dataToSend,
    			success: function(response)
    			{
            alert("Готово!");
    			},
    			error:function(response){alert("error")}
    		});
      }

    });
});
