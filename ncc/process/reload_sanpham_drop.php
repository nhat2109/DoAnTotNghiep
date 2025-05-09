<?php
	$kieu=addslashes($_REQUEST['kieu']);
	$limit = 50;
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
	$total_follow=mysqli_num_rows($thongtin_follow);
	if($total_follow==0){
		$list_follow='';
	}else{
		$r_fl=mysqli_fetch_assoc($thongtin_follow);
		$list_follow=$r_fl['sanpham'];
	}
	if($kieu=='mobile'){
		$list = $class_index->list_sanpham_drop($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho,$sort, 1, $limit);
	}else{
		$list = $class_index->list_sanpham_drop($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho,$sort, 1, $limit);
	}
	$info = array(
		'list' => $list,
		'page' => 2,
		'kieu'=>$kieu
	);
	echo json_encode($info);
?>