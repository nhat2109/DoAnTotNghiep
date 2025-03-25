<?php
// echo "Action received: " . $action;

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $key = $_POST['key'] ?? '';

//     // Ghi log để kiểm tra
//     file_put_contents('debug_log.txt', "Received key: " . $key . "\n", FILE_APPEND);

//     // Trả về dữ liệu để debug
//     echo "Received: " . htmlspecialchars($key);
// }
if($r_cat['cat_main']==0){
	$list_category_sub=$tach_category['list_main'];
}else{
	$thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_id']}' AND shop='{$r_shop['user_id']}'");
	$total_sub=mysqli_num_rows($thongtin_sub);
	if($total_sub>0){
		while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
			$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub['cat_blank'].'.html" class="nav-link" title="'.$r_sub['cat_tieude'].'">'.$r_sub['cat_tieude'].'</a></li>';
		}
	}else{
		$thongtin_sub_main=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_main']}' AND shop='{$r_shop['user_id']}'");
		while($r_sub_main=mysqli_fetch_assoc($thongtin_sub_main)){
			if($r_cat['cat_id']==$r_sub_main['cat_id']){
				$list_category_sub.='<li class="active"><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}else{
				$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}
		}
	}
}
$class_index = $tlca_do->load_skin($s, 'class_shop');
if ($action == 'check_exp') {
	$thongtin_exp = mysqli_query($conn, "SELECT * FROM domain WHERE user_id='$shop'");
	$r_exp = mysqli_fetch_assoc($thongtin_exp);
	if ($r_exp['expired'] < time() and $r_exp['free'] == '0') {
		$ok = 0;
		$thongbao = 'Shop đã hết hạn lúc: ' . date('H:i:s d/m/Y', $r_exp['expired']);
	} else {
		$ok = 1;
		$thongbao = 'Shop chưa hết hạn';
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'checkout_step_1') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$tinh = intval(strip_tags($_REQUEST['tinh']));
	$huyen = intval(strip_tags($_REQUEST['huyen']));
	$coupon = $_SESSION['coupon'];
	if (strlen($ho_ten) < 4) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập số điện thoại';
	} else if (strlen($dia_chi) < 10) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ';
	} else if ($tinh == '') {
		$ok = 0;
		$thongbao = 'Vui lòng chọn Tỉnh/Thành phố';
	} else if ($huyen == '') {
		$ok = 0;
		$thongbao = 'Vui lòng chọn Quận/Huyện';
	} else {
		$ok = 1;
		$thongbao = 'Đang chuyển hướng...';
		$_SESSION['ho_ten'] = $ho_ten;
		$_SESSION['email'] = $email;
		$_SESSION['dien_thoai'] = $dien_thoai;
		$_SESSION['dia_chi'] = $dia_chi;
		$_SESSION['tinh'] = $tinh;
		$_SESSION['huyen'] = $huyen;
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'checkout_step_2') {
	if (isset($_COOKIE['user_id'])) {
		$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
		$user_id = $tach_token['user_id'];
	} else {
		$user_id = 0;
	}
	$thanhtoan = addslashes(strip_tags($_REQUEST['thanhtoan']));
	if (count((array)$_SESSION['cart']) == 0) {
		$ok = 0;
		$thongbao = 'Thất bại! Giỏ hàng trống';
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
		}
		$list_id = substr($list_id, 0, -1);
		if (isset($_SESSION['coupon'])) {
			$thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='$shop'");
			$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
			if ($r_coupon['kieu'] == 'sanpham') {
				$tach_list_id = explode(',', $list_id);
				$tach_sanpham_id = explode(',', $r_coupon['sanpham']);
				$id_apdung = array_intersect($tach_sanpham_id, $tach_list_id);
				$total_id = count($id_apdung);
			}
		}
		$hientai = time();
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
			$thongtin_cart = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.ma_sanpham FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.id IN ($list_id) AND sanpham_shop.shop='$shop' ORDER BY FIELD(sanpham_shop.id,$list_id) ASC");
			$k = 0;
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$k++;
				$id_sp = $r_cart['id'];
				if ($r_cart['can_nang'] == '') {
					$can_nang += 0;
				} else {
					$can_nang += str_replace(',', '.', $r_cart['can_nang']) * $_SESSION['cart'][$id_sp]['quantity'];
				}
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Quà tặng] ' . $r_cart['tieu_de'];
					$tamtinh += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['quantity'] = 1;
				} else if (in_array($id_sp, $tach_list_id_mk) == true) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Deal sốc] ' . $r_cart['tieu_de'];
					if ($list_s[$id_sp]['gia'] != '') {
						$tamtinh += preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
						if ($r_coupon['kieu'] == 'all') {
							if ($r_coupon['loai'] == 'phantram') {
								$g = (preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						} else {
							if (in_array($id_sp, $id_apdung) == true) {
								if ($r_coupon['loai'] == 'phantram') {
									$g = (preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
									$giam += ceil($g);
								} else {
									$giam += $r_coupon['giam'];
								}
							}
						}
						$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
						$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']));
						$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					} else {
						$gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $list_s[$id_sp]['sale'];
						$tamtinh += $gia_moi * $_SESSION['cart'][$id_sp]['quantity'];
						if ($r_coupon['kieu'] == 'all') {
							if ($r_coupon['loai'] == 'phantram') {
								$g = ($gia_moi * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						} else {
							if (in_array($id_sp, $id_apdung) == true) {
								if ($r_coupon['loai'] == 'phantram') {
									$g = ($gia_moi * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
									$giam += ceil($g);
								} else {
									$giam += $r_coupon['giam'];
								}
							}
						}
						$r_cart['thanhtien'] = number_format($gia_moi * $_SESSION['cart'][$id_sp]['quantity']);
						$r_cart['gia_moi'] = number_format($gia_moi);
						$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					}
				} else if (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Flash Sale] ' . $r_cart['tieu_de'];
					$tamtinh += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all') {
						if ($r_coupon['loai'] == 'phantram') {
							$g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
							$giam += ceil($g);
						} else {
							$giam += $r_coupon['giam'];
						}
					} else {
						if (in_array($id_sp, $id_apdung) == true) {
							if ($r_coupon['loai'] == 'phantram') {
								$g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						}
					}
					$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$tamtinh += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all') {
						if ($r_coupon['loai'] == 'phantram') {
							$g = ($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
							$giam += ceil($g);
						} else {
							$giam += $r_coupon['giam'];
						}
					} else {
						if (in_array($id_sp, $id_apdung) == true) {
							if ($r_coupon['loai'] == 'phantram') {
								$g = ($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						}
					}
					$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				}
				$list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout', $r_cart);
				if (strpos($r_cart['ma_sanpham'], '|') !== false) {
					$tach_ma_sanpham = explode('|', $r_cart['ma_sanpham']);
					foreach ($tach_ma_sanpham as $key => $value) {
						$tach_m = explode('&&', $value);
						if ($tach_m[0] == $_SESSION['cart'][$id_sp]['color']) {
							$ma_sanpham = $tach_m[2];
						}
					}
				} else {
					$tach_m = explode('&&', $r_cart['ma_sanpham']);
					$ma_sanpham = $tach_m[2];
				}
				$mau = $r_cart['mau'];
				$thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
				$m = 0;
				while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
					$m++;
					if ($r_m['id'] == $_SESSION['cart'][$id_sp]['color']) {
						$color = $r_m['tieu_de'];
					} else if ($m == 1) {
						$color = $r_m['tieu_de'];
					} else {
					}
				}
				if ($k == 1) {
					$list .= '"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				} else {
					$list .= ',"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				}
			}
			$sanpham = '{' . $list . '}';
			//$total_price = number_format($tongtien) . 'đ';
		} else {
			foreach ($_SESSION['cart'] as $key => $value) {
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
			$thongtin_cart = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.ma_sanpham FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.id IN ($list_id) AND sanpham_shop.shop='$shop' ORDER BY FIELD(sanpham_shop.id,$list_id) ASC");
			$k = 0;
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$k++;
				$id_sp = $r_cart['id'];
				if ($r_cart['can_nang'] == '') {
					$can_nang += 0;
				} else {
					$can_nang += str_replace(',', '.', $r_cart['can_nang']) * $_SESSION['cart'][$id_sp]['quantity'];
				}
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Quà tặng] ' . $r_cart['tieu_de'];
					$tamtinh += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['quantity'] = 1;
					$list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout', $r_cart);
				} else if (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Flash Sale] ' . $r_cart['tieu_de'];
					$tamtinh += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all') {
						if ($r_coupon['loai'] == 'phantram') {
							$g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
							$giam += ceil($g);
						} else {
							$giam += $r_coupon['giam'];
						}
					} else {
						if (in_array($id_sp, $id_apdung) == true) {
							if ($r_coupon['loai'] == 'phantram') {
								$g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						}
					}
					$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout', $r_cart);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$tamtinh += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all') {
						if ($r_coupon['loai'] == 'phantram') {
							$g = ($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
							$giam += ceil($g);
						} else {
							$giam += $r_coupon['giam'];
						}
					} else {
						if (in_array($id_sp, (array)$id_apdung) == true) {
							if ($r_coupon['loai'] == 'phantram') {
								$g = ($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'] / 100) * $r_coupon['giam'];
								$giam += ceil($g);
							} else {
								$giam += $r_coupon['giam'];
							}
						}
					}
					$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout', $r_cart);
				}
				if (strpos($r_cart['ma_sanpham'], '|') !== false) {
					$tach_ma_sanpham = explode('|', $r_cart['ma_sanpham']);
					foreach ($tach_ma_sanpham as $key => $value) {
						$tach_m = explode('&&', $value);
						if ($tach_m[0] == $_SESSION['cart'][$id_sp]['color']) {
							$ma_sanpham = $tach_m[2];
						}
					}
				} else {
					$tach_m = explode('&&', $r_cart['ma_sanpham']);
					$ma_sanpham = $tach_m[2];
				}
				$mau = $r_cart['mau'];
				$thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
				$m = 0;
				while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
					$m++;
					if ($r_m['id'] == $_SESSION['cart'][$id_sp]['color']) {
						$color = $r_m['tieu_de'];
					} else if ($m == 1) {
						$color = $r_m['tieu_de'];
					} else {
					}
				}
				if ($k == 1) {
					$list .= '"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				} else {
					$list .= ',"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				}
			}
			$sanpham = '{' . $list . '}';
			//$tongtien = number_format($total_price) . 'đ';
		}
		if (isset($_SESSION['coupon'])) {
			if ($r_coupon['total'] == 0) {
				$giam = 0;
				$coupon = '';
			} else {
				if ($r_coupon['expired'] > time()) {
					if ($r_coupon['kieu'] == 'all') {
						if ($r_coupon['loai'] == 'phantram') {
							$giam = ($tamtinh / 100) * $r_coupon['giam'];
							$giam = ceil($giam);
						} else {
							$giam = $giam;
						}
					} else {
						$giam = $giam;
					}
					$coupon = $_SESSION['coupon'];
				} else {
					$giam = 0;
					$coupon = '';
				}
			}
		} else {
			$giam = 0;
			$coupon = '';
		}
		if ($can_nang <= 5) {
			$phi_ship = 28000;
			$tongtien = $tamtinh - $giam + $phi_ship;
		} else {
			//$phi_ship=25000;
			$phi_ship = 28000 + ($can_nang - 5) * 6000;
			$tongtien = $tamtinh - $giam + $phi_ship;
		}
		$_SESSION['thanhtoan'] = $thanhtoan;
		$ho_ten = $_SESSION['ho_ten'];
		$email = $_SESSION['email'];
		$dien_thoai = $_SESSION['dien_thoai'];
		$dia_chi = $_SESSION['dia_chi'];
		$tinh = $_SESSION['tinh'];
		$huyen = $_SESSION['huyen'];
		$ma_don = $shop . '' . $check->random_number(6);
		$thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='$shop'");
		$r_td = mysqli_fetch_assoc($thongtin_tichdiem);
		$diem = ceil(($tongtien / 100000) * $r_td['diem']);
		if ($thanhtoan == 'diem') {
			if ($r_td['total'] > 0) {
				$thongtin_diem = mysqli_query($conn, "SELECT * FROM diem WHERE user_id='$user_id'");
				$r_diem = mysqli_fetch_assoc($thongtin_diem);
				if ($tongtien <= $r_diem['diem']) {
					$ok = 1;
					$thongbao = 'Đang chuyển hướng...';
					mysqli_query($conn, "INSERT INTO donhang_shop(ma_don,shop,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,status,thanhtoan,date_post)VALUES('$ma_don','$shop','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$sanpham','$tamtinh','$coupon','$giam','$phi_ship','$tongtien','0','$thanhtoan'," . time() . ")");
					$conlai = $r_diem['diem'] - $tongtien;
					mysqli_query($conn, "UPDATE diem SET diem='$conlai' WHERE user_id='$user_id'");
					$_SESSION['ma_don'] = $ma_don;
					unset($_SESSION['cart']);
					unset($_SESSION['coupon']);
					unset($_SESSION['main_product']);
					unset($_SESSION['muakem']);
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Số điểm của bạn không đủ';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Phương thức này không được áp dụng';
			}
		} else {
			$ok = 1;
			$thongbao = 'Đang chuyển hướng...';
			mysqli_query($conn, "INSERT INTO donhang_shop(ma_don,shop,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,status,ghi_chu,thanhtoan,date_post)VALUES('$ma_don','$shop','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$sanpham','$tamtinh','$coupon','$giam','$phi_ship','$tongtien','0','bruh','$thanhtoan'," . time() . ")");
			if ($r_td['total'] > 0 and $r_td['diem'] > 0) {
				$noi_dung = 'Nhận điểm thưởng khi đặt đơn hàng #' . $ma_don;
				$hientai = time();
				mysqli_query($conn, "INSERT INTO tich_diem_shop(shop,user_id,don,diem,noi_dung,status,date_post)VALUES('$shop','$user_id','$ma_don','$diem','$noi_dung','0','$hientai')");
			}
			$_SESSION['ma_don'] = $ma_don;
			unset($_SESSION['cart']);
			unset($_SESSION['coupon']);
			unset($_SESSION['main_product']);
			unset($_SESSION['muakem']);
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'load_huyen') {
	$tinh = intval($_REQUEST['tinh']);
	$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
	}
	echo json_encode(array('list' => $list));
} 
else if ($action == 'remove_coupon') {
    $coupon = addslashes(strip_tags($_REQUEST['coupon']));
    if (isset($_SESSION['coupon']) && $_SESSION['coupon'] == $coupon) {
        unset($_SESSION['coupon']);
        $ok = 1;
        $thongbao = 'Đã hủy áp dụng mã giảm giá';
    } else {
        $ok = 0;
        $thongbao = 'Mã giảm giá không tồn tại hoặc chưa được áp dụng';
    }
    echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
}

else if ($action == 'show_cart') {
	global $tongtien, $total_price;
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
				$tongtien += 0;
				$r_cart['thanhtien'] = 0;
				$r_cart['gia_moi'] = 0;
				$r_cart['quantity'] = 1;
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
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
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$tongtien += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			}
		}
		$total_price = number_format($tongtien) . ' đ';
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
			if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
				$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck = mysqli_fetch_assoc($thongtin_check);
				$list_check_product[] = json_decode($r_ck['sub_product'], true);
			}
		}
		// Kiểm tra xem giỏ hàng có sản phẩm không
		if (empty($_SESSION['cart'])) {
			// Giỏ hàng trống
			echo json_encode(array(
				'ok' => 0,
				'list_shopcart' => '',
				'list_shopcart_mobile' => '',
				'list_cart' => '',
				'total_cart' => 0,
				'tongtien' => '0 đ',
				'thongbao' => 'Giỏ hàng của bạn đang trống'
			));
			exit;  // Dừng mã tiếp theo để không thực hiện thêm logic xử lý giỏ hàng
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
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$total_price += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$total_price += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_cart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_cart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			}
		}
		$total_price = number_format($total_price) . ' đ';
		
	}
	echo json_encode(array('ok' => 1, 'list_shopcart' => $list_shopcart, 'list_shopcart_mobile' => $list_shopcart_mobile, 'list_cart' => $list_cart, 'total_cart' => count((array)$_SESSION['cart']), 'tongtien' => $total_price, 'thongbao' => 'Cập nhật giỏ hàng thành công'));
}
else if ($action == 'apply_coupon') {
	$coupon = addslashes(strip_tags($_REQUEST['coupon']));
	$thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='$coupon' AND shop='$shop'");
	$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
	if ($r_coupon['total'] == 0) {
		$ok = 0;
		$thongbao = 'Mã giảm giá không tồn tại';
	} else {
		if ($r_coupon['expired'] > time()) {
			$_SESSION['coupon'] = $r_coupon['ma'];
			$thongbao = 'Đã áp dụng mã giảm giá';
			$ok = 1;
		} else {
			$ok = 0;
			$thongbao = 'Mã giảm giá đã hết hạn sử dụng';
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'add_muakem') {
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
	$sp_id = intval($_REQUEST['sp_id']);
	$mau = addslashes(strip_tags($_REQUEST['mau']));
	$size = addslashes(strip_tags($_REQUEST['size']));
	$quantity = intval($_REQUEST['quantity']);
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'flash_sale') {
		$_SESSION['cart'][$sp_id]['flash_sale'] = 1;
	} else {
		$_SESSION['cart'][$sp_id]['flash_sale'] = 0;
	}
	if ($quantity > 1) {
		$_SESSION['cart'][$sp_id]['quantity'] = $quantity;
		$_SESSION['cart'][$sp_id]['size'] = $size;
		$_SESSION['cart'][$sp_id]['color'] = $mau;
	} else {
		$_SESSION['cart'][$sp_id]['quantity'] = 1;
		$_SESSION['cart'][$sp_id]['size'] = $size;
		$_SESSION['cart'][$sp_id]['color'] = $mau;
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
	echo json_encode(array('ok' => 1, 'total' => count((array)$_SESSION['cart']), 'name' => $name, 'list' => $list, 'total_cart' => count((array)$_SESSION['cart']), 'total_price' => $total_price, 'thongbao' => 'Thêm vào giỏ hàng thành công'));
}
else if ($action == 'get_product_info') {
    $sp_id = intval($_REQUEST['sp_id']);

	$sql = "SELECT 
				sp_shop.*, 
				sp.kho, 
				sp.kho_hcm 
			FROM sanpham_shop AS sp_shop
			INNER JOIN sanpham AS sp ON sp_shop.sp_id = sp.id
			WHERE sp_shop.id = '$sp_id' AND sp_shop.shop = '$shop'";

	$thongtin = mysqli_query($conn, $sql);
	$r_tt = mysqli_fetch_assoc($thongtin);

	if ($r_tt['kho'] > 0 OR $r_tt['kho_hang'] > 0) {
		$r_tt['tinh_trang'] = 'Còn hàng';
		$disabled = '';
		$text_button = 'Thêm vào giỏ hàng';
	} else {
		$r_tt['tinh_trang'] = 'Hết hàng';
		$disabled = 'disabled="disabled"'; // Thêm disabled vào nút
    	$text_button = 'Hết hàng';
}

	
	if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
		$giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
		$r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
	} else {
		$r_tt['label_sale'] = '';
	}
	 // Lấy thông tin màu sắc
	if ($r_tt['mau'] != '') { // Thay vì $r_tt['mau'], dùng $r_tt['mau']
		$mau = $r_tt['mau']; // Lấy thông tin màu từ sản phẩm
		$thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
		$list_mau = '';
		$m = 0;
		while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
			$checked = ($m === 0) ? 'checked' : '';
			$list_mau .= '
				<div class="n-sd swatch-element">
					<input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" ' . $checked . ' />
					<label for="mau-' . $r_m['id'] . '">
						' . $r_m['tieu_de'] . '
						<img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
						<img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
					</label>
				</div>';
			$m++;
		}
		$r_tt['option_mau'] = '
			<div class="swatch-div">
				<div id="variant-swatch-0" class="swatch clearfix swatch-color">
					<div class="select-swap">' . $list_mau . '</div>
				</div>
			</div>';
	} else {
		$r_tt['option_mau'] = ''; // Nếu không có màu sắc
	}
	
	if ($r_tt['thuong_hieu'] != '') {
		$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
		$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
		$thuong_hieu = '<div class="inve_brand">
						<span class="stock-brand-title"><strong>Thương hiệu:</strong></span>
						<span class="a-brand" itemprop="brand" itemscope itemtype="https://schema.org/brand">' . $r_th['tieu_de'] . '</span>
					</div>';
	
	} else {
		$thuong_hieu = '<div class="inve_brand">
						<span class="stock-brand-title"><strong>Thương hiệu:</strong></span>
						<span class="a-brand" itemprop="brand" itemscope itemtype="https://schema.org/brand">'.' Đang cập nhật'.'</span>
					</div>';
	}
	$sp_id = $r_tt['id'];
	if (!isset($_SESSION['daxem'][$sp_id])) {
		$_SESSION['daxem'][$sp_id] = $sp_id;
	}
	
$hientai = time();
$where_flash = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND loai='flash_sale'";
$thongtin_flash = mysqli_query($conn, "SELECT * FROM deal WHERE $where_flash ORDER BY id DESC LIMIT 1");
$total_flash = mysqli_num_rows($thongtin_flash);
if ($total_flash == 0) {
	$box_flash_sale = '';
	$time_conlai = 0;
	$where_deal = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND (loai='muakem' OR loai='tang')";
	$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE $where_deal ORDER BY id DESC LIMIT 1");
	$total_deal = mysqli_num_rows($thongtin_deal);
	if ($total_deal == 0) {
		$box_deal_soc = '';
		$loai = '';
	} else {
		$box_flash_sale = '';
		$r_deal = mysqli_fetch_assoc($thongtin_deal);
		if ($r_deal['loai'] == 'muakem') {
			$loai = 'muakem';
			$box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_deal_soc');
			$sub_product = $r_deal['sub_id'];
			$tach_sub_product = json_decode($r_deal['sub_product'], true);
			$thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY FIELD(id,$sub_product) ASC LIMIT 2");
			while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
				$sp = $r_sub_product['id'];
				if ($tach_sub_product[$sp]['gia'] != '') {
					if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
						$giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
				} else {
					$gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['sale']);
					if ($r_sub_product['gia_cu'] > $gia_moi) {
						$giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format($gia_moi);
					$gia_drop = $r_sub_product['gia_cu'] - $r_sub_product['gia_moi'];
					$gia_drop = number_format($r_sub_product['gia_cu']) - number_format($gia_moi);
					$r_sub_product['gia_drop']=number_format($gia_drop);
				}
				$list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_muakem', $r_sub_product);
			}
		} else if ($r_deal['loai'] == 'tang') {
			$loai = 'tang';
			$box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_quatang');
			$sub_product = $r_deal['sub_id'];
			$tach_sub_product = json_decode($r_deal['sub_product'], true);
			$thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY rand() DESC LIMIT 4");
			while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
				$sp = $r_sub_product['id'];
				if ($tach_sub_product[$sp]['gia'] != '') {
					if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
						$giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
				} else {
					$gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
					if ($r_sub_product['gia_cu'] > $gia_moi) {
						$giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format($gia_moi);
					$gia_drop = number_format($r_sub_product['gia_cu']) - number_format($gia_moi);
					$r_sub_product['gia_drop']=number_format($gia_drop);
				}
				$list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_quatang', $r_sub_product);
			}
		}
	}

} else {
	$box_flash_sale = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_flash_sale');
	$loai = 'flash_sale';
	$r_flash = mysqli_fetch_assoc($thongtin_flash);
	$time_conlai = $r_flash['date_end'] - time();
	$tach_flash_sub_product = json_decode($r_flash['sub_product'], true);
	$r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $tach_flash_sub_product[$sp_id]['gia']);
	$where_deal = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND (loai='muakem' OR loai='tang')";
	$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE $where_deal ORDER BY id DESC LIMIT 1");
	$total_deal = mysqli_num_rows($thongtin_deal);
	if ($total_deal == 0) {
		$box_deal_soc = '';
	} else {
		$r_deal = mysqli_fetch_assoc($thongtin_deal);
		if ($r_deal['loai'] == 'muakem') {
			$box_deal_soc = $skin->skin_normal('skin_shop/box_deal_soc');
			$sub_product = $r_deal['sub_id'];
			$tach_sub_product = json_decode($r_deal['sub_product'], true);
			$thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY FIELD(id,$sub_product) ASC LIMIT 2");
			while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
				$sp = $r_sub_product['id'];
				if ($tach_sub_product[$sp]['gia'] != '') {
					if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
						$giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
				} else {
					$gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
					if ($r_sub_product['gia_cu'] > $gia_moi) {
						$giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format($gia_moi);
					$gia_drop = number_format($r_sub_product['gia_cu']) - number_format($gia_moi);
					$r_sub_product['gia_drop']=number_format($gia_drop);
				}
				$list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_muakem', $r_sub_product);
			}
		} else if ($r_deal['loai'] == 'tang') {
			$box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_quatang');
			$sub_product = $r_deal['sub_id'];
			$tach_sub_product = json_decode($r_deal['sub_product'], true);
			$thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) ORDER BY rand() DESC LIMIT 4");
			while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
				$sp = $r_sub_product['id'];
				if ($tach_sub_product[$sp]['gia'] != '') {
					if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
						$giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
				} else {
					$gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
					if ($r_sub_product['gia_cu'] > $gia_moi) {
						$giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
						$r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sub_product['label_sale'] = '';
					}
					$r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
					$r_sub_product['gia_moi'] = number_format($gia_moi);
					$gia_drop = number_format($r_sub_product['gia_cu']) - number_format($gia_moi);
					$r_sub_product['gia_drop']=number_format($gia_drop);
				}
				$list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_quatang', $r_sub_product);
			}
		}
	}
}
$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE date_start<='$hientai' AND date_end>='$hientai' AND shop='$shop' ORDER BY id DESC");
while ($r_d = mysqli_fetch_assoc($thongtin_deal)) {
	if ($r_d['loai'] == 'flash_sale') {
		$list_flashsale_id .= $r_d['main_product'] . ',';
		$list_check_product[] = json_decode($r_d['sub_product'], true);
	} else if ($r_d['loai'] == 'muakem') {
		$list_muakem_id .= $r_d['main_product'] . ',';
	} else if ($r_d['loai'] == 'tang') {
		$list_tang_id .= $r_d['main_product'] . ',';
	}
}
foreach ($list_check_product as $key => $value) {
	foreach ($value as $k => $v) {
		$list_c[$k] = $v;
	}
}
$thongtin_coupon=mysqli_query($conn,"SELECT * FROM coupon WHERE shop='$shop' AND start<='$hientai' AND expired>='$hientai' ORDER BY id DESC");
// print_r($thongtin_coupon);
// exit();
$total_coupon=mysqli_num_rows($thongtin_coupon);
if($total_coupon==0){
	$box_coupon='';
}else{
	$box_coupon=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_coupons');
	while ($r_cp=mysqli_fetch_assoc($thongtin_coupon)) {
		if($r_cp['loai']=='phantram'){
			$r_cp['giam']=$r_cp['giam'].'%';
		}else{
			$r_cp['giam']=number_format($r_cp['giam']).'đ';
		}
		$r_cp['expired']=date('H:i d/m/Y',$r_cp['expired']);
		$list_coupon.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_coupon',$r_cp);
		$list_coupon_code.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_coupon_code',$r_cp);
	}

}
$view_new = $r_tt['view'] + 1;
mysqli_query($conn, "UPDATE sanpham_shop SET view='$view_new' WHERE id='{$r_tt['id']}' AND shop='$shop'");
if (strlen($r_tt['anh']) > 3) {
	$tach_anh = explode(",", $r_tt['anh']);
	foreach ($tach_anh as $key => $value) {
		$pt['src'] = $value;
		$pt['tieu_de'] = $r_tt['tieu_de'];
		$list_anh .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_photo', $pt);
		$list_anh_1 .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_photo_1', $pt);
	}
	// Lưu vào session
    $_SESSION['list_photo'] = $list_anh;
    $_SESSION['list_photo_1'] = $list_anh_1;
}
	if ($r_tt) {
		echo json_encode(array(
			'list_photo' => $list_anh,
			'list_photo_1' => $list_anh_1,
			'loai' => $loai,
			'id' => $r_tt['id'],
			'tieu_de' => $r_tt['tieu_de'],
			'minh_hoa' => $r_tt['minh_hoa'],
			'noi_dung' => $r_tt['noi_dung'],
			'gia_moi' => number_format($r_tt['gia_moi'], 0, ',', '.'), // Định dạng giá
			'gia_cu' => number_format($r_tt['gia_cu'], 0, ',', '.'),   // Định dạng giá
			'link' => $r_tt['link'],
			'size' => $r_tt['size'],
			'label_sale' => $r_tt['label_sale'],
			'mau' => $r_tt['mau'],
			'thuong_hieu' => $thuong_hieu,
			'option_mau' => $r_tt['option_mau'],
			'text_button' => $text_button,
			'tinh_trang' => $r_tt['kho_hang'] > 0 ? 'Còn hàng' : 'Hết hàng'
		));
	} else {
		echo json_encode(array('error' => 'Không tìm thấy sản phẩm'));
	}
	
}


