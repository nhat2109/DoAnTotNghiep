<?php
	$thaythe['title'] = 'Danh sách deal sốc';
	$thaythe['title_action'] = 'Danh sách deal sốc';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM deal WHERE shop='$user_id' AND (loai='muakem' OR loai='tang')");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_deal' => $class_index->list_deal($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-deal'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_deal', $bien);
?>