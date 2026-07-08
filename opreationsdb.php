<?php
include_once 'session.php';
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
$foodid=(int)0;
$UsrId =(int)0;
$IsAdd=(int)0;
$type=(int)0;
//start session 
if ($IsUnLogin) { //if does not session set to redirect this page index.php
header('location:index.php');
} else {
  $UsrId = (int) $_SESSION['Id'];
}
if (isset($_POST['foodid'])) {
	$foodid = (int)$_POST['foodid'];
	$IsAdd = (int)$_POST['IsAdd'];
	$type = (int)$_POST['type'];
}
if($foodid>0)
{
if(	$IsAdd==0)
{
$query = "delete from mycart where foodid=$foodid and usrid=$UsrId and type=$type";
$result = $db->deletedb($query);
}
else
{
$query = "select * from mycart where foodid=$foodid and usrid=$UsrId and type=$type";
$num_row = $db->getRows($query);
$result=true;
if ($num_row <= 0) {
$query = "insert into mycart(foodid,usrid,type) values($foodid,$UsrId,$type)";
$result = $db->insert($query);
}
}
if ($result) {
	echo "success";
}
}
?>