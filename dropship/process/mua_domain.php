<?php
			$domain = addslashes(strip_tags($_REQUEST['domain']));
			$link = 'https://whois.net.vn/checkdomain.php?domain=' . $domain;
			$kq = $check->getpage($link, $link);
			$tach_ketqua = explode('|', $kq);
			if (intval($tach_ketqua[0]) == 1) {
				$ok = 0;
				$thongbao = 'Thất bại! Tên miền này đã có người mua';
			} else if ($tach_ketqua[0] == 0) {
				$tach_domain = explode('.', $domain);
				$duoi = str_replace($tach_domain[0] . '.', '', $domain);
				$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain_price WHERE domain='$duoi'");
				$r_tt = mysqli_fetch_assoc($thongtin);
				$price = $r_tt['gia'] + $r_tt['phi_caidat'];
				if ($user_info['user_money'] < $price) {
					$ok = 0;
					$thongbao = 'Thất bại! Số dư của bạn không đủ';
				} else {
					$thongtin_mua = mysqli_query($conn, "SELECT *,count(*) AS total FROM mua_domain WHERE domain='$domain' AND status='0'");
					$r_m = mysqli_fetch_assoc($thongtin_mua);
					if ($r_m['total'] > 0) {
						$ok = 0;
						$thongbao = 'Thất bại! Đã có người đặt mua trên hệ thống';
					} else {
						$thongtin_giaodien = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
						$r_gd = mysqli_fetch_assoc($thongtin_giaodien);
						if ($r_gd['total'] == 0) {
							$ok = 0;
							$thongbao = 'Thất bại! Bạn chưa thiết lập giao diện';
						} else if ($r_gd['free'] == 1) {
							$ok = 0;
							$thongbao = 'Thất bại! Bạn đang dùng giao diện miễn phí';
						} else {
							$ok = 1;
							$thongbao = 'Đăt mua tên miền thành công';
							$truoc = $user_info['user_money'] + $user_info['user_money2'];
							$sau = $truoc - $price;
							$moi = $user_info['user_money'] - $price;
							$noidung = 'Đặt mua tên miền ' . $domain;
							$noidung_notification=$user_info['name'].'('.$user_info['mobile'].') đặt mua tên miền '.$domain;
							mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','0','$noidung_notification','','hotro_chung','1'," . time() . ")");
							mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
							mysqli_query($conn, "INSERT INTO mua_domain(user_id,domain,gia,phi_caidat,status,date_post)VALUES('$user_id','$domain','{$r_tt['gia']}','{$r_tt['phi_caidat']}','0'," . time() . ")");
							mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$price','$truoc','$sau','$noidung'," . time() . ")");
						}
					}
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Tên miền này chưa được phép mua bán';
			}
			echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
?>