<?php
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM seeding_shopee_ncc WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Gói dịch vụ không tồn tại';
			} else if ($user_info['user_money'] < $r_tt['gia']) {
				$ok = 0;
				$thongbao = 'Thất bại! Số dư của bạn không đủ';
			} else {
				$ok = 1;
				$thongbao = 'Mua gói seeding shopee thành công';
				$moi = $user_info['user_money'] - $r_tt['gia'];
				if ($r_tt['loai'] == 'seeding') {
					$noidung = 'Mua ' . $r_tt['tieu_de'] . ' - dịch vụ seeding shopee';
				} else if ($r_tt['loai'] == 'copy_sanpham') {
					$noidung = 'Mua ' . $r_tt['tieu_de'] . ' - dịch vụ copy sản phẩm shopee';
				} else if ($r_tt['loai'] == 'template') {
					$noidung = 'Mua ' . $r_tt['tieu_de'] . ' - dịch vụ template';
				} else if ($r_tt['loai'] == 'setup_gianhang') {
					$noidung = 'Mua ' . $r_tt['tieu_de'] . ' - Setup gian hàng shopee';
				}
				$price = $r_tt['gia'];
				$truoc = $user_info['user_money'] + $user_info['user_money2'];
				$sau = $truoc - $price;
				mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
				mysqli_query($conn, "INSERT INTO mua_seeding_shopee_ncc(user_id,goi,gia,status,date_post)VALUES('$user_id','$id','$price','0'," . time() . ")");
				mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$price','$truoc','$sau','$noidung'," . time() . ")");
			}
			echo json_encode(array('ok' => 1, 'thongbao' => $thongbao));
?>