<?php
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM giaodien WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	$tong_money = $user_info['user_money'] + $user_info['user_money2'];
	// if ($r_tt['total'] == 0) {
	// 	$thongbao = '<i class="fa fa-warning"></i> Giao diện không tồn tại';
	// 	$ok = 0;
	// } else {
	// 	$thongtin_domain = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
	// 	$r_domain = mysqli_fetch_assoc($thongtin_domain);
	// 	$expired = time() + 365 * 24 * 3600;
	// 	$log_file = '../uploads/log-user-' . $user_id . '.txt';
	// 	$log_text = file_get_contents($log_file);
	// 	$tach_log = explode("\n", $log_text);
	// 	if ($r_domain['total'] == 0) {
			
	// 		if ($tong_money < $r_tt['gia_moi']) {
	// 			$ok = 0;
	// 			$thongbao = 'Thất bại! Số dư của bạn không đủ';

	// 		} else {
	// 			$ok = 1;
	// 			$thongbao = 'Thành công! Hệ thống đang chuyển hướng';
	// 			$truoc = $user_info['user_money'] + $user_info['user_money2'];
	// 			$sau = $truoc - $r_tt['gia_moi'];
	// 			if ($user_info['user_money'] >= $r_tt['gia_moi']) {
	// 				$moi = $user_info['user_money'] - $r_tt['gia_moi'];
	// 				mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
	// 			} else {
	// 				$moi = $user_info['user_money2'] - ($r_tt['gia_moi'] - $user_info['user_money']);
	// 				mysqli_query($conn, "UPDATE user_info SET user_money2='$moi',user_money='0' WHERE user_id='$user_id'");
	// 			}
	// 			if ($r_tt['gia_moi'] > 0) {
	// 				$free = 0;
	// 				$noidung = 'Cài đặt giao diện "' . $r_tt['tieu_de'] . '"';
	// 				mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','{$r_tt['gia_moi']}','$truoc','$sau','$noidung'," . time() . ")");
	// 			} else {
	// 				$free = 1;
	// 			}
	// 			mysqli_query($conn, "INSERT INTO domain(user_id,domain,skin,skin_tieude,free,active,expired)VALUES('$user_id','','$id','{$r_tt['tieu_de']}','$free','0','$expired')");
	// 		}
	// 	} else {
	// 		if ($r_domain['expired'] > time() AND $r_domain['free'] == 0) {
	// 			$ok = 1;
	// 			$thongbao = 'Thành công! Hệ thống đang chuyển hướng';
	// 			foreach ($tach_log as $key => $value) {
	// 				$tach_value = explode(':', $value);
	// 				if ($tach_value[0] == 'caidat') {
	// 					$log_text_new .= "caidat:0\n";
	// 				} else {
	// 					$log_text_new .= $value . "\n";
	// 				}
	// 			}
	// 			$fh = fopen($log_file, "w");
	// 			fwrite($fh, $log_text_new);
	// 			fclose($fh);
	// 			mysqli_query($conn, "UPDATE domain SET skin='$id',skin_tieude='{$r_tt['tieu_de']}' WHERE user_id='$user_id'");
	// 		} else {
	// 			$truoc = $user_info['user_money'] + $user_info['user_money2'];
	// 			$sau = $truoc - $r_tt['gia_moi'];

	// 			if ($tong_money >= $r_tt['gia_moi']) {
	// 				if ($user_info['user_money'] >= $r_tt['gia_moi']) {
	// 					$moi = $user_info['user_money'] - $r_tt['gia_moi'];
	// 					mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
	// 				} else {
	// 					$moi = $user_info['user_money2'] - ($r_tt['gia_moi'] - $user_info['user_money']);
	// 					mysqli_query($conn, "UPDATE user_info SET user_money2='$moi',user_money='0' WHERE user_id='$user_id'");
	// 				}
	// 				if ($r_tt['gia_moi'] > 0) {
	// 					$free = 0;
	// 					$noidung = 'Cài đặt giao diện "' . $r_tt['tieu_de'] . '"';
	// 					mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','{$r_tt['gia_moi']}','$truoc','$sau','$noidung'," . time() . ")");
	// 				} else {
	// 					$free = 1;
	// 				}
	// 				$ok = 1;
	// 				$thongbao = 'Thành công! Hệ thống đang chuyển hướng';
	// 				foreach ($tach_log as $key => $value) {
	// 					$tach_value = explode(':', $value);
	// 					if ($tach_value[0] == 'caidat') {
	// 						$log_text_new .= "caidat:0\n";
	// 					} else {
	// 						$log_text_new .= $value . "\n";
	// 					}
	// 				}
	// 				$fh = fopen($log_file, "w");
	// 				fwrite($fh, $log_text_new);
	// 				fclose($fh);
	// 				mysqli_query($conn, "UPDATE domain SET skin='$id',skin_tieude='{$r_tt['tieu_de']}',active='0',free='$free' WHERE user_id='$user_id'");
	// 			} else {
	// 				$ok = 0;
	// 				$thongbao = 'Thất bại! Số dư của bạn không đủ';
	// 			}
	// 		}
	// 	}
	// }
	if ($r_tt['total'] == 0) {
			$thongbao = '<i class="fa fa-warning"></i> Giao diện không tồn tại';
			$ok = 0;
	} else {
		$thongtin_domain = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
		$r_domain = mysqli_fetch_assoc($thongtin_domain);
		$expired = time() + 365 * 24 * 3600;
		$log_file = '../uploads/log-user-' . $user_id . '.txt';
		$log_text = file_get_contents($log_file);
		$tach_log = explode("\n", $log_text);
			if ($r_domain['total'] == 0) {
					$ok = 1;
					$thongbao = 'Thành công! Hệ thống đang chuyển hướng';	
					mysqli_query($conn, "INSERT INTO domain(user_id,domain,skin,skin_tieude,free,active,expired)VALUES('$user_id','','$id','{$r_tt['tieu_de']}','1','0','$expired')");
			} else
			{
				$ok = 1;
				$thongbao = 'Thành công! Hệ thống đang chuyển hướng';
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'caidat') {
						$log_text_new .= "caidat:0\n";
					} else {
						$log_text_new .= $value . "\n";
					}
				}
				$fh = fopen($log_file, "w");
				fwrite($fh, $log_text_new);
				fclose($fh);
				mysqli_query($conn, "UPDATE domain SET skin='$id',skin_tieude='{$r_tt['tieu_de']}',active='0',free='1' WHERE user_id='$user_id'");
			}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
?>