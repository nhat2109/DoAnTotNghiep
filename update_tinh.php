<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$class_viettel=$tlca_do->load('class_viettel');
$xxx=$class_viettel->get_tinh($tinh);
$kq=json_decode($xxx,true);
foreach ($kq['data'] as $key => $value) {
	$thongtin=mysqli_query($conn,"SELECT * FROM tinh_viettel WHERE PROVINCE_ID='{$value['PROVINCE_ID']}'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO tinh_viettel(PROVINCE_ID,PROVINCE_CODE,PROVINCE_NAME)VALUES('{$value['PROVINCE_ID']}','{$value['PROVINCE_CODE']}','{$value['PROVINCE_NAME']}')");
		echo $value['PROVINCE_NAME'].'<br>';

	}
}
/*$thongbao="Dữ liệu không tồn tại.";
$replace=array(
	'title'=>'Dữ liệu không tồn tại',
	'thongbao'=>$thongbao,
	'link'=>'/'
);
echo $skin->skin_replace('skin/chuyenhuong',$replace);*/
?>