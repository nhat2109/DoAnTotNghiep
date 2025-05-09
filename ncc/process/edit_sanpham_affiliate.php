<?php
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$gia_cu = preg_replace('/[^0-9]/', '', $_REQUEST['gia_cu']);
	$gia_moi = preg_replace('/[^0-9]/', '', $_REQUEST['gia_moi']);
	$anh = addslashes(strip_tags($_REQUEST['anh']));
	$minh_hoa = addslashes(strip_tags($_REQUEST['minh_hoa']));
	$link_aff = addslashes(strip_tags($_REQUEST['link_aff']));
	$link = addslashes(strip_tags($_REQUEST['link']));
	$link_old = addslashes(strip_tags($_REQUEST['link_old']));
	$category = addslashes(strip_tags($_REQUEST['category']));
	$color = addslashes(strip_tags($_REQUEST['color']));
	$size = addslashes(strip_tags($_REQUEST['size']));
	$size_2 = addslashes(strip_tags($_REQUEST['size_2']));
	$thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
	$thuong_hieu_2 = addslashes(strip_tags($_REQUEST['thuong_hieu_2']));
	$info = addslashes(strip_tags($_REQUEST['info']));
	$info = substr($info, 0, -1);
	$noibat = addslashes($_REQUEST['noibat']);
	$noidung = addslashes($_REQUEST['noidung']);
	$title = addslashes(strip_tags($_REQUEST['title']));
	$description = addslashes(strip_tags($_REQUEST['description']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Thất bại! Sản phẩm không tồn tại';
	} else {
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			if ($r_tt['minh_hoa'] != $r_sp['minh_hoa']) {
				@unlink($r_tt['minh_hoa']);
			}
			if ($link == $link_old) {
				if ($size_2 != '') {
					mysqli_query($conn, "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$size_2','0','0')");
					$thongtin_kichco = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
					$r_kc = mysqli_fetch_assoc($thongtin_kichco);
					$size = $r_kc['id'];
				}
				if ($thuong_hieu_2 != '') {
					mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
					$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
					$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
					$thuong_hieu = $r_th['id'];
				}
				mysqli_query($conn, "UPDATE sanpham_shop SET tieu_de='$tieu_de',cat='$category',gia_cu='$gia_cu',gia_moi='$gia_moi',noi_bat='$noibat',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',thongtin='$info',link_aff='$link_aff',size='$size',minh_hoa='$minh_hoa',anh='$anh',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
				$thongbao = 'Sửa sản phẩm thành công';
				$ok = 1;
			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] == 0) {
					if ($size_2 != '') {
						mysqli_query($conn, "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$size_2','0','0')");
						$thongtin_kichco = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
						$r_kc = mysqli_fetch_assoc($thongtin_kichco);
						$size = $r_kc['id'];
					}
					if ($thuong_hieu_2 != '') {
						mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
						$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
						$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
						$thuong_hieu = $r_th['id'];
					}
					mysqli_query($conn, "UPDATE sanpham_shop SET tieu_de='$tieu_de',cat='$category',link='$link',link_aff='$link_aff',gia_cu='$gia_cu',gia_moi='$gia_moi',noi_bat='$noibat',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',thongtin='$info',size='$size',minh_hoa='$minh_hoa',anh='$anh',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
					mysqli_query($conn, "UPDATE seo_shop SET link='$link' WHERE link='$link_old' AND loai='sanpham' AND shop='$user_id'");
					$thongbao = 'Sửa sản phẩm thành công';
					$ok = 1;
				} else {
					$ok = 0;
					$thongbao = "Thất bại! Link xem đã tồn tại";
				}
			}
		} else {
			if ($link == $link_old) {
				if ($size_2 != '') {
					mysqli_query($conn, "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$size_2','0','0')");
					$thongtin_kichco = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
					$r_kc = mysqli_fetch_assoc($thongtin_kichco);
					$size = $r_kc['id'];
				}
				if ($thuong_hieu_2 != '') {
					mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
					$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
					$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
					$thuong_hieu = $r_th['id'];
				}
				mysqli_query($conn, "UPDATE sanpham_shop SET tieu_de='$tieu_de',cat='$category',link_aff='$link_aff',gia_cu='$gia_cu',gia_moi='$gia_moi',noi_bat='$noibat',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',thongtin='$info',size='$size',anh='$anh',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
				$thongbao = 'Sửa sản phẩm thành công';
				$ok = 1;
			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] == 0) {
					if ($size_2 != '') {
						mysqli_query($conn, "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$size_2','0','0')");
						$thongtin_kichco = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
						$r_kc = mysqli_fetch_assoc($thongtin_kichco);
						$size = $r_kc['id'];
					}
					if ($thuong_hieu_2 != '') {
						mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
						$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
						$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
						$thuong_hieu = $r_th['id'];
					}
					mysqli_query($conn, "UPDATE sanpham_shop SET tieu_de='$tieu_de',cat='$category',link='$link',link_aff='$link_aff',gia_cu='$gia_cu',gia_moi='$gia_moi',noi_bat='$noibat',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',thongtin='$info',size='$size',anh='$anh',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
					mysqli_query($conn, "UPDATE seo_shop SET link='$link' WHERE link='$link_old' AND loai='sanpham' AND shop='$user_id'");
					$thongbao = 'Sửa sản phẩm thành công';
					$ok = 1;
				} else {
					$ok = 0;
					$thongbao = "Thất bại! Link xem đã tồn tại";
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>