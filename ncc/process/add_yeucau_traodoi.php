<?php
	$hientai=time();
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$quy_trinh=addslashes(strip_tags($_REQUEST['quy_trinh']));
	$thanh_vien=$user_id;
	$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$thanh_vien'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($quy_trinh==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn bộ phận hỗ trợ';
	}else if(strlen($noi_dung)<2){
		$ok=0;
		$thongbao='Chưa nhập nội dung lưu ý';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE thanh_vien='$thanh_vien' AND active='1'");
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			$ok=0;
			$thongbao='Thất bại! Bạn có yêu cầu đang được xử lý';
		}else{
			$ok=1;
			$thongbao='Thành công! Yêu cầu hỗ trợ đã được gửi';
			$phien_traodoi=$class_index->creat_random($conn,'phien_traodoi');
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien_traodoi','$quy_trinh','$noi_dung','$thanh_vien','0','$user_id','','0','1','$hientai')");
			$thay=array(
				'ho_ten'=>$r_tt['name'],
				'mobile'=>$r_tt['mobile'],
				'tieu_de'=>$noi_dung,
				'phien'=>$phien_traodoi,
				'date_post'=>'Vừa xong',
				'thanh_vien'=>$thanh_vien,
				'active'=>'active'
			);
			$list=$skin->skin_replace('skin_ncc/box_action/li_yeucau', $thay);
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'thanh_vien'=>$thanh_vien,
		'ho_ten'=>$r_tt['name'],
		'phien'=>$phien_traodoi,
		'list'=>$list,
		'bo_phan'=>$quy_trinh,
		'phien_traodoi'=>$phien_traodoi,
	);
	echo json_encode($info);
?>