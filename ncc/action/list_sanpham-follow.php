<?php
	$thaythe['title'] = 'Theo dõi sản phẩm quan tâm';
	$thaythe['title_action'] = 'Theo dõi sản phẩm quan tâm';
	$limit = 10;
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	if($check->is_mobile()==true){
		$kieu='mobile';
	}else{
		$kieu='laptop';
	}
	$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
	$total_follow=mysqli_num_rows($thongtin_follow);
	if($total_follow==0){
		$bien=array(
			'list_sanpham'=>'',
			'phantrang'=>''
		);
	}else{
		$r_fl=mysqli_fetch_assoc($thongtin_follow);
		$list_id=$r_fl['sanpham'];
		if($list_id==''){
			$bien=array(
				'list_sanpham'=>'',
				'phantrang'=>''
			);
		}else{
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE id IN ($list_id)");
			$r_tk = mysqli_fetch_assoc($thongke);
			$total_page = ceil($r_tk['total'] / $limit);
			$bien = array(
				'list_sanpham' => $class_index->list_sanpham_follow($conn,$list_id,$user_info['leader'],$user_info['gia_leader'],$kieu, $kho,'kho-asc', $page, $limit),
				'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-follow'),
			);
		}
	}
	if($kieu=='mobile'){
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_follow_mobile', $bien);
	}else{
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_follow', $bien);
	}
?>