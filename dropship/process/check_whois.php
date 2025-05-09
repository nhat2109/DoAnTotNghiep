<?php
	$domain = addslashes(strip_tags($_REQUEST['domain']));
	$link = 'https://whois.net.vn/checkdomain.php?act=getwhois&domain=' . $domain;
	$kq = $check->getpage($link, $link);
	echo json_encode(array('kq' => $kq, 'domain' => $domain));
?>