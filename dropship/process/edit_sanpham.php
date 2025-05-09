<?php
	$info = ['ok' => 0, 'thongbao' => 'Hành động không hợp lệ'];
	if ($_POST['action'] == 'edit_sanpham') {
		$id = intval($_POST['id']);
		$tieu_de = addslashes(strip_tags($_POST['tieu_de']));
		$link = addslashes(strip_tags($_POST['link']));
		$link_old = addslashes(strip_tags($_POST['link_old']));
		$kich_thuoc = addslashes(strip_tags($_POST['kich_thuoc']));
		$anh = addslashes(strip_tags($_POST['anh']));
		$category = addslashes(strip_tags($_POST['category']));
		$thuong_hieu = addslashes(strip_tags($_POST['thuong_hieu']));
		$info = addslashes(strip_tags($_POST['info']));
		$noibat = addslashes($_POST['noibat']);
		$noidung = addslashes($_POST['noidung']);
		$title = addslashes(strip_tags($_POST['title']));
		$description = addslashes(strip_tags($_POST['description']));
		$phan_loai_raw = $_POST['phan_loai']; // Lấy chuỗi JSON thủ công
		$phan_loai = json_decode('[' . $phan_loai_raw . ']', true); // Thêm [] để thành mảng JSON hợp lệ
		$gia_cu = intval(str_replace(',', '', $phan_loai[0]['gia_cu']));
		$gia_moi = intval(str_replace(',', '', $phan_loai[0]['gia_moi']));
		// Xử lý file minh họa
		$minh_hoa = addslashes(strip_tags($_POST['minh_hoa']));
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		}
	
		// Kiểm tra sản phẩm tồn tại
		$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] == 0) {
			$info = ['ok' => 0, 'thongbao' => 'Sản phẩm không tồn tại'];
			echo json_encode($info);
			exit();
		}
	
		// Cập nhật bảng sanpham_shop
		$query = "UPDATE sanpham_shop SET 
			tieu_de='$tieu_de', link='$link', anh='$anh', cat='$category', thuong_hieu='$thuong_hieu', thongtin='$info', noi_bat='$noibat', noi_dung='$noidung', title='$title', description='$description', kich_thuoc='$kich_thuoc', gia_cu=$gia_cu, gia_moi=$gia_moi";
		if ($duoi) {
			$query .= ", minh_hoa='$minh_hoa'";
		}
		$query .= " WHERE id='$id' AND shop='$user_id'";
		mysqli_query($conn, $query);
	
		// Lấy danh sách ID phân loại từ form
		$new_ids = [];
		foreach ($phan_loai as $pl) {
			if (!empty($pl['id'])) {
				$new_ids[] = intval($pl['id']); // Chỉ lấy ID có sẵn (loại bỏ phân loại mới chưa có ID)
			}
		}
	
		// Lấy danh sách phân loại cũ từ database
		$old_ids = [];
		$query = "SELECT id FROM phanloai_sanpham_shop WHERE sp_id = '$id'";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$old_ids[] = intval($row['id']);
		}
	
		// ** XÓA** phân loại không có trong danh sách mới
		$ids_to_delete = array_diff($old_ids, $new_ids);
		if (!empty($ids_to_delete)) {
			$delete_ids = implode(',', $ids_to_delete);
			mysqli_query($conn, "DELETE FROM phanloai_sanpham_shop WHERE id IN ($delete_ids)");
		}
	
		// ** CẬP NHẬT hoặc THÊM MỚI**
		foreach ($phan_loai as $pl) {
			$ma_sp = addslashes($pl['ma_sp']);
			$size = addslashes($pl['size']);
			$ten_size = addslashes($pl['ten_size']);
			$color = addslashes($pl['color']);
			$ten_color = addslashes($pl['ten_color']);
			$ma_mau = addslashes($pl['ma_mau']);
			$can_nang = floatval($pl['can_nang']);
			$can_nang_tinhship = floatval($pl['trongluongtinhship']);
			$gia_cu = intval(preg_replace('/[^0-9]/', '', $pl['gia_cu']));
			$gia_moi = intval(preg_replace('/[^0-9]/', '', $pl['gia_moi']));
			$kho_sanpham_shop = intval($pl['kho_sanpham_shop']);
	
			if (!empty($pl['id']) && in_array($pl['id'], $old_ids)) {
				// **CẬP NHẬT** phân loại nếu ID đã tồn tại
				$phanloai_id = intval($pl['id']);
				$query = "UPDATE phanloai_sanpham_shop SET 
				color='$color', size='$size', ten_size='$ten_size', 
				ten_color='$ten_color', ma_mau='$ma_mau', can_nang='$can_nang', 
				gia_cu='$gia_cu', gia_moi='$gia_moi', kho_sanpham_shop='$kho_sanpham_shop', can_nang_tinhship='$can_nang_tinhship',
				date_post=UNIX_TIMESTAMP() 
				WHERE id='$phanloai_id'";
				mysqli_query($conn, $query);
			} else {
				// **THÊM MỚI** phân loại nếu chưa có ID
				$query = "INSERT INTO phanloai_sanpham_shop 
				(user_id, sp_id, ma_sp, color, size, ten_size, ten_color, ma_mau, can_nang, gia_cu, gia_moi, gia_drop, gia_ctv, gia_socdo, drop_min, kho_sanpham_shop, can_nang_tinhship, date_post) 
				VALUES ('$user_id', '$id', '$ma_sp', '$color', '$size', '$ten_size', '$ten_color', '$ma_mau', '$can_nang', '$gia_cu', '$gia_moi', 0, 0, 0, 0, '$kho_sanpham_shop', $can_nang_tinhship, UNIX_TIMESTAMP())";
				mysqli_query($conn, $query);
			}
		}
		$info = ['ok' => 1, 'thongbao' => 'Sửa sản phẩm thành công'];
	}
	echo json_encode($info);
	exit();
?>