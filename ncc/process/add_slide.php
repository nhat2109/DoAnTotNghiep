<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$link = addslashes(strip_tags($_REQUEST['link']));
			$target = addslashes(strip_tags($_REQUEST['target']));
			$thu_tu = intval(strip_tags($_REQUEST['thu_tu']));
			$duoi = $check->duoi_file($_FILES['file']['name']);
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
				$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				@unlink('..' . $index_setting[$name]);
				mysqli_query($conn, "INSERT INTO slide(shop,tieu_de,minh_hoa,link,target,thu_tu)VALUES('$user_id','$tieu_de','$minh_hoa','$link','$target','$thu_tu')");
				$ok = 1;
				$thongbao = 'Thêm slide thành công!';
			} else {
				$thongbao = 'Thất bại! Bạn chưa chọn hình ảnh';
				$ok = 0;
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>