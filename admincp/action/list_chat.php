<?php
    if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title'] = 'Danh sách yêu cầu hỗ trợ';
	$thaythe['title_action'] = 'Danh sách yêu cầu hỗ trợ';
	$limit = 100;
	if($user_info['bo_phan']=='all'){
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.active='1' AND chat.noi_dung='' ORDER BY chat.id DESC LIMIT 1");
	}else{
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.active='1' AND chat.bo_phan='{$user_info['bo_phan']}' AND chat.noi_dung='' ORDER BY chat.id DESC LIMIT 1");
	}
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$list_chat='';
		$list_yeucau='';
		$ho_ten='';
		$note='';
		$phien='';
		$thanh_vien='';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['thanh_vien']}'");
		$r_user=mysqli_fetch_assoc($thongtin_thanhvien);
		$phien=$r_tt['phien'];
		$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
		$r_c=mysqli_fetch_assoc($thongtin_cuoi);
		$sms_id=$r_c['id'] + 1;
		$tach_chat=json_decode($class_index->list_chat($conn,$user_info['id'],$user_info['name'],$user_info['avatar'],$r_user['name'],$r_user['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
		$list_yeucau=$class_index->list_yeucau($conn,$user_info['id'],$user_info['bo_phan'],$r_c['thanh_vien']);
		$ho_ten=$r_tt['name'];
		$note=$r_tt['tieu_de'];
		$thanh_vien=$r_c['thanh_vien'];
	}
	$bien=array(
		'ok'=>1,
		'list_chat'=>$tach_chat['list'],
		'list_yeucau'=>$list_yeucau,
		'ho_ten'=>$ho_ten,
		'note'=>$note,
		'phien'=>$phien,
		'thanh_vien'=>$thanh_vien,
		'user_id'=>$user_info['id'],
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_chat', $bien);
?>