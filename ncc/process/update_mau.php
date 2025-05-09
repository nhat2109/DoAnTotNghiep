<?php
	$list_mau = addslashes(strip_tags($_REQUEST['list_mau']));
	$tach_mau = explode('|', $list_mau);
	foreach ($tach_mau as $key => $value) {
		if (strlen($value) > 2) {
			$tach_value = explode('&&', $value);
			$sp_id = $tach_value[0];
			$ma = $tach_value[1];
			$_SESSION['drop_cart'][$sp_id]['color'] = $ma;
		}
	}
	echo json_encode(array('ok' => 1, 'thongbao' => 'Hệ thống đang chuyển hướng'));
?>