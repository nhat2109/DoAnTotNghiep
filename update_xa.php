<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$class_viettel=$tlca_do->load('class_viettel');
$huyen=intval($_REQUEST['huyen']);
$thongtin_huyen=mysqli_query($conn,"SELECT * FROM huyen_viettel WHERE id='$huyen'");
$total_huyen=mysqli_num_rows($thongtin_huyen);
if($total_huyen==0){
	echo 'Đã hết dữ liệu';
}else{
	$r_h=mysqli_fetch_assoc($thongtin_huyen);
	$xxx=$class_viettel->get_xa($r_h['DISTRICT_ID']);
	$kq=json_decode($xxx,true);
	foreach ($kq['data'] as $key => $value) {
		$thongtin=mysqli_query($conn,"SELECT * FROM xa_viettel WHERE WARDS_ID='{$value['WARDS_ID']}'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ten=addslashes($value['WARDS_NAME']);
			mysqli_query($conn,"INSERT INTO xa_viettel(WARDS_ID,WARDS_NAME,DISTRICT_ID)VALUES('{$value['WARDS_ID']}','$ten','{$value['DISTRICT_ID']}')");
			echo $value['WARDS_NAME'].' - '.$r_h['DISTRICT_NAME'].'<br>';

		}
	}
	$id_moi=$huyen + 1;	
	echo "<title>Đang chuyển hướng để tiếp tục copy...</title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	echo "<center><img src='/images/load.gif' width='50'></center>";
	echo "<center><font color=red>Đang chuyển hướng để copy tiếp...</font></center>";
	echo "<meta http-equiv='refresh' content='0;url=/update_xa.php?huyen=".$id_moi."'>";
}
?>