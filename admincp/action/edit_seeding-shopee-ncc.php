<?php 
    if(in_array('seeding', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Sửa gói dịch vụ seeding shopee NCC';
	$thaythe['title_action']='Sửa gói dịch vụ seeding shopee NCC';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM seeding_shopee_ncc WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Gói dịch vụ không tồn tại...";
		$replace=array(
			'title'=>'Gói dịch vụ không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-seeding-shopee-ncc'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
    $r_tt['gia_cu']=number_format($r_tt['gia_cu']);
    $r_tt['gia']=number_format($r_tt['gia']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_seeding_shopee_ncc',$r_tt);  
?>