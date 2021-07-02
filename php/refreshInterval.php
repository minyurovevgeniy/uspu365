<?php
  session_start();
  if ($_SESSION['mdf843hrk52']<=0 or !isset($_SESSION['mdf843hrk52'])) die("OK");

  date_default_timezone_set('Asia/Yekaterinburg');

  $file=fopen("./refreshInterval.json","r");
  $dataInJson=fread($file,filesize("./refreshInterval.json"));
  fclose($file);
  /*echo '<pre>';
  print_r($dataInJson);
  echo '</pre>';
  */

  echo $dataInJson;
  ?>
