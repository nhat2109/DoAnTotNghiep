<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('tongkho.vn','socdo.vn','soc.vn','socdo.xyz');
if(in_array($web, $web_root)==false){
	include('./shop/ban_hang.php');
	exit();
}

?>