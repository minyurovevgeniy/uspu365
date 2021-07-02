<?php
  include("./connect.php");

date_default_timezone_set('Asia/Yekaterinburg');
  $egeExams=array();
  $stmt=$pdo->prepare("SELECT * FROM `ege_exams`");
  $stmt->execute();
  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {
    $egeExams[$row['ege_id']]=iconv("cp1251","utf-8",$row['ege_abbr']);
  }

  /*
  echo '<pre>';
  print_r($egeExams);
  echo '</pre>';
  */

  $egeSets=array();
  //$stmt=$pdo->prepare("SELECT * FROM ege_sets LIMIT 24");
  $stmt=$pdo->prepare("SELECT * FROM `ege_sets`");
  $stmt->execute();
  while($row=$stmt->fetch(PDO::FETCH_LAZY))
  {
    $egeSets[$row['ege_set_id']][]=$egeExams[$row['ege']];
  }


  //echo '<hr>';
  /*
  echo '<pre>';
  print_r($egeSets);
  echo '</pre>';
  */

  foreach ($egeSets as $setId => $setContent)
  {
    asort($egeSets[$setId]);
  }

  /*
  echo '<hr>';
  echo '<pre>';
  print_r($egeSets);
  echo '</pre>';
  */

  $response=array();

  $egeSetSortedByABC=array();

  foreach ($egeSets as $setId => $setContent)
  {
    $egeSetSortedByABC['ege_sets'][$setId]=implode(" ",$setContent);
    /*array
    (
      "ege_set_id"=>$setId,
      "ege_set_string"=>
    );*/
  }

  /*
  echo '<hr>';
  echo '<pre>';
  print_r($egeSetSortedByABC);
  //echo json_encode($response);
  echo '</pre>';
  */

  asort($egeSetSortedByABC['ege_sets']);

  /*echo '<hr>';
  echo 'Sorted by ABC <br>';
  echo '<pre>';
  print_r($egeSetSortedByABC);
  //echo json_encode($response);
  echo '</pre>';
  */

  $response=array();

  foreach ($egeSetSortedByABC['ege_sets'] as $EGEsetId => $EGEsetString)
  {
    $response['ege_sets'][]=
    array
    (
      "ege_set_id"=>(string)$EGEsetId,
      "ege_set_string"=>$EGEsetString
    );
  }


/*
  echo '<hr>';
  echo 'Final result <br>';
  echo '<pre>';
  print_r($response);
  echo '</pre>';
*/

  echo json_encode($response);

  include("./disconnect.php");
?>
