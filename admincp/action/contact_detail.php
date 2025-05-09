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
	$thaythe['title']='Chi tiết liên hệ';
	$thaythe['title_action']='Chi tiết liên hệ';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM contact WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Liên hệ không tồn tại...";
		$replace=array(
			'title'=>'Liên hệ không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-contact'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	mysqli_query($conn, "UPDATE contact SET status='1' WHERE id='$id'");
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/contact_detail',$r_tt);
?>