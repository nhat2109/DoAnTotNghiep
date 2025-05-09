<?php
			$domain = strip_tags(addslashes($_REQUEST['domain']));
			$domain = str_replace(array('http://', 'https://', '/'), '', $domain);
			//$parse = parse_url($domain);
			//$domain=$parse['host'];
			if (strlen($domain) < 5) {
				$thongbao = "Vui lòng nhập tên miền" . $domain;
				$ok = 0;
			} else {
				if ($user_info['domain'] == $domain) {
					mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");
					mysqli_query($conn, "UPDATE domain SET domain='$domain' WHERE user_id='$user_id'");
					$ok = 1;
					$thongbao = 'Lưu thay đổi thành công!';
				} else {
					$thongtin_domain = mysqli_query($conn, "SELECT * FROM domain WHERE user_id='$user_id'");
					$r_domain = mysqli_fetch_assoc($thongtin_domain);
					if ($r_domain['free'] == 1) {
						if (strpos($domain, 'socdo.vn') !== false) {
							$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE domain='$domain'");
							$r_tt = mysqli_fetch_assoc($thongtin);
							if ($r_tt['total'] == 0) {
								$ok = 1;
								$thongbao = 'Lưu thay đổi thành công!';
								mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");
								mysqli_query($conn, "UPDATE domain SET domain='$domain' WHERE user_id='$user_id'");
							} else {
								$ok = 0;
								$thongbao = 'Thất bại! Tên miền đã tồn tại';
							}
						} else {
							$ok = 0;
							$thongbao = 'Không sử dụng tên miền riêng với gian hàng miễn phí';

						}
					} else {
						$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE domain='$domain'");
						$r_tt = mysqli_fetch_assoc($thongtin);
						if ($r_tt['total'] == 0) {
							$ok = 1;
							$thongbao = 'Lưu thay đổi thành công!';
							mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");
							mysqli_query($conn, "UPDATE domain SET domain='$domain' WHERE user_id='$user_id'");
						} else {
							$ok = 0;
							$thongbao = 'Thất bại! Tên miền đã tồn tại';
						}

					}

				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>