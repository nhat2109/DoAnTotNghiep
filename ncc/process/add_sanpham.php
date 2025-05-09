<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$sp_id = preg_replace('/[^0-9]/', '', $_REQUEST['sp_id']);
			$gia_cu = preg_replace('/[^0-9]/', '', $_REQUEST['gia_cu']);
			$gia_moi = preg_replace('/[^0-9]/', '', $_REQUEST['gia_moi']);
			$anh = addslashes(strip_tags($_REQUEST['anh']));
			$minh_hoa = addslashes(strip_tags($_REQUEST['minh_hoa']));
			$link = addslashes(strip_tags($_REQUEST['link']));
			$category = addslashes(strip_tags($_REQUEST['category']));
			$color = addslashes(strip_tags($_REQUEST['color']));
			$size = addslashes(strip_tags($_REQUEST['size']));
			$can_nang = addslashes(strip_tags($_REQUEST['can_nang']));
			$thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
			$info = addslashes(strip_tags($_REQUEST['info']));
			$info = substr($info, 0, -1);
			$noibat = addslashes($_REQUEST['noibat']);
			$noidung = addslashes($_REQUEST['noidung']);
			$title = addslashes(strip_tags($_REQUEST['title']));
			$description = addslashes(strip_tags($_REQUEST['description']));
			$duoi = $check->duoi_file($_FILES['file']['name']);
			$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='$sp_id'");
			$r_sp = mysqli_fetch_assoc($thongtin_sanpham);
			if ($gia_moi < $r_sp['drop_min']) {
				$ok = 0;
				$thongbao = 'Thất bại! Giá bán của bạn thấp hơn giá bán tối thiểu';
			} else {
				$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ($r_tt['total'] == 0) {
					$thongbao = 'Thêm sản phẩm thành công';
					$ok = 1;
					$duoi = $check->duoi_file($_FILES['file']['name']);
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
						$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					}
					mysqli_query($conn, "INSERT INTO sanpham_shop(shop,sp_id,tieu_de,minh_hoa,link,link_aff,cat,kho_hang,gia_cu,gia_moi,noi_bat,noi_dung,mau,thuong_hieu,size,thongtin,can_nang,anh,ban,title,description,view,date_post)VALUES('$user_id','$sp_id','$tieu_de','$minh_hoa','$link','$link_aff','$category','0','$gia_cu','$gia_moi','$noibat','$noidung','$color','$thuong_hieu','$size','$info','$can_nang','$anh','0','$title','$description','0'," . time() . ")");
					mysqli_query($conn, "INSERT INTO seo_shop (loai,link,shop)VALUES('sanpham','$link','$user_id')");
				} else {
					$ok = 0;
					$thongbao = "Link xem đã tồn tại";
				}
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>