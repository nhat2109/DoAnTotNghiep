<?php
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM video WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Video không tồn tại...";
		$replace = array(
			'title' => 'Video không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-video',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$thaythe['title'] = $r_tt['tieu_de'];
	$thaythe['title_action'] = 'Học viên socdo.vn';
	$param_video = parse_url($r_tt['link_video']);
	parse_str($param_video['query'], $video_query);
	$id_video = addslashes($video_query['v']);
	$r_tt['id_video'] = $id_video;
	$r_tt['list_video_right'] = $class_index->list_video_right($conn, $id, 24);
	$moi = $r_tt['view'] + 1;
	mysqli_query($conn, "UPDATE video SET view='$moi' WHERE id='$id'");
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/view_video', $r_tt);
?>