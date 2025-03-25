<?php
error_reporting(0);
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('tongkho.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$page=intval($page);
if($page>1){
	$page=$page;
	$title_page=' - Page '.$page;
}else{
	$page=1;
	$title_page='';
}
$sort=addslashes($url_query['sort']);
$affgroup=intval($url_query['affgroup']);
if($affgroup>0){
	if(isset($_COOKIE['affgroup'])){
		setcookie("affgroup",$_COOKIE['affgroup'],time() - 3600,'/');
		setcookie("affgroup",$affgroup,time() + 1296000,'/');
	}else{
		setcookie("affgroup",$affgroup,time() + 1296000,'/');
	}
}
if(in_array($web, $web_root)==false){
	include('./shop/dangky.php');
	exit();
}
?>