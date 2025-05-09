<?php
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang_ncc WHERE id='$id' AND user_id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Đơn hàng không tồn tại';
			} else {
				if ($r_tt['status'] == 5) {
					$ok = 0;
					$thongbao = 'Thất bại! Đơn hàng này đã hoàn thành';
				} else if ($r_tt['status'] == 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Đơn hàng này đang được vận chuyển';
				} else if ($r_tt['status'] == 3) {
					$ok = 0;
					$thongbao = 'Thất bại! Đã yêu cầu hủy đơn';
				} else if ($r_tt['status'] == 4) {
					$ok = 0;
					$thongbao = 'Thất bại! Đơn hàng này đã hủy';
				} else if ($r_tt['status'] == 6) {
					$ok = 0;
					$thongbao = 'Thất bại! Đơn hàng này đã hoàn đơn';
				} else {
					$ok = 1;
					$thongbao = 'Yêu cầu hủy đơn thành công';
					mysqli_query($conn, "UPDATE donhang_ncc SET status='3' WHERE id='$id'");
				}
			}
			echo json_encode(array('ok' => 1, 'thongbao' => $thongbao));
?>