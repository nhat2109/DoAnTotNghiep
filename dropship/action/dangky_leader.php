<?php
	$thaythe['title'] = 'Đăng ký làm nhà bán chuyên nghiệp';
	$thaythe['title_action'] = 'Đăng ký nhà bán chuyên nghiệp';
	$user_info['user_money'] = number_format($user_info['user_money']) . ' đ';
	if($user_info['doitac']=='knv'){
		$user_info['noidung_leader']=$index_setting['noidung_leader_knv'];
	}else{
		$user_info['noidung_leader']=$index_setting['noidung_leader'];
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/dangky_leader', $user_info);
?>