// Kiểm tra action

 else if ($action == 'update_cart') {
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
	echo json_encode(array('ok' => 1, 'total' => count((array)$_SESSION['cart']), 'list' => $list, 'total_cart' => count((array)$_SESSION['cart']), 'total_price' => $total_price, 'thongbao' => 'Thêm vào giỏ hàng thành công'));
} else if ($action == 'update_shopcart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$quantity = intval($_REQUEST['quantity']);
	$hientai = time();
	if (isset($_SESSION['cart'][$sp_id]) and $quantity > 1) {
		$_SESSION['cart'][$sp_id]['quantity'] = $quantity;
	} else {
		$_SESSION['cart'][$sp_id]['quantity'] = 1;
	}
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
				$tongtien += 0;
				$r_cart['thanhtien'] = 0;
				$r_cart['gia_moi'] = 0;
				$r_cart['quantity'] = 1;
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
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
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$tongtien += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			}
		}
		$total_price = number_format($tongtien) . ' đ';
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
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
			} else if (isset($list_c[$id_sp])) {
				$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
				$total_price += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			} else {
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$total_price += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
				$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
			}
		}
		$total_price = number_format($total_price) . ' đ';
	}
	echo json_encode(array('ok' => 1, 'list_shopcart' => $list_shopcart, 'list_shopcart_mobile' => $list_shopcart_mobile, 'total_cart' => count((array)$_SESSION['cart']), 'tongtien' => $total_price, 'thongbao' => 'Thêm vào giỏ hàng thành công'));
} else if ($action == 'remove_shopcart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$hientai = time();
	unset($_SESSION['cart'][$sp_id]);
	foreach ($_SESSION['cart'] as $key => $value) {
		if ($_SESSION['cart'][$key]['main_product'] == $sp_id) {
			unset($_SESSION['cart'][$key]);
		}
	}
	if (isset($_SESSION['main_product'][$sp_id])) {
		if (count($_SESSION['main_product']) > 1) {
			unset($_SESSION['main_product'][$sp_id]);
		} else {
			unset($_SESSION['main_product'][$sp_id]);
			unset($_SESSION['main_product']);
			unset($_SESSION['muakem']);
		}
		$thongtin_main = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
		$r_main = mysqli_fetch_assoc($thongtin_main);
		$tach_sub = json_decode($r_main['sub_product'], true);
		foreach ($tach_sub as $key => $value) {
			unset($_SESSION['cart'][$key]);
		}
	}
	if (count((array)$_SESSION['cart']) > 0) {
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
			$i = 0;
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id) ASC");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$i++;
				if ($i == 1) {
					$name = '<a href="/product/' . $r_cart['link'] . '.html" style="color:red;" title="' . $r_cart['tieu_de'] . '">' . $r_cart['tieu_de'] . '</a>';
				}
				$id_sp = $r_cart['id'];
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$tongtien += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['quantity'] = 1;
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
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
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
				} else if (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$tongtien += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
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
			$i = 0;
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$i++;
				if ($i == 1) {
					$name = '<a href="/product/' . $r_cart['link'] . '.html" style="color:red;" title="' . $r_cart['tieu_de'] . '">' . $r_cart['tieu_de'] . '</a>';
				}
				$id_sp = $r_cart['id'];
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$total_price += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['quantity'] = 1;
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
				} else if (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$total_price += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$total_price += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
					$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
					$list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
					$list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
				}
			}
			$total_price = number_format($total_price) . 'đ';
		}
	} else {
		unset($_SESSION['cart']);
		unset($_SESSION['muakem']);
		unset($_SESSION['main_product']);
	}
	echo json_encode(array('ok' => 1, 'list_shopcart' => $list_shopcart, 'list_shopcart_mobile' => $list_shopcart_mobile, 'total_cart' => count((array)$_SESSION['cart']), 'tongtien' => $total_price, 'thongbao' => 'Cập nhật giỏ hàng thành công'));
} else if ($action == 'remove_cart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$hientai = time();
	foreach ($_SESSION['cart'] as $key => $value) {
		if ($_SESSION['cart'][$key]['main_product'] == $sp_id) {
			unset($_SESSION['cart'][$key]);
		}
	}
	unset($_SESSION['cart'][$sp_id]);
	if (isset($_SESSION['main_product'][$sp_id])) {
		if (count($_SESSION['main_product']) > 1) {
			unset($_SESSION['main_product'][$sp_id]);
		} else {
			unset($_SESSION['main_product'][$sp_id]);
			unset($_SESSION['main_product']);
			unset($_SESSION['muakem']);
		}
		$thongtin_main = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
		$r_main = mysqli_fetch_assoc($thongtin_main);
		$tach_sub = json_decode($r_main['sub_product'], true);
		foreach ($tach_sub as $key => $value) {
			unset($_SESSION['cart'][$key]);
		}
	}
	if (count((array)$_SESSION['cart']) > 0) {
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
			$i = 0;
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id) ASC");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$i++;
				if ($i == 1) {
					$name = '<a href="/product/' . $r_cart['link'] . '.html" style="color:red;" title="' . $r_cart['tieu_de'] . '">' . $r_cart['tieu_de'] . '</a>';
				}
				$id_sp = $r_cart['id'];
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$tongtien += 0;
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
			$i = 0;
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$i++;
				if ($i == 1) {
					$name = '<a href="/product/' . $r_cart['link'] . '.html" style="color:red;" title="' . $r_cart['tieu_de'] . '">' . $r_cart['tieu_de'] . '</a>';
				}
				$id_sp = $r_cart['id'];
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$tongtien += 0;
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
	} else {
		unset($_SESSION['cart']);
		unset($_SESSION['muakem']);
		unset($_SESSION['main_product']);
	}
	echo json_encode(array('ok' => 1, 'total' => count((array)$_SESSION['cart']), 'name' => $name, 'list' => $list, 'total_cart' => count((array)$_SESSION['cart']), 'total_price' => $total_price, 'thongbao' => 'Xóa sản phẩm khỏi giỏ hàng thành công'));
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
	$gioi_tinh = addslashes(strip_tags($_REQUEST['gioi_tinh']));
	$tinh = addslashes(strip_tags($_REQUEST['tinh']));
	$huyen = addslashes(strip_tags($_REQUEST['huyen']));
	$xa = addslashes(strip_tags($_REQUEST['xa']));
	$maso_thue = addslashes(strip_tags($_REQUEST['maso_thue']));
	$maso_thue_cap = addslashes(strip_tags($_REQUEST['maso_thue_cap']));
	$maso_thue_noicap = addslashes(strip_tags($_REQUEST['maso_thue_noicap']));
	$nhan_vien = addslashes(strip_tags($_REQUEST['nhan_vien']));


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
				mysqli_query($conn, "INSERT INTO user_info(
					username, shop, user_money, user_money2, email, password, name, avatar, 
					mobile, domain, ngaysinh, cmnd, gioi_tinh, ngaycap, noicap, dia_chi, dropship, ctv, 
					code_active, active, chinh_thuc, created, date_update, ip_address, 
					logined, aff, about, nhom, tinh, huyen, xa, maso_thue, maso_thue_cap, nhan_vien, 
					end_online, maso_thue_noicap, gia_leader, leader, doitac, leader_start
				) VALUES (
					'$username', '$shop', '0', '0', '$email', '$pass', '$ho_ten', '', 
					'$dien_thoai', '', '$ngaysinh', '$cmnd', '$gioi_tinh', '$ngaycap', '$noicap', 
					'$dia_chi', '0', '0', '', '1', '0', '$hientai', '$hientai', '$ip_address', '', 
					'', '', '', '0', '0', '0', '$maso_thue', '$maso_thue_cap', '0', 
					'', '$maso_thue_noicap', '0', '0', '', ''
				)");
				
				
				
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
// } else if ($action == 'goi_y') {
//     $key = addslashes(strip_tags($_REQUEST['key']));
//     $query = "SELECT id, tieu_de AS title, gia_moi AS new_price, gia_cu AS old_price, hinh_anh AS image FROM truyen WHERE tieu_de LIKE '%$key%' ORDER BY tieu_de ASC LIMIT 5";
//     $result = mysqli_query($conn, $query);
//     $products = [];
    
