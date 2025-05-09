<?php 
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$pop = addslashes(strip_tags($_REQUEST['pop']));
		$noidung = addslashes($_REQUEST['noidung']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$noi_dang= addslashes(strip_tags($_REQUEST['noi_dang']));
		$duoi_pop = $check->duoi_file($_FILES['file_popup']['name']);
		$id = intval($_REQUEST['id']);
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao WHERE id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			@unlink('..'.$r_tt['minh_hoa']);
		} else {
			$minh_hoa=$r_tt['minh_hoa'];
		}
		if (in_array($duoi_pop, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$img_pop = '/uploads/minh-hoa/popup-' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi_pop;
			move_uploaded_file($_FILES['file_popup']['tmp_name'], '..' . $img_pop);
			@unlink('..'.$r_tt['img_pop']);
		} else {
			$img_pop=$r_tt['img_pop'];
		}
		mysqli_query($conn,"UPDATE thongbao SET tieu_de='$tieu_de',noi_dung='$noidung',noi_dang='$noi_dang',minh_hoa='$minh_hoa',img_pop='$img_pop',pop='$pop' WHERE id='$id'");
		$ok=1;
		$thongbao='Sửa thông báo thành công';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);?>