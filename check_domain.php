<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if (isset($_COOKIE['user_id'])) {
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
}
$hientai = time();
$expired = $hientai + 365 * 24 * 60 * 60;
if ($action == 'check_domain') {
	$domain = addslashes($_REQUEST['domain']);
	if(strpos($domain, 'socdo.vn') !== false){
		$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE domain='$domain'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
		} else {
			$thongtin_domain_giaoviec = mysqli_query($conn, "SELECT count(*) AS total FROM domain_giaoviec WHERE domain='$domain'");
			$r_tt_domain_giaoviec = mysqli_fetch_assoc($thongtin_domain_giaoviec);
			if ($r_tt_domain_giaoviec['total'] > 0) {
				$ok = 0;
				$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
			} else {
				$ok = 1;
				$message = 'Tên miền <b>' . $domain . '</b> có thể sử dụng!';
			}
		}
	}else{
		$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE domain='$domain'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
		} else {
			$domain = addslashes(strip_tags($_REQUEST['domain']));
			$link = 'https://api3.tadu.vn/api/domain/' . $domain . '/check';
			$kq = $check->getpage($link, $link);
			$tach_ketqua = json_decode($kq, true);
			if ($tach_ketqua['data']['is_exist'] == 1) {
				$ok = 0;
				$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
			} else if ($tach_ketqua['data']['is_exist'] == false) {
				$ok = 1;
				$message = 'Tên miền <b>' . $domain . '</b> có thể sử dụng!';
			} else {
				$ok = 0;
				$message = 'Tên miền <b>' . $domain . '</b>	 chưa cho phép đăng ký. Vui lòng chọn tên miền khác.';
			}
		}
	}
	echo json_encode(array('available' => $ok, 'message' => $message));
}else if($action == 'confirm_domain'){
	$domain = addslashes($_REQUEST['domain']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE domain='$domain'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
		$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
	}else{
		$thongtin_domain_giaoviec = mysqli_query($conn, "SELECT count(*) AS total FROM domain_giaoviec WHERE domain='$domain'");
		$r_tt_domain_giaoviec = mysqli_fetch_assoc($thongtin_domain_giaoviec);
		if ($r_tt_domain_giaoviec['total'] > 0) {
			$ok = 0;
			$message = 'Tên miền <b>' . $domain . '</b> đã được sử dụng. Vui lòng chọn tên miền khác.';
		}else{
			$thongtin_domain_user = mysqli_query($conn, "SELECT count(*) AS total FROM domain_giaoviec WHERE user_id='$user_id'");
			$r_tt_domain_user = mysqli_fetch_assoc($thongtin_domain_user);
			if ($r_tt_domain_user['total'] > 0) {
				$ok = 1;
				mysqli_query($conn, "UPDATE domain_giaoviec SET domain='$domain' WHERE user_id='$user_id'");
				$message = 'Sử dụng tên miền <b>' . $domain . '</b> thành công!';
			}else{
				mysqli_query($conn, "INSERT INTO domain_giaoviec (user_id, domain, expired, date_post) VALUES ('$user_id', '$domain', '$expired', '$hientai')");
				$ok = 1;
				$message = 'Sử dụng tên miền <b>' . $domain . '</b> thành công!';
			}


		}
	}
	echo json_encode(array('available' => $ok, 'message' => $message));
} else {
	echo "Không có hành động nào được xử lý";
}
