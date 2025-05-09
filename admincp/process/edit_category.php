<?php 

$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
	$cat_title = strip_tags($_REQUEST['cat_title']);
	$cat_description = strip_tags($_REQUEST['cat_description']);
	$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
	$link_old = addslashes($_REQUEST['link_old']);
	$cat_thutu = intval($_REQUEST['cat_thutu']);
	$cat_blank = addslashes($_REQUEST['cat_blank']);
	$cat_link = addslashes($_REQUEST['cat_link']);
	$cat_id = intval($_REQUEST['cat_id']);
	$cat_main = intval($_REQUEST['cat_main']);
	$cat_icon = addslashes($_REQUEST['cat_icon']);
	$hoa_hong = addslashes($_REQUEST['hoa_hong']);
	$cat_index = intval($_REQUEST['cat_index']);
	$cat_noibat = intval($_REQUEST['cat_noibat']);
	$cat_trend = intval($_REQUEST['cat_trend']);
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
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM category_sanpham WHERE cat_id='$cat_id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Danh mục không tồn tại';
			}else{
				$duoi = $check->duoi_file($_FILES['file']['name']);
				$duoi_minhhoa = $check->duoi_file($_FILES['file_minhhoa']['name']);
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
					$minh_hoa = '/uploads/minh-hoa/' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					@unlink('..'.$r_tt['cat_img']);
					if (in_array($duoi_minhhoa, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
						$cat_minhhoa = '/uploads/minh-hoa/icon-' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi_minhhoa;
						move_uploaded_file($_FILES['file_minhhoa']['tmp_name'], '..' . $cat_minhhoa);
						@unlink('..'.$r_tt['cat_minhhoa']);
					}else{
						$cat_minhhoa=$r_tt['cat_minhhoa'];
					}
					if ($cat_blank == $link_old) {
						$ok = 1;
						$thongbao = "Sửa thể loại thành công";
						mysqli_query($conn, "UPDATE category_sanpham SET cat_tieude='$cat_tieude',cat_main='$cat_main',cat_blank='$cat_blank',cat_link='$cat_link',cat_img='$minh_hoa',cat_minhhoa='$cat_minhhoa',cat_trend='$cat_trend',cat_noibat='$cat_noibat',cat_noidung='$cat_noidung',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',cat_index='$cat_index',hoa_hong='$hoa_hong' WHERE cat_id='$cat_id'");

					} else {
						$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' AND loai='category' ORDER BY id DESC LIMIT 1");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] > 0) {
							$ok = 0;
							$thongbao = 'Thất bại! Link xem đã tồn tại';

						} else {
							$ok = 1;
							$thongbao = "Sửa thể loại thành công";
							mysqli_query($conn, "UPDATE category_sanpham SET cat_tieude='$cat_tieude',cat_blank='$cat_blank',cat_link='$cat_link',cat_img='$minh_hoa',cat_minhhoa='$cat_minhhoa',cat_trend='$cat_trend',cat_noibat='$cat_noibat',cat_noidung='$cat_noidung',cat_main='$cat_main',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',hoa_hong='$hoa_hong' WHERE cat_id='$cat_id'");
							mysqli_query($conn, "UPDATE seo SET link='$cat_blank' WHERE link='$link_old' AND loai='category'");
						}
					}
				}else{
					if (in_array($duoi_minhhoa, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
						$cat_minhhoa = '/uploads/minh-hoa/icon-' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi_minhhoa;
						move_uploaded_file($_FILES['file_minhhoa']['tmp_name'], '..' . $cat_minhhoa);
						@unlink('..'.$r_tt['cat_minhhoa']);
					}else{
						$cat_minhhoa=$r_tt['cat_minhhoa'];
					}					
					if ($cat_blank == $link_old) {
						$ok = 1;
						$thongbao = "Sửa thể loại thành công";
						mysqli_query($conn, "UPDATE category_sanpham SET cat_tieude='$cat_tieude',cat_main='$cat_main',cat_blank='$cat_blank',cat_link='$cat_link',cat_noidung='$cat_noidung',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',cat_minhhoa='$cat_minhhoa',cat_trend='$cat_trend',cat_noibat='$cat_noibat',cat_index='$cat_index',hoa_hong='$hoa_hong' WHERE cat_id='$cat_id'");

					} else {
						$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' AND loai='category' ORDER BY id DESC LIMIT 1");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] > 0) {
							$ok = 0;
							$thongbao = 'Thất bại! Link xem đã tồn tại';

						} else {
							$ok = 1;
							$thongbao = "Sửa thể loại thành công";
							mysqli_query($conn, "UPDATE category_sanpham SET cat_tieude='$cat_tieude',cat_blank='$cat_blank',cat_link='$cat_link',cat_noidung='$cat_noidung',cat_main='$cat_main',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_index='$cat_index',cat_minhhoa='$cat_minhhoa',cat_trend='$cat_trend',cat_noibat='$cat_noibat',cat_icon='$cat_icon',hoa_hong='$hoa_hong' WHERE cat_id='$cat_id'");
							mysqli_query($conn, "UPDATE seo SET link='$cat_blank' WHERE link='$link_old' AND loai='category'");
						}
					}
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);?>