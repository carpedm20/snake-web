<?
$mysql_host = ""
$mysql_id = ""
$mysql_passwd = ""
$mysql_db = ""

$connect = mysql_connect($mysql_host, $mysql_id, $mysql_passwd) or die("Mysql 접속실패");
$db_con = mysql_select_db($mysql_db,$connect) or die("데이터베이스 연결실패");
?>
