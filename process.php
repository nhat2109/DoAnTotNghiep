<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root=array('tongkho.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if (in_array($web, $web_root) == false) {
	include './shop/process.php';
	exit();
}
?>