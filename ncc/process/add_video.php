<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$title = addslashes(strip_tags($_REQUEST['title']));
			$description = addslashes(strip_tags($_REQUEST['description']));
			$category = addslashes($_REQUEST['category']);
			$link = strip_tags(addslashes($_REQUEST['link']));
			$noidung = addslashes($_REQUEST['noidung']);
			$duoi = $check->duoi_file($_FILES['file']['name']);
			$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo_shop WHERE shop='$user_id' AND link='$link' AND loai='baiviet'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
					$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					$thongbao = 'Thêm bài viết thành công';
					$ok = 1;
					$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
					mysqli_query($conn, "INSERT INTO post_shop(shop,tieu_de,minh_hoa,cat,link,noidung,title,description,view,date_post)VALUES('$user_id','$tieu_de','$minh_hoa','$category','$link','$noidung','$title','$description','0'," . time() . ")");
					mysqli_query($conn, "INSERT INTO seo_shop (shop,loai,link)VALUES('$user_id','baiviet','$link')");
				} else {
					$thongbao = 'Vui lòng chọn ảnh minh họa';
					$ok = 0;
				}
			} else {
				$ok = 0;
				$thongbao = "Link xem đã tồn tại";
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>