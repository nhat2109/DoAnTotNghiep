<?php
	$thaythe['title'] = 'Danh sách yêu cầu hỗ trợ';
	$thaythe['title_action'] = 'Danh sách yêu cầu hỗ trợ';
	$limit = 100;
	$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.thanh_vien='$user_id' AND chat.noi_dung='' ORDER BY chat.id DESC LIMIT 1");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$list_chat='';
		$list_yeucau='';
		$note='';
		$phien='';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$phien=$r_tt['phien'];
		$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
		$r_c=mysqli_fetch_assoc($thongtin_cuoi);
		$sms_id=$r_c['id'] + 1;
		$tach_chat=json_decode($class_index->list_chat($conn,$user_id,$user_info['name'],$user_info['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
		$list_yeucau=$class_index->list_yeucau($conn,$user_id,$r_c['phien']);
		$note=$r_tt['tieu_de'];
		$list_chat=$tach_chat['list'];
	}
	$bien=array(
		'ok'=>1,
		'list_chat'=>$list_chat,
		'list_yeucau'=>$list_yeucau,
		'note'=>$note,
		'phien'=>$phien,
		'user_id'=>$user_info['user_id'],
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_chat', $bien);
?>