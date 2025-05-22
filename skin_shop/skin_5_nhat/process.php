<?php
session_start();
$class_index = $tlca_do->load_skin($s, 'class_shop');
$check = $tlca_do->load('class_check');
$class_supership = $tlca_do->load('class_supership');
if ($action == 'check_exp') {
	// $thongtin_exp = mysqli_query($conn, "SELECT * FROM domain WHERE user_id='$shop'");
	// $r_exp = mysqli_fetch_assoc($thongtin_exp);
	// if ($r_exp['expired'] < time() and $r_exp['free'] == '0') {
	// 	$ok = 0;
	// 	$thongbao = 'Shop đã hết hạn lúc: ' . date('H:i:s d/m/Y', $r_exp['expired']);
	// } else {
	// 	$ok = 1;
	// 	$thongbao = 'Shop chưa hết hạn';
	// }
	// echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'checkout_complete') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten'] ?? ''));
	$email = addslashes(strip_tags($_REQUEST['email'] ?? ''));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai'] ?? ''));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi'] ?? ''));
	$tinh = intval($_REQUEST['tinh'] ?? 0);
	$huyen = intval($_REQUEST['huyen'] ?? 0);
	$thanhtoan = addslashes(strip_tags($_REQUEST['thanhtoan'] ?? 'cod'));
	$ghi_chu = addslashes(strip_tags($_REQUEST['ghi_chu'] ?? ''));
	$coupon = $_SESSION['coupon'] ?? '';
	$phi_ship = intval($_REQUEST['phi_ship'] ?? 28000);
	$tamtinh = intval($_REQUEST['tamtinh'] ?? 0);
	$giam = intval($_REQUEST['giam'] ?? 0);
	$tongtien = intval($_REQUEST['tongtien'] ?? 0);
	$shop = addslashes(strip_tags($_REQUEST['shop'] ?? ''));
	if (isset($_COOKIE['user_id'])) {
		$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
		$user_id = $tach_token['user_id'];
	} else {
		$user_id = 0;
	}
	function updateVoucherUsage($voucher_code, $user_id)
	{
		global $conn;
		$user_id = ($user_id === null || $user_id === '') ? 0 : intval($user_id);
		$voucher_code = mysqli_real_escape_string($conn, $voucher_code);

		mysqli_query($conn, "START TRANSACTION");
		$max_attempts = 3; // Số lần thử tối đa để tránh deadlock
		$attempt = 0;

		while ($attempt < $max_attempts) {
			$query = "SELECT id, current_uses, max_global_uses, max_uses_per_user FROM coupon WHERE ma = '$voucher_code' FOR UPDATE";
			$result = mysqli_query($conn, $query);
			$voucher = mysqli_fetch_assoc($result);

			if ($voucher && $voucher['current_uses'] < $voucher['max_global_uses']) {
				$new_uses = $voucher['current_uses'] + 1;
				$update_query = "UPDATE coupon SET current_uses = '$new_uses' WHERE id = '{$voucher['id']}' AND current_uses = '{$voucher['current_uses']}'";
				if (mysqli_query($conn, $update_query)) {
					if ($user_id > 0) {
						$voucher_id = mysqli_real_escape_string($conn, $voucher['id']);
						mysqli_query($conn, "INSERT INTO voucher_usage (voucher_id, user_id, use_date) VALUES ('$voucher_id', '$user_id', UNIX_TIMESTAMP())");
					}
					mysqli_query($conn, "COMMIT");
					return true;
				}
			} else {
				mysqli_query($conn, "ROLLBACK");
				return false;
			}
			function getUserVoucherUses($user_id, $voucher_code)
			{
				global $conn;
				$user_id = intval($user_id);
				$voucher_code = mysqli_real_escape_string($conn, $voucher_code);

				$query = "SELECT COUNT(*) AS uses FROM voucher_usage vu 
						JOIN coupon c ON vu.voucher_id = c.id 
						WHERE vu.user_id = $user_id AND c.ma = '$voucher_code'";
				$result = mysqli_query($conn, $query);
				if ($result && mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					return (int) ($row['uses'] ?? 0);
				}
				return 0;
			}
			$uses_by_user = ($user_id > 0) ? getUserVoucherUses($user_id, $voucher_code) : 0;
			if ($voucher['current_uses'] >= $voucher['max_global_uses'] && $voucher['max_global_uses'] > 0) {
				mysqli_query($conn, "ROLLBACK");
				return false;
			}
			if ($user_id > 0 && $uses_by_user >= $voucher['max_uses_per_user'] && $voucher['max_uses_per_user'] > 0) {
				mysqli_query($conn, "ROLLBACK");
				return false;
			}
			$attempt++;
			if ($attempt < $max_attempts) {
				usleep(100000); // Chờ 100ms trước khi thử lại
			}
		}

		mysqli_query($conn, "ROLLBACK");
		return false;
	}
	if (strlen($ho_ten) < 4) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập họ và tên';
	} elseif (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập số điện thoại';
	} elseif (strlen($dia_chi) < 10) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ';
	} elseif ($tinh == 0) {
		$ok = 0;
		$thongbao = 'Vui lòng chọn Tỉnh/Thành phố';
	} elseif ($huyen == 0) {
		$ok = 0;
		$thongbao = 'Vui lòng chọn Quận/Huyện';
	} else if (!in_array($thanhtoan, ['cod', 'bank', 'vnpay'])) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Phương thức thanh toán không hợp lệ']);
		exit();
	} else if ($phi_ship < 0) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Phí vận chuyển không hợp lệ']);
		exit();
	} else {
		if (count($_SESSION['cart']) == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Giỏ hàng trống';
		} else {
			$list_id = '';
			foreach ($_SESSION['cart'] as $key => $value) {
				if (isset($value['sp_id']) && !empty($value['sp_id']) && is_numeric($value['sp_id'])) {
					$list_id .= $value['sp_id'] . ',';
				}
			}
			$list_id = rtrim($list_id, ',');

			if (empty($list_id)) {
				$ok = 0;
				$thongbao = 'Thất bại! Không có sản phẩm hợp lệ trong giỏ hàng';
			} else {
				// Tính toán giỏ hàng
				$hientai = time();
				$tamtinh_server = 0;
				$giam_server = 0;
				$can_nang = 0;
				$list = '';
				$k = 0;

				// Debug: Ghi log $_SESSION['cart']
				file_put_contents('debug.log', "SESSION CART Process: " . print_r($_SESSION['cart'], true) . "\n", FILE_APPEND);

				// Tạo danh sách sản phẩm và tính toán
				$k = 0;
				foreach ($_SESSION['cart'] as $cart_item) {
					$k++;
					$id_sp = $cart_item['sp_id'];
					$r_cart = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$id_sp' AND shop='$shop'"));
					if (!$r_cart)
						continue;
					if (isset($r_cart['so_luong']) && $r_cart['so_luong'] < $cart_item['quantity']) {
						echo json_encode(['ok' => 0, 'thongbao' => "Sản phẩm {$r_cart['tieu_de']} không đủ số lượng trong kho"]);
						exit();
					}
					// Tính tổng cân nặng
					$can_nang += floatval(str_replace(',', '.', $r_cart['can_nang'])) * $cart_item['quantity'];

					$item = [
						'tieu_de' => $r_cart['tieu_de'],
						'ma_sanpham' => $r_cart['ma_sanpham'] ?? '',
						'soluong' => $cart_item['quantity'],
						'color' => $cart_item['ten_color'] ?? '',
						'size' => $cart_item['ten_size'] ?? '',
						'gia_moi' => number_format(floatval($cart_item['gia_moi'])),
						'minh_hoa' => $r_cart['minh_hoa'],
						'link' => $r_cart['link'],
						'thanhtien' => number_format(floatval($cart_item['gia_moi']) * $cart_item['quantity'])
					];

					$tamtinh_server += floatval($cart_item['gia_moi']) * $cart_item['quantity'];

					$unique_key = $id_sp . '_' . ($cart_item['ten_color'] ?? '') . '_' . ($cart_item['ten_size'] ?? '');
					if ($k == 1) {
						$list .= '"' . $unique_key . '":' . json_encode($item, JSON_UNESCAPED_UNICODE);
					} else {
						$list .= ',"' . $unique_key . '":' . json_encode($item, JSON_UNESCAPED_UNICODE);
					}
				}
				$sanpham = '{' . $list . '}';

				// Tính giảm giá từ coupon
				if (isset($_SESSION['coupon'])) {
					if (!updateVoucherUsage($coupon, $user_id)) {
						echo json_encode(['ok' => 0, 'thongbao' => 'Voucher đã đạt giới hạn sử dụng.']);
						exit();
					}
					$thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='$shop'");
					$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
					if ($r_coupon['total'] > 0 && $r_coupon['expired'] > time()) {
						if ($r_coupon['kieu'] == 'all') {
							$giam_server = $r_coupon['loai'] == 'phantram' ? ceil(($tamtinh_server / 100) * $r_coupon['giam']) : $r_coupon['giam'];
						} elseif ($r_coupon['kieu'] == 'sanpham') {
							$tach_list_id = explode(',', $list_id);
							$tach_sanpham_id = explode(',', $r_coupon['sanpham']);
							$id_apdung = array_intersect($tach_sanpham_id, $tach_list_id);
							foreach ($id_apdung as $id_sp) {
								foreach ($_SESSION['cart'] as $item) {
									if ($item['sp_id'] == $id_sp) {
										$thanhtien = floatval($item['gia_moi']) * $item['quantity'];
										$giam_server += $r_coupon['loai'] == 'phantram' ? ceil(($thanhtien / 100) * $r_coupon['giam']) : $r_coupon['giam'];
									}
								}
							}
						}
					}
				}

				$tongtien_server = $tamtinh_server - $giam_server + $phi_ship;
				$tamtinh = $tamtinh_server;
				$giam = $giam_server;
				$tongtien = $tongtien_server;

				file_put_contents('debug.log', "Sanpham: $sanpham\nTamtinh: $tamtinh\nGiam: $giam\nPhi_ship: $phi_ship\nTongtien: $tongtien\n", FILE_APPEND);

				$dayMonth = (int)date("m", $time);
				$ma_don = intval($shop . $check->random_number(4).$dayMonth);
				// $thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='$shop'");
				// $r_td = mysqli_fetch_assoc($thongtin_tichdiem);
				// $diem = ceil(($tongtien / 100000) * $r_td['diem']);

				$ok = 1;
				$thongbao = 'Đang chuyển hướng...';
				mysqli_query($conn, "INSERT INTO donhang_shop(ma_don,shop,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,status,thanhtoan,date_post,ghi_chu) VALUES ('$ma_don','$shop','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$sanpham','$tamtinh','$coupon','$giam','$phi_ship','$tongtien','0','$thanhtoan'," . time() . ",'$ghi_chu')");

				$noidung_notification = "Bạn có đơn hàng mới: #$ma_don - " . $ho_ten . " - " . $dien_thoai;
				$date_post = time();
				mysqli_query($conn, "INSERT INTO notification (user_id, sp_id, noi_dung, doc, bo_phan, admin, date_post) VALUES ('$user_id', '$ma_don', '$noidung_notification', '', 'donhang', '0', '$date_post')");
				if ($ok == 1) {
					$_SESSION['ma_don'] = $ma_don;
					unset($_SESSION['cart']);
					unset($_SESSION['coupon']);
					unset($_SESSION['main_product']);
					unset($_SESSION['muakem']);
					if ($thanhtoan == 'vnpay') {
						// Cấu hình VNPay
						$vnp_TmnCode = '8TKOSK63';
						$vnp_HashSecret = 'KWVSKMORO004EISIYKM91EVS2X5GSLH0';
						$vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
						$vnp_Returnurl = 'https://giaodiennhat.vn/checkout.html?step=3';
						
						// Tạo URL thanh toán VNPay
						//require_once($_SERVER['DOCUMENT_ROOT'] . '/vnpay_php/vnpay_create_payment.php');
						$payment_url = $class_index->createOrderVnpay($ma_don, $vnp_TmnCode, $vnp_HashSecret, $vnp_Url, $vnp_Returnurl, $tongtien);
						echo json_encode(['ok' => 1, 'thongbao' => 'Đang chuyển hướng tới VNPay...', 'redirect' => $payment_url]);
					} else {
						echo json_encode(['ok' => 1, 'thongbao' => 'Đang chuyển hướng...']);
					}
					exit();
				}
			}
		}
	}
	echo json_encode(['ok' => $ok, 'thongbao' => $thongbao]);
} 
else if ($action == 'load_huyen') {
	$tinh = intval($_REQUEST['tinh']);
	$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
	}
	echo json_encode(array('list' => $list));
} 
else if ($action == 'apply_coupon') {
    $coupon = mysqli_real_escape_string($conn, trim($_REQUEST['coupon'] ?? ''));
    $response = ['ok' => 0, 'thongbao' => ''];

    if (empty($shop)) {
        $response['thongbao'] = 'Thông tin cửa hàng không hợp lệ';
        echo json_encode($response);
        exit();
    }

    // Kiểm tra giỏ hàng
    if (empty($_SESSION['cart'])) {
        $response['thongbao'] = 'Giỏ hàng trống, không thể áp dụng mã giảm giá';
        echo json_encode($response);
        exit();
    }

    // Lấy user_id
    $user_id = 0;
    if (isset($_COOKIE['user_id'])) {
        $tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
        $user_id = $tach_token['user_id'] ?? 0;
    }

    // Kiểm tra mã đã được áp dụng
    if (isset($_SESSION['coupon']) && $_SESSION['coupon'] === $coupon) {
        $response['thongbao'] = 'Mã giảm giá đã được áp dụng';
        echo json_encode($response);
        exit();
    }

    // Truy vấn coupon
    $stmt = $conn->prepare("SELECT * FROM coupon WHERE ma = ? AND shop = ?");
    $stmt->bind_param("ss", $coupon, $shop);
    $stmt->execute();
    $result = $stmt->get_result();
    $r_coupon = $result->fetch_assoc();
    $stmt->close();

    if (!$r_coupon) {
        $response['thongbao'] = 'Mã giảm giá không tồn tại';
        echo json_encode($response);
        exit();
    }

    // Kiểm tra thời hạn
    if ($r_coupon['expired'] < time()) {
        $response['thongbao'] = 'Mã giảm giá đã hết hạn sử dụng';
        echo json_encode($response);
        exit();
    }

    // Kiểm tra giới hạn sử dụng toàn cầu
    $max_global_uses = (int)($r_coupon['max_global_uses'] ?? 0);
    $current_uses = (int)($r_coupon['current_uses'] ?? 0);
    if ($max_global_uses > 0 && $current_uses >= $max_global_uses) {
        $response['thongbao'] = 'Mã giảm giá đã đạt giới hạn sử dụng tổng cộng';
        echo json_encode($response);
        exit();
    }
	function getUserVoucherUses($user_id, $voucher_code) {
		global $conn;
		$user_id = intval($user_id);
		$voucher_code = mysqli_real_escape_string($conn, $voucher_code);
		
		$query = "SELECT COUNT(*) AS uses FROM voucher_usage vu 
				JOIN coupon c ON vu.voucher_id = c.id 
				WHERE vu.user_id = $user_id AND c.ma = '$voucher_code'";
		$result = mysqli_query($conn, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			return (int)($row['uses'] ?? 0);
		}
		return 0;
	}
    // Kiểm tra giới hạn sử dụng mỗi người
    $max_uses_per_user = (int)($r_coupon['max_uses_per_user'] ?? 0);
    if ($user_id > 0 && $max_uses_per_user > 0) {
        $user_uses = getUserVoucherUses($user_id, $coupon);
        if ($user_uses >= $max_uses_per_user) {
            $response['thongbao'] = 'Bạn đã đạt giới hạn sử dụng cho mã giảm giá này';
            echo json_encode($response);
            exit();
        }
    }

    // Tính tổng giá trị đơn hàng
    $tamtinh = 0;
    $applicable_total = 0;
    $valid_products = [];
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['sp_id']) && is_numeric($item['sp_id'])) {
            $tamtinh += floatval($item['gia_moi']) * $item['quantity'];
            $valid_products[] = $item['sp_id'];
        }
    }

    // Kiểm tra điều kiện giá trị đơn hàng
    $min_price = (int)($r_coupon['min_price'] ?? 0);
    $max_price = (int)($r_coupon['max_price'] ?? 0);
    $kieu = $r_coupon['kieu'] ?? 'all';

    if ($kieu === 'sanpham') {
        $tach_sanpham = !empty($r_coupon['sanpham']) ? explode(',', $r_coupon['sanpham']) : [];
        $valid_products = array_intersect($valid_products, $tach_sanpham);
        if (empty($valid_products)) {
            $response['thongbao'] = 'Mã giảm giá không áp dụng cho sản phẩm trong giỏ hàng';
            echo json_encode($response);
            exit();
        }
        foreach ($_SESSION['cart'] as $item) {
            if (in_array($item['sp_id'], $valid_products)) {
                $applicable_total += floatval($item['gia_moi']) * $item['quantity'];
            }
        }
    } else {
        $applicable_total = $tamtinh;
    }

    if (($min_price > 0 && $applicable_total < $min_price) || ($max_price > 0 && $applicable_total > $max_price)) {
        $response['thongbao'] = 'Giá trị đơn hàng không đủ điều kiện áp dụng mã giảm giá';
        echo json_encode($response);
        exit();
    }

    // Kiểm tra allow_combination (nếu cần)
    $allow_combination = (int)($r_coupon['allow_combination'] ?? 0);
    if (!$allow_combination && isset($_SESSION['coupon']) && $_SESSION['coupon'] !== $coupon) {
        $response['thongbao'] = 'Mã giảm giá này không thể kết hợp với mã khác';
        echo json_encode($response);
        exit();
    }

    // Áp dụng mã giảm giá
    $_SESSION['coupon'] = $r_coupon['ma'];
    $response['ok'] = 1;
    $response['thongbao'] = 'Đã áp dụng mã giảm giá';
    echo json_encode($response);
}
 else if ($action == 'add_muakem') {
	$main_product = intval($_REQUEST['main_product']);
	$list_id = addslashes(strip_tags($_REQUEST['list_id']));
	$hientai = time();
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE FIND_IN_SET($main_product,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 1;
		$_SESSION['cart'][$main_product]['quantity'] = 1;
		$tach_list_id = explode(',', $list_id);
		foreach ($tach_list_id as $key => $value) {
			$_SESSION['cart'][$value]['quantity'] = 1;
			$_SESSION['cart'][$value]['main_product'] = $main_product;
		}
		$_SESSION['main_product'][$main_product] = $main_product;
		$_SESSION['muakem'] = 1;
	} else {
		$ok = 0;
		$thongbao = 'Sản phẩm không nằm trong chương trình mua kèm deal sốc';
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'add_to_cart') {
	$sp_id = intval($_REQUEST['sp_id'] ?? 0);
	$variant_id = intval($_REQUEST['variant_id'] ?? 0);
	$mau = addslashes(strip_tags($_REQUEST['mau'] ?? ''));
	$size = addslashes(strip_tags($_REQUEST['size'] ?? ''));
	$ten_color = addslashes(strip_tags($_REQUEST['ten_color'] ?? ''));
	$ten_size = addslashes(strip_tags($_REQUEST['ten_size'] ?? ''));
	$gia_moi = intval($_REQUEST['gia_moi'] ?? 0);
	$quantity = intval($_REQUEST['quantity'] ?? 1);
	$loai = addslashes(strip_tags($_REQUEST['loai'] ?? ''));
	$hientai = time();
	$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai'AND  shop ='$shop'");
	$r_tt_deal = mysqli_fetch_assoc($thongtin_deal);
	$sub_product_arr = json_decode($r_tt_deal['sub_product'], true);

	if ($sp_id <= 0) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không hợp lệ']);
		exit();
	}

	// Kiểm tra giá và tồn kho nếu có biến thể
	if ($mau && $size && $gia_moi <= 0) {
		$query = "SELECT gia_moi, kho_sanpham_shop FROM phanloai_sanpham_shop WHERE sp_id='$sp_id' AND color='$mau' AND size='$size'";
		$result = mysqli_query($conn, $query);
		if ($row = mysqli_fetch_assoc($result)) {
			$gia_moi = $row['gia_moi'];
			if ($row['kho_sanpham_shop'] < $quantity) {
				echo json_encode(['ok' => 0, 'thongbao' => 'Số lượng tồn kho không đủ']);
				exit();
			}
		}
	}

	// Tạo key duy nhất cho sản phẩm
	$cart_key = $sp_id . '_' . $mau . '_' . $size;

	// Lưu vào session, cộng dồn số lượng nếu đã tồn tại
	if (!isset($_SESSION['cart'][$cart_key])) {
		$_SESSION['cart'][$cart_key] = [
			'sp_id' => $sp_id,
			'quantity' => $quantity,
			'color' => $mau,
			'size' => $size,
			'ten_color' => $ten_color,
			'ten_size' => $ten_size,
			'gia_moi' => $gia_moi,
			'variant_id' => $variant_id,
			'flash_sale' => ($loai == 'flash_sale') ? 1 : 0
		];
	} else {
		$_SESSION['cart'][$cart_key]['quantity'] += $quantity;
	}

	// Xử lý quà tặng
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$sp_id' AND shop='$shop'");
	$r_tt = mysqli_fetch_assoc($thongtin);

	$thongtin_tang = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='tang' AND shop='$shop' ORDER BY id DESC LIMIT 1");
	$r_tang = mysqli_fetch_assoc($thongtin_tang);
	$total_tang = mysqli_num_rows($thongtin_tang);
	if ($total_tang > 0) {
		$tach_tang = explode(',', $r_tang['sub_id']);
		foreach ($tach_tang as $value) {
			$tang_key = $value . '_0_0';
			if (!isset($_SESSION['cart'][$tang_key])) {
				$_SESSION['cart'][$tang_key] = [
					'sp_id' => $value,
					'quantity' => 1,
					'tang' => 1,
					'main_product' => $sp_id,
					'color' => '',
					'size' => '',
					'ten_color' => '',
					'ten_size' => '',
					'gia_moi' => 0,
					'flash_sale' => 0,
					'variant_id' => $variant_id,
				];
			}
		}
	}

	// Tạo danh sách giỏ hàng
	$list = '';
	$tongtien = 0;
	$valid_ids = [];
	$list_check_product = [];
	$variants = []; // khởi tạo mảng
	foreach ($_SESSION['cart'] as $key => $value) {
		if (isset($value['sp_id']) && !empty($value['sp_id']) && is_numeric($value['sp_id'])) {
			$valid_ids[] = $value['sp_id'];
			if ($value['flash_sale'] == 1) {
				$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET(" . $value['sp_id'] . ",main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck = mysqli_fetch_assoc($thongtin_check);
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
	}

	$valid_ids = array_unique($valid_ids);
	if (empty($valid_ids)) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Giỏ hàng không chứa sản phẩm hợp lệ']);
		exit();
	}

	$list_id = implode(',', $valid_ids);
	$list_c = [];
	foreach ($list_check_product as $value) {
		foreach ($value as $k => $v) {
			$list_c[$k] = $v;
		}
	}
	if (is_array($list_c[$sp_id][0])) {
		foreach ($list_c[$sp_id] as $variant) {
			if ((int) $variant['variant_id'] === (int) $variant_id) {
				$price_deal = $variant['gia'];
			}
		}
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			if ($list_c[$value['sp_id']][0]) {
				foreach ($list_c[$value['sp_id']] as $variant) {
					if ((int) $variant['variant_id'] === (int) $value['variant_id']) {
						$price_deal = $variant['gia'];
					}
				}
			}
		}
	}
	// var_dump($price_deal);
	// die();
	$stmt = $conn->prepare("SELECT * FROM sanpham_shop WHERE id IN (" . rtrim(str_repeat('?,', count($valid_ids)), ',') . ") AND shop=? ORDER BY FIELD(id," . rtrim(str_repeat('?,', count($valid_ids)), ',') . ")");
	$params = array_merge($valid_ids, [$shop], $valid_ids);
	$stmt->bind_param(str_repeat('i', count($valid_ids)) . 's' . str_repeat('i', count($valid_ids)), ...$params);
	$stmt->execute();
	$thongtin_cart = $stmt->get_result();

	while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
		$id_sp = $r_cart['id'];
		foreach ($_SESSION['cart'] as $key => $value) {
			if ($value['sp_id'] == $id_sp) {
				$r_cart['quantity'] = $value['quantity'];
				$r_cart['color'] = $value['color'];
				$r_cart['size'] = $value['size'];
				if ($value['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['variant_info'] = '';
				} elseif (isset($list_c[$id_sp]) && $value['flash_sale'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$tongtien += $value['gia_moi'] * $value['quantity'];
					$r_cart['thanhtien'] = number_format($value['gia_moi'] * $value['quantity']);
					$r_cart['gia_moi'] = number_format($value['gia_moi']);
					$r_cart['variant_info'] = 'Màu: ' . $value['ten_color'] . ' - Size: ' . $value['ten_size'];
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$gia_variant = $value['gia_moi'];
					$tongtien += $gia_variant * $value['quantity'];
					$r_cart['thanhtien'] = number_format($gia_variant * $value['quantity']);
					$r_cart['gia_moi'] = number_format($gia_variant);
					$r_cart['variant_info'] = 'Màu: ' . $value['ten_color'] . ' - Size: ' . $value['ten_size'];
				}
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			}
		}
	}

	$name = '<a href="/product/' . $r_tt['link'] . '.html" style="color:red;" title="' . $r_tt['tieu_de'] . '">' . $r_tt['tieu_de'] . '</a>';
	$total_price = number_format($tongtien) . ' ₫';

	echo json_encode([
		'ok' => 1,
		'total' => count($_SESSION['cart']),
		'name' => $name,
		'list' => $list,
		'total_cart' => count($_SESSION['cart']),
		'total_price' => $total_price, // Sửa key từ 'tongtien' thành 'total_price' để đồng bộ với process.js
		'thongbao' => 'Thêm vào giỏ hàng thành công'
	]);
	exit();
	////////////////////////////////////////
} else if ($action == 'update_cart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$quantity = intval($_REQUEST['quantity']);
	if (isset($_SESSION['cart'][$sp_id]) and $quantity > 1) {
		$_SESSION['cart'][$sp_id]['quantity'] = $quantity;
	} else {
		$_SESSION['cart'][$sp_id]['quantity'] = 1;
	}
	$hientai = time();
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$sp_id' AND shop='$shop'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	$thongtin_tang = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='tang' AND shop='$shop' ORDER BY id DESC LIMIT 1");
	$r_tang = mysqli_fetch_assoc($thongtin_tang);
	$total_tang = mysqli_num_rows($thongtin_tang);
	if ($total_tang > 0) {
		$tach_tang = explode(',', $r_tang['sub_id']);
		foreach ($tach_tang as $key => $value) {
			$_SESSION['cart'][$value]['quantity'] = 1;
			$_SESSION['cart'][$value]['tang'] = 1;
			$_SESSION['cart'][$value]['main_product'] = $sp_id;
		}
	} else {
	}
	$name = '<a href="/product/' . $r_tt['link'] . '.html" style="color:red;" title="' . $r_tt['tieu_de'] . '">' . $r_tt['tieu_de'] . '</a>';
	if (isset($_SESSION['muakem'])) {
		foreach ($_SESSION['main_product'] as $key => $value) {
			$list_main_id .= $value . ',';
			$thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
			$r_mk = mysqli_fetch_assoc($thongtin_muakem);
			$list_id_mk .= $r_mk['sub_id'] . ',';
			$list_sub_product[] = json_decode($r_mk['sub_product'], true);
		}
		foreach ($list_sub_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_s[$k] = $v;
			}
		}
		$list_main_id = substr($list_main_id, 0, -1);
		$tach_list_main_id = explode(',', $list_main_id);
		$list_id_mk = substr($list_id_mk, 0, -1);
		$tach_list_id_mk = explode(',', $list_id_mk);
		$list_id_check = '';
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
			if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
				$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck = mysqli_fetch_assoc($thongtin_check);
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
		foreach ($list_check_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_c[$k] = $v;
			}
		}
		$list_id = substr($list_id, 0, -1);
		$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id) ASC");
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
			if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
				$total_price += 0;
				$r_cart['thanhtien'] = 0;
				$r_cart['gia_moi'] = 0;
				$r_cart['quantity'] = 1;
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop_tang', $r_cart);
			} else if (in_array($id_sp, $tach_list_id_mk) == true) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
				if ($list_s[$id_sp]['gia'] != '') {
					$tongtien += preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']));
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				} else {
					$gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $list_s[$id_sp]['sale'];
					$tongtien += $gia_moi * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format($gia_moi * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format($gia_moi);
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				}
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$tongtien += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			}
		}
		$total_price = number_format($tongtien) . 'đ';
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
			if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
				$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck = mysqli_fetch_assoc($thongtin_check);
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
		foreach ($list_check_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_c[$k] = $v;
			}
		}
		$list_id = substr($list_id, 0, -1);
		$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
			if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
				$total_price += 0;
				$r_cart['thanhtien'] = 0;
				$r_cart['gia_moi'] = 0;
				$r_cart['quantity'] = 1;
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$total_price += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$total_price += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			}
		}
		$total_price = number_format($total_price) . 'đ';
	}
	echo json_encode(array('ok' => 1, 'total' => count($_SESSION['cart']), 'list' => $list, 'total_cart' => count($_SESSION['cart']), 'total_price' => $total_price, 'thongbao' => 'Thêm vào giỏ hàng thành công'));
} else if ($action == 'update_shopcart') {
	$sp_id = intval($_REQUEST['sp_id'] ?? 0);
	$color = addslashes(strip_tags($_REQUEST['color'] ?? ''));
	$size = addslashes(strip_tags($_REQUEST['size'] ?? ''));
	$quantity = intval($_REQUEST['quantity'] ?? 1);
	$hientai = time();

	if ($sp_id <= 0) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không hợp lệ']);
		exit();
	}

	// Tạo key duy nhất cho sản phẩm dựa trên sp_id, color và size
	$cart_key = $sp_id . '_' . $color . '_' . $size;

	// Cập nhật số lượng trong session
	if (isset($_SESSION['cart'][$cart_key])) {
		$_SESSION['cart'][$cart_key]['quantity'] = $quantity > 0 ? $quantity : 1;
	} else {
		echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không tồn tại trong giỏ hàng']);
		exit();
	}

	$tongtien = 0;
	$list_shopcart = '';
	$list_shopcart_mobile = '';
	$valid_ids = [];
	$list_check_product = [];
	$list_sub_product = [];
	$list_s = [];
	$list_c = [];

	// Lấy danh sách sản phẩm trong giỏ hàng
	foreach ($_SESSION['cart'] as $key => $value) {
		if (isset($value['sp_id']) && !empty($value['sp_id']) && is_numeric($value['sp_id'])) {
			$valid_ids[] = $value['sp_id'];
			if ($value['flash_sale'] == 1) {
				$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET(" . $value['sp_id'] . ",main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck = mysqli_fetch_assoc($thongtin_check);
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
	}

	$valid_ids = array_unique($valid_ids);
	if (empty($valid_ids)) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Giỏ hàng không chứa sản phẩm hợp lệ']);
		exit();
	}

	$list_id = implode(',', $valid_ids);
	foreach ($list_check_product as $value) {
		foreach ($value as $k => $v) {
			$list_c[$k] = $v;
		}
	}

	// Xử lý mua kèm nếu có
	if (isset($_SESSION['muakem'])) {
		$list_main_id = '';
		foreach ($_SESSION['main_product'] as $value) {
			if (is_numeric($value)) {
				$list_main_id .= $value . ',';
				$thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_mk = mysqli_fetch_assoc($thongtin_muakem);
				$list_sub_product[] = json_decode($r_mk['sub_product'], true);
			}
		}
		foreach ($list_sub_product as $value) {
			foreach ($value as $k => $v) {
				$list_s[$k] = $v;
			}
		}
		$list_main_id = rtrim($list_main_id, ',');
		$tach_list_main_id = explode(',', $list_main_id);
		$tach_list_id_mk = explode(',', rtrim($r_mk['sub_id'] ?? '', ','));
	}

	$stmt = $conn->prepare("SELECT * FROM sanpham_shop WHERE id IN (" . rtrim(str_repeat('?,', count($valid_ids)), ',') . ") AND shop=? ORDER BY FIELD(id," . rtrim(str_repeat('?,', count($valid_ids)), ',') . ")");
	$params = array_merge($valid_ids, [$shop], $valid_ids);
	$stmt->bind_param(str_repeat('i', count($valid_ids)) . 's' . str_repeat('i', count($valid_ids)), ...$params);
	$stmt->execute();
	$thongtin_cart = $stmt->get_result();

	while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
		$id_sp = $r_cart['id'];
		foreach ($_SESSION['cart'] as $key => $value) {
			if ($value['sp_id'] == $id_sp) {
				$r_cart['quantity'] = $value['quantity'];
				$r_cart['color'] = $value['color'];
				$r_cart['size'] = $value['size'];

				if ($value['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$tongtien += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['variant_info'] = '';
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
				} elseif (isset($_SESSION['muakem']) && in_array($id_sp, $tach_list_id_mk ?? [])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
					if (!empty($list_s[$id_sp]['gia'])) {
						$gia_deal = preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']);
						$tongtien += $gia_deal * $value['quantity'];
						$r_cart['thanhtien'] = number_format($gia_deal * $value['quantity']);
						$r_cart['gia_moi'] = number_format($gia_deal);
					} else {
						$gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * ($list_s[$id_sp]['sale'] ?? 0);
						$tongtien += $gia_moi * $value['quantity'];
						$r_cart['thanhtien'] = number_format($gia_moi * $value['quantity']);
						$r_cart['gia_moi'] = number_format($gia_moi);
					}
					$r_cart['variant_info'] = 'Màu: ' . $value['ten_color'] . ' - Size: ' . $value['ten_size'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				} elseif (isset($list_c[$id_sp]) && $value['flash_sale'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					if ($list_c[$value['sp_id']][0]) {
						foreach ($list_c[$value['sp_id']] as $variant) {
							if ((int) $variant['variant_id'] === (int) $value['variant_id']) {
								$gia_flash = $variant['gia'];
							}
						}
					}
					$tongtien += $gia_flash * $value['quantity'];
					$r_cart['thanhtien'] = number_format($gia_flash * $value['quantity']);
					$r_cart['gia_moi'] = number_format($gia_flash);
					$r_cart['variant_info'] = 'Màu: ' . $value['ten_color'] . ' - Size: ' . $value['ten_size'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$gia_variant = $value['gia_moi'];
					$tongtien += $gia_variant * $value['quantity'];
					$r_cart['thanhtien'] = number_format($gia_variant * $value['quantity']);
					$r_cart['gia_moi'] = number_format($gia_variant);
					$r_cart['variant_info'] = 'Màu: ' . $value['ten_color'] . ' - Size: ' . $value['ten_size'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				}
			}
		}
	}

	$total_price = number_format($tongtien) . ' ₫';
	echo json_encode([
		'ok' => 1,
		'list_shopcart' => $list_shopcart,
		'list_shopcart_mobile' => $list_shopcart_mobile,
		'total_cart' => count($_SESSION['cart']),
		'tongtien' => $total_price,
		'thongbao' => 'Cập nhật giỏ hàng thành công'
	]);
	exit();
} else if ($action == 'remove_shopcart') {
	$sp_id = intval($_REQUEST['sp_id'] ?? 0);
	$color = addslashes($_REQUEST['color'] ?? '');
	$size = addslashes($_REQUEST['size'] ?? '');
	$hientai = time();

	if ($sp_id <= 0) {
		echo json_encode(['ok' => 0, 'thongbao' => 'ID sản phẩm không hợp lệ']);
		exit();
	}

	$found = false;
	foreach ($_SESSION['cart'] as $key => $value) {
		if (!empty($color) && !empty($size)) {
			if ($value['sp_id'] == $sp_id && $value['color'] == $color && $value['size'] == $size) {
				unset($_SESSION['cart'][$key]);
				$found = true;
				break;
			}
		} else {
			if ($value['sp_id'] == $sp_id) {
				unset($_SESSION['cart'][$key]);
				$found = true;
				break;
			}
		}
	}

	if (!$found) {
		echo json_encode(['ok' => 0, 'thongbao' => 'Không tìm thấy sản phẩm trong giỏ hàng']);
		exit();
	}

	// Xử lý quà tặng hoặc sản phẩm phụ thuộc
	foreach ($_SESSION['cart'] as $key => $value) {
		if (isset($value['main_product']) && $value['main_product'] == $sp_id) {
			unset($_SESSION['cart'][$key]);
		}
	}

	// Xử lý mua kèm
	if (isset($_SESSION['main_product'][$sp_id])) {
		if (count($_SESSION['main_product']) > 1) {
			unset($_SESSION['main_product'][$sp_id]);
		} else {
			unset($_SESSION['main_product']);
			unset($_SESSION['muakem']);
		}
		$thongtin_main = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
		$r_main = mysqli_fetch_assoc($thongtin_main);
		$tach_sub = json_decode($r_main['sub_product'], true);
		foreach ($tach_sub as $key => $value) {
			foreach ($_SESSION['cart'] as $cart_key => $cart_value) {
				if ($cart_value['sp_id'] == $key) {
					unset($_SESSION['cart'][$cart_key]);
				}
			}
		}
	}

	// Tính toán lại tổng tiền và tạm tính
	if (count($_SESSION['cart']) > 0) {
		$tongtien = 0;
		$tamtinh = 0;
		$list_shopcart = '';
		$list_shopcart_mobile = '';
		$valid_ids = [];

		foreach ($_SESSION['cart'] as $key => $value) {
			if (isset($value['sp_id']) && !empty($value['sp_id']) && is_numeric($value['sp_id'])) {
				$valid_ids[] = $value['sp_id'];

				// Lấy thông tin sản phẩm từ DB
				$stmt = $conn->prepare("SELECT * FROM sanpham_shop WHERE id = ? AND shop = ?");
				$stmt->bind_param("is", $value['sp_id'], $shop);
				$stmt->execute();
				$product = $stmt->get_result()->fetch_assoc();

				if ($product) {
					$gia_moi = $value['gia_moi'] ?? $product['gia_moi'];
					$quantity = $value['quantity'] ?? 1;
					$tamtinh += $gia_moi * $quantity;
					$tongtien = $tamtinh; // Có thể thêm logic giảm giá nếu cần

					// Render lại danh sách sản phẩm (dành cho mobile hoặc trường hợp đặc biệt)
					$replace = [
						'id' => $value['sp_id'],
						'link' => $product['link'],
						'tieu_de' => htmlspecialchars($product['tieu_de']),
						'minh_hoa' => $product['minh_hoa'],
						'ten_sanpham' => htmlspecialchars($product['ten_sanpham']),
						'gia_moi' => number_format($gia_moi),
						'color' => $value['color'] ?? '',
						'size' => $value['size'] ?? '',
						'quantity' => $quantity,
						'variant_info' => ($value['color'] ? "Màu: " . $value['color'] : '') . ($value['size'] ? " - Size: " . $value['size'] : '')
					];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/list_shopcart', $replace);
					$list_shopcart_mobile .= $list_shopcart; // Có thể tùy chỉnh cho mobile
				}
			}
		}

		$total_price = number_format($tongtien) . ' ₫';
		$tamtinh_price = number_format($tamtinh) . ' ₫';
		echo json_encode([
			'ok' => 1,
			'list_shopcart' => $list_shopcart,
			'list_shopcart_mobile' => $list_shopcart_mobile,
			'total_cart' => count($_SESSION['cart']),
			'tongtien' => $total_price,
			'tamtinh' => $tamtinh_price,
			'thongbao' => 'Xóa sản phẩm thành công'
		]);
	} else {
		unset($_SESSION['cart']);
		unset($_SESSION['muakem']);
		unset($_SESSION['main_product']);
		echo json_encode([
			'ok' => 1,
			'list_shopcart' => '',
			'list_shopcart_mobile' => '',
			'total_cart' => 0,
			'tongtien' => '0 ₫',
			'tamtinh' => '0 ₫',
			'thongbao' => 'Giỏ hàng đã trống'
		]);
	}
	exit();
} else if ($action == 'remove_cart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$color = addslashes(strip_tags($_REQUEST['color'] ?? ''));
	$size = addslashes(strip_tags($_REQUEST['size'] ?? ''));

	// Create unique key for cart item
	$cart_key = $sp_id;
	if (!empty($color) || !empty($size)) {
		$cart_key .= '_' . $color . '_' . $size;
	}

	// Remove the item
	if (isset($_SESSION['cart'][$cart_key])) {
		unset($_SESSION['cart'][$cart_key]);
	}

	// Calculate new totals
	$tongtien = 0;
	$list = '';
	foreach ($_SESSION['cart'] as $key => $value) {
		$id_sp = $value['sp_id'];
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$id_sp' AND shop='$shop'");
		$r_cart = mysqli_fetch_assoc($thongtin);

		if ($r_cart) {
			if ($value['tang'] == 1) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
				$r_cart['thanhtien'] = 0;
				$r_cart['gia_moi'] = 0;
				$r_cart['quantity'] = 1;
				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop_tang', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$gia = $value['gia_moi'] ?? $r_cart['gia_moi'];
				$tongtien += $gia * $value['quantity'];
				$r_cart['thanhtien'] = number_format($gia * $value['quantity']);
				$r_cart['gia_moi'] = number_format($gia);
				$r_cart['quantity'] = $value['quantity'];
				$r_cart['color'] = $value['color'] ?? '';
				$r_cart['size'] = $value['size'] ?? '';
				$r_cart['ten_color'] = $value['ten_color'] ?? '';
				$r_cart['ten_size'] = $value['ten_size'] ?? '';

				// Tạo giá trị cho variant_info
				$variant_info = '';
				if (!empty($r_cart['ten_color'])) {
					$variant_info .= 'Màu: ' . $r_cart['ten_color'];
				}
				if (!empty($r_cart['ten_size'])) {
					$variant_info .= ($variant_info ? ' - ' : '') . 'Size: ' . $r_cart['ten_size'];
				}
				$r_cart['variant_info'] = $variant_info ?: 'Không có biến thể';

				$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_pop', $r_cart);
			}
		}
	}

	echo json_encode([
		'ok' => 1,
		'total' => count($_SESSION['cart']),
		'list' => $list,
		'total_price' => number_format($tongtien) . ' ₫'
	]);
} else if ($action == 'load_product') {
	$url = strip_tags($_REQUEST['url']);
	$url = addslashes($url);
	$cat_id = preg_replace('/[^0-9]/', '', $_REQUEST['cat_id']);
	$bien_url = parse_url($url);
	parse_str($bien_url['query'], $bien);
	if (intval($bien['page']) > 1) {
		$page = intval($bien['page']);
	} else {
		$page = 1;
	}
	$sort = $bien['sort'];
	if (isset($bien['sort'])) {
		if ($sort == 'price-ascending') {
			$order = 'gia_moi ASC';
		} else if ($sort == 'price-descending') {
			$order = 'gia_moi DESC';
		} else if ($sort == 'title-ascending') {
			$order = 'tieu_de ASC';
		} else if ($sort == 'title-descending') {
			$order = 'tieu_de DESC';
		} else if ($sort == 'created-ascending') {
			$order = 'date_post ASC';
		} else if ($sort == 'created-descending') {
			$order = 'date_post DESC';
		} else if ($sort == 'best-selling') {
			$order = 'ban DESC';
		} else {
			$order = 'date_post DESC';
		}
	} else {
		$order = 'date_post DESC';
		$sort = 'created-descending';
	}
	$color = addslashes(strip_tags($bien['color']));
	if (isset($bien['color']) and strpos($color, '*') !== false) {
		$tach_color = explode('*', $color);
		$c = 0;
		foreach ($tach_color as $key => $value) {
			$c++;
			if ($c == 1) {
				$color_where .= '(FIND_IN_SET(' . $value . ',mau)>0 OR ';
			} else if ($c == count($tach_color)) {
				$color_where .= 'FIND_IN_SET(' . $value . ',mau)>0) ';
			} else {
				$color_where .= 'FIND_IN_SET(' . $value . ',mau)>0 OR ';
			}
		}
	} else if (isset($bien['color'])) {
		$color_where = 'FIND_IN_SET(' . $color . ',mau)>0';
	} else {
		$color_where = '';
	}
	$size = addslashes(strip_tags($bien['size']));
	if (isset($bien['size']) and strpos($size, '*') !== false) {
		$tach_size = explode('*', $size);
		$s = 0;
		foreach ($tach_size as $key => $value) {
			$s++;
			if ($s == 1) {
				if ($color_where != '') {
					$size_where .= 'AND (FIND_IN_SET(' . $value . ',size)>0 OR ';
				} else {
					$size_where .= '(FIND_IN_SET(' . $value . ',size)>0 OR ';
				}
			} else if ($s == count($tach_size)) {
				$size_where .= 'FIND_IN_SET(' . $value . ',size)>0) ';
			} else {
				$size_where .= 'FIND_IN_SET(' . $value . ',size)>0 OR ';
			}
		}
	} else if (isset($bien['size'])) {
		if ($color_where != '') {
			$size_where = 'AND FIND_IN_SET(' . $color . ',size)>0';
		} else {
			$size_where = 'FIND_IN_SET(' . $color . ',size)>0';
		}
	} else {
		$size_where = '';
	}
	$brand = addslashes(strip_tags($bien['brand']));
	if (isset($bien['brand']) and strpos($brand, '*') !== false) {
		$tach_brand = explode('*', $brand);
		$b = 0;
		foreach ($tach_brand as $key => $value) {
			$b++;
			if ($b == 1) {
				if ($color_where != '' or $size_where != '') {
					$brand_where .= 'AND (FIND_IN_SET(' . $value . ',thuong_hieu)>0 OR ';
				} else {
					$brand_where .= '(FIND_IN_SET(' . $value . ',thuong_hieu)>0 OR ';
				}
			} else if ($b == count($tach_brand)) {
				$brand_where .= 'FIND_IN_SET(' . $value . ',thuong_hieu)>0) ';
			} else {
				$brand_where .= 'FIND_IN_SET(' . $value . ',thuong_hieu)>0 OR ';
			}
		}
	} else if (isset($bien['brand'])) {
		if ($color_where != '' or $size_where != '') {
			$brand_where = 'AND FIND_IN_SET(' . $brand . ',thuong_hieu)>0';
		} else {
			$brand_where = 'FIND_IN_SET(' . $brand . ',thuong_hieu)>0';
		}
	} else {
		$brand_where = '';
	}
	$price = addslashes(strip_tags($bien['price']));
	if (isset($bien['price']) and strpos($price, '*') !== false) {
		$tach_price = explode('*', $price);
		$p = 0;
		foreach ($tach_price as $key => $value) {
			$p++;
			$tach_value = explode('-', $value);
			if ($p == 1) {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "AND (gia_moi<'" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "AND (gia_moi>'" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "AND ((gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "') OR ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi<'" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "(gia_moi>'" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "((gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "') OR ";
					}
				}
			} else if ($p == count($tach_brand)) {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<'" . $max_price . "')";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>'" . $min_price . "')";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "')) ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<'" . $max_price . "')";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>'" . $min_price . "')";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "')) ";
					}
				}
			} else {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<'" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>'" . $min_price . "' OR";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "') OR ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<'" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>'" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "') OR ";
					}
				}
			}
		}
	} else if (isset($bien['price'])) {
		$tach_price = explode('-', $price);
		if ($color_where != '' or $size_where != '' or $brand_where != '') {
			if ($tach_price[0] == 0) {
				$max_price = $tach_price[1];
				$price_where = "AND gia_moi<'" . $max_price . "'";
			} else if ($tach_price[1] == 999999999999) {
				$min_price = $tach_price[0];
				$price_where = "AND gia_moi>'" . $min_price . "'";
			} else {
				$min_price = $tach_price[0];
				$max_price = $tach_price[1];
				$price_where = "AND gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "'";
			}
		} else {
			if ($tach_price[0] == 0) {
				$max_price = $tach_price[1];
				$price_where = "gia_moi<'" . $max_price . "'";
			} else if ($tach_price[1] == 999999999999) {
				$min_price = $tach_price[0];
				$price_where = "gia_moi>'" . $min_price . "'";
			} else {
				$min_price = $tach_price[0];
				$max_price = $tach_price[1];
				$price_where = "gia_moi>'" . $min_price . "' AND gia_moi<'" . $max_price . "'";
			}
		}
	} else {
		$price_where = '';
	}
	if (strpos($url, 'tim-kiem.html') !== false) {
		$limit = 16;
		$tukhoa = addslashes(strip_tags($bien['key']));
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where . " AND tieu_de LIKE '%$tukhoa%'";
		} else {
			$where = "tieu_de LIKE '%$tukhoa%'";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $shop, $where, $order, $page, $limit);
	} else if ($cat_id > 0) {
		$limit = 16;
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where . " AND FIND_IN_SET($cat_id,cat)>0";
		} else {
			$where = "FIND_IN_SET($cat_id,cat)>0";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $shop, $where, $order, $page, $limit);
	} else {
		$limit = 16;
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where;
		} else {
			$where = "";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $shop, $where, $order, $page, $limit);
	}
	$info = array(
		'list' => $ketqua,
		'ok' => 1
	);
	echo json_encode($info);
} 
else if ($action == 'register') {
	$email = addslashes(strip_tags($_REQUEST['email']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_passpord = addslashes(strip_tags($_REQUEST['re_password']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$username = addslashes(strip_tags($_REQUEST['username']));
	if ($check->check_username($username) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Tài khoản không đúng định dạng';
	} else if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Địa chỉ email không đúng';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_passpord) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE username='$username' AND shop='$shop'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Tài khoản đã tồn tại trên hệ thống';
		} else {
			$thongtin_e = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='$shop'");
			$r_e = mysqli_fetch_assoc($thongtin_e);
			if ($r_e['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Email đã tồn tại trên hệ thống';
			} else {
				$ok = 1;
				$thongbao = 'Đăng ký tài khoản thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				// mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,dia_chi,dropship,ctv,code_active,active,chinh_thuc,created,date_update,ip_address,logined,end_online,aff,about,nhom)
				// 											      VALUES('$username','$shop','0','0','$email','$pass','$ho_ten','','$dien_thoai','','','','','','','','0','0','','1','0','$hientai','$hientai','$ip_address','','','','','')");
				mysqli_query($conn, "INSERT INTO user_info (user_id, shop, username, password, email, name, avatar, mobile, domain, ngaysinh, gioi_tinh, tinh, huyen, xa, dia_chi, active, ctv, created, date_update)
                													VALUES (NULL, '0', '$username', '$pass', '$email', '$ho_ten', '', '$dien_thoai', '', '0', '0', '0', '0', '0', '0', '1', '0', '$hientai', '$hientai')");
			}
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} 
else if ($action == 'change_profile') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$ngay_sinh = addslashes(strip_tags($_REQUEST['ngay_sinh']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if (strlen($ho_ten) < 4) {
		$ok = 0;
		$thongbao = 'Họ và tên quá ngắn';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Địa chỉ email không đúng';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($ngay_sinh) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập ngày sinh';
	} else if (strlen($dia_chi) < 5) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ';
	} else {
		if ($email != $user_info['email']) {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Email đã tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Lưu thay đổi thành công!';
				mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',mobile='$dien_thoai',ngaysinh='$ngay_sinh',dia_chi='$dia_chi' WHERE user_id='$user_id'");
			}
		} else {
			$ok = 1;
			$thongbao = 'Lưu thay đổi thành công!';
			mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',mobile='$dien_thoai',ngaysinh='$ngay_sinh',dia_chi='$dia_chi' WHERE user_id='$user_id'");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'change_avatar') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
		$minh_hoa = '/uploads/avatar/' . $check->blank($user_info['name']) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
		@unlink('.' . $user_info['avatar']);
		$thongbao = 'Thay hình đại diện thành công';
		$ok = 1;
		mysqli_query($conn, "UPDATE user_info SET avatar='$minh_hoa' WHERE user_id='$user_id'");
	} else {
		$thongbao = 'Vui lòng chọn ảnh đại diện';
		$ok = 0;
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'change_password') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$password = addslashes(strip_tags($_REQUEST['password']));
	$pass_old = md5($password);
	$new_password = addslashes(strip_tags($_REQUEST['new_password']));
	$confirm_password = addslashes(strip_tags($_REQUEST['confirm_password']));
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($pass_old != $user_info['password']) {
		$ok = 0;
		$thongbao = 'Mật khẩu hiện tại không đúng';
	} else if (strlen($new_password) < 6) {
		$ok = 0;
		$thongbao = 'Mật khẩu mới phải dài từ 6 ký tự';
	} else if ($new_password != $confirm_password) {
		$ok = 0;
		$thongbao = 'Nhập lại mật khẩu mới không đúng';
	} else {
		$thongbao = 'Thành công! Đã cập nhật mật khẩu mới';
		$ok = 1;
		$pass_new = md5($new_password);
		mysqli_query($conn, "UPDATE user_info SET password='$pass_new' WHERE user_id='$user_id'");
		setcookie("user_id", $_COOKIE['user_id'], time() - 3600);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'forgot_password') {
	if (isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Bạn đã đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Email không đúng định dạng';
	} else {
		$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email'");
		$r_tt = mysqli_fetch_assoc($thongtin_email);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Email không tồn tại trên hệ thống';
		} else {
			$code_active = $check->random_string(10);
			$passnew = $check->random_number(8);
			$link_active = $index_setting['link_domain'] . 'confirm_password.php?email=' . $email . '&token=' . $code_active;
			$mailer = new PHPMailer(); // khởi tạo đối tượng
			$mailer->IsSMTP(); // gọi class smtp để đăng nhập
			$mailer->CharSet = "utf-8"; // bảng mã unicode
			$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
			$mailer->SMTPSecure = "ssl"; // Giao thức SSL
			$mailer->Host = $index_setting['email_server']; // SMTP của GMAIL
			$mailer->Port = $index_setting['email_server_port']; // cổng SMTP
			$mailer->Username = $index_setting['email']; // GMAIL username
			$mailer->Password = $index_setting['email_password']; // GMAIL password
			$mailer->FromName = $index_setting['email_name']; // tên người gửi
			$mailer->From = $index_setting['email']; // mail người gửi
			$mailer->AddAddress($email, $r_tt['name']); //thêm mail của admin
			$mailer->Subject = 'Lấy lại mật khẩu';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = 'Mật khẩu mới của bạn tại ' . $index_setting['link_domain'] . ' là: ' . $passnew . ', vui lòng bấm vào link <a href="' . $link_active . '">' . $link_active . '</a> để xác nhận thay đổi';
			if ($mailer->Send() == true) {
				mysqli_query($conn, "INSERT INTO forgot_password (email,password,code_active,date_post)VALUES('$email','$passnew','$code_active'," . time() . ")");
				$ok = 1;
				$thongbao = 'Mật khẩu đã được gửi tới email của bạn';
			} else {
				$ok = 0;
				$thongbao = 'Gặp lỗi trong quá trình gửi mail';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'timkiem') {
	$key = addslashes(strip_tags($_REQUEST['key_search']));
	$key = strtolower($key);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM dangky_email WHERE ma_don='$key' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Không tìm thấy kết quả phù hợp';
	} else {
		$ok = 1;
		$thongbao = 'Đã tìm thấy! Hệ thống đang chuyển hướng';
		$link = '/tracuu-detail.html?hoso=' . $key;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'goi_y') {
	$key = addslashes(strip_tags($_REQUEST['key']));
	$thongtin = mysqli_query($conn, "SELECT * FROM truyen WHERE tieu_de LIKE '%$key%' AND chap!='' ORDER BY tieu_de ASC LIMIT 10");
	$total = mysqli_num_rows($thongtin);
	if ($total == 0) {
		$list = '<center>Không có kết quả phù hợp</center>';
	} else {
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_timkiem', $r_tt);
		}
	}
	$info = array(
		'ok' => 1,
		'list' => $list
	);
	echo json_encode($info);
} else if ($action == 'lienhe') {
	$name = addslashes(strip_tags($_REQUEST['ho_ten']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$subject = addslashes(strip_tags($_REQUEST['tieu_de']));
	$message = addslashes(strip_tags($_REQUEST['noi_dung']));
	if ($name == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên của bạn';
	} else if ($email == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ email';
	} else if ($subject == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập chủ đề';
	} else if ($message == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập nội dung';
	} elseif (time() - $_SESSION['contact'] < 15) {
		$ok = 0;
		$thongbao = 'Bạn thực hiện quá nhanh';
	} else {
		$ok = 1;
		mysqli_query($conn, "INSERT INTO contact_shop (shop,name,email,subject,message,status,date_post)VALUES('$shop','$name','$email','$subject','$message','0'," . time() . ")");
		$_SESSION['contact'] = time();
		$thongbao = 'Cảm ơn bạn! Việc liên hệ đã thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'dangky_nhantin') {
	$email = addslashes(strip_tags($_REQUEST['email']));
	if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ email';
	} else {
		$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM dangky_nhantin WHERE email='$email' AND shop='$shop'");
		$r_tt = mysqli_fetch_assoc($thongtin_email);
		if ($r_tt['total'] == 0) {
			$ok = 1;
			mysqli_query($conn, "INSERT INTO dangky_nhantin (shop,email,date_post)VALUES('$shop','$email'," . time() . ")");
			$thongbao = 'Đăng ký nhận tin thành công!';
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Email đã đăng ký nhận tin';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'get_popup') {
	if (isset($_COOKIE['user_id'])) {
		$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
		$user_id = $tach_token['user_id'];
		$gioihan = time() - 15 * 24 * 3600;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE FIND_IN_SET($user_id,poped)<1 AND pop='1' AND date_post>'$gioihan' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') AND shop='$shop' ORDER BY id ASC LIMIT 1");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			$ok = 0;
		} else {
			$ok = 1;
			$r_tt = mysqli_fetch_assoc($thongtin);
			$tach_doc = explode(',', $r_tt['poped']);
			if (in_array($user_id, $tach_doc) == true) {
			} else {
				if ($r_tt['poped'] == '') {
					mysqli_query($conn, "UPDATE thongbao_shop SET poped='$user_id' WHERE id='{$r_tt['id']}'");
				} else {
					$doc = $r_tt['poped'] . ',' . $user_id;
					mysqli_query($conn, "UPDATE thongbao_shop SET poped='$doc' WHERE id='{$r_tt['id']}'");
				}
			}
			$content = '<a href="/thongbao-chitiet?id=' . $r_tt['id'] . '"><img src="' . $r_tt['img_pop'] . '" alt="' . $r_tt['tieu_de'] . '"></a>';
			//$content='';
		}
	} else {
		$user_id = 0;
		$ok = 0;
		$content = '';
	}
	$thongtin_doc = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE FIND_IN_SET($user_id,doc)<1 AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') AND shop='$shop'");
	$count_note = mysqli_num_rows($thongtin_doc);
	if ($count_note > 9) {
		$count_note = '9+';
	}
	$info = array(
		'ok' => $ok,
		'content' => $content,
		'count_note' => $count_note
	);
	echo json_encode($info);
} else if ($action == 'check_blank') {
	$link = $check->blank($_REQUEST['link']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else if ($action == 'check_link') {
	$link = $check->blank($_REQUEST['link']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else if ($action == 'quick_view') {
	global $skin, $s;
	$sp_id = (int) $_REQUEST['sp_id'];
	$link = addslashes(strip_tags($_REQUEST['link']));
	$shop = $r_shop['user_id'];

	// Lấy thông tin sản phẩm
	$stmt = $conn->prepare("SELECT * FROM sanpham_shop WHERE id=? AND shop=?");
	$stmt->bind_param("is", $sp_id, $shop);
	$stmt->execute();
	$r_tt = $stmt->get_result()->fetch_assoc();
	if (!$r_tt) {
		echo "Sản phẩm không tồn tại.";
		exit();
	}

	// Lấy biến thể
	$stmt = $conn->prepare("SELECT * FROM phanloai_sanpham_shop WHERE sp_id=?");
	$stmt->bind_param("i", $sp_id);
	$stmt->execute();
	$thongtin_phanloai = $stmt->get_result();

	$variants = [];
	$colors = [];
	$sizes = [];
	$kho_total = 0;
	$deal_sp = [];
	$hientai = time();

	$sql = "SELECT * FROM deal WHERE date_start <= ? AND date_end >= ? AND FIND_IN_SET(?, main_product) AND shop = ?";

	$stmt_deal = $conn->prepare($sql);
	$stmt_deal->bind_param("iiss", $hientai, $hientai, $sp_id, $shop);
	$stmt_deal->execute();

	$result = $stmt_deal->get_result();
	$data = $result->fetch_assoc();
	$sub_product_arr = json_decode($data['sub_product'], true);

	while ($r_phanloai = $thongtin_phanloai->fetch_assoc()) {
		$variant_id = $r_phanloai['id'];
		$gia_cu = isset($r_phanloai['gia_cu']) ? (int) $r_phanloai['gia_cu'] : 0;

		if (isset($sub_product_arr[$sp_id])) {
			foreach ($sub_product_arr[$sp_id] as $variant) {
				if ($variant['variant_id'] == $variant_id) {
					$kho_total += $r_phanloai['kho_sanpham_shop'];

					$variants[] = [
						'variant_id' => $variant['variant_id'],
						'color' => $r_phanloai['color'],
						'ten_color' => $r_phanloai['ten_color'],
						'ma_mau' => $r_phanloai['ma_mau'],
						'size' => $r_phanloai['size'],
						'ten_size' => $r_phanloai['ten_size'],
						'kho' => $r_phanloai['kho_sanpham_shop'],
						'gia_moi' => $variant['gia'],
						'gia_cu' => $variant['gia_cu'],
					];
					$colors[$r_phanloai['color']] = [
						'ten_color' => $r_phanloai['ten_color'],
						'ma_mau' => $r_phanloai['ma_mau'],
					];

					$sizes[$r_phanloai['size']] = [
						'ten_size' => $r_phanloai['ten_size'],
					];
				}
			}
		} else {
			$kho_total += $r_phanloai['kho_sanpham_shop'];
			$variants[] = [
				'variant_id' => $variant_id,
				'color' => $r_phanloai['color'],
				'ten_color' => $r_phanloai['ten_color'],
				'ma_mau' => $r_phanloai['ma_mau'],
				'size' => $r_phanloai['size'],
				'ten_size' => $r_phanloai['ten_size'],
				'kho' => $r_phanloai['kho_sanpham_shop'],
				'gia_moi' => $r_phanloai['gia_moi'],
				'gia_cu' => $gia_cu,
			];

			$colors[$r_phanloai['color']] = [
				'ten_color' => $r_phanloai['ten_color'],
				'ma_mau' => $r_phanloai['ma_mau'],
			];

			$sizes[$r_phanloai['size']] = [
				'ten_size' => $r_phanloai['ten_size'],
			];
		}
	}

	// Xử lý danh sách màu
	$list_mau = '';
	$m = 0;
	foreach ($colors as $color_id => $color_info) {
		$m++;
		$checked = $m == 1 ? 'checked' : '';
		$list_mau .= '<div class="color-swatch">
                        <input class="variant-color" id="mau-' . $color_id . '" type="radio" name="mau" value="' . $color_id . '" ' . $checked . ' data-ten-color="' . $color_info['ten_color'] . '" data-ma-mau="' . $color_info['ma_mau'] . '" />
                        <label for="mau-' . $color_id . '" style="background-color: ' . $color_info['ma_mau'] . ';"></label>
                      </div>';
	}
	$option_mau = !empty($colors) ? '<div class="color-options">' . $list_mau . '</div>' : '';

	// Xử lý danh sách kích cỡ ban đầu
	$list_size = '';
	$ss = 0;
	$first_color = array_key_first($colors);
	foreach ($variants as $variant) {
		if ($variant['color'] == $first_color) {
			$ss++;
			$checked = $ss == 1 ? 'checked' : '';
			$list_size .= '<div class="n-sd swatch-element">
                            <input class="variant-size" id="size-' . $variant['size'] . '" type="radio" name="size" value="' . $variant['size'] . '" ' . $checked . ' data-kho="' . $variant['kho'] . '" data-gia="' . $variant['gia_moi'] . '" data-gia-cu="' . $variant['gia_cu'] . '" data-ten-size="' . $variant['ten_size'] . '" />
                            <label for="size-' . $variant['size'] . '">' . $variant['ten_size'] . '</label>
                          </div>';
		}
	}
	$option_size = !empty($sizes) ? '<div class="select-swatch"><div id="variant-swatch-1" class="swatch clearfix"><div class="header">Size</div><div class="select-swap" id="size-swap">' . $list_size . '</div></div></div>' : '';

	// Ảnh sản phẩm
	$list_anh = '';
	if (strlen($r_tt['anh']) > 3) {
		$tach_anh = explode(",", $r_tt['anh']);
		foreach ($tach_anh as $value) {
			$list_anh .= '<img class="img-responsive" src="' . $value . '" alt="' . $r_tt['tieu_de'] . '">';
		}
	}

	// Tình trạng kho
	if ($kho_total > 0 || $r_tt['kho_hang'] > 0) {
		$tinh_trang = 'Còn hàng';
		$disabled = '';
		$text_button = 'Thêm vào giỏ hàng';
	} else {
		$tinh_trang = 'Hết hàng';
		$disabled = ' disabled';
		$text_button = 'Hết hàng';
	}

	// Đặt giá cũ ban đầu
	$initial_gia_cu = !empty($variants) ? $variants[0]['gia_cu'] : (isset($r_tt['gia_cu']) ? (int) $r_tt['gia_cu'] : 0);

	// Chuẩn bị dữ liệu thay thế
	$hientai = time();
	$id_sp = $r_tt['id'];

	$sql = "SELECT COUNT(*) as total FROM deal 
			WHERE date_start <= '$hientai' 
			  AND date_end >= '$hientai' 
			  AND shop = '$shop' 
			  AND FIND_IN_SET($id_sp, main_product) 
			  AND loai = 'flash_sale'";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$loai = ($row['total'] > 0) ? 'flash_sale' : '';
	$replace = [
		'id' => $r_tt['id'],
		'tieu_de' => htmlspecialchars($r_tt['tieu_de']),
		'minh_hoa' => $r_tt['minh_hoa'],
		'gia_moi' => number_format($r_tt['gia_moi']),
		'gia_moi_raw' => $r_tt['gia_moi'],
		'gia_cu' => number_format($initial_gia_cu),
		'tinh_trang' => $tinh_trang,
		'thuong_hieu' => htmlspecialchars($r_tt['thuong_hieu'] ?? 'Không xác định'),
		'noi_dung' => $r_tt['noi_dung'],
		'option_mau' => $option_mau,
		'option_size' => $option_size,
		'list_anh' => $list_anh,
		'loai' => $loai,
		'kho' => $kho_total,
		'quantity_default' => 1,
		'disabled' => $disabled,
		'text_button' => $text_button,
		'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
		'script_variants' => '<script>window.variants = ' . json_encode($variants) . ';</script>' ///// 26-5

	];

	echo $skin->skin_replace('skin_shop/' . $s . '/tpl/quick_view', $replace);
} else if ($action == 'load_sp_more_index') {
	$limit = (int) $_REQUEST['limit'];
	$list_sp = $class_index->list_home_goiy($conn, $s, $shop, $limit);
	echo json_encode(
		[
			'ok' => 1,
			'list_sp' => $list_sp,
		]
	);
} else if ($action == 'fee_ship') {
	$sender_province = addslashes(strip_tags($_REQUEST['sender_province'] ?? ''));
	$sender_district = addslashes(strip_tags($_REQUEST['sender_district'] ?? ''));
	$receiver_province = addslashes(strip_tags($_REQUEST['receiver_province'] ?? ''));
	$receiver_district = addslashes(strip_tags($_REQUEST['receiver_district'] ?? ''));
	$weight = intval($_REQUEST['weight'] ?? 0);
	$amount = intval($_REQUEST['amount'] ?? 0);

	// $data_ship = $class_supership->get_tax($sender_province,$sender_district,$receiver_province,$receiver_district,$weight, $amount, $accessToken);
	$data_ship = $class_supership->get_tax($sender_province, $sender_district, $receiver_province, $receiver_district, $weight, $amount, $accessToken);
	$phi_ship = $data_ship['results'][0]['fee'];

	echo json_encode([
		'ok' => 1,
		'fee' => $phi_ship,
	]);
	// echo json_encode([
	//     'success' => true,
	//     'sender_province' => $sender_province,
	//     'sender_district' => $sender_district,
	//     'receiver_province' => $receiver_province,
	//     'receiver_district' => $receiver_district,
	//     'weight' => $weight,
	//     'amount' => $amount,
	// 	'fee'=> $data_ship
	// ]);
} else if ($action == 'search_suggestions') {
	$keyword = addslashes(strip_tags($_REQUEST['keyword'] ?? ''));
	$list_muakem_id = $_REQUEST['list_muakem_id'] ?? ''; // Giả sử dữ liệu được gửi qua request
	$list_tang_id = $_REQUEST['list_tang_id'] ?? '';
	$list_flashsale_id = $_REQUEST['list_flashsale_id'] ?? '';
	$list_c = $_REQUEST['list_c'] ?? []; // Giả sử list_c là mảng, cần xử lý phù hợp

	$class_index = $tlca_do->load_skin($s, 'class_shop');
	$suggestions = $class_index->get_search_suggestions($conn, $s, $shop, $keyword);
	echo json_encode($suggestions);
} else if ($action == 'show_cart') {
	global $conn, $skin, $s, $shop;

	$list_shopcart = '';
	$list_shopcart_mobile = '';
	$list_cart = '';
	$tongtien = 0;
	$hientai = time();

	// Check if cart is empty
	if (empty($_SESSION['cart'])) {
		echo json_encode([
			'ok' => 0,
			'list_shopcart' => '',
			'list_shopcart_mobile' => '',
			'list_cart' => '',
			'total_cart' => 0,
			'tongtien' => '0 đ',
			'thongbao' => 'Giỏ hàng của bạn đang trống'
		]);
		exit;
	}

	// Collect product IDs
	$list_id = '';
	foreach ($_SESSION['cart'] as $item) {
		if (isset($item['sp_id']) && !empty($item['sp_id'])) {
			$list_id .= mysqli_real_escape_string($conn, $item['sp_id']) . ',';
		}
	}

	if (empty($list_id)) {
		echo json_encode([
			'ok' => 0,
			'list_shopcart' => '',
			'list_shopcart_mobile' => '',
			'list_cart' => '',
			'total_cart' => 0,
			'tongtien' => '0 đ',
			'thongbao' => 'Không có sản phẩm hợp lệ trong giỏ hàng'
		]);
		exit;
	}

	$list_id = substr($list_id, 0, -1);
	$query = "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop=? ORDER BY FIELD(id, $list_id)";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "s", $shop);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (!$result) {
		echo json_encode([
			'ok' => 0,
			'thongbao' => 'Lỗi truy vấn cơ sở dữ liệu: ' . mysqli_error($conn)
		]);
		exit;
	}

	// Handle muakem deals
	$list_main_id = '';
	$list_id_mk = '';
	$list_sub_product = [];
	if (isset($_SESSION['muakem']) && !empty($_SESSION['main_product'])) {
		foreach ($_SESSION['main_product'] as $value) {
			$list_main_id .= mysqli_real_escape_string($conn, $value) . ',';
			$query = "SELECT * FROM deal WHERE FIND_IN_SET(?, main_product)>0 AND date_start<=? AND date_end>=? AND loai='muakem' AND shop=? ORDER BY id DESC LIMIT 1";
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "siss", $value, $hientai, $hientai, $shop);
			mysqli_stmt_execute($stmt);
			$thongtin_muakem = mysqli_stmt_get_result($stmt);
			if ($r_mk = mysqli_fetch_assoc($thongtin_muakem)) {
				$list_id_mk .= $r_mk['sub_id'] . ',';
				$list_sub_product[] = json_decode($r_mk['sub_product'], true);
			}
		}
		$list_s = [];
		foreach ($list_sub_product as $value) {
			foreach ($value as $k => $v) {
				$list_s[$k] = $v;
			}
		}
		$list_main_id = rtrim($list_main_id, ',');
		$tach_list_main_id = explode(',', $list_main_id);
		$list_id_mk = rtrim($list_id_mk, ',');
		$tach_list_id_mk = explode(',', $list_id_mk);
	}

	// Handle flash sale products
	$list_check_product = [];
	foreach ($_SESSION['cart'] as $item) {
		if (isset($item['flash_sale']) && $item['flash_sale'] == 1 && isset($item['sp_id'])) {
			$query = "SELECT * FROM deal WHERE FIND_IN_SET(?, main_product)>0 AND date_start<=? AND date_end>=? AND loai='flash_sale' AND shop=? ORDER BY id DESC LIMIT 1";
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "siss", $item['sp_id'], $hientai, $hientai, $shop);
			mysqli_stmt_execute($stmt);
			$thongtin_check = mysqli_stmt_get_result($stmt);
			if ($r_ck = mysqli_fetch_assoc($thongtin_check)) {
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
	}
	$list_c = [];
	foreach ($list_check_product as $value) {
		foreach ($value as $k => $v) {
			$list_c[$k] = $v;
		}
	}

	while ($r_cart = mysqli_fetch_assoc($result)) {
		$id_sp = $r_cart['id'];
		foreach ($_SESSION['cart'] as $key => $item) {
			if (isset($item['sp_id']) && $item['sp_id'] == $id_sp) {
				$r_cart['quantity'] = $item['quantity'];
				$r_cart['color'] = $item['color'] ?? '';
				$r_cart['size'] = $item['size'] ?? '';
				$r_cart['variant_info'] = 'Màu: ' . ($item['ten_color'] ?? '') . ' - Size: ' . ($item['ten_size'] ?? '');

				if (isset($item['tang']) && $item['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['variant_info'] = '';
				} elseif (isset($tach_list_id_mk) && in_array($id_sp, $tach_list_id_mk)) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
					if (!empty($list_s[$id_sp]['gia'])) {
						$gia_deal = preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']);
						$tongtien += $gia_deal * $item['quantity'];
						$r_cart['thanhtien'] = number_format($gia_deal * $item['quantity']);
						$r_cart['gia_moi'] = number_format($gia_deal);
					} else {
						$gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $list_s[$id_sp]['sale'];
						$tongtien += $gia_moi * $item['quantity'];
						$r_cart['thanhtien'] = number_format($gia_moi * $item['quantity']);
						$r_cart['gia_moi'] = number_format($gia_moi);
					}
				} elseif (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$gia_flash = 0;
					if (isset($list_c[$id_sp][0]) && is_array($list_c[$id_sp])) {
						foreach ($list_c[$id_sp] as $variant) {
							if ((int) $variant['variant_id'] === (int) ($item['variant_id'] ?? 0)) {
								$gia_flash = preg_replace('/[^0-9]/', '', $variant['gia']);
							}
						}
					}
					if ($gia_flash == 0) {
						$gia_flash = $r_cart['gia_moi'] * 0.8; // Fallback to 20% discount
					}
					$tongtien += $gia_flash * $item['quantity'];
					$r_cart['thanhtien'] = number_format($gia_flash * $item['quantity']);
					$r_cart['gia_moi'] = number_format($gia_flash);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$gia_variant = $item['gia_moi'] ?? $r_cart['gia_moi'];
					$tongtien += $gia_variant * $item['quantity'];
					$r_cart['thanhtien'] = number_format($gia_variant * $item['quantity']);
					$r_cart['gia_moi'] = number_format($gia_variant);
				}

				// Replace templates
				$template = (isset($item['tang']) && $item['tang'] == 1) ? '_tang' : '';
				$list_shopcart .= $skin->skin_replace("skin_shop/{$s}/tpl/box_li/li_shopcart{$template}", $r_cart);
				$list_cart .= $skin->skin_replace("skin_shop/{$s}/tpl/box_li/li_cart{$template}", $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace("skin_shop/{$s}/tpl/box_li/li_shopcart_mobile{$template}", $r_cart);
			}
		}
	}

	$total_price = number_format($tongtien) . ' đ';

	echo json_encode([
		'ok' => 1,
		'list_shopcart' => $list_shopcart,
		'list_shopcart_mobile' => $list_shopcart_mobile,
		'list_cart' => $list_cart,
		'total_cart' => count($_SESSION['cart']),
		'tongtien' => $total_price,
		'thongbao' => 'Cập nhật giỏ hàng thành công'
	]);
	exit;
} else if ($action == 'remove_cart' && isset($_POST['id'])) {
	$product_id = mysqli_real_escape_string($conn, $_POST['id']);

	if (isset($_SESSION['cart'][$product_id])) {
		unset($_SESSION['cart'][$product_id]);
		echo json_encode([
			'ok' => 1,
			'total_cart' => count($_SESSION['cart']),
			'thongbao' => 'Xóa sản phẩm thành công'
		]);
	} else {
		echo json_encode([
			'ok' => 0,
			'thongbao' => 'Sản phẩm không tồn tại trong giỏ hàng'
		]);
	}
	exit;
} 
// else if ($action == 'vnpay') {
//     // Cấu hình VNPay
//     $vnp_TmnCode = '8TKOSK63';
//     $vnp_HashSecret = 'KWVSKMORO004EISIYKM91EVS2X5GSLH0';
//     $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
//     $vnp_Returnurl = 'http://' . $_SERVER['HTTP_HOST'] . '/vnpay_php/vnpay_return.php';
    
//     // Tạo đơn hàng trước
//     $order_id = createOrder($conn, $user_id, $payment_method, $total_amount, $shipping_fee, $discount_amount);
    
//     if ($order_id) {
//         require_once($_SERVER['DOCUMENT_ROOT'] . '/vnpay_php/vnpay_create_payment.php');
//         $payment_url = createOrderVnpay($order_id, $vnp_TmnCode, $vnp_HashSecret, $vnp_Url, $vnp_Returnurl, $tongtien);
//         echo json_encode(['ok' => 1, 'redirect_url' => $payment_url]);
//         exit;
//     } else {
//         echo json_encode(['ok' => 0, 'msg' => 'Không thể tạo đơn hàng']);
//         exit;
//     }
// } 
else {
	echo "Không có hành động nào được xử lý";
}

