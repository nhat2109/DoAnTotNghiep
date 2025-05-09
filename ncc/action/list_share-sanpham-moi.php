<?php
	$thaythe['title']='Nội dung bán hàng';
	$thaythe['title_action']='Nội dung bán hàng';
	$limit=25;
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM sanpham WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='$id'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$tach_list=json_decode($class_index->list_share_sanpham_moi($conn,$id),true);
	$thongtin_rutgon=mysqli_query($conn,"SELECT * FROM rut_gon WHERE sp_id='$id' AND user_id='$user_id'");
	$total_rutgon=mysqli_num_rows($thongtin_rutgon);
	if($total_rutgon>0){
		$r_rut=mysqli_fetch_assoc($thongtin_rutgon);
		$rut_gon='https://socdo.xyz/v/'.$r_rut['rut_gon'];
	}else{
		$ma_rutgon=$class_index->creat_random($conn,'rut_gon');
		$link='https://socdo.vn/product/'.$r_tt['link'].'.html?utm_source='.$user_id;
		$rut_gon='https://socdo.xyz/v/'.$ma_rutgon;
		mysqli_query($conn,"INSERT INTO rut_gon(sp_id,link,rut_gon,user_id,click,date_post)VALUES('$id','$link','$ma_rutgon','$user_id','0','$hientai')");
	}
	if(strlen($tach_list['list'])<10){
		$list_noidung='Nội dung đang cập nhật';
	}else{
		$list_noidung=$tach_list['list'];
	}
	$bien=array(
		'tieu_de'=>$r_tt['tieu_de'],
		'id'=>$id,
		'mobile'=>$user_info['mobile'],
		'rut_gon'=>$rut_gon,
		'list_noidung'=>$list_noidung,
		'list_tab'=>$tach_list['list_tab'],
		'list_anh'=>$tach_list['list_photo_share'][0],
		'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/ncc/list-share-sahsanpham?id='.$id)
	);
	echo $skin->skin_replace('skin_ncc/box_action/list_share_sanpham_moi',$bien);
	exit();
?>