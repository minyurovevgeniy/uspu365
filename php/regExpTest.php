<?php
  date_default_timezone_set('Asia/Yekaterinburg');

  function deleteUnnecessarySpacesFromString($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean the end
		$cleanString=preg_replace("/\s{1,}$/i",'',$cleanString);
		// clean middle spaces
		$cleanString=preg_replace("/\b\s{2,}\b/i",' ',$cleanString);
		// clean the beginning
		$cleanString=preg_replace("/^\s{1,}/i",'',$cleanString);

		return $cleanString;
	}

	function deleteAllSpacesFromString($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean the whole line
		$cleanString=preg_replace("/\s{1,}/i",'',$cleanString);

		return $cleanString;
	}

  function deleteSpacesFromProfileName($stringToClean)
	{
		$cleanString=$stringToClean;
		// clean before dot
		$cleanString=preg_replace("/\s{1,}\./",'.',$cleanString);
    // clean after dot
		$cleanString=preg_replace("/\.\s{0,}/i",'. ',$cleanString);
		return $cleanString;
	}

  $string=' привет   test   ';
  echo $string."(".$length.")<br>";
  //$string=iconv("utf-8","cp1251",' dfse   test   ');

  $string=iconv("utf-8","cp1251",$string);
  $length=mb_strlen($string);
  echo iconv("cp1251","utf-8",$string)."(".$length.")<br>";
  /*
  $string=preg_replace("/\s{1,}$/i",'',$string);
  $length=mb_strlen($string);
  echo $string."(".$length.")<br>";

  $string=preg_replace("/\b\s{2,}\b/i",' ',$string);
  $length=mb_strlen($string);
  echo $string."(".$length.")<br>";

  $string=preg_replace("/^\s{1,}/i",'',$string);*/


  $cleanString=deleteUnnecessarySpacesFromString($string);
  $length=mb_strlen($cleanString);
  echo iconv("cp1251","utf-8",$cleanString)."(".$length.")<br>";

  $cleanString=deleteAllSpacesFromString($string);
  $length=mb_strlen($cleanString);
  echo iconv("cp1251","utf-8",$cleanString)."(".$length.")<br>";

  $string="Педагогическое образование    .    Английиский язык";
  $length=mb_strlen($string);
  echo $string." (".$length.")<br>";

  $string=iconv("utf-8","cp1251",$string);
  $cleanString=deleteSpacesFromProfileName($string);
  $length=mb_strlen(iconv("cp1251","utf-8",$cleanString));
  echo iconv("cp1251","utf-8",$cleanString)." (".$length.")<br>";
?>
