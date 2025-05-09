<?php 
    if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Thông tin thành viên';
	$thaythe['title_action']='Thông tin thành viên';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thành viên này không tồn tại...";
		$replace=array(
			'title'=>'Thành viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-thanhvien'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	if($r_tt['nhom']!=''){
		$thongtin_nhom=mysqli_query($conn,"SELECT *,count(*) AS total FROM nhom WHERE id='{$r_tt['nhom']}'");
		$r_nhom=mysqli_fetch_assoc($thongtin_nhom);
		if($r_nhom['total']>0){
			$r_tt['ten_nhom']=$r_nhom['tieu_de'];
		}else{
			$r_tt['ten_nhom']='Chưa tham gia nhóm';
		}

	}else{
		$r_tt['ten_nhom']='Chưa tham gia nhóm';
	}
	$r_tt['user_money']=number_format($r_tt['user_money']);
	$r_tt['user_money2']=number_format($r_tt['user_money2']);
	$r_tt['option_tinh'] = $class_index->list_option_tinh($conn,$r_tt['tinh']);
	$r_tt['option_huyen'] = $class_index->list_option_huyen($conn,$r_tt['tinh'],$r_tt['huyen']);
	$r_tt['option_xa'] = $class_index->list_option_xa($conn,$r_tt['huyen'],$r_tt['xa']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_thanhvien',$r_tt);
?>