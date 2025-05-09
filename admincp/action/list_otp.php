<?php 
	$thaythe['title']='Danh sách mã OTP';
	$thaythe['title_action']='Danh sách mã OTP';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT * FROM code_otp");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total=mysqli_num_rows($thongke);
	$total_page=ceil($total/$limit);
	$bien=array(
		'list_otp'=>$class_index->list_otp($conn,$total,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-otp')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_otp',$bien);
?>