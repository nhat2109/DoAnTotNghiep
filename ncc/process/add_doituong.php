<?php
	$khach=addslashes($_REQUEST['khach']);
	if($khach=='san'){
		$bien=array(
			'option_tinh'=>$class_viettel->option_tinh('')
		);
		$html = $skin->skin_replace('skin_ncc/box_action/box_khach_san',$bien);
	}else if($khach=='socdo'){
		$bien=array(
			'option_tinh'=>$class_viettel->option_tinh('')
		);
		$html = $skin->skin_replace('skin_ncc/box_action/box_khach_socdo',$bien);
	}
	$info=array(
		'html'=>$html,
		'ok'=>1
	);
	echo json_encode($info);
?>