//     while ($row = mysqli_fetch_assoc($result)) {
//         $products[] = [
//             'link' => '/san-pham/' . $row['id'], // Tạo link tới sản phẩm
//             'title' => $row['title'],
//             'new_price' => number_format($row['new_price'], 0, ',', '.') . '₫',
//             'old_price' => $row['old_price'] ? number_format($row['old_price'], 0, ',', '.') . '₫' : null,
//             'image' => $row['image']
//         ];
//     }

//     echo json_encode([
//         'ok' => count($products) > 0,
//         'products' => $products
//     ]);
// }
} else if ($action == 'filter_search') {
		$search_name = mysqli_real_escape_string($conn, $_REQUEST['key']);
		$query = "SELECT `id`, `tieu_de` AS `title`, `gia_moi` AS `new_price`, `gia_cu` AS `old_price`, `anh` AS `image`, `link`, `minh_hoa`
				  FROM `sanpham_shop` 
				  WHERE `tieu_de` LIKE '%$search_name%'  and shop = '$shop'
				  ORDER BY `tieu_de` ASC 
				  LIMIT 5";
		$result = mysqli_query($conn, $query);
		$products = "";
		$images = explode(',', $value['image']);
        $first_image = trim($images[0]); // Lấy ảnh đầu tiên
		foreach ($result as $value) {
			$products .= '
				<li class="list-group">
					<div class="row">
						<div class="col-2">
							<div class="dropdown-item">
								<div class="image">
									<a href="/product/' . htmlspecialchars($value["link"]) . '.html" title="' . htmlspecialchars($value["title"]) . '">
                                    <img loading="lazy" 
                                        class="product-thumbnail__img product-thumbnail__img--secondary" 
                                        width="480" height="480" style="--image-scale: 1" 
                                        src="' . '/thumbnail.php?w=320&img='.($value['minh_hoa']).'" 
                                        alt="' . htmlspecialchars($value["title"]) . '" />
                                </a>
								</div>
							</div>
						</div>
						<div class="col-10">
							<div class="name_product"> 
								 <a href="/product/' . $value["link"] . '.html">' . htmlspecialchars($value["title"]) . '</a>	
							</div>
							<div style="display: flex;">
								<div class="price_product_new" style="margin-right: 20px;">  
								'.number_format($value["new_price"]).' ₫
							</div>
							<div class="price_product_old"> 
								 <del>' . number_format($value["old_price"]) . ' ₫</del>
							</div>
							</div>
							
						</div>
					</div>
				</li>
			';
		}
		echo $products;
}
else if ($action == 'lienhe') {
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
} else {
	echo "Không có hành động nào được xử lý";
}
