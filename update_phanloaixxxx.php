<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes(strip_tags($_REQUEST['action']));
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$x=0;
$thongtin=mysqli_query($conn,"SELECT * FROM sanpham ORDER BY id DESC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$x++;
	$ma_sp=$r_tt['ma_sanpham'];
	$gia_moi=$r_tt['gia_moi'];
	$gia_cu=$r_tt['gia_cu'];
	$gia_drop=$r_tt['gia_drop'];
	$drop_min=$r_tt['drop_min'];
	$gia_ctv=$r_tt['gia_ctv'];
	$id_sp=$r_tt['id'];
	//$color=$r_tt['mau'];
	$can_nang=$r_tt['can_nang'];
	$size=$r_tt['size'];
	$thongtin_size=mysqli_query($conn,"SELECT * FROM kich_co WHERE id='$size'");
	$r_size=mysqli_fetch_assoc($thongtin_size);
	$ten_size=$r_size['tieu_de'];
	$thongtin_phanloai=mysqli_query($conn,"SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}'");
	$list_pl=array();
	while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
		$sp_id=$r_tt['id'];
		$list_pl[$sp_id]['size'].=$r_tt['size'];
		$list_pl[$sp_id]['color'].=$r_tt['color'];
	}
	print_r($list_pl);
	if(strpos($ma_sp, '|')!==false){
		$tach_ma=explode('|', $ma_sp);
		foreach ($tach_ma as $key => $value) {
			$tach_value=explode('&&', $value);
			$color=intval($tach_value[0]);
			if(intval($color)>0){
				$thongtin_color=mysqli_query($conn,"SELECT * FROM mau_sanpham WHERE id='$color'");
				$r_color=mysqli_fetch_assoc($thongtin_color);
				$ma_mau=$r_color['ma_mau'];
				$ten_color=$r_color['tieu_de'];
			}
			$ma=$tach_value[2];
			if($list_pl[$id_sp]['size']==$size AND $list_pl[$id_sp]==$color){

			}else{

				mysqli_query($conn,"INSERT INTO phanloai_sanpham(user_id,sp_id,ma_sp,color,size,ten_size,ten_color,ma_mau,can_nang,gia_cu,gia_moi,gia_drop,gia_ctv,drop_min,date_post)VALUES('0','{$r_tt['id']}','$ma','$color','$size','$ten_size','$ten_color','$ma_mau','$can_nang','$gia_cu','$gia_moi','$gia_drop','$gia_ctv','$drop_min',".time().")");
				echo 'Đã thêm '.$ma.' - '.$tach_value[1].'- '.$r_tt['tieu_de'].'<br>';
			}
		}
	}else{
		$tach_value=explode('&&', $r_tt['ma_sanpham']);
		$color=$tach_value[0];
		$ma=$tach_value[2];
			if(intval($color)>0){
				$thongtin_color=mysqli_query($conn,"SELECT * FROM mau_sanpham WHERE id='$color'");
				$r_color=mysqli_fetch_assoc($thongtin_color);
				$ma_mau=$r_color['ma_mau'];
				$ten_color=$r_color['tieu_de'];
			}
		if($list_pl[$id_sp]['size']==$size AND $list_pl[$id_sp]==$color){

		}else{
			mysqli_query($conn,"INSERT INTO phanloai_sanpham(user_id,sp_id,ma_sp,color,size,ten_size,ten_color,ma_mau,can_nang,gia_cu,gia_moi,gia_drop,gia_ctv,drop_min,date_post)VALUES('0','{$r_tt['id']}','$ma','$color','$size','$ten_size','$ten_color','$ma_mau','$can_nang','$gia_cu','$gia_moi','$gia_drop','$gia_ctv','$drop_min',".time().")");
			echo 'Đã thêm '.$ma.' - '.$tach_value[1].'- '.$r_tt['tieu_de'].'<br>';
		}

	}
}
?>