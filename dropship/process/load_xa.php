<?php
	$tinh = intval($_REQUEST['tinh']);
	$huyen = intval($_REQUEST['huyen']);
	$congty_ship=addslashes($_REQUEST['congty_ship']);
	if($congty_ship=='ninja_van'){
		$list=$class_index->list_option_xa_ninja($conn,$tinh,$huyen,'');
	}else{
		$list=$class_viettel->option_xa($huyen,'');
	}
	echo json_encode(array('list' => $list));
?>