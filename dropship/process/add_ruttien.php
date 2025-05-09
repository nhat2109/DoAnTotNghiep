<?php
			$so_tien = preg_replace('/[^0-9]/', '', $_REQUEST['so_tien']);
			$chu_khoan = addslashes(strip_tags($_REQUEST['chu_khoan']));
			$so_taikhoan = addslashes(strip_tags($_REQUEST['so_taikhoan']));
			$ngan_hang = addslashes(strip_tags($_REQUEST['ngan_hang']));
			$duoi = $check->duoi_file($_FILES['file']['name']);
			if (intval($so_tien) > $user_info['user_money']) {
				$ok = 0;
				$thongbao = 'Thất bại! Số dư của bạn không đủ';
			} else if (strlen($chu_khoan) < 4) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập tên chủ tài khoản';
			} else if (strlen($so_taikhoan) < 4) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập số tài khoản';
			} else if (strlen($ngan_hang) < 4) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập tên ngân hàng';
			} else {
				$ok = 1;
				$thongbao = 'Thành công! Yêu cầu rút tiền đã được gửi đi';
				$conlai = $user_info['user_money'] - $so_tien;
				$truoc = $user_info['user_money'] + $user_info['user_money2'];
				$sau = $truoc - $so_tien;
				$noidung = 'Yêu cầu rút tiền lúc: ' . date('H:i:s d/m/Y');
				$noidung_notification=$user_info['name'].'('.$user_info['mobile'].') yêu cầu rút tiền '.number_format($so_tien).'đ';
				mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','0','$noidung_notification','','tai_chinh','1'," . time() . ")");
				mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$so_tien','$truoc','$sau','$noidung'," . time() . ")");
				mysqli_query($conn, "UPDATE user_info SET user_money='$conlai' WHERE user_id='$user_id'");
				mysqli_query($conn, "INSERT INTO rut_tien (user_id,so_tien,chu_khoan,so_taikhoan,ngan_hang,status,date_post)VALUES('$user_id','$so_tien','$chu_khoan','$so_taikhoan','$ngan_hang','0'," . time() . ")");

			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>