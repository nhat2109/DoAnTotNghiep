<?php
			$time_start = strip_tags(addslashes($_REQUEST['time_start']));
			$time_end = strip_tags(addslashes($_REQUEST['time_end']));
			$ngay = strip_tags(addslashes($_REQUEST['ngay']));
			$san_pham = strip_tags(addslashes($_REQUEST['san_pham']));
			$ghi_chu = strip_tags(addslashes($_REQUEST['ghi_chu']));
			$tach_time_start = explode(':', $time_start);
			$tach_time_end = explode(':', $time_end);
			$tach_ngay = explode('/', $ngay);
			$date_time_start = mktime($tach_time_start[0], $tach_time_start[1], 0, $tach_ngay[1], $tach_ngay[0], $tach_ngay[2]);
			$date_time_end = mktime($tach_time_end[0], $tach_time_end[1], 0, $tach_ngay[1], $tach_ngay[0], $tach_ngay[2]);
			$next_today = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 2 * 24 * 3600;
			$time_order = mktime(0, 0, 0, $tach_ngay[1], $tach_ngay[0], $tach_ngay[2]);

			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM idol WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Idol không tồn tại';
			} else if ($time_order < $next_today) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng đặt live stream trước 2 ngày';
			} else {
				$start = strtotime($time_start);
				$end = strtotime($time_end);
				$mins = ($end - $start) / 60;
				$thongtin_dat = mysqli_query($conn, "SELECT *,count(*) AS total FROM dat_live WHERE ngay='$ngay' AND status!='2' AND (start_time='$date_time_start' OR (start_time<'$date_time_start' AND end_time>'$date_time_start'))");
				$r_dat = mysqli_fetch_assoc($thongtin_dat);
				if ($r_dat['total'] > 0) {
					$ok = 0;
					$thongbao = 'Thất bại! Khung giờ này đã có người đặt';
				} else if ($mins % 60 == 0) {
					$khung = intval($mins / 60);
					$tongtien = $khung * (preg_replace('/[^0-9]/', '', $r_tt['ngan_sach']));
					if ($khung == 1) {
						if ($user_info['user_money'] >= $tongtien) {
							$ok = 1;
							$thongbao = 'Đặt lịch live stream thành công';
							$truoc = $user_info['user_money'] + $user_info['user_money2'];
							$moi = $user_info['user_money'] - $tongtien;
							$sau = $truoc - $tongtien;
							mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
							$noidung = 'Đặt ' . $r_tt['ho_ten'] . ' live stream, khung giờ ' . $time_start . ' - ' . $time_end;
							$noidung_notification=$user_info['name'].' Đặt ' . $r_tt['ho_ten'] . ' live stream, khung giờ ' . $time_start . ' - ' . $time_end;
							mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','0','$noidung_notification','','hotro_chung','1'," . time() . ")");
							mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tongtien','$truoc','$sau','$noidung'," . time() . ")");
							$khung_gio = $time_start . ' - ' . $time_end;
							mysqli_query($conn, "INSERT INTO dat_live(user_id,idol,ngan_sach,san_pham,ghi_chu,ngay,khung_gio,start_time,end_time,status,date_post)VALUES('$user_id','$id','$tongtien','$san_pham','$ghi_chu','$ngay','$khung_gio','$date_time_start','$date_time_end','0'," . time() . ")");
						} else {
							$ok = 0;
							$thongbao = 'Thất bại! Số dư của bạn không đủ';
						}
					} else {
						$ok = 0;
						$thongbao = 'Vui lòng chọn thời gian livestream là 60 phút';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Thời gian không hợp lệ';
				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'tongtien' => $tongtien,
			);
			echo json_encode($info);
?>