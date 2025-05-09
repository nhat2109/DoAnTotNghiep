<?php
	$page = intval($_REQUEST['page']);
	$limit = 25;
	$start = $page * $limit - $limit;
	$list_id = addslashes(strip_tags($_REQUEST['list_id']));
	if ($list_id == '') {
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE shop='$user_id' ORDER BY id DESC LIMIT $start,$limit");

	} else {
		$list_id = substr($list_id, 0, -1);
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id NOT IN ($list_id) AND shop='$user_id' ORDER BY id DESC LIMIT $start,$limit");
	}
	$i = 0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$i++;
		$r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
		$r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
		$list .= $skin->skin_replace('skin_dropship/box_action/li_product_deal', $r_tt);
	}
	if ($i < $limit) {
		$tiep = 0;
	} else {
		$tiep = 1;
	}
	$page++;
	$info = array(
		'page' => $page,
		'tiep' => $tiep,
		'list' => $list,
	);
	echo json_encode($info);
?>