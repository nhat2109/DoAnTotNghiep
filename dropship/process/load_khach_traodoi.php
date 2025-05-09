<?php
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.noi_dung='' AND chat.phien='$phien' ORDER BY chat.id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['thanh_vien']!=$user_id){
		$ok=0;
		$thongbao='Bạn không có quyền xem phiên yêu cầu này';
		$info=array(
			'ok'=>$ok,
			'thongbao'=>$thongbao
		);
	}else{
		$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
		$r_c=mysqli_fetch_assoc($thongtin_cuoi);
		$sms_id=$r_c['id'] + 1;
		$tach_chat=json_decode($class_index->list_chat($conn,$user_id,$user_info['name'],$user_info['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
		$list_yeucau=$class_index->list_yeucau($conn,$user_id,$phien);
		$note=$r_tt['tieu_de'];
		$info=array(
			'ok'=>1,
			'list_chat'=>$tach_chat['list'],
			'list'=>$list_yeucau,
			'note'=>$note,
			'phien'=>$phien,
			'active'=>$r_tt['active'],
			'load_chat'=>$tach_chat['load'],
			'thanh_vien'=>$user_id,
			'user_id'=>$user_id,
		);
	}
	echo json_encode($info);
?>