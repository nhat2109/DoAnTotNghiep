<?php
	$thaythe['title'] = 'Cài đặt tích điểm';
	$thaythe['title_action'] = 'Cài đặt tích điểm';
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM caidat_tichdiem WHERE shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$r_tt['diem'] = 0;
	} else {
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_tichdiem', $r_tt);
?>