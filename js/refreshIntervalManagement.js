$(function()
{
  $.ajax(
    {
      type: "GET",
      url: "../php/refreshInterval.php",
      dataType: "json",
      success: function(response)
      {
        console.log(response);
        if (response.intervals)
        {
          var intervals=response.intervals;
          var length=intervals.length;
          for (var id=0;id<length;id++)
          {
            $(".days[data-id="+id+"]").val(intervals[id].days);
            $(".hours[data-id="+id+"]").val(intervals[id].hours);
            $(".minutes[data-id="+id+"]").val(intervals[id].minutes);
            $(".seconds[data-id="+id+"]").val(intervals[id].seconds);
          }
        }
      },
      error:function(xml){alert("error")}
    });

    $("body").on("input",".days, .hours, .minutes, .seconds",function()
  	{
  		$(".saveRefreshInterval[type=button][data-id="+$(this).attr("data-id")+"]").addClass('new');
  	});

  $('body').on("click",".saveRefreshInterval",function()
  {
    var buttonId=$(this).attr("data-id");
    var id=$(this).attr("data-id");
    var days=$(".days[data-id="+id+"]").val();
    var hours=$(".hours[data-id="+id+"]").val();
    var minutes=$(".minutes[data-id="+id+"]").val();
    var seconds=$(".seconds[data-id="+id+"]").val();
    var pattern=/\D/ig;
    if ((pattern).test(days) || days.length<=0)
    {
      alert("В количестве дней должны быть только цифры");
    }
    else
     {
       if ((pattern).test(hours) || hours.length<=0)
        {
          alert("В количестве часов должны быть только цифры");
        }
        else
        {
          if ((pattern).test(minutes) || minutes.length<=0)
          {
            alert("В количестве минут должны быть только цифры");
          }
          else
          {
            if ((pattern).test(seconds) || seconds.length<=0)
            {
              alert("В количестве секунд должны быть только цифры");
            }
            else
            {
              var passwordToSave=$("#save_password").val();
              var dataToSend={id:id,days:days,hours:hours,minutes:minutes,seconds:seconds,password:passwordToSave};

              $.ajax(
                {
                  type: "POST",
                  data:dataToSend,
                  url: "../php/saveRefreshInterval.php",
                  dataType: "json",
                  success: function(response)
                  {
                    if (response.intervals)
                    {
                      var intervals=response;
                      var length=intervals.length;
                      for (var id=0;id<length;id++)
                      {
                        $(".days[data-id="+id+"]").val(intervals[id].days);
                        $(".hours[data-id="+id+"]").val(intervals[id].hours);
                        $(".minutes[data-id="+id+"]").val(intervals[id].minutes);
                        $(".seconds[data-id="+id+"]").val(intervals[id].seconds);
                      }

                      $(".saveRefreshInterval[type=button][data-id="+buttonId+"]").removeClass('new');
                      alert("ok");
                    }

                  },
                  error:function(xml){alert("error")}
                });
            }

          }
        }
    }
  });
});
