<?php
	$hientai = time();
	$thongtin_noti=mysqli_query($conn,"SELECT * FROM notification WHERE admin='0' AND FIND_IN_SET($user_id,doc)<1 AND date_post>'{$user_info['created']}'");
	$total_noti=mysqli_num_rows($thongtin_noti);
	if($total_noti>9){
		$total_noti='9+';
	}

	$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE status='0' AND shop='$user_id'");
	$total = mysqli_num_rows($thongtin);
	if ($total > 9) {
		$total = '9+';
	}
	// $thongtin_quantam=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
	// $total_quantam=mysqli_num_rows($thongtin_quantam);
	// if($total_quantam==0){
	// 	$total_follow=0;
	// }else{
	// 	$r_qt=mysqli_fetch_assoc($thongtin_quantam);
	// 	if($r_qt['sanpham']==''){
	// 		$total_follow=0;
	// 	}else{
	// 		$list_id=$r_qt['sanpham'];
	// 		$thongtin_follow = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho='0' AND id IN ($list_id)");
	// 		$total_follow= mysqli_num_rows($thongtin_follow);
	// 		if ($total_follow > 9) {
	// 			$total_follow = '9+';
	// 		}
	// 	}
	// }
	// $thongtin_tuan = mysqli_query($conn, "SELECT * FROM sanpham_tuan WHERE time_end>'$hientai'");
	// $total_tuan = mysqli_num_rows($thongtin_tuan);
	// if ($total_tuan > 9) {
	// 	$total_tuan = '9+';
	// }
	// $thongtin_hethang = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10'");
	// $total_hethang = mysqli_num_rows($thongtin_hethang);
	// if ($total_hethang > 9) {
	// 	$total_hethang = '9+';
	// }
	// $thongtin_catma = mysqli_query($conn, "SELECT * FROM sanpham WHERE cat_ma='1'");
	// $total_catma = mysqli_num_rows($thongtin_catma);
	// if ($total_catma > 9) {
	// 	$total_catma = '9+';
	// }
	// $thongke_chat=mysqli_query($conn,"SELECT count(*) AS total FROM chat WHERE thanh_vien='$user_id' AND active='1' AND doc='0' AND tieu_de='' GROUP BY thanh_vien");
	// $r_chat=mysqli_fetch_assoc($thongke_chat);
	// $total_chat=intval($r_chat['total']);
	// if($total_chat>9){
	// 	$total_chat='9+';
	// }
	// $thongtin_thongbao = mysqli_query($conn, "SELECT * FROM thongbao WHERE (noi_dang LIKE '%all%' OR noi_dang LIKE '%drop%') AND date_post>='{$user_info['created']}' ORDER BY id DESC LIMIT 20");
	// $i = $start;
	// $total_thongbao=0;
	// while ($r_tb = mysqli_fetch_assoc($thongtin_thongbao)) {
	// 	$i++;
	// 	$tach_doc = explode(',', $r_tb['doc']);
	// 	if (in_array($user_id, $tach_doc) == true) {
	// 	} else {
	// 		$total_thongbao++;
	// 	}
	// }
	// if($total_thongbao>9){
	// 	$total_thongbao='9+';
	// }
	echo json_encode(array('total_noti'=>$total_noti,'total_chat'=>$total_chat,'total' => $total,'total_thongbao'=>$total_thongbao, 'total_tuan' => $total_tuan, 'total_hethang' => $total_hethang,'total_catma' => $total_catma,'total_follow'=>$total_follow));
?>