<?php
	$sp_id=intval($_REQUEST['sp_id']);
	$size=intval($_REQUEST['size']);
	$tach_list_color=json_decode($class_index->list_phanloai_color($conn,$sp_id,$size),true);
	$info = array(
		'ok'=>1,
		'list'=>$tach_list_color['list_option_color']
	);
	echo json_encode($info);
?>