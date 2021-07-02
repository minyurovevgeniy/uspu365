<?
	$host="localhost";
	$dbname="dod";
	$charset="utf8";
	$dsn = "mysql:host=".$host.";dbname=".$dbname.";charset=".$charset;
	$user="root";
	$pass="";
	$opt = array
	(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$stmt='';
?>