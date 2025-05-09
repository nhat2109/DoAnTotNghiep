<?php
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$sms_id=intval($_REQUEST['sms_id']);
	$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id' ORDER BY id DESC LIMIT 1");
	$r_c=mysqli_fetch_assoc($thongtin_cuoi);
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
		'thanh_vien'=>$user_id,
		'load_chat'=>$tach_chat['load'],
		'user_id'=>$user_id,
	);
	echo json_encode($info);
?>