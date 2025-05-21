<?php
ini_set('display_errors', 1); // Bật debug trên server
error_reporting(E_ALL);
$user_id = $tach_token['user_id']; // Giả định từ token
$loai = addslashes($_REQUEST['loai']);
$id = preg_replace('/[^0-9a-z]/', '', $_REQUEST['id']);
$reload = null;
if (isset($_POST['selectedIds'])) {
	$ids = array_map('intval', $_POST['selectedIds']);
}
if ($loai == 'category') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category_shop WHERE cat_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Danh mục không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa danh mục thành công';
		mysqli_query($conn, "DELETE FROM category_shop WHERE cat_id='$id' AND shop='$user_id'");
		mysqli_query($conn, "DELETE FROM seo_shop WHERE link='{$r_tt['cat_blank']}' AND loai='theloai' AND shop='$user_id'");
	}
} else if ($loai == 'category_sanpham') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category_sanpham_shop WHERE cat_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Danh mục không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa danh mục thành công';
		mysqli_query($conn, "DELETE FROM category_sanpham_shop WHERE cat_id='$id' AND shop='$user_id'");
		mysqli_query($conn, "DELETE FROM seo_shop WHERE link='{$r_tt['cat_blank']}' AND loai='category' AND shop='$user_id'");
	}
} else if ($loai == 'menu') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM menu_shop WHERE menu_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Menu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa menu thành công';
		mysqli_query($conn, "DELETE FROM menu_shop WHERE menu_id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'thanhvien') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Thành viên này không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa thành viên thành công';
		@unlink('..' . $r_tt['avatar']);
		mysqli_query($conn, "DELETE FROM user_info WHERE user_id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'coupon') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu này không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa coupon thành công';
		mysqli_query($conn, "DELETE FROM coupon WHERE id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'deal') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu này không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa deal sốc thành công';
		mysqli_query($conn, "DELETE FROM deal WHERE id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'flash_sale') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu này không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa flash sale thành công';
		$reload = 1;
		mysqli_query($conn, "DELETE FROM deal WHERE id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'bom') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM bom_hang WHERE user_id='$user_id' AND id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa bom hàng thành công';
		mysqli_query($conn, "DELETE FROM bom_hang WHERE id='$id' AND user_id='$user_id'");
	}
} else if ($loai == 'brand') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thuong_hieu WHERE shop='$user_id' AND id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa thương hiệu thành công';
		mysqli_query($conn, "DELETE FROM thuong_hieu WHERE id='$id' AND shop='$user_id'");
	}
}
// nhatthem114
else if ($loai == 'transport') {
	// $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM transport WHERE user_id = '$user_id' AND id='$id'");
	// $r_tt = mysqli_fetch_assoc($thongtin);
	// if ($r_tt['total'] == 0) {
	// 	$ok = 0;
	// 	$thongbao = 'Dữ liệu không tồn tại';
	// } else {
	// 	$ok = 1;
	// 	$thongbao = 'Xóa địa chỉ giao nhận thành công';
	// 	mysqli_query($conn, "DELETE FROM transport WHERE id = '$id' AND user_id = '$user_id' AND is_default = 0");
	// }
	$sql = "SELECT COUNT(*) AS total, is_default FROM transport WHERE user_id = ? AND id = ?";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "ii", $user_id, $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);
	mysqli_stmt_close($stmt);

	if ($row['total'] == 0) {
		$ok = 0;
		$thongbao = 'Địa chỉ không tồn tại';
	} elseif ($row['is_default'] == 1) {
		$ok = 0;
		$thongbao = 'Không thể xóa địa chỉ mặc định';
	} else {
		$sql = "DELETE FROM transport WHERE id = ? AND user_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
		if (mysqli_stmt_execute($stmt)) {
			$ok = 1;
			$thongbao = 'Xóa địa chỉ giao nhận thành công';
		} else {
			$ok = 0;
			$thongbao = 'Lỗi khi xóa địa chỉ: ' . mysqli_stmt_error($stmt);
		}
		mysqli_stmt_close($stmt);
	}
} else if ($loai == 'bank_accounts') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM bank_accounts WHERE user_id = '$user_id' AND id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa tài khoản ngân hàng thành công';
		mysqli_query($conn, "DELETE FROM bank_accounts WHERE id = '$id' AND user_id = '$user_id' AND is_default = 0");
	}
} else if ($loai == 'size') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM kich_co WHERE shop='$user_id' AND id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa kích cỡ thành công';
		mysqli_query($conn, "DELETE FROM kich_co WHERE id='$id' AND shop='$user_id'");
	}
} else if ($loai == 'color') {

	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM mau_sanpham WHERE shop='$user_id' AND id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Màu sản phẩm không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa màu sản phẩm thành công';
		mysqli_query($conn, "DELETE FROM mau_sanpham WHERE shop='$user_id' AND id='$id'");
	}
} else if ($loai == 'remarketing') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thongbao_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa Remarketing thành công';
		mysqli_query($conn, "DELETE FROM thongbao_shop WHERE id='$id' AND shop='$user_id'");
		@unlink('..' . $r_tt['minh_hoa']);
		@unlink('..' . $r_tt['img_pop']);
	}
} else if ($loai == 'baiviet') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM post_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Bài viết không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa bài viết thành công';
		mysqli_query($conn, "DELETE FROM post_shop WHERE id='$id' AND shop='$user_id'");
		if (strpos($r_tt['minh_hoa'], $index_setting['link_img']) !== false) {
			@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
		} else {
			@unlink('..' . $r_tt['minh_hoa']);
		}
		mysqli_query($conn, "DELETE FROM seo_shop WHERE link='{$r_tt['link']}' AND loai='baiviet' AND shop='$user_id'");
	}
} else if ($loai == 'slide') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM slide WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Slide không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa slide thành công';
		mysqli_query($conn, "DELETE FROM slide WHERE id='$id'");
		@unlink('..' . $r_tt['minh_hoa']);
	}
} else if ($loai == 'sanpham') {
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] == 0) {	
        $ok = 0;
        $thongbao = 'Sản phẩm không tồn tại';
    } else {
        $ok = 1;
        $thongbao = 'Xóa sản phẩm thành công';
        mysqli_query($conn, "DELETE FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
        // mysqli_query($conn, "DELETE FROM sanpham WHERE id='{$r_tt['sp_id']}'");
        mysqli_query($conn, "DELETE FROM phanloai_sanpham WHERE sp_id='{$r_tt['sp_id']}' AND user_id='$user_id'");
        mysqli_query($conn, "DELETE FROM phanloai_sanpham_shop WHERE sp_id='$id' AND user_id='$user_id'");
        mysqli_query($conn, "DELETE FROM seo_shop WHERE link='{$r_tt['link']}' AND loai='sanpham' AND shop='$user_id'");
    }
}
// huyphuc24/04/2025
else if ($loai == 'xoanhieu_sanpham') {
	$success_count = 0;
	$total_count = count($ids);

	foreach ($ids as $id) {
		// Lấy thông tin sản phẩm
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		$tach_anh = explode(',', $r_tt['anh']);
		// foreach ($tach_anh as $key => $value) {
		// 	$tach_value = explode('/uploads/', $value);
		// 	@unlink('../uploads/' . $tach_value[1]);
		// }
		// @unlink('..' . $r_tt['minh_hoa']);
		// // Thực hiện xóa sản phẩm
		$query = "DELETE FROM sanpham_shop WHERE id='$id' AND shop='$user_id'";
		if (mysqli_query($conn, $query)) {
			// Xóa phân loại sản phẩm
			$query_phanloai = "DELETE FROM phanloai_sanpham_shop WHERE sp_id='$id'";
			if (mysqli_query($conn, $query_phanloai)) {
				// Xóa seo sản phẩm
				$query_seo = "DELETE FROM seo_shop WHERE link='{$r_tt['link']}' AND loai='sanpham' AND shop='$user_id'";
				if (mysqli_query($conn, $query_seo)) {
					$success_count++;
				}
			}
		}
	}

	// Trả về kết quả
	if ($success_count == $total_count) {
		$ok = 1;
		$thongbao = 'Đã xóa thành công sản phẩm';
		$reload = 1;
	} else {
		$ok = 0;
		$thongbao = 'xóa sản phẩm thất bại';
	}
} else if ($loai == 'donhang_drop') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Đơn hàng không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa đơn hàng thành công';
		mysqli_query($conn, "DELETE FROM donhang WHERE id='$id' AND user_id='$user_id'");
	}
} else if ($loai == 'contact') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM contact_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Liên hệ không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa liên hệ thành công';
		mysqli_query($conn, "DELETE FROM contact_shop WHERE id='$id'");
	}
} else if ($loai == 'banner') {
	$query = "SELECT minh_hoa FROM banner WHERE id = '$id'";
	$result = mysqli_query($conn, $query);
	if ($result && $row = mysqli_fetch_assoc($result)) {
		$minh_hoa = $row['minh_hoa'];
		if ($minh_hoa && file_exists(".." . $minh_hoa)) {
			unlink(".." . $minh_hoa);
		}
	}
	$query = "DELETE FROM banner WHERE id = '$id'";
	if (mysqli_query($conn, $query)) {
		$thongbao = "Xóa banner thành công!";
		$ok = 1;
	} else {
		$thongbao = "Lỗi: " . mysqli_error($conn);
		$ok = 0;
	}
} else if ($loai == 'share_sanpham') {
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM list_share_sanpham WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Nội dung không tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Xóa nội dung thành công';
		$tach_hinhanh = explode(',', $r_tt['minh_hoa']);
		foreach ($tach_hinhanh as $key => $value) {
			if (strlen($value) > 5) {
				@unlink('..' . $value);
			}
		}
		mysqli_query($conn, "DELETE FROM list_share_sanpham WHERE id='$id'");
	}
}
$info = array(
	'ok' => $ok,
	'thongbao' => $thongbao,
	'reload' => $reload, //huyphuc25/04/2025
);
echo json_encode($info);
