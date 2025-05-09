<?php
	$page = intval($_REQUEST['page']);
	$list_id = addslashes(strip_tags($_REQUEST['list_id']));
	$limit = 25;
	$start = $page * $limit - $limit;
	$list_id = substr($list_id, 0, -1);
	$kieu = addslashes(strip_tags($_REQUEST['kieu']));
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$user_id' ORDER BY id DESC");
	$i = 0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$i++;
		$r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
		$r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
		if ($kieu == 'tang') {
			$r_tt['gia_deal'] = 0;
			$r_tt['sale_deal'] = 100;
			$list .= $skin->skin_replace('skin_dropship/box_action/li_product_sub_tang', $r_tt);
		} else if ($kieu == 'muakem') {
			$r_tt['gia_deal'] = '';
			$r_tt['sale_deal'] = '';
			$list .= $skin->skin_replace('skin_dropship/box_action/li_product_sub_deal', $r_tt);
		} else {
			$r_tt['gia_deal'] = '';
			$r_tt['sale_deal'] = '';
			$list .= $skin->skin_replace('skin_dropship/box_action/li_product_flash_sale', $r_tt);

		}
	}
	$tiep = 0;
	$page++;
	$info = array(
		'page' => $page,
		'tiep' => $tiep,
		'list' => $list,
	);
	echo json_encode($info);
?>