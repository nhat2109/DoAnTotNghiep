<?php
	$page = intval($_REQUEST['page']);
	$key = addslashes(strip_tags($_REQUEST['key']));
	$tach_key = explode(' ', $key);
	$k = 0;
	foreach ($tach_key as $key => $value) {
		$k++;
		if ($value != '') {
			if ($k == 1) {
				$where .= "tieu_de LIKE '%$value%'";
			} else {
				$where .= " AND tieu_de LIKE '%$value%'";
			}
		}
	}
	$limit = 25;
	$start = $page * $limit - $limit;
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE $where AND shop='$user_id' ORDER BY id DESC");
	$i = 0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$i++;
		$r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
		$r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
		$list .= $skin->skin_replace('skin_dropship/box_action/li_product_deal', $r_tt);
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