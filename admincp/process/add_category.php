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
	$hoa_hong = addslashes($_REQUEST['hoa_hong']);
	$cat_index = intval($_REQUEST['cat_index']);
	$cat_trend = intval($_REQUEST['cat_trend']);
	$cat_noibat = intval($_REQUEST['cat_noibat']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('category', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
			exit();
		}
		if ($cat_tieude == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else {
			$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' AND loai='category' ORDER BY id DESC LIMIT 1");
			$r_seo = mysqli_fetch_assoc($thongtin_seo);
			if ($r_seo['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Link xem đã tồn tại';
			} else {
				$ok = 1;
				$thongbao = "Thêm thể loại thành công";
				$duoi = $check->duoi_file($_FILES['file']['name']);
				$duoi_minhhoa = $check->duoi_file($_FILES['file_minhhoa']['name']);
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
					$minh_hoa = '/uploads/minh-hoa/' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				}
				if (in_array($duoi_minhhoa, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
					$cat_minhhoa = '/uploads/minh-hoa/icon-' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi_minhhoa;
					move_uploaded_file($_FILES['file_minhhoa']['tmp_name'], '..' . $cat_minhhoa);
				}
				mysqli_query($conn, "INSERT INTO category_sanpham(cat_tieude,cat_blank,cat_link,cat_img,cat_noidung,cat_title,cat_main,cat_description,cat_minhhoa,cat_trend,cat_noibat,cat_index,cat_thutu,hoa_hong,cat_icon)VALUES('$cat_tieude','$cat_blank','$cat_link','$minh_hoa','$cat_noidung','$cat_title','$cat_main','$cat_description','$cat_minhhoa','$cat_trend','$cat_noibat','$cat_index','$cat_thutu','$hoa_hong','$cat_icon')");
				mysqli_query($conn, "INSERT INTO seo (loai,link)VALUES('category','$cat_blank')");

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);?>