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
if ($action == 'donhang_drop') {
	$expired=time() - 25*24*3600;
	$expired_vc=time() - 20*24*3600;
	mysqli_query($conn,"UPDATE donhang SET status='5' WHERE status='1' AND date_update<'$expired' AND date_update!=''");
	mysqli_query($conn,"UPDATE donhang SET status='5' WHERE status='2' AND date_update<'$expired_vc' AND date_update!=''");
	mysqli_query($conn,"UPDATE donhang SET status='5' WHERE status='1' AND date_update='' AND date_post<'$expired'");
	mysqli_query($conn,"UPDATE donhang SET status='5' WHERE status='2' AND date_update='' AND date_post<'$expired'");
	echo 'ok';
}else if($action=='naptien'){
	$expired=time() - 48*3600;
	mysqli_query($conn,"UPDATE naptien SET status='2' WHERE status='0' AND date_post<'$expired'");
	echo 'ok';

}else if($action=='update_price'){
	$hientai=time();
	$thongtin=mysqli_query($conn,"SELECT sanpham_tuan.*,sanpham.drop_min FROM sanpham_tuan LEFT JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham_tuan.time_start<='$hientai' AND sanpham_tuan.time_end>'$hientai' AND sanpham_tuan.update_price='0'");
	while($r_tt=mysqli_fetch_assoc($thongtin)){
		if($r_tt['gia_ctv_tuan']==0){
			$gia_ctv= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
		}else{
			$gia_ctv= $r_tt['gia_ctv_tuan'];
		}
		mysqli_query($conn,"UPDATE sanpham SET gia_drop='{$r_tt['gia_tuan']}',gia_ctv='$gia_ctv' WHERE id='{$r_tt['sp_id']}'");
		mysqli_query($conn,"UPDATE sanpham_tuan SET update_price='1' WHERE id='{$r_tt['id']}'");

	}
	$thongtin_cu=mysqli_query($conn,"SELECT sanpham_tuan.*,sanpham.drop_min FROM sanpham_tuan LEFT JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham_tuan.time_end<'$hientai' AND sanpham_tuan.update_price<'2'");
	while($r_c=mysqli_fetch_assoc($thongtin_cu)){
		if($r_c['gia_ctv_truoc']==0){
			$gia= $r_c['gia_truoc'] + (($r_c['drop_min'] - $r_c['gia_truoc'])*0.3);
		}else{
			$gia= $r_c['gia_ctv_truoc'];
		}
		mysqli_query($conn,"UPDATE sanpham SET gia_drop='{$r_c['gia_truoc']}',gia_ctv='$gia' WHERE id='{$r_c['sp_id']}'");
		mysqli_query($conn,"UPDATE sanpham_tuan SET update_price='2' WHERE id='{$r_c['id']}'");
	}

}else if($action=='export_sanpham'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM sanpham WHERE id>='$id' ORDER BY id ASC LIMIT 1");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$thongtin_conlai=mysqli_query($conn,"SELECT * FROM sanpham WHERE id>'$id'");
		$total_con=mysqli_num_rows($thongtin_conlai);
		if($total_con>0){
			$info=array(
				'ok'=>0,
				'thongbao'=>'Sản phẩm không tồn tại'
			);
		}else{
			$info=array(
				'ok'=>2,
				'thongbao'=>'Đã copy toàn bộ sản phẩm'
			);
		}
		echo json_encode($info);
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$r_tt['ok']=1;
		$r_tt['thongbao']='Lấy thông tin thành công';
		echo json_encode($r_tt);
	}

} else {
	echo "Không có hành động nào được xử lý";
}
?>