<?php
	$thaythe['title'] = 'Đặt lịch live stream';
	$thaythe['title_action'] = 'Đặt lịch live stream';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM idol WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-idol',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$param_video = parse_url($r_tt['video']);
	parse_str($param_video['query'], $video_query);
	$r_tt['ma_video'] = addslashes($video_query['v']);
	$r_tt['date_start'] = date('H:i d/m/Y', $r_tt['date_start']);
	$r_tt['date_end'] = date('H:i d/m/Y', $r_tt['date_end']);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_livestream', $r_tt);
?>