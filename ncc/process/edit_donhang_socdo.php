<?php
			$status = intval($_REQUEST['status']);
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE id='$id' AND shop_id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Đơn hàng không tồn tại';
			} else {
				if ($status == 0) {
					if ($r_tt['status'] == 0) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu trạng thái này';
					}

				} else if ($status == 1) {
					if ($r_tt['status'] == 0) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu trạng thái này';
					}

				} else if ($status == 2) {
					if ($r_tt['status'] == 0 OR $r_tt['status'] == 1) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu trạng thái này';
					}
				} else if ($status == 3) {
					if ($r_tt['status'] == 0) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu thay đổi';
					}
				} else if ($status == 4) {
					if ($r_tt['status'] == 3) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu trạng thái này';
					}
				} else if ($status == 5) {
					if ($r_tt['status'] != 3 AND $r_tt['status'] != 4 AND $r_tt['status'] != 6) {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						if ($r_tt['status'] != 5) {
							$thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM tich_diem_shop WHERE don='{$r_tt['ma_don']}' AND user_id='{$r_tt['user_id']}'");
							$r_td = mysqli_fetch_assoc($thongtin_tichdiem);
							if ($r_td['total'] > 0) {
								mysqli_query($conn, "UPDATE tich_diem_shop SET status='1' WHERE user_id='{$r_tt['user_id']}' AND don='{$r_tt['ma_don']}'");
								$thongtin_diem = mysqli_query($conn, "SELECT *,count(*) AS total FROM diem WHERE user_id='{$r_tt['user_id']}'");
								$r_diem = mysqli_fetch_assoc($thongtin_diem);
								if ($r_diem['total'] > 0) {
									$moi = $r_diem['diem'] + $r_td['diem'];
									mysqli_query($conn, "UPDATE diem SET diem='$moi' WHERE user_id='{$r_tt['user_id']}'");
								} else {
									mysqli_query($conn, "INSERT INTO diem(user_id,diem)VALUES('{$r_tt['user_id']}','{$r_td['diem']}')");
								}
							}

						}
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể lưu trạng thái này';
					}
				} else if ($status == 6) {
					if ($r_tt['status'] == 3) {
						$ok = 0;
						$thongbao = 'Thất bại! Đơn hàng này đang yêu cầu hủy';
					} else if ($r_tt['status'] == 4) {
						$ok = 0;
						$thongbao = 'Thất bại! Đơn hàng này đã bị hủy';
					} else if ($r_tt['status'] == 5) {
						$ok = 0;
						$thongbao = 'Thất bại! Đơn hàng này đã hoàn thành';
					} else {
						mysqli_query($conn, "UPDATE donhang SET status='$status' WHERE id='$id' AND shop_id='$user_id'");
						$thongbao = 'Lưu thay đổi thành công';
						$ok = 1;
					}
				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>