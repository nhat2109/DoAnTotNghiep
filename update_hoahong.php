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
$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE leader='1' ORDER BY user_id DESC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$thongtin_quanly=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='{$r_tt['user_id']}' ORDER BY user_id ASC");
	$list_id='';
	while($r_ql=mysql_fetch_assoc($thongtin_quanly)){
		$list_id.=$r_ql['user_id'].',';
	}
	if($list_id==''){

	}else{
		$list_id=substr($list_id, 0,-1);
		$thongtin_dh = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_dh = mysqli_fetch_assoc($thongtin_dh)) {
			if ($r_dh['status'] == 5) {
				$thongtin_hh=mysqli_query($conn,"SELECT * FROM hoahong_nhom WHERE loai='drop' AND ma_don='{$r_dh['ma_don']}'");
			}
		}
		$doanhthu_nhom=intval(($doanhthu_nhom/100)*5);
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$ngay = date('d', $r_tt_ctv['date_post']);
			$ngay = intval($ngay);
			if ($r_tt_ctv['status'] == 5) {
				$donhang_ctv_nhom++;
				$doanhthu_ctv_nhom += $r_tt_ctv['tongtien'];
			}
		}
	}

}
?>