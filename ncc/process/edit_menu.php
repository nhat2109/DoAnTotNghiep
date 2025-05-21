<?php
			$loai = addslashes($_REQUEST['loai']);
			$tieu_de = addslashes($_REQUEST['tieu_de']);
			$link = addslashes($_REQUEST['link']);
			$target = addslashes($_REQUEST['target']);
			$thu_tu = intval($_REQUEST['thu_tu']);
			$category = addslashes($_REQUEST['category']);
			$theloai = addslashes($_REQUEST['theloai']);
			$page = addslashes($_REQUEST['page']);
			$vi_tri = addslashes($_REQUEST['vi_tri']);
			$id = intval($_REQUEST['id']);
			if ($loai == 'page') {
				if (strlen($tieu_de) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Hãy nhập tiêu đề';
				} else {
					$ok = 1;
					$thongbao = 'sửa menu thành công';
					mysqli_query($conn, "UPDATE menu_shop SET menu_tieude='$tieu_de',menu_cat='',menu_link='$page',menu_target='$target',menu_thutu='$thu_tu',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id' AND shop='$user_id'");
				}
			} else if ($loai == 'theloai') {
				if (strlen($tieu_de) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Hãy nhập tiêu đề';
				} else {
					$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category_shop WHERE cat_id='$theloai' AND shop='$user_id' ORDER BY cat_id DESC LIMIT 1");
					$r_tt = mysqli_fetch_assoc($thongtin);
					if ($r_tt['total'] > 0) {
						$ok = 1;
						$thongbao = 'Sửa menu thành công';
						mysqli_query($conn, "UPDATE menu_shop SET menu_tieude='$tieu_de',menu_cat='$category',menu_link='/bai-viet/{$r_tt['cat_blank']}.html',menu_target='$target',menu_thutu='$thu_tu',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id' AND shop='$user_id'");
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Danh mục không tồn tại';

					}
				}
			} else if ($loai == 'category') {
				if (strlen($tieu_de) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Hãy nhập tiêu đề';
				} else {
					$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category_sanpham_shop WHERE cat_id='$category' AND shop='$user_id' ORDER BY cat_id DESC LIMIT 1");
					$r_tt = mysqli_fetch_assoc($thongtin);
					if ($r_tt['total'] > 0) {
						$ok = 1;
						$thongbao = 'Sửa menu thành công';
						mysqli_query($conn, "UPDATE menu_shop SET menu_tieude='$tieu_de',menu_cat='$category',menu_link='/san-pham/{$r_tt['cat_blank']}.html',menu_target='$target',menu_thutu='$thu_tu',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id' AND shop='$user_id'");
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Danh mục không tồn tại';

					}
				}
			} else {
				if (strlen($tieu_de) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Hãy nhập tiêu đề';
				} else {
					$ok = 1;
					$thongbao = 'Sửa menu thành công';
					mysqli_query($conn, "UPDATE menu_shop SET menu_tieude='$tieu_de',menu_cat='0',menu_link='$link',menu_target='$target',menu_thutu='$thu_tu',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id' AND shop='$user_id'");
				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>