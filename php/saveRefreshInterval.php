<?php
  session_start();
  if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  date_default_timezone_set('Asia/Yekaterinburg');

  //if ($_POST['password']!="") die("Неверный пароль");


  $file=fopen("./refreshInterval.json","r");
  $response=fread($file,filesize("./refreshInterval.json"));
  fclose($file);

  $response=json_decode($response,true);

  $data=array();
  $data = $response['intervals'];

  $id=$_POST['id'];
  $days=$_POST['days'];
  $hours=$_POST['hours'];
  $minutes=$_POST['minutes'];
  $seconds=$_POST['seconds'];

  if ($days+$hours+$minutes+$seconds<=0)
  {
    $days="1";
    $hours="0";
    $minutes="0";
    $seconds="0";
  }

  /*
  $id=0;
  $days=1;
  $hours=2;
  $minutes=3;
  $seconds=4;
  */

  /*
  echo '<pre>';
  print_r($response);
  echo '</pre>';
  */

  //$response['intervals'][$id]=array
  $data[$id]=array
      (
           'days' => $days,
           'hours' => $hours,
           'minutes' => $minutes,
           'seconds' => $seconds
      );

  $response=array("intervals"=>$data);

  echo json_encode($response);

  $myfile = fopen("./refreshInterval.json", "w");
  fwrite($myfile,json_encode($response));
  fclose($myfile);
?>
