<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$class_viettel=$tlca_do->load('class_viettel');
$tinh=intval($_REQUEST['tinh']);
$thongtin_tinh=mysqli_query($conn,"SELECT * FROM tinh_viettel WHERE id='$tinh'");
$total_tinh=mysqli_num_rows($thongtin_tinh);
if($total_tinh==0){
	echo 'Đã hết dữ liệu';
}else{
	$r_t=mysqli_fetch_assoc($thongtin_tinh);
	$xxx=$class_viettel->get_huyen($r_t['PROVINCE_ID']);
	$kq=json_decode($xxx,true);
	foreach ($kq['data'] as $key => $value) {
		$thongtin=mysqli_query($conn,"SELECT * FROM huyen_viettel WHERE DISTRICT_ID='{$value['DISTRICT_ID']}'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ten=addslashes($value['DISTRICT_NAME']);
			mysqli_query($conn,"INSERT INTO huyen_viettel(DISTRICT_ID,DISTRICT_VALUE,DISTRICT_NAME,PROVINCE_ID)VALUES('{$value['DISTRICT_ID']}','{$value['DISTRICT_VALUE']}','$ten','{$value['PROVINCE_ID']}')");
			echo $value['DISTRICT_NAME'].' - '.$r_t['PROVINCE_NAME'].'<br>';

		}
	}
	$id_moi=$tinh + 1;	
	echo "<title>Đang chuyển hướng để tiếp tục copy...</title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	echo "<center><img src='/images/load.gif' width='50'></center>";
	echo "<center><font color=red>Đang chuyển hướng để copy tiếp...</font></center>";
	echo "<meta http-equiv='refresh' content='0;url=/update_huyen.php?tinh=".$id_moi."'>";
}
?>