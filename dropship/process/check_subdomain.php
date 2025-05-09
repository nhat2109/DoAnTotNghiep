<?php
	$domain = addslashes(strip_tags($_REQUEST['domain']));
	$domain = $domain . '.socdo.vn';
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE domain='$domain'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$thongbao = '<i class="fa fa-warning"></i> Tên miền đã tồn tại';
	} else {
		$thongtin_domain_giaoviec = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain_giaoviec WHERE domain='$domain'");
		$r_tt_domain_giaoviec = mysqli_fetch_assoc($thongtin_domain_giaoviec);
		if ($r_tt_domain_giaoviec['total'] > 0) {
			$thongbao = '<i class="fa fa-warning"></i> Tên miền đã tồn tại';
		} else {
			$thongbao = '<button class="apply_subdomain bg_green">Sử dụng tên miền</button>';
		}
	}
	echo json_encode(array('ok' => 1, 'thongbao' => $thongbao));
?>