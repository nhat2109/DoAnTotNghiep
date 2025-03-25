<?php
include('./includes/tlca_world.php');
include_once("./class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_index');
$class_member=$tlca_do->load('class_member');
if(isset($_REQUEST['link'])){
	$link=strip_tags(addslashes($_REQUEST['link']));
	$xxx=$check->getpage($link,$link);
	preg_match_all('/data-src="(.*?)"/is',$xxx, $tach_link);
	foreach ($tach_link[1] as $key => $value) {
		echo $value.'<br>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lọc link ảnh</title>
</head>
<body>
	<form action="/loc_anh.php">
	<input type="text" name="link">
	<button type="submit">Lọc ảnh</button>		
	</form>

</body>
</html>