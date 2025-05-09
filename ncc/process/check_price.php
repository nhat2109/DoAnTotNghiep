<?php
			$time_start = strip_tags(addslashes($_REQUEST['time_start']));
			$time_end = strip_tags(addslashes($_REQUEST['time_end']));
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM idol WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Idol không tồn tại';
			} else {
				$start = strtotime($time_start);
				$end = strtotime($time_end);
				$mins = ($end - $start) / 60;
				if ($mins % 60 == 0) {
					$khung = intval($mins / 60);
					$tongtien = $khung * (preg_replace('/[^0-9]/', '', $r_tt['ngan_sach']));
					$tongtien = number_format($tongtien) . 'đ';
					if ($khung > 0) {
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thời gian không hợp lệ';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thời gian không hợp lệ';
				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'tongtien' => $tongtien,
			);
			echo json_encode($info);
?>