<?php
	$link=addslashes(strip_tags($_REQUEST['link']));
	$thongtin=mysqli_query($conn,"SELECT * FROM category_video WHERE link='$link'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thaythe['title'] = $r_tt['tieu_de'];
	$thaythe['title_action'] = $r_tt['tieu_de'];
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM video WHERE loai LIKE '%all%' OR loai LIKE '%drop%'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'tieu_de'=>$r_tt['tieu_de'],
		'list_video' => $class_index->list_video_category($conn,$r_tt['id'], $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/danh-muc-video/'.$link),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_video_category', $bien);
?>