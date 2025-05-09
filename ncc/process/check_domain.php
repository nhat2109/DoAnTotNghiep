<?php
	$domain = addslashes(strip_tags($_REQUEST['domain']));
	$link = 'https://api3.tadu.vn/api/domain/' . $domain . '/check';
	$kq = $check->getpage($link, $link);
	$tach_ketqua = json_decode($kq, true);
	if ($tach_ketqua['data']['is_exist'] == 1) {
		$ok = 0;
		$button = '<div class="btn-whois-domain" data="' . $domain . '">Đã có người mua</div>';
	} else if ($tach_ketqua['data']['is_exist'] == false) {
		$ok = 1;
		$button = '<div class="btn-register-domain" data="' . $domain . '" onclick="confirm_action_domain(\'mua_domain\', \'Xác nhận đăng ký tên miền\', \'' . $domain . '\');"><a href="javascript:;">Mua Ngay</a></div>';
	} else {
		$ok = 0;
		$button = '<div class="btn-whois-domain" data="' . $domain . '">Chưa cho phép</div>';
	}
	echo json_encode(array('ok' => $ok, 'domain' => $domain, 'button' => $button));
?>