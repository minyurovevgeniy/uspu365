$(function()
  {
    $('body').on("click","#deleteBachelorRating",function()
    {
      var password=$("#delete_password").val();
      var dataToSend={password:password};
  		$.ajax(
  		{
  			type: "POST",
  			url: "../php/deleteRatingBachelor.php",
  			dataType: "json",
  			data:dataToSend,
  			success: function(response)
  			{
          alert("Готово!");
  			},
  			error:function(response){alert("error")}
  		});
    });


    $('body').on("click","#deleteOneBachelorRating",function()
    {
      var noDigitsPattern=/\D/ig;
      var id=$("#profileId").val();
      var password=$("#delete_password").val();
      var dataToSend={id:id,password:password};
      if (nonDigitsPattern.test(id) || id.length<1)
      {
        alert("Номер направления должен быть натуральным числом");
      }
      else
      {
        $.ajax(
    		{
    			type: "POST",
    			url: "../php/deleteOneBachelorRating.php",
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
