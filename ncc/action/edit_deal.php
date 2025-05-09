<?php
	$thaythe['title'] = 'Sửa deal sốc';
	$thaythe['title_action'] = 'Sửa deal sốc';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM deal WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-deal',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['date_start'] = date('H:i d/m/Y', $r_tt['date_start']);
	$r_tt['date_end'] = date('H:i d/m/Y', $r_tt['date_end']);
	$list_id = $r_tt['main_product'] . ',' . $r_tt['sub_id'];
	$tach_main = explode(',', $r_tt['main_product']);
	$tach_sub = explode(',', $r_tt['sub_id']);
	$tach_sp_sub = json_decode($r_tt['sub_product'], true);
	$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$user_id' ORDER BY id DESC");
	while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
		$r_sp['gia_cu'] = number_format($r_sp['gia_cu']) . 'đ';
		$r_sp['gia_moi'] = number_format($r_sp['gia_moi']) . 'đ';
		if (in_array($r_sp['id'], $tach_main) == true) {
			$list_main .= $skin->skin_replace('skin_ncc/box_action/li_product_main_deal', $r_sp);
		} else if (in_array($r_sp['id'], $tach_sub) == true) {
			$sp_id = $r_sp['id'];
			$r_sp['gia_deal'] = $tach_sp_sub[$sp_id]['gia'];
			$r_sp['sale_deal'] = $tach_sp_sub[$sp_id]['sale'];
			if ($r_tt['loai'] == 'tang') {
				$list_sub .= $skin->skin_replace('skin_ncc/box_action/li_product_sub_tang', $r_sp);
			} else {
				$list_sub .= $skin->skin_replace('skin_ncc/box_action/li_product_sub_deal', $r_sp);
			}
		}
	}
	$r_tt['list_main'] = $list_main;
	$r_tt['list_sub'] = $list_sub;
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_deal', $r_tt);
?>