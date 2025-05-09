<?php
			$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
			$cat_title = strip_tags($_REQUEST['cat_title']);
			$cat_description = strip_tags($_REQUEST['cat_description']);
			$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
			$cat_thutu = intval($_REQUEST['cat_thutu']);
			$cat_blank = addslashes($_REQUEST['cat_blank']);
			$cat_link = addslashes($_REQUEST['cat_link']);
			$cat_main = intval($_REQUEST['cat_main']);
			$cat_icon = addslashes($_REQUEST['cat_icon']);
			$cat_index = intval($_REQUEST['cat_index']);
			//1-4
			// thêm danh muc của socdo 
			// thêm cat_id_socdo vào bảng category_sanpham_shop 
			$cat_id_socdo = $_REQUEST['cat_id_socdo'];
			if ($cat_tieude == '') {
				$ok = 0;
				$thongbao = 'Vui lòng nhập tiêu đề';
			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo_shop WHERE link='$cat_blank' AND loai='category' AND shop='$user_id' ORDER BY id DESC LIMIT 1");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] > 0) {
					$ok = 0;
					$thongbao = 'Thất bại! Link xem đã tồn tại';
				} else {
					$ok = 1;
					$thongbao = "Thêm danh mục thành công";
					$duoi = $check->duoi_file($_FILES['file']['name']);
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
						$minh_hoa = '/uploads/minh-hoa/' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					}
					mysqli_query($conn, "INSERT INTO category_sanpham_shop(shop,cat_tieude,cat_blank,cat_noidung,cat_title,cat_main,cat_description,cat_index,cat_img,cat_link,cat_thutu,cat_icon,cat_id_socdo)VALUES('$user_id','$cat_tieude','$cat_blank','$cat_noidung','$cat_title','$cat_main','$cat_description','$cat_index','$minh_hoa','$cat_link','$cat_thutu','$cat_icon','$cat_id_socdo')");
					mysqli_query($conn, "INSERT INTO seo_shop (shop,loai,link)VALUES('$user_id','category','$cat_blank')");

				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>