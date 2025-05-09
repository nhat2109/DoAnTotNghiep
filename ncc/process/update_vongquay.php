<?php
	$giai=addslashes($_REQUEST['giai']);
	$thongtin=mysqli_query($conn,"SELECT * FROM quay_thuong WHERE user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO quay_thuong(user_id,giai_thuong,noi_dung,status,date_post)VALUES('$user_id','$giai','','0','$hientai')");
	}else{

	}
?>