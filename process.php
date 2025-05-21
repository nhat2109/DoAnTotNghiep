<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
	include './shop/process.php';
	exit();
}
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
// nhathem
$class_supership = $tlca_do->load('class_supership');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if (isset($_COOKIE['user_id'])) {
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
}
if ($action == 'get_popup') {
	if (isset($_COOKIE['user_id'])) {
		$gioihan = time() - 15 * 24 * 3600;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE FIND_IN_SET($user_id,poped)<1 AND pop='1' AND date_post>'$gioihan' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') AND shop='0' ORDER BY id ASC LIMIT 1");
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
	$info = array(
		'ok' => $ok,
		'content' => $content,
	);
	echo json_encode($info);
} 
elseif ($action == 'filter_search') { // chức năng tìm kiếm nâng cao
	$search_name = mysqli_real_escape_string($conn, $_REQUEST['key']);
	$query = "SELECT `id`, `tieu_de` AS `title`, `gia_moi` AS `new_price`, `gia_cu` AS `old_price`, `anh` AS `image`, `link`, `minh_hoa`
              FROM `sanpham` 
              WHERE `tieu_de` LIKE '%$search_name%'
              ORDER BY `new_price` ASC 
              LIMIT 5";
	//   if (strlen($where) < 5) {
	// 	$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY $order LIMIT $start,$limit");
	// } else {
	// 	$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE " . $where . " ORDER BY $order LIMIT $start,$limit");
	// }
	$result = mysqli_query($conn, $query);

	$products = "";
	if (mysqli_num_rows($result)) {
		while ($value = mysqli_fetch_assoc($result)) {
			$products .= '
			<li class="list-group" style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd; margin: 0; padding: 10px; list-style: none;">
				<div class="row">
					<div class="col-2">
						<div class="dropdown-item">
							<div class="image">
								<a href="/product/' . htmlspecialchars($value["link"]) . '.html" title="' . htmlspecialchars($value["title"]) . '">
									<img loading="lazy" 
										class="product-thumbnail__img product-thumbnail__img--secondary" 
										width="480" height="480" style="--image-scale: 1; width: 100%; height: auto;" 
										src="' . htmlspecialchars($value['minh_hoa']) . '" 
										alt="' . htmlspecialchars($value["title"]) . '" />
								</a>
							</div>
						</div>
					</div>
					<div class="col-10">
						<div class="name_product" style="font-size: 16px; font-weight: bold; margin-bottom: 5px;"> 
							<a href="/product/' . htmlspecialchars($value["link"]) . '.html" style="text-decoration: none; color: #333;">' . htmlspecialchars($value["title"]) . '</a>    
						</div>
						<div style="display: flex; align-items: center;">
							<div class="price_product_new" style="margin-right: 20px; color: #ff4d4d; font-size: 14px;">  
								' . number_format($value["new_price"]) . ' ₫
							</div>
							<div class="price_product_old" style="font-size: 14px; color: #999;"> 
								<del>' . number_format($value["old_price"]) . ' ₫</del>
							</div>
						</div>
					</div>
				</div>
			</li>
		';
		}
	} else {
		$products = '<li class="list-group"><center>Không có kết quả phù hợp</center></li>';
	}

	echo $products;
} else if ($action == 'load_size') {
	$sp_id = mysqli_real_escape_string($conn, $_POST['sp_id']);
	$color = mysqli_real_escape_string($conn, $_POST['color']);

	$query = "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' AND color='$color'";
	$result = mysqli_query($conn, $query);

	$list_size = '';
	$ten_size = '';
	$first = true;
	$has_size = false;
	$phanloai_data = null;

	while ($row = mysqli_fetch_assoc($result)) {
		if ($phanloai_data === null) {
			$phanloai_data = $row;
		}

		if (!empty($row['size']) && !empty($row['ten_size'])) {
			$has_size = true;
			$disabled = ($row['kho_sanpham_socdo'] <= 0) ? 'disabled' : '';
			$active = ($first && !$disabled) ? 'active' : '';
			$list_size .= '<div class="li_size ' . $active . ' ' . $disabled . '" sp_id="' . $row['sp_id'] . '" size="' . $row['size'] . '" tieu_de="' . $row['ten_size'] . '">' . $row['ten_size'] . '</div>';
			if ($first && !$disabled) {
				$ten_size = $row['ten_size'];
				$first = false;
			}
		}
	}

	if ($phanloai_data) {
		$gia_moi = isset($phanloai_data['gia_moi']) ? number_format($phanloai_data['gia_moi'], 0, ',', '.') : 'Liên hệ';
		$gia_cu = isset($phanloai_data['gia_cu']) ? number_format($phanloai_data['gia_cu'], 0, ',', '.') : '0';
		$kho = isset($phanloai_data['kho_sanpham_socdo']) ? $phanloai_data['kho_sanpham_socdo'] : 0;
		$sale = ($phanloai_data['gia_cu'] > 0 && $phanloai_data['gia_cu'] > $phanloai_data['gia_moi'])
			? round((($phanloai_data['gia_cu'] - $phanloai_data['gia_moi']) / $phanloai_data['gia_cu']) * 100)
			: 0;

		$response = [
			'ok' => 1,
			'list' => $list_size,
			'ten_size' => $ten_size,
			'has_size' => $has_size,
			'phanloai' => [
				'gia_moi' => $gia_moi,
				'gia_cu' => $gia_cu,
				'kho' => $kho,
				'sale' => $sale
			]
		];
	} else {
		$response = [
			'ok' => 0,
			'thongbao' => 'Không có dữ liệu phân loại cho màu này'
		];
	}

	echo json_encode($response);
	exit;
}else if ($action == 'get_price_by_phanloai') {
	$sp_id = intval($_POST['sp_id']);
	$color = addslashes(strip_tags($_POST['color']));
	$size = addslashes(strip_tags($_POST['size'])); // Có thể rỗng

	// Truy vấn bảng phanloai_sanpham để lấy thông tin giá và pl
	$query = "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' AND color='$color'";
	if (!empty($size)) {
		$query .= " AND size='$size'";
	}
	$query .= " LIMIT 1";
	$thongtin_phanloai = mysqli_query($conn, $query);

	if ($thongtin_phanloai && mysqli_num_rows($thongtin_phanloai) > 0) {
		$variant = mysqli_fetch_assoc($thongtin_phanloai);
		$gia_moi = $variant['gia_moi'] ?? 0;
		$gia_cu = $variant['gia_cu'] ?? 0;
		$sale = ($gia_cu > 0 && $gia_cu > $gia_moi) ? round((($gia_cu - $gia_moi) / $gia_cu) * 100) : 0;

		$response = [
			'ok' => 1,
			'pl' => $variant['id'],
			'gia_moi' => $gia_moi,
			'gia_cu' => $gia_cu,
			'sale' => $sale
		];
	} else {
		$response = [
			'ok' => 0,
			'thongbao' => 'Không tìm thấy biến thể phù hợp!'
		];
	}

	echo json_encode($response);
	exit;
} else if ($_POST['action'] == 'get_product_info') {
	$sp_id = $_POST['sp_id'];
	$color = $_POST['color'];
	$size = $_POST['size'];

	$product = [
		'gia_moi' => 300000,
		'gia_cu' => 300000,
		'sale' => 0,
		'ton_kho' => 10,
		'pl' => 2766,
		'specs' => [
			'Chất liệu' => 'Nhựa',
			'Dung tích' => '1L',
			'Trọng lượng' => '500g'
		]
	];

	if ($product) {
		echo json_encode([
			'ok' => 1,
			'gia_moi' => $product['gia_moi'],
			'gia_cu' => $product['gia_cu'],
			'sale' => $product['sale'],
			'ton_kho' => $product['ton_kho'],
			'pl' => $product['pl'],
			'specs' => $product['specs']
		]);
	} else {
		echo json_encode(['ok' => 0]);
	}
	exit;
} else if ($action == 'update_click') {
	$link = addslashes(strip_tags($_REQUEST['link']));
	$param_url = parse_url($link);
	parse_str($param_url['query'], $url_query);
	$utm_source = addslashes($url_query['utm_source']);
	$tach_link = explode('/product/', $link);
	$tach_a = explode('.html', $tach_link[1]);
	$a = $tach_a[0];
	$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE link='$a'");
	$r_sp = mysqli_fetch_assoc($thongtin_sanpham);
	$total_sp = mysqli_num_rows($thongtin_sanpham);
	if ($total_sp == 0) {
		$ok = 0;
	} else {
		$thongtin_link = mysqli_query($conn, "SELECT * FROM rut_gon WHERE link='$link'");
		$total = mysqli_num_rows($thongtin_link);
		if ($total == 0) {
			$hientai = time();
			$link_sp = 'https://socdo.vn/product/' . $r_sp['link'] . '.html';
			mysqli_query($conn, "INSERT INTO rut_gon (sp_id,link,rut_gon,user_id,click,date_post)VALUES('{$r_sp['id']}','$link_sp','','$utm_source','1','$hientai')");
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin_link);
			$click = $r_tt['click'] + 1;
			mysqli_query($conn, "UPDATE rut_gon SET click='$click' WHERE id='{$r_tt['id']}'");
		}
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
	);
	echo json_encode($info);
} else if ($action == 'load_content_chinhsach') {
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	$info = array(
		'ok' => 1,
		'content' => $check->remove_blank_line($r_tt['noidung'])
	);
	echo json_encode($info);
} else if ($action == 'load_content_right') {
	$link = addslashes($_REQUEST['link']);
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$ok = 1;
		$thongbao = 'Load dữ liệu thành công';
		if (strpos($link, 'tai-khoan') !== false) {
			if ($user_info['mobile'] == '') {
				$user_info['mobile'] = '<i>Chưa cập nhật</i>';
			}
			if ($user_info['gioi_tinh'] == '') {
				$user_info['gioi_tinh'] = '<i>Chưa cập nhật</i>';
			}
			if ($user_info['email'] == '') {
				$user_info['email'] = '<i>Chưa cập nhật</i>';
			}
			if ($user_info['ngaysinh'] == '') {
				$user_info['ngaysinh'] = '<i>Chưa cập nhật</i>';
			}
			if ($user_info['gioi_tinh'] == 'nam') {
				$user_info['gioi_tinh'] = 'Nam';
			} else if ($user_info['gioi_tinh'] == 'nu') {
				$user_info['gioi_tinh'] = 'Nữ';
			} elseif ($user_info['gioi_tinh'] == 'khac') {
				$user_info['gioi_tinh'] = 'Khác';
			}
			$bien = array(
				'name' => $user_info['name'],
				'dien_thoai' => $user_info['mobile'],
				'gioi_tinh' => $user_info['gioi_tinh'],
				'email' => $user_info['email'],
				'ngay_sinh' => $user_info['ngaysinh']
			);
			$html = $skin->skin_replace('skin/box_right_taikhoan', $bien);
		} else if (strpos($link, 'don-hang') !== false) {
			$bien = array(
				'list_donhang' => $class_index->list_donhang($conn, $user_id, 1, 10),
			);
			$html = $skin->skin_replace('skin/box_right_donhang', $bien);
		} else if (strpos($link, 'tich-diem') !== false) {
			$bien = array(
				'list_tichdiem' => $class_index->list_tichdiem($conn, 0, $user_id, 1, 10),
			);
			$html = $skin->skin_replace('skin/box_right_tichdiem', $bien);
		} else if (strpos($link, 'vi-voucher') !== false) {
			$tach_list = json_decode($class_index->list_vi_voucher($conn, $user_id, 1, 12), true);
			$bien = array(
				'list_voucher' => $tach_list['list']
			);
			$html = $skin->skin_replace('skin/box_right_vivoucher', $bien);
		} else if (strpos($link, 'dia-chi') !== false) {
			$tach_list_diachi = json_decode($class_index->list_diachi($conn, $user_id), true);
			if ($tach_list_diachi['total'] == 0) {
				$tach_list_diachi['list'] = 'Bạn chưa có địa chỉ nào!';
			}
			$bien = array(
				'list_diachi' => $tach_list_diachi['list']
			);
			$html = $skin->skin_replace('skin/box_right_diachi', $bien);
		} else if (strpos($link, 'danh-gia') !== false) {
			$tach_list = json_decode($class_index->list_danhgia($conn, $user_id, 1, 10), true);
			$bien = array(
				'list_danhgia' => $tach_list['list']
			);
			$html = $skin->skin_replace('skin/box_right_danhgia', $bien);
		} else if (strpos($link, 'chinh-sach') !== false) {
			$list = $class_index->list_chinhsach($conn, 1, 30);
			$bien = array(
				'list_chinhsach' => $list
			);
			$html = $skin->skin_replace('skin/box_right_chinhsach', $bien);
		}
	}
	$info = array(
		'html' => $html,
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'show_update') {
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'show_update_password') {
		$ok = 1;
		$thongbao = 'Load box thành công';
		$bien = array(
			'name' => $user_info['name'],
			'dien_thoai' => $user_info['mobile'],
			'gioi_tinh' => $user_info['gioi_tinh'],
			'email' => $user_info['email'],
			'ngay_sinh' => $user_info['ngaysinh']
		);
		$html = $skin->skin_replace('skin/box_show/box_change_password', $bien);
	} else if ($loai == 'show_update_profile') {
		$ok = 1;
		$thongbao = 'Load box thành công';
		$bien = array(
			'name' => $user_info['name'],
			'dien_thoai' => $user_info['mobile'],
			'gioi_tinh' => $user_info['gioi_tinh'],
			'email' => $user_info['email'],
			'ngay_sinh' => $user_info['ngaysinh']
		);
		$html = $skin->skin_replace('skin/box_show/box_update_profile', $bien);
	} else if ($loai == 'show_add_diachi') {
		$ok = 1;
		$thongbao = 'Load box thành công';
		$bien = array(
			'option_tinh' => $class_index->list_option_tinh($conn, ''),
			'option_huyen' => $class_index->list_option_huyen($conn, '', ''),
			'option_xa' => $class_index->list_option_xa($conn, '', ''),
		);
		$html = $skin->skin_replace('skin/box_show/box_add_diachi', $bien);
	} else if ($loai == 'show_update_diachi') {
		$id = intval($_REQUEST['id']);
		$thongtin = mysqli_query($conn, "SELECT * FROM dia_chi WHERE id='$id' AND user_id='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ok = 1;
		$thongbao = 'Load box thành công';
		$bien = array(
			'option_tinh' => $class_index->list_option_tinh($conn, $r_tt['tinh']),
			'option_huyen' => $class_index->list_option_huyen($conn, $r_tt['tinh'], $r_tt['huyen']),
			'option_xa' => $class_index->list_option_xa($conn, $r_tt['huyen'], $r_tt['xa']),
			'ho_ten' => $r_tt['ho_ten'],
			'dien_thoai' => $r_tt['dien_thoai'],
			'dia_chi' => $r_tt['dia_chi'],
			'email' => $r_tt['email'],
			'active' => $r_tt['active'],
			'id' => $id
		);
		$html = $skin->skin_replace('skin/box_show/box_update_diachi', $bien);
	}
	$info = array(
		'html' => $html,
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'set_default_diachi') {
	$id = intval($_REQUEST['id']);
	mysqli_query($conn, "UPDATE dia_chi SET active='0' WHERE user_id='$user_id'");
	mysqli_query($conn, "UPDATE dia_chi SET active='1' WHERE user_id='$user_id' AND id='$id'");
	$info = array(
		'ok' => 1,
		'thongbao' => 'Đặt làm mặc định thành công'
	);
	echo json_encode($info);
} else if ($action == 'del') {
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	$id = intval($_REQUEST['id']);
	if ($loai == 'dia_chi') {
		mysqli_query($conn, "DELETE FROM dia_chi WHERE id='$id' AND user_id='$user_id'");
		$ok = 1;
		$thongbao = 'Xóa địa chỉ thành công';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'load_skin') {
	$page = intval($_REQUEST['page']);
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'vip') {
		$thongtin_giaodien = mysqli_query($conn, "SELECT * FROM giaodien WHERE gia_moi>'0'");
	} else if ($loai == 'free') {
		$thongtin_giaodien = mysqli_query($conn, "SELECT * FROM giaodien WHERE gia_moi='0'");
	} else {
		$thongtin_giaodien = mysqli_query($conn, "SELECT * FROM giaodien");
	}
	$total_giaodien = mysqli_num_rows($thongtin_giaodien);
	$tach_list = json_decode($class_index->list_skin($conn, $total_giaodien, $loai, $page, 6), true);
	$total = $tach_list['total'];
	$page++;
	$info = array(
		'total' => $total,
		'list' => $tach_list['list'],
		'total_giaodien' => $total_giaodien,
		'end' => $tach_list['end'],
		'page' => $page
	);
	echo json_encode($info);
} else if ($action == 'load_product_sub') {
	$cat_id = intval($_REQUEST['cat_id']);
	$tach_list = json_decode($class_index->list_sanpham_sub($conn, $cat_id), true);
	if ($tach_list['total'] > 0) {
		$ok = 1;
		$list = $tach_list['list'];
		$thongbao = 'Đã lấy được dữ liệu';
	} else {
		$ok = 0;
		$list = '';
		$thongbao = 'Không có dữ liệu';
	}
	echo json_encode(array('ok' => $ok, 'list' => $list, 'thongbao' => $thongbao));
} else if ($action == 'load_product') {
	$url = strip_tags($_REQUEST['url']);
	$url = addslashes($url);
	$cat_id = preg_replace('/[^0-9]/', '', $_REQUEST['cat_id']);
	$cat_id = intval($cat_id);
	$param_url = parse_url($url);
	parse_str($param_url['query'], $url_query);
	$page = addslashes($url_query['page']);
	$page = intval($page);
	if ($page > 1) {
		$page = $page;
	} else {
		$page = 1;
	}
	$brand = addslashes(strip_tags($url_query['brand']));
	$color = addslashes(strip_tags($url_query['color']));
	$price = addslashes(strip_tags($url_query['price']));
	$size = addslashes(strip_tags($url_query['size']));
	$sort = addslashes(strip_tags($url_query['sort']));
	if (isset($url_query['sort'])) {
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
	if (isset($url_query['color']) and strpos($color, '*') !== false) {
		$tach_color = explode('*', $color);
		$c = 0;
		foreach ($tach_color as $key => $value) {
			$c++;
			if ($c == 1) {
				$color_where .= '(FIND_IN_SET(' . $value . ',mau)>0 OR ';
			} else if ($c == count((array)$tach_color)) {
				$color_where .= 'FIND_IN_SET(' . $value . ',mau)>0) ';
			} else {
				$color_where .= 'FIND_IN_SET(' . $value . ',mau)>0 OR ';
			}
		}
	} else if (isset($url_query['color'])) {
		$color_where = 'FIND_IN_SET(' . $color . ',mau)>0';
	} else {
		$color_where = '';
	}
	if (isset($url_query['size']) and strpos($size, '*') !== false) {
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
			} else if ($s == count((array)$tach_size)) {
				$size_where .= 'FIND_IN_SET(' . $value . ',size)>0) ';
			} else {
				$size_where .= 'FIND_IN_SET(' . $value . ',size)>0 OR ';
			}
		}
	} else if (isset($url_query['size'])) {
		if ($color_where != '') {
			$size_where = 'AND FIND_IN_SET(' . $color . ',size)>0';
		} else {
			$size_where = 'FIND_IN_SET(' . $color . ',size)>0';
		}
	} else {
		$size_where = '';
	}
	if (isset($url_query['brand']) and strpos($brand, '*') !== false) {
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
			} else if ($b == count((array)$tach_brand)) {
				$brand_where .= 'FIND_IN_SET(' . $value . ',thuong_hieu)>0) ';
			} else {
				$brand_where .= 'FIND_IN_SET(' . $value . ',thuong_hieu)>0 OR ';
			}
		}
	} else if (isset($url_query['brand'])) {
		if ($color_where != '' or $size_where != '') {
			$brand_where = 'AND FIND_IN_SET(' . $brand . ',thuong_hieu)>0';
		} else {
			$brand_where = 'FIND_IN_SET(' . $brand . ',thuong_hieu)>0';
		}
	} else {
		$brand_where = '';
	}
	if (isset($url_query['price']) and strpos($price, '*') !== false) {
		$tach_price = explode('*', $price);
		$p = 0;
		foreach ($tach_price as $key => $value) {
			$p++;
			$tach_value = explode('-', $value);
			if ($p == 1) {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "AND (gia_moi<='" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "AND (gia_moi>='" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "AND ((gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "') OR ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi<='" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "(gia_moi>='" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "((gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "') OR ";
					}
				}
			} else if ($p == count((array)$tach_price)) {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<='" . $max_price . "')";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>='" . $min_price . "')";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "')) ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<='" . $max_price . "')";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>='" . $min_price . "')";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "')) ";
					}
				}
			} else {
				if ($color_where != '' or $size_where != '' or $brand_where != '') {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<='" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>='" . $min_price . "' OR";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "') OR ";
					}
				} else {
					if ($tach_value[0] == 0) {
						$max_price = $tach_value[1];
						$price_where .= "gia_moi<='" . $max_price . "' OR ";
					} else if ($tach_value[1] == 999999999999) {
						$min_price = $tach_value[0];
						$price_where .= "gia_moi>='" . $min_price . "' OR ";
					} else {
						$min_price = $tach_value[0];
						$max_price = $tach_value[1];
						$price_where .= "(gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "') OR ";
					}
				}
			}
		}
	} else if (isset($url_query['price'])) {
		$tach_price = explode('-', $price);
		if ($color_where != '' or $size_where != '' or $brand_where != '') {
			if ($tach_price[0] == 0) {
				$max_price = $tach_price[1];
				$price_where = "AND gia_moi<='" . $max_price . "'";
			} else if ($tach_price[1] == 999999999999) {
				$min_price = $tach_price[0];
				$price_where = "AND gia_moi>='" . $min_price . "'";
			} else {
				$min_price = $tach_price[0];
				$max_price = $tach_price[1];
				$price_where = "AND gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "'";
			}
		} else {
			if ($tach_price[0] == 0) {
				$max_price = $tach_price[1];
				$price_where = "gia_moi<='" . $max_price . "'";
			} else if ($tach_price[1] == 999999999999) {
				$min_price = $tach_price[0];
				$price_where = "gia_moi>='" . $min_price . "'";
			} else {
				$min_price = $tach_price[0];
				$max_price = $tach_price[1];
				$price_where = "gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "'";
			}
		}
	} else {
		$price_where = '';
	}
	if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
		$where = $color_where . " " . $size_where . " " . $brand_where . " " . $price_where;
	} else {
		$where = "";
	}
	if (strpos($url, 'tim-kiem.html') !== false) {
		$limit = 16;
		$tukhoa = addslashes(strip_tags($bien['key']));
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where . " AND tieu_de LIKE '%$tukhoa%'";
		} else {
			$where = "tieu_de LIKE '%$tukhoa%'";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $where, $order, $page, $limit);
	} else if ($cat_id > 0) {
		$limit = 16;
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where . " AND FIND_IN_SET($cat_id,cat)>0";
		} else {
			$where = "FIND_IN_SET($cat_id,cat)>0";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $where, $order, $page, $limit);
	} else {
		$limit = 16;
		if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
			$where = $color_where . ' ' . $size_where . ' ' . $brand_where . ' ' . $price_where;
		} else {
			$where = "";
		}
		$ketqua = $class_index->list_sanpham_timkiem($conn, $where, $order, $page, $limit);
	}
	if (strlen($ketqua) < 10) {
		$ketqua = '<p style="display:inline-block;width:100%;text-align:center;padding:20px;">Không có kết quả phù hợp</p>';
	}
	$info = array(
		'list' => $ketqua,
		'ok' => 1,
	);
	echo json_encode($info);
} else if ($action == 'load_quickview') {
	$sp_id = intval($_REQUEST['sp_id']);

	$thongtin = mysqli_query($conn, "SELECT s.*, p.id AS pl, p.gia_moi AS pl_gia_moi, p.gia_cu AS pl_gia_cu, COUNT(*) AS total 
                                    FROM sanpham AS s 
                                    LEFT JOIN phanloai_sanpham AS p ON s.id = p.sp_id 
                                    WHERE s.id='$sp_id' 
                                    GROUP BY s.id 
                                    ORDER BY s.id DESC LIMIT 1");

	if (!$thongtin || mysqli_num_rows($thongtin) == 0) {
		$ok = 0;
		$thongbao = 'Sản phẩm không tồn tại';
		$info = array('ok' => $ok, 'thongbao' => $thongbao);
		echo json_encode($info);
		exit();
	}

	$r_tt = mysqli_fetch_assoc($thongtin);
	$pl = $r_tt['pl'];

	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Sản phẩm không tồn tại';
		$info = array('ok' => $ok, 'thongbao' => $thongbao);
		echo json_encode($info);
		exit();
	}

	$ok = 1;
	$thongbao = 'Lấy thông tin thành công!';

	$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' ORDER BY kho_sanpham_socdo DESC");
	$variants = [];
	$colors = [];
	$sizes = [];
	$phanloai_data = [];
	$default_variant = null;

	while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
		$kho = $r_pl['kho_sanpham_socdo'] ?? 0;
		$variants[] = [
			'color' => $r_pl['color'],
			'mau_id' => $r_pl['mau_id'],
			'size' => $r_pl['size'],
			'ten_color' => $r_pl['ten_color'],
			'ten_size' => $r_pl['ten_size'],
			'gia_moi' => $r_pl['gia_moi'],
			'gia_cu' => $r_pl['gia_cu'],
			'kho' => $kho,
			'id' => $r_pl['id']
		];

		if (!isset($colors[$r_pl['color']])) {
			$color_code = $r_pl['ma_mau'] ?? '#000000';
			if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color_code)) {
				$color_code = '#000000';
			}

			$colors[$r_pl['color']] = [
				'mau_id' => $r_pl['mau_id'],
				'tieu_de_mau' => $r_pl['ten_color'],
				'color_code' => $color_code,
				'kho' => []
			];
		}
		$colors[$r_pl['color']]['kho'][] = $kho;

		if (!isset($sizes[$r_pl['size']])) {
			$sizes[$r_pl['size']] = [
				'tieu_de_size' => $r_pl['ten_size']
			];
		}

		$variant_data = [
			'mau_id' => $r_pl['mau_id'],
			'size' => $r_pl['size'],
			'pl' => $r_pl['id'],
			'gia_moi' => $r_pl['gia_moi'],
			'gia_cu' => $r_pl['gia_cu'],
			'tieu_de_mau' => $r_pl['ten_color'],
			'tieu_de_size' => $r_pl['ten_size'],
			'color_code' => $color_code,
			'kho' => $kho
		];
		$phanloai_data[] = $variant_data;

		if ($kho > 0 && $default_variant === null) {
			$default_variant = $variant_data;
		}
	}

	if ($default_variant === null && !empty($phanloai_data)) {
		$default_variant = $phanloai_data[0];
	}

	$list_mau = '';
	$m = 0;
	foreach ($colors as $color => $color_info) {
		$m++;
		$is_default_color = $default_variant && $default_variant['tieu_de_mau'] === $color_info['tieu_de_mau'];
		$checked = $is_default_color ? 'checked' : '';
		$is_color_out_of_stock = true;
		foreach ($color_info['kho'] as $kho) {
			if ($kho > 0) {
				$is_color_out_of_stock = false;
				break;
			}
		}
		$disabled = $is_color_out_of_stock ? 'disabled' : '';
		$list_mau .= '<div class="swatch-element color-swatch">
                        <input class="variant-color" id="mau-' . $color . '" type="radio" name="mau" value="' . $color . '" ' . $checked . ' ' . $disabled . ' data-ten-color="' . $color_info['tieu_de_mau'] . '" data-color-code="' . $color_info['color_code'] . '" />
                        <label for="mau-' . $color . '" style="background-color: ' . $color_info['color_code'] . ';" class="' . ($is_color_out_of_stock ? 'out-of-stock' : '') . '" title="' . $color_info['tieu_de_mau'] . '"></label>
                      </div>';
	}
	$option_mau = !empty($colors) ? '<div class="select-swatch"><div class="swatch clearfix"><div class="header"></div><div class="select-swap">' . $list_mau . '</div></div></div>' : '';

	$option_size = '<div class="select-swatch"><div class="swatch clearfix"><div class="header"></div><div class="select-swap"></div></div></div>';

	$r_tt['tinh_trang'] = '';

	$thuong_hieu = '';
	if ($r_tt['thuong_hieu'] != '') {
		$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
		$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
		$thuong_hieu = $r_th['tieu_de'] ?? '';
	}

	$list_big = '';
	if (strlen($r_tt['anh']) > 3) {
		$tach_anh = explode(",", $r_tt['anh']);
		foreach ($tach_anh as $key => $value) {
			$pt['src'] = $value;
			$pt['tieu_de'] = $r_tt['tieu_de'];
			$list_big .= $skin->skin_replace('skin/box_li/li_big', $pt);
		}
	}

	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'tieu_de' => $r_tt['tieu_de'],
		'gia_moi' => number_format($r_tt['pl_gia_moi'] ?: $r_tt['gia_moi']) . '₫',
		'gia_cu' => '<del>' . number_format($r_tt['pl_gia_cu'] ?: $r_tt['gia_cu']) . '₫</del>',
		'group_status' => '<span>Thương hiệu: <span class="status">' . $thuong_hieu . '</span></span> <span>|</span> <span>Tình trạng: <span class="status">' . $r_tt['tinh_trang'] . '</span></span>',
		'list_mau' => $option_mau,
		'list_size' => $option_size,
		'list_anh' => $list_big,
		'sp_id' => $sp_id,
		'pl' => $pl,
		'phanloai_data' => $phanloai_data,
		'default_variant' => $default_variant
	);
	echo json_encode($info);
} else if ($action == 'order_step1') {
    $ho_ten = addslashes($_REQUEST['ho_ten']);
    $email = addslashes($_REQUEST['email']);
    $dien_thoai = addslashes($_REQUEST['dien_thoai']);
    $dia_chi = addslashes($_REQUEST['dia_chi']);
    $tinh = intval($_REQUEST['tinh']);
    $huyen = intval($_REQUEST['huyen']);
    $xa = intval($_REQUEST['xa']);
    $ghi_chu = addslashes($_REQUEST['ghi_chu']);
    $phuongthuc = addslashes($_REQUEST['phuongthuc']);
    $apply_hatde = intval($_REQUEST['apply_hatde']);
    $total_cart = count((array)$_SESSION['cart']);
    $hientai = time();

    // Kiểm tra thông tin đầu vào
    if ($total_cart == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Không có sản phẩm trong giỏ hàng';
    } else if (strlen($ho_ten) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa nhập họ và tên';
    } else if (strlen($dien_thoai) < 10) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa nhập số điện thoại';
    } else if (strlen($dia_chi) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa nhập địa chỉ';
    } else if ($tinh == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa chọn tỉnh/TP';
    } else if ($huyen == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa chọn Quận/huyện';
    } else if ($xa == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa chọn Xã/phường';
    } else {
        // Tạo danh sách ID sản phẩm từ giỏ hàng
        $list_id = '';
        $list_pl = '';
        foreach ($_SESSION['cart'] as $key => $value) {
            list($sp_id, $pl) = explode('_', $key);
            if (!is_numeric($sp_id) || !is_numeric($pl)) {
                $ok = 0;
                $thongbao = 'Thất bại! Dữ liệu giỏ hàng không hợp lệ';
                $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                echo json_encode($info);
                exit();
            }
            $list_id .= $sp_id . ',';
            $list_pl .= $pl . ',';
        }
        $list_id = rtrim($list_id, ',');
        $list_pl = rtrim($list_pl, ',');

        // Kiểm tra $list_id hợp lệ
        if (empty($list_id) || !preg_match('/^[0-9,]+$/', $list_id)) {
            $ok = 0;
            $thongbao = 'Thất bại! Danh sách sản phẩm không hợp lệ';
            $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
            echo json_encode($info);
            exit();
        }

        // Lấy thông tin sản phẩm từ bảng sanpham (chỉ để kiểm tra kho và lấy thông tin cơ bản)
        $products = [];
        $thongtin_sp = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY id ASC");
        if ($thongtin_sp) {
            while ($r_sp = mysqli_fetch_assoc($thongtin_sp)) {
                $products[$r_sp['id']] = $r_sp;
            }
        } else {
            $ok = 0;
            $thongbao = 'Lỗi truy vấn cơ sở dữ liệu (sanpham)';
            $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
            echo json_encode($info);
            exit();
        }

        // Lấy thông tin phân loại sản phẩm từ bảng phanloai_sanpham (chỉ để kiểm tra kho)
        $product_pl = [];
        $list_pl_array = explode(',', $list_pl);
        $filtered_list_pl = array_filter($list_pl_array, function($value) {
            return $value > 0;
        });
        if (!empty($filtered_list_pl)) {
            $filtered_list_pl_str = implode(',', $filtered_list_pl);
            $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE id IN ($filtered_list_pl_str) ORDER BY id ASC");
            if ($thongtin_pl) {
                while ($r_pl = mysqli_fetch_assoc($thongtin_pl)) {
                    $sp_pl = $r_pl['sp_id'] . '_' . $r_pl['id'];
                    $product_pl[$sp_pl] = $r_pl;
                }
            } else {
                $ok = 0;
                $thongbao = 'Lỗi truy vấn cơ sở dữ liệu (phanloai_sanpham)';
                $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                echo json_encode($info);
                exit();
            }
        }

        // Kiểm tra kho của từng sản phẩm trong giỏ hàng - Đồng bộ với logic trong add_to_cart
        foreach ($_SESSION['cart'] as $key => $value) {
            list($sp_id, $pl) = explode('_', $key);
            $sp_pl = $sp_id . '_' . $pl;
            $quantity = $value['quantity'];
            $is_flash_sale = isset($value['flash_sale']) && $value['flash_sale'] == 1;

            // Kiểm tra sản phẩm có tồn tại không
            if (!isset($products[$sp_id])) {
                $ok = 0;
                $thongbao = 'Thất bại! Sản phẩm (ID: ' . $sp_id . ') không tồn tại';
                $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                echo json_encode($info);
                exit();
            }

            $kho = 0;
            $has_variant = false;

            // Nếu có biến thể ($pl > 0)
            if ($pl > 0) {
                if (isset($product_pl[$sp_pl])) {
                    $has_variant = true;
                    $kho = max(0, $product_pl[$sp_pl]['kho_sanpham_socdo'] ?? 0);
                    // Nếu kho của phân loại bằng 0, lấy kho từ bảng sanpham (giống add_to_cart)
                    if ($kho == 0) {
                        $kho = max(0, $products[$sp_id]['kho'] ?? 0);
                    }
                } else {
                    $ok = 0;
                    $thongbao = 'Thất bại! Phân loại sản phẩm (ID: ' . $pl . ') không tồn tại';
                    $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                    echo json_encode($info);
                    exit();
                }
            } else {
                // Nếu không có biến thể, lấy kho từ bảng sanpham (giống add_to_cart)
                $kho = max(0, $products[$sp_id]['kho'] ?? 0);
            }

            // Kiểm tra tồn kho
            if ($kho < $quantity) {
                $ok = 0;
                $thongbao = 'Thất bại! Sản phẩm (ID: ' . $sp_id . ') không đủ số lượng trong kho' . ($has_variant ? ' (phân loại ID: ' . $pl . ')' : '');
                $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                echo json_encode($info);
                exit();
            }

            // Kiểm tra Flash Sale (nếu có) - Đồng bộ với add_to_cart
            if ($is_flash_sale) {
                $thongtin_flash = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
                $total_flash = mysqli_num_rows($thongtin_flash);
                if ($total_flash == 0) {
                    $ok = 0;
                    $thongbao = 'Thất bại! Flash sale đã hết hạn';
                    $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                    echo json_encode($info);
                    exit();
                } else {
                    $r_flash = mysqli_fetch_assoc($thongtin_flash);
                    $tach_sp_flash = json_decode($r_flash['sub_product'], true);
                    $so_luong_con = 0;
                    foreach ($tach_sp_flash as $flash_key => $flash_value) {
                        if ($flash_value['sp_id'] == $sp_id) {
                            if ($has_variant) {
                                foreach ($flash_value['list_pl'] as $k => $v) {
                                    if ($v['pl'] == $pl) {
                                        $so_luong_con = $v['so_luong'];
                                    }
                                }
                            } else {
                                $so_luong_con = $flash_value['so_luong'] ?? 0;
                            }
                        }
                    }
                    if ($so_luong_con <= 0) {
                        $ok = 0;
                        $thongbao = 'Thất bại! Số lượng khuyến mại đã hết';
                        $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                        echo json_encode($info);
                        exit();
                    }
                    if ($so_luong_con < $quantity) {
                        $ok = 0;
                        $thongbao = 'Thất bại! Số lượng khuyến mại không đủ';
                        $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
                        echo json_encode($info);
                        exit();
                    }
                }
            }
        }

        // Xử lý coupon (nếu có)
        $giam = 0;
        if (isset($_SESSION['coupon'])) {
            $thongtin_coupon = mysqli_query($conn, "SELECT *, COUNT(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='0'");
            $r_coupon = mysqli_fetch_assoc($thongtin_coupon);
            if ($r_coupon['total'] > 0 && $r_coupon['kieu'] == 'sanpham') {
                $tach_list_id = explode(',', $list_id);
                $tach_sanpham_id = explode(',', $r_coupon['sanpham']);
                $id_apdung = array_intersect($tach_sanpham_id, $tach_list_id);
            }
        }

        // Xử lý danh sách sản phẩm trong giỏ hàng
        $list_c = [];
        $list_s = [];
        $tamtinh = 0;
        $list = '';

        // Xử lý Flash Sale (nếu có)
        $list_check_product = [];
        foreach ($_SESSION['cart'] as $key => $value) {
            list($sp_f, $pl) = explode('_', $key);
            if ($value['flash_sale'] == 1) {
                $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_f,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
                $r_ck = mysqli_fetch_assoc($thongtin_check);
                $list_check_product[] = json_decode($r_ck['sub_product'], true);
            }
        }
        foreach ($list_check_product as $key => $value) {
            foreach ($value as $k => $v) {
                $list_c[$k] = $v;
            }
        }

        // Xử lý Deal Mua Kèm (nếu có)
        if (isset($_SESSION['muakem'])) {
            $list_main_id = '';
            $list_id_mk = '';
            $list_sub_product = [];
            foreach ($_SESSION['main_product'] as $key => $value) {
                $list_main_id .= $value . ',';
                $thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='0' ORDER BY id DESC LIMIT 1");
                $r_mk = mysqli_fetch_assoc($thongtin_muakem);
                $list_id_mk .= $r_mk['sub_id'] . ',';
                $list_sub_product[] = json_decode($r_mk['sub_product'], true);
            }
            foreach ($list_sub_product as $key => $value) {
                foreach ($value as $k => $v) {
                    $list_s[$k] = $v;
                }
            }
            $list_main_id = rtrim($list_main_id, ',');
            $tach_list_main_id = explode(',', $list_main_id);
            $list_id_mk = rtrim($list_id_mk, ',');
            $tach_list_id_mk = explode(',', $list_id_mk);
        }

        // Truy vấn sản phẩm từ bảng sanpham (chỉ để lấy thông tin cơ bản như tiêu đề, link, minh họa)
        $thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id, $list_id)");
        if (!$thongtin_cart) {
            $ok = 0;
            $thongbao = 'Lỗi truy vấn cơ sở dữ liệu (sanpham): ' . mysqli_error($conn);
            $info = array('ok' => $ok, 'thongbao' => $thongbao, 'link' => '');
            echo json_encode($info);
            exit();
        }

        $xvn = 0;
        $list = array();
        while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
            $xvn++;
            $id_sp = $r_cart['id'];

            // Tìm sản phẩm trong giỏ hàng
            $found = false;
            foreach ($_SESSION['cart'] as $key => $value) {
                list($cart_sp_id, $cart_pl) = explode('_', $key);
                if ($cart_sp_id == $id_sp) {
                    $found = true;

                    // Sử dụng thông tin từ $_SESSION['cart']
                    $r_cart['ten_color'] = $value['color'] ?? '';
                    $r_cart['ten_size'] = $value['size'] ?? '';
                    $r_cart['gia_moi'] = $value['gia_moi'] ?? $r_cart['gia_moi'];
                    $r_cart['gia_cu'] = $value['gia_cu'] ?? $r_cart['gia_cu'];

                    // Xử lý các trường hợp đặc biệt (quà tặng, flash sale, deal sốc)
                    if (isset($value['tang']) && $value['tang'] == 1) {
                        $r_cart['ten_sanpham'] = '[Quà tặng] ' . $r_cart['tieu_de'];
                        $tamtinh += 0;
                        $r_cart['thanhtien'] = 0;
                        $r_cart['gia_moi'] = 0;
                        $r_cart['quantity'] = 1;
                        $r_cart['gia_cu'] = $value['gia_cu'] ?? $r_cart['gia_cu'];
                    } else if (isset($list_c[$id_sp])) {
                        $r_cart['ten_sanpham'] = '[Flash Sale] ' . $r_cart['tieu_de'];
                        $tamtinh += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $value['quantity'];
                        if (isset($_SESSION['coupon'])) {
                            if ($r_coupon['kieu'] == 'all' || $r_coupon['kieu'] == 'baohanh') {
                                if ($r_coupon['loai'] == 'phantram') {
                                    $g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $value['quantity'] / 100) * $r_coupon['giam'];
                                    $giam += ceil($g);
                                } else {
                                    $giam += $r_coupon['giam'];
                                }
                            } else {
                                if (in_array($id_sp, $id_apdung)) {
                                    if ($r_coupon['loai'] == 'phantram') {
                                        $g = (preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $value['quantity'] / 100) * $r_coupon['giam'];
                                        $giam += ceil($g);
                                    } else {
                                        $giam += $r_coupon['giam'];
                                    }
                                }
                            }
                        }
                        $r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $value['quantity']);
                        $r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
                        $r_cart['gia_cu'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia_cu']));
                        $r_cart['quantity'] = $value['quantity'];
                    } else if (isset($list_s[$id_sp])) {
                        $r_cart['ten_sanpham'] = '[Deal sốc] ' . $r_cart['tieu_de'];
                        if ($list_s[$id_sp]['gia'] != '') {
                            $tamtinh += preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $value['quantity'];
                            $r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']) * $value['quantity']);
                            $r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']));
                            $r_cart['gia_cu'] = $value['gia_cu'] ?? $r_cart['gia_cu'];
                            $r_cart['quantity'] = $value['quantity'];
                        } else {
                            $gia_moi = ($value['gia_moi'] ?? $r_cart['gia_moi']) - (($value['gia_moi'] ?? $r_cart['gia_moi']) / 100) * $list_s[$id_sp]['sale'];
                            $tamtinh += $gia_moi * $value['quantity'];
                            $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity']);
                            $r_cart['gia_moi'] = number_format($gia_moi);
                            $r_cart['gia_cu'] = $value['gia_cu'] ?? $r_cart['gia_cu'];
                            $r_cart['quantity'] = $value['quantity'];
                        }
                    } else {
                        $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                        $tamtinh += ($value['gia_moi'] ?? $r_cart['gia_moi']) * $value['quantity'];
                        if (isset($_SESSION['coupon'])) {
                            if ($r_coupon['kieu'] == 'all' || $r_coupon['kieu'] == 'baohanh') {
                                if ($r_coupon['loai'] == 'phantram') {
                                    $g = (($value['gia_moi'] ?? $r_cart['gia_moi']) * $value['quantity'] / 100) * $r_coupon['giam'];
                                    $giam += ceil($g);
                                } else {
                                    $giam += $r_coupon['giam'];
                                }
                            } else {
                                if (in_array($id_sp, $id_apdung)) {
                                    if ($r_coupon['loai'] == 'phantram') {
                                        $g = (($value['gia_moi'] ?? $r_cart['gia_moi']) * $value['quantity'] / 100) * $r_coupon['giam'];
                                        $giam += ceil($g);
                                    } else {
                                        $giam += $r_coupon['giam'];
                                    }
                                }
                            }
                        }
                        $r_cart['thanhtien'] = number_format(($value['gia_moi'] ?? $r_cart['gia_moi']) * $value['quantity']);
                        $r_cart['gia_moi'] = number_format($value['gia_moi'] ?? $r_cart['gia_moi']);
                        $r_cart['gia_cu'] = number_format($value['gia_cu'] ?? $r_cart['gia_cu']);
                        $r_cart['quantity'] = $value['quantity'];
                    }

                    // Tính hoa hồng
                    $cat = $r_cart['cat'];
                    if (isset($value['tang']) && $value['tang'] == 1) {
                        $hoa_hong = '0';
                    } else if ($cat == '') {
                        $hoa_hong = '0';
                    } else {
                        $thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
                        while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
                            if ($r_c['hoa_hong'] == 'ko' || $r_c['hoa_hong'] == 'khong') {
                                $hoa_hong = 0;
                            } else if ($r_c['cat_main'] > 0) {
                                if ($r_c['hoa_hong'] != '') {
                                    $hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * $r_c['hoa_hong'];
                                } else {
                                    $hoa_hong = 0;
                                }
                            } else if ($r_c['cat_main'] == 0) {
                                $hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * intval($r_c['hoa_hong']);
                            } else {
                                $hoa_hong = 0;
                            }
                        }
                    }

                    // Tạo chuỗi JSON cho danh sách sản phẩm
                    $list[] = '"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . ($r_cart['ma_sp'] ?? '') . '","soluong":"' . $value['quantity'] . '","color":"' . $r_cart['ten_color'] . '","size":"' . $r_cart['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","gia_cu":"' . $r_cart['gia_cu'] . '","link":"' . $r_cart['link'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","hoa_hong":"' . $hoa_hong . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
                }
            }
            if (!$found) {
                continue; // Bỏ qua nếu không tìm thấy sản phẩm trong giỏ hàng
            }
        }
        $list = implode(',', $list);
        $sanpham = '{' . $list . '}';
        if (isset($_SESSION['coupon'])) {
            if ($r_coupon['expired'] > time()) {
                $coupon = $_SESSION['coupon'];
            } else {
                $giam = 0;
                $coupon = '';
            }
        } else {
            $giam = 0;
            $coupon = '';
        }

        if (in_array($phuongthuc, array('momo', 'qr', 'vnpay'))) {
            $giam_them = 0;
        } else {
            $giam_them = 0;
        }

        $phi_ship = 0;
        $tonggiam = $giam_them + $giam;
        $tongtien = $tamtinh - $giam - $giam_them + $phi_ship;
        $_SESSION['phuongthuc'] = $phuongthuc;
        $ma_don = $class_index->creat_random($conn, 'donhang');
        $thongtin_tichdiem = mysqli_query($conn, "SELECT *, COUNT(*) AS total FROM caidat_tichdiem WHERE shop='0'");
        $r_td = mysqli_fetch_assoc($thongtin_tichdiem);
        $diem = ceil(($tamtinh / 100) * $r_td['diem']);
        $utm_source = addslashes(strip_tags($_COOKIE['utm_source']));
        $utm_campaign = addslashes(strip_tags($_COOKIE['utm_campaign']));
		// nhatthem
		//$shop_id = mysqli_query($conn, "SELECT ");
        if ($tongtien < 0) {
            $ok = 0;
            $thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
        } else if (strlen($sanpham) < 10) {
            $ok = 0;
            $thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
        } else {
            if ($apply_hatde == '1') {
                if ($r_td['total'] > 0) {
                    $user_id = isset($user_id) ? $user_id : 0;
                    if ($user_id == 0) {
                        $ok = 0;
                        $thongbao = 'Thất bại! Vui lòng đăng nhập để sử dụng Hạt Dẻ';
                    } else {
                        $thongtin_diem = mysqli_query($conn, "SELECT * FROM diem WHERE user_id='$user_id'");
                        $r_diem = mysqli_fetch_assoc($thongtin_diem);
                        if ($tongtien <= $r_diem['diem']) {
                            $ok = 1;
                            $thongbao = 'Đang chuyển hướng...';
                            mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','0','$sanpham','$tamtinh','{$_SESSION['coupon']}','$tonggiam','$phi_ship','$tongtien','','0','$phuongthuc','','$utm_source','$utm_campaign'," . time() . "," . time() . ")");
                            $conlai = $r_diem['diem'] - $tongtien;
                            mysqli_query($conn, "UPDATE coupon SET status='1' WHERE ma='$coupon' AND kieu='baohanh' AND shop='0'");
                            mysqli_query($conn, "UPDATE kichhoat_baohanh SET status='1' WHERE coupon='{$_SESSION['coupon']}'");
                            mysqli_query($conn, "UPDATE diem SET diem='$conlai' WHERE user_id='$user_id'");
                            $_SESSION['ma_don'] = $ma_don;

                            // Cập nhật kho của từng sản phẩm
                            foreach ($_SESSION['cart'] as $key => $value) {
                                list($spx, $plx) = explode('_', $key);
                                $quantity = $value['quantity'];
                                if ($plx > 0) {
                                    mysqli_query($conn, "UPDATE phanloai_sanpham SET kho_sanpham_socdo = kho_sanpham_socdo - $quantity WHERE id = '$plx'");
                                } else {
                                    if (!empty($products[$spx]['shop'])) {
                                        // Nếu có shop_id, không cập nhật trực tiếp vì tổng kho của shop không thể phân bổ trực tiếp
                                    } else {
                                        mysqli_query($conn, "UPDATE sanpham SET kho = kho - $quantity WHERE id = '$spx'");
                                    }
                                }

                                if ($value['flash_sale'] == 1) {
                                    $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($spx,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
                                    $r_ck = mysqli_fetch_assoc($thongtin_check);
                                    $sp_info = json_decode($r_ck['sub_product'], true);
                                    $i = 0;
                                    foreach ($sp_info as $k => $v) {
                                        $i++;
                                        $m = 0;
                                        foreach ($v['list_pl'] as $k_pl => $v_pl) {
                                            $m++;
                                            if ($v_pl['pl'] == $plx) {
                                                $sl = $v['so_luong'] - $quantity;
                                            } else {
                                                $sl = $v['so_luong'];
                                            }
                                            if ($m == 1) {
                                                $list_update_pl .= '{"pl": "' . $v_pl['pl'] . '","ten_color":"' . $v_pl['ten_color'] . '","color":"' . $v_pl['color'] . '","ma_mau":"' . $v_pl['ma_mau'] . '","ten_size":"' . $v_pl['ten_size'] . '","size":"' . $v_pl['size'] . '","gia_cu":"' . $v_pl['gia_cu'] . '","gia_moi":"' . $v_pl['gia_moi'] . '","gia":"' . $v_pl['gia'] . '","so_luong":"' . $sl . '"}';
                                            } else {
                                                $list_update_pl .= ',{"pl": "' . $v_pl['pl'] . '","ten_color":"' . $v_pl['ten_color'] . '","color":"' . $v_pl['color'] . '","ma_mau":"' . $v_pl['ma_mau'] . '","ten_size":"' . $v_pl['ten_size'] . '","size":"' . $v_pl['size'] . '","gia_cu":"' . $v_pl['gia_cu'] . '","gia_moi":"' . $v_pl['gia_moi'] . '","gia":"' . $v_pl['gia'] . '","so_luong":"' . $sl . '"}';
                                            }
                                        }
                                        if ($i == 1) {
                                            $list_sp_update .= '{"sp_id": "' . $v['sp_id'] . '","list_pl": [' . $list_update_pl . ']}';
                                        } else {
                                            $list_sp_update .= ',{"sp_id": "' . $v['sp_id'] . '","list_pl": [' . $list_update_pl . ']}';
                                        }
                                        unset($list_update_pl);
                                    }
                                    $list_update = '[' . $list_sp_update . ']';
                                    mysqli_query($conn, "UPDATE deal SET sub_product='$list_update' WHERE id='{$r_ck['id']}'");
                                    $i = 0;
                                    unset($list_update);
                                }
                            }

                            unset($_SESSION['cart']);
                            unset($_SESSION['main_product']);
                            unset($_SESSION['muakem']);
                            unset($_SESSION['coupon']);
                        } else {
                            $ok = 0;
                            $thongbao = 'Thất bại! Số điểm của bạn không đủ';
                        }
                    }
                } else {
                    $ok = 0;
                    $thongbao = 'Thất bại! Phương thức này không được áp dụng';
                }
            } else {
                $user_id = isset($user_id) ? $user_id : 0;
				
                mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post, shop_id)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','0','$sanpham','$tamtinh','$coupon','$tonggiam','$phi_ship','$tongtien','','0','$phuongthuc','','$utm_source','$utm_campaign'," . time() . "," . time() . ", '$shop_id')");
                $ok = 1;
                $thongbao = 'Đang chuyển hướng...';
                if ($r_td['total'] > 0 && $r_td['diem'] > 0) {
                    $noi_dung = 'Nhận điểm thưởng khi đặt đơn hàng #' . $ma_don;
                    $hientai = time();
                    mysqli_query($conn, "INSERT INTO tich_diem(shop,user_id,don,diem,noi_dung,status,date_post)VALUES('0','$user_id','$ma_don','$diem','$noi_dung','0','$hientai')");
                }
                mysqli_query($conn, "UPDATE coupon SET status='1' WHERE ma='$coupon' AND kieu='baohanh' AND shop='0'");
                mysqli_query($conn, "UPDATE kichhoat_baohanh SET status='1' WHERE coupon='$coupon'");
                $_SESSION['ma_don'] = $ma_don;

                // Cập nhật kho của từng sản phẩm
                foreach ($_SESSION['cart'] as $key => $value) {
                    list($spx, $plx) = explode('_', $key);
                    $quantity = $value['quantity'];
                    if ($plx > 0) {
                        mysqli_query($conn, "UPDATE phanloai_sanpham SET kho_sanpham_socdo = kho_sanpham_socdo - $quantity WHERE id = '$plx'");
                    } else {
                        if (!empty($products[$spx]['shop'])) {
                            // Nếu có shop_id, không cập nhật trực tiếp vì tổng kho của shop không thể phân bổ trực tiếp
                        } else {
                            mysqli_query($conn, "UPDATE sanpham SET kho = kho - $quantity WHERE id = '$spx'");
                        }
                    }

                    if ($value['flash_sale'] == 1) {
                        $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($spx,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
                        $r_ck = mysqli_fetch_assoc($thongtin_check);
                        $sp_info = json_decode($r_ck['sub_product'], true);
                        $i = 0;
                        foreach ($sp_info as $k => $v) {
                            $i++;
                            $m = 0;
                            foreach ($v['list_pl'] as $k_pl => $v_pl) {
                                $m++;
                                if ($v_pl['pl'] == $plx) {
                                    $sl = $v['so_luong'] - $quantity;
                                } else {
                                    $sl = $v['so_luong'];
                                }
                                if ($m == 1) {
                                    $list_update_pl .= '{"pl": "' . $v_pl['pl'] . '","ten_color":"' . $v_pl['ten_color'] . '","color":"' . $v_pl['color'] . '","ma_mau":"' . $v_pl['ma_mau'] . '","ten_size":"' . $v_pl['ten_size'] . '","size":"' . $v_pl['size'] . '","gia_cu":"' . $v_pl['gia_cu'] . '","gia_moi":"' . $v_pl['gia_moi'] . '","gia":"' . $v_pl['gia'] . '","so_luong":"' . $sl . '"}';
                                } else {
                                    $list_update_pl .= ',{"pl": "' . $v_pl['pl'] . '","ten_color":"' . $v_pl['ten_color'] . '","color":"' . $v_pl['color'] . '","ma_mau":"' . $v_pl['ma_mau'] . '","ten_size":"' . $v_pl['ten_size'] . '","size":"' . $v_pl['size'] . '","gia_cu":"' . $v_pl['gia_cu'] . '","gia_moi":"' . $v_pl['gia_moi'] . '","gia":"' . $v_pl['gia'] . '","so_luong":"' . $sl . '"}';
                                }
                            }
                            if ($i == 1) {
                                $list_sp_update .= '{"sp_id": "' . $v['sp_id'] . '","list_pl": [' . $list_update_pl . ']}';
                            } else {
                                $list_sp_update .= ',{"sp_id": "' . $v['sp_id'] . '","list_pl": [' . $list_update_pl . ']}';
                            }
                            unset($list_update_pl);
                        }
                        $list_update = '[' . $list_sp_update . ']';
                        mysqli_query($conn, "UPDATE deal SET sub_product='$list_update' WHERE id='{$r_ck['id']}'");
                        $i = 0;
                        unset($list_update);
                    }
                }

                unset($_SESSION['cart']);
                unset($_SESSION['main_product']);
                unset($_SESSION['muakem']);
                unset($_SESSION['coupon']);
            }
        }
    }

    if (in_array($phuongthuc, array('vnpay', 'momo', 'qr'))) {
        $link = '/order-detail.html?id=' . $ma_don;
    } else {
        $link = '/order-detail.html?id=' . $ma_don;
    }
    $info = array(
        'ok' => $ok,
        'thongbao' => $thongbao,
        'link' => $link
    );
    echo json_encode($info);
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
	} else if (strlen($dien_thoai) < 10) {
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
	} else if (in_array($thanhtoan, array('cod', 'diem', 'chuyenkhoan')) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Phương thức thanh toán không hợp lệ';
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
		}
		$list_id = substr($list_id, 0, -1);
		if (isset($_SESSION['coupon'])) {
			$thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='0'");
			$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
			if ($r_coupon['kieu'] == 'sanpham') {
				$tach_list_id = explode(',', $list_id);
				$tach_sanpham_id = explode(',', $r_coupon['sanpham']);
				$id_apdung = array_intersect($tach_sanpham_id, $tach_list_id);
				$total_id = count((array)$id_apdung);
			}
		}
		$hientai = time();
		if (isset($_SESSION['muakem'])) {
			foreach ($_SESSION['main_product'] as $key => $value) {
				$list_main_id .= $value . ',';
				$thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='0' ORDER BY id DESC LIMIT 1");
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
					$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
					$r_ck = mysqli_fetch_assoc($thongtin_check);
					$list_check_product[] = json_decode($r_ck['sub_product'], true);
				}
			}
			foreach ($list_check_product as $key => $value) {
				foreach ($value as $k => $v) {
					$list_c[$k] = $v;
				}
			}
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id) ASC");
			$k = 0;
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$k++;
				$id_sp = $r_cart['id'];
				$can_nang += str_replace(',', '.', $r_cart['can_nang']) * $_SESSION['cart'][$id_sp]['quantity'];
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
						if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
						if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
					if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
					if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
				$list_product .= $skin->skin_replace('skin/box_li/li_product_checkout', $r_cart);
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
				if ($mau == '') {
					$color = '';
				} else {
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
				}
				$cat = $r_cart['cat'];
				if ($cat == '') {
					$hoa_hong = '0';
				} else {
					$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
					while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
						if ($r_c['hoa_hong'] == 'ko' or $r_c['hoa_hong'] == 'khong') {
							$hoa_hong = 0;
						} else if ($r_c['cat_main'] > 0) {
							if ($r_c['hoa_hong'] != '') {
								$hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * $r_c['hoa_hong'];
							} else {
							}
						} else if ($r_c['cat_main'] == 0) {
							$hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * intval($r_c['hoa_hong']);
						}
					}
				}
				if ($ko_apdung == 1) {
					$hoa_hong = '0';
				} else {
					$hoa_hong = $hoa_hong;
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
					$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
					$r_ck = mysqli_fetch_assoc($thongtin_check);
					$list_check_product[] = json_decode($r_ck['sub_product'], true);
				}
			}
			foreach ($list_check_product as $key => $value) {
				foreach ($value as $k => $v) {
					$list_c[$k] = $v;
				}
			}
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
			$k = 0;
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$k++;
				$id_sp = $r_cart['id'];
				$can_nang += str_replace(',', '.', $r_cart['can_nang']) * $_SESSION['cart'][$id_sp]['quantity'];
				if ($_SESSION['cart'][$id_sp]['tang'] == 1) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Quà tặng] ' . $r_cart['tieu_de'];
					$tamtinh += 0;
					$r_cart['thanhtien'] = 0;
					$r_cart['gia_moi'] = 0;
					$r_cart['quantity'] = 1;
					$list_product .= $skin->skin_replace('skin/box_li/li_product_checkout', $r_cart);
				} else if (isset($list_c[$id_sp])) {
					$r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
					$r_cart['tieu_de'] = '[Flash Sale] ' . $r_cart['tieu_de'];
					$tamtinh += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
					$list_product .= $skin->skin_replace('skin/box_li/li_product_checkout', $r_cart);
				} else {
					$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
					$tamtinh += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
					if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
					$list_product .= $skin->skin_replace('skin/box_li/li_product_checkout', $r_cart);
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
				if ($mau == '') {
					$color = '';
				} else {
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
				}
				$cat = $r_cart['cat'];
				if ($cat == '') {
					$hoa_hong = '0';
				} else {
					$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
					while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
						if ($r_c['hoa_hong'] == 'ko' or $r_c['hoa_hong'] == 'khong') {
							$hoa_hong = 0;
						} else if ($r_c['cat_main'] > 0) {
							if ($r_c['hoa_hong'] != '') {
								$hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * $r_c['hoa_hong'];
							} else {
							}
						} else if ($r_c['cat_main'] == 0) {
							$hoa_hong = (preg_replace('/[^0-9]/', '', $r_cart['thanhtien']) / 100) * intval($r_c['hoa_hong']);
						}
					}
				}
				if ($ko_apdung == 1) {
					$hoa_hong = '0';
				} else {
					$hoa_hong = $hoa_hong;
				}
				if ($k == 1) {
					$list .= '"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","hoa_hong":"' . $hoa_hong . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				} else {
					$list .= ',"' . $id_sp . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"' . $_SESSION['cart'][$id_sp]['quantity'] . '","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","hoa_hong":"' . $hoa_hong . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
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
					if ($r_coupon['kieu'] == 'all' or $r_coupon['kieu'] == 'baohanh') {
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
		if ($thanhtoan == 'chuyenkhoan') {
			//$giam_them=(($tamtinh - $giam)/100)*5;
			$giam_them = 0;
		} else {
			$giam_them = 0;
		}
		if ($can_nang <= 5) {
			//$phi_ship=28000;
		} else {
			//$phi_ship=25000;
			//$phi_ship=28000 + ($can_nang - 5)*6000;
		}
		$phi_ship = 0;
		$tonggiam = $giam_them + $giam;
		$tongtien = $tamtinh - $giam - $giam_them + $phi_ship;
		$_SESSION['thanhtoan'] = $thanhtoan;
		$ho_ten = $_SESSION['ho_ten'];
		$email = $_SESSION['email'];
		$dien_thoai = $_SESSION['dien_thoai'];
		$dia_chi = $_SESSION['dia_chi'];
		$tinh = $_SESSION['tinh'];
		$huyen = $_SESSION['huyen'];
		$ma_don = $class_index->creat_random($conn, 'donhang');
		$thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='0'");
		$r_td = mysqli_fetch_assoc($thongtin_tichdiem);
		$diem = ceil(($tongtien / 100) * $r_td['diem']);
		$utm_source = addslashes(strip_tags($_COOKIE['utm_source']));
		$utm_campaign = addslashes(strip_tags($_COOKIE['utm_campaign']));
		if ($tongtien < 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
		} else if (strlen($sanpham) < 10) {
			$ok = 0;
			$thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
		} else if (strlen($ho_ten) < 2) {
			$ok = 0;
			$thongbao = 'Thất bại! Họ và tên không hợp lệ';
		} else if (strlen($dien_thoai) < 10) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại không hợp lệ';
		} else if (strlen($dia_chi) < 2) {
			$ok = 0;
			$thongbao = 'Thất bại! Địa chỉ không hợp lệ';
		} else {
			if ($thanhtoan == 'diem') {
				if ($r_td['total'] > 0) {
					$thongtin_diem = mysqli_query($conn, "SELECT * FROM diem WHERE user_id='$user_id'");
					$r_diem = mysqli_fetch_assoc($thongtin_diem);
					if ($tongtien <= $r_diem['diem']) {
						$ok = 1;
						$thongbao = 'Đang chuyển hướng...';
						mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post,shop_id)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','$sanpham','$tamtinh','$coupon','$tonggiam','$phi_ship','$tongtien','','0','$thanhtoan','','$utm_source','$utm_campaign'," . time() . "," . time() . ")");
						$conlai = $r_diem['diem'] - $tongtien;
						mysqli_query($conn, "UPDATE coupon SET status='1' WHERE ma='$coupon' AND kieu='baohanh' AND shop='0'");
						mysqli_query($conn, "UPDATE kichhoat_baohanh SET status='1' WHERE coupon='$coupon'");
						mysqli_query($conn, "UPDATE diem SET diem='$conlai' WHERE user_id='$user_id'");
						$_SESSION['ma_don'] = $ma_don;
						foreach ($_SESSION['cart'] as $key => $value) {
							if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
								$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
								$r_ck = mysqli_fetch_assoc($thongtin_check);
								$sp_info = json_decode($r_ck['sub_product'], true);
								$i = 0;
								foreach ($sp_info as $k => $v) {
									$i++;
									if ($k == $key) {
										$sl = $v['so_luong'] - 1;
									} else {
										$sl = $v['so_luong'];
									}
									if ($i == 1) {
										$list_update .= '"' . $k . '":{"gia":"' . $v['gia'] . '","so_luong":"' . $sl . '","date_start":"' . $v['date_start'] . '","date_end":"' . $v['date_end'] . '"}';
									} else {
										$list_update .= ',"' . $k . '":{"gia":"' . $v['gia'] . '","so_luong":"' . $sl . '","date_start":"' . $v['date_start'] . '","date_end":"' . $v['date_end'] . '"}';
									}
								}
								$list_update = '{' . $list_update . '}';
								mysqli_query($conn, "UPDATE deal SET sub_product='$list_update' WHERE id='{$r_ck['id']}'");
								$i = 0;
								unset($list_update);
							}
						}
						unset($_SESSION['cart']);
						unset($_SESSION['main_product']);
						unset($_SESSION['muakem']);
						unset($_SESSION['coupon']);
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Số điểm của bạn không đủ';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Phương thức này không được áp dụng';
				}
			} else {
				mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','$sanpham','$tamtinh','$coupon','$tonggiam','$phi_ship','$tongtien','','0','$thanhtoan','','$utm_source','$utm_campaign'," . time() . "," . time() . ")");
				$ok = 1;
				$thongbao = 'Đang chuyển hướng...';
				if ($r_td['total'] > 0 and $r_td['diem'] > 0) {
					$noi_dung = 'Nhận điểm thưởng khi đặt đơn hàng #' . $ma_don;
					$hientai = time();
					mysqli_query($conn, "INSERT INTO tich_diem(shop,user_id,don,diem,noi_dung,status,date_post)VALUES('0','$user_id','$ma_don','$diem','$noi_dung','0','$hientai')");
				}
				mysqli_query($conn, "UPDATE coupon SET status='1' WHERE ma='$coupon' AND kieu='baohanh' AND shop='0'");
				mysqli_query($conn, "UPDATE kichhoat_baohanh SET status='1' WHERE coupon='$coupon'");
				$_SESSION['ma_don'] = $ma_don;
				foreach ($_SESSION['cart'] as $key => $value) {
					if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
						$thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
						$r_ck = mysqli_fetch_assoc($thongtin_check);
						$sp_info = json_decode($r_ck['sub_product'], true);
						$i = 0;
						foreach ($sp_info as $k => $v) {
							$i++;
							if ($k == $key) {
								$sl = $v['so_luong'] - 1;
							} else {
								$sl = $v['so_luong'];
							}
							if ($i == 1) {
								$list_update .= '"' . $k . '":{"gia":"' . $v['gia'] . '","so_luong":"' . $sl . '","date_start":"' . $v['date_start'] . '","date_end":"' . $v['date_end'] . '"}';
							} else {
								$list_update .= ',"' . $k . '":{"gia":"' . $v['gia'] . '","so_luong":"' . $sl . '","date_start":"' . $v['date_start'] . '","date_end":"' . $v['date_end'] . '"}';
							}
						}
						$list_update = '{' . $list_update . '}';
						mysqli_query($conn, "UPDATE deal SET sub_product='$list_update' WHERE id='{$r_ck['id']}'");
						$i = 0;
						unset($list_update);
					}
				}
				unset($_SESSION['cart']);
				unset($_SESSION['main_product']);
				unset($_SESSION['muakem']);
				unset($_SESSION['coupon']);
			}
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'checkout_gopdon_step_2') {
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
	} else if (in_array($thanhtoan, array('cod', 'diem', 'chuyenkhoan')) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Phương thức thanh toán không hợp lệ';
	} else {
		foreach ($_SESSION['cart'] as $key => $value) {
			$list_id .= $key . ',';
		}
		$list_id = substr($list_id, 0, -1);
		$hientai = time();
		$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_moi DESC");
		$k = 0;
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
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
			if ($mau == '') {
				$color = '';
			} else {
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
			}
			$cat = $r_cart['cat'];
			for ($i = 0; $i < $_SESSION['cart'][$id_sp]['quantity']; $i++) {
				$k++;
				if ($k == 1) {
					$sp_giam = 0;
				} else if ($k == 2) {
					$sp_giam = 5;
				} else if ($k == 3) {
					$sp_giam = 7;
				} else if ($k == 4) {
					$sp_giam = 8;
				} else if ($k == 5) {
					$sp_giam = 10;
				} else {
					$sp_giam = 0;
				}
				$can_nang += str_replace(',', '.', $r_cart['can_nang']);
				$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
				$thanhtien = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $sp_giam;
				$tamtinh += $thanhtien;
				$r_cart['giam'] = ($r_cart['gia_moi'] / 100) * $sp_giam;
				$r_cart['thanhtien'] = number_format($thanhtien);
				$r_cart['gia_gop'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = 1;
				if ($cat == '') {
					$hoa_hong = '0';
				} else {
					$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
					while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
						if ($r_c['hoa_hong'] == 'ko' or $r_c['hoa_hong'] == 'khong') {
							$hoa_hong = 0;
						} else if ($r_c['cat_main'] > 0) {
							if ($r_c['hoa_hong'] != '') {
								$hoa_hong = ($thanhtien / 100) * $r_c['hoa_hong'];
							} else {
							}
						} else if ($r_c['cat_main'] == 0) {
							$hoa_hong = ($thanhtien / 100) * intval($r_c['hoa_hong']);
						}
					}
				}
				if ($ko_apdung == 1) {
					$hoa_hong = '0';
				} else {
					$hoa_hong = $hoa_hong;
				}
				if ($k == 1) {
					$list .= '"' . $id_sp . '_' . $i . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"1","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_gop'] . '","giam":"' . $r_cart['giam'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","hoa_hong":"' . $hoa_hong . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				} else {
					$list .= ',"' . $id_sp . '_' . $i . '":{"tieu_de":"' . $r_cart['tieu_de'] . '","ma_sanpham":"' . $ma_sanpham . '","soluong":"1","color":"' . $color . '","size":"' . $_SESSION['cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart['gia_gop'] . '","giam":"' . $r_cart['giam'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","hoa_hong":"' . $hoa_hong . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
				}
			}
		}
		$sanpham = '{' . $list . '}';
		//$tongtien = number_format($total_price) . 'đ';
		$giam = 0;
		$coupon = '';
		if ($thanhtoan == 'chuyenkhoan') {
			//$giam_them=(($tamtinh - $giam)/100)*5;
			$giam_them = 0;
		} else {
			$giam_them = 0;
		}
		if ($can_nang <= 5) {
			//$phi_ship=28000;
		} else {
			//$phi_ship=25000;
			//$phi_ship=28000 + ($can_nang - 5)*6000;
		}
		$phi_ship = 0;
		$tonggiam = $giam_them + $giam;
		$tongtien = $tamtinh - $giam - $giam_them + $phi_ship;
		$_SESSION['thanhtoan'] = $thanhtoan;
		$ho_ten = $_SESSION['ho_ten'];
		$email = $_SESSION['email'];
		$dien_thoai = $_SESSION['dien_thoai'];
		$dia_chi = $_SESSION['dia_chi'];
		$tinh = $_SESSION['tinh'];
		$huyen = $_SESSION['huyen'];
		$ma_don = $class_index->creat_random($conn, 'donhang');
		$thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='0'");
		$r_td = mysqli_fetch_assoc($thongtin_tichdiem);
		$diem = ceil(($tongtien / 100) * $r_td['diem']);
		$utm_source = addslashes(strip_tags($_COOKIE['utm_source']));
		$utm_campaign = addslashes(strip_tags($_COOKIE['utm_campaign']));
		if ($tongtien < 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
		} else if (strlen($sanpham) < 10) {
			$ok = 0;
			$thongbao = 'Thất bại! Giỏ hàng không hợp lệ';
		} else if (strlen($ho_ten) < 2) {
			$ok = 0;
			$thongbao = 'Thất bại! Họ và tên không hợp lệ';
		} else if (strlen($dien_thoai) < 10) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại không hợp lệ';
		} else if (strlen($dia_chi) < 2) {
			$ok = 0;
			$thongbao = 'Thất bại! Địa chỉ không hợp lệ';
		} else {
			if ($thanhtoan == 'diem') {
				if ($r_td['total'] > 0) {
					$thongtin_diem = mysqli_query($conn, "SELECT * FROM diem WHERE user_id='$user_id'");
					$r_diem = mysqli_fetch_assoc($thongtin_diem);
					if ($tongtien <= $r_diem['diem']) {
						$ok = 1;
						$thongbao = 'Đang chuyển hướng...';
						mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','$sanpham','$tamtinh','$coupon','$tonggiam','$phi_ship','$tongtien','','0','$thanhtoan','','$utm_source','$utm_campaign'," . time() . "," . time() . ")");
						$conlai = $r_diem['diem'] - $tongtien;
						mysqli_query($conn, "UPDATE diem SET diem='$conlai' WHERE user_id='$user_id'");
						$_SESSION['ma_don'] = $ma_don;
						unset($_SESSION['cart']);
						unset($_SESSION['main_product']);
						unset($_SESSION['muakem']);
						unset($_SESSION['coupon']);
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Số điểm của bạn không đủ';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Phương thức này không được áp dụng';
				}
			} else {
				mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','','','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','$sanpham','$tamtinh','$coupon','$tonggiam','$phi_ship','$tongtien','','0','$thanhtoan','','$utm_source','$utm_campaign'," . time() . "," . time() . ")");
				$ok = 1;
				$thongbao = 'Đang chuyển hướng...';
				if ($r_td['total'] > 0 and $r_td['diem'] > 0) {
					$noi_dung = 'Nhận điểm thưởng khi đặt đơn hàng #' . $ma_don;
					$hientai = time();
					mysqli_query($conn, "INSERT INTO tich_diem(shop,user_id,don,diem,noi_dung,status,date_post)VALUES('0','$user_id','$ma_don','$diem','$noi_dung','0','$hientai')");
				}
				$_SESSION['ma_don'] = $ma_don;
				unset($_SESSION['cart']);
				unset($_SESSION['main_product']);
				unset($_SESSION['muakem']);
				unset($_SESSION['coupon']);
			}
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'load_huyen') {
	$tinh = isset($_REQUEST['tinh']) ? intval($_REQUEST['tinh']) : 0;
	error_log("Loading huyen for tinh: " . $tinh); // Debug

	// Kiểm tra nếu $tinh rỗng hoặc không hợp lệ
	if ($tinh <= 0) {
		error_log("Invalid tinh value: " . $tinh);
		echo json_encode(array('ok' => 0, 'list' => '<option value="">Chọn huyện</option>', 'thongbao' => 'Vui lòng chọn tỉnh hợp lệ'));
		exit;
	}

	$list = '<option value="">Chọn huyện</option>';
	$tinh = mysqli_real_escape_string($conn, $tinh); // Bảo mật đầu vào
	$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC");

	if (!$thongtin) {
		error_log("Query error for huyen_moi: " . mysqli_error($conn));
		echo json_encode(array('ok' => 0, 'list' => $list, 'error' => 'Lỗi truy vấn: ' . mysqli_error($conn)));
		exit;
	}

	$num_rows = mysqli_num_rows($thongtin);
	error_log("Number of huyen records found: " . $num_rows); // Debug số bản ghi

	if ($num_rows == 0) {
		error_log("No huyen found for tinh: " . $tinh);
		echo json_encode(array('ok' => 0, 'list' => $list, 'thongbao' => 'Không tìm thấy huyện cho tỉnh này'));
		exit;
	}

	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<option value="' . htmlspecialchars($r_tt['id']) . '">' . htmlspecialchars($r_tt['tieu_de']) . '</option>';
	}

	error_log("Generated huyen list: " . $list); // Debug danh sách
	echo json_encode(array('ok' => 1, 'list' => $list));
	exit;
} else if ($action == 'load_xa') {
	$huyen = isset($_REQUEST['huyen']) ? intval($_REQUEST['huyen']) : 0;
	error_log("Loading xa for huyen: " . $huyen); // Debug

	// Kiểm tra nếu $huyen rỗng hoặc không hợp lệ
	if ($huyen <= 0) {
		error_log("Invalid huyen value: " . $huyen);
		echo json_encode(array('ok' => 0, 'list' => '<option value="">Chọn xã</option>', 'thongbao' => 'Vui lòng chọn huyện hợp lệ'));
		exit;
	}

	$list = '<option value="">Chọn xã</option>';
	$huyen = mysqli_real_escape_string($conn, $huyen); // Bảo mật đầu vào
	$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY tieu_de ASC");

	if (!$thongtin) {
		error_log("Query error for xa_moi: " . mysqli_error($conn));
		echo json_encode(array('ok' => 0, 'list' => $list, 'error' => 'Lỗi truy vấn: ' . mysqli_error($conn)));
		exit;
	}

	$num_rows = mysqli_num_rows($thongtin);
	error_log("Number of xa records found: " . $num_rows); // Debug số bản ghi

	if ($num_rows == 0) {
		error_log("No xa found for huyen: " . $huyen);
		echo json_encode(array('ok' => 0, 'list' => $list, 'thongbao' => 'Không tìm thấy xã cho huyện này'));
		exit;
	}

	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<option value="' . htmlspecialchars($r_tt['id']) . '">' . htmlspecialchars($r_tt['tieu_de']) . '</option>';
	}

	error_log("Generated xa list: " . $list); // Debug danh sách
	echo json_encode(array('ok' => 1, 'list' => $list));
	exit;
} else if ($action == 'add_diachi') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$tinh = addslashes(strip_tags($_REQUEST['tinh']));
	$huyen = addslashes(strip_tags($_REQUEST['huyen']));
	$xa = addslashes(strip_tags($_REQUEST['xa']));
	$ten_tinh = addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen = addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa = addslashes(strip_tags($_REQUEST['ten_xa']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$active = intval($_REQUEST['active']);
	if ($active == 1) {
		mysqli_query($conn, "UPDATE dia_chi SET active='0' WHERE user_id='$user_id'");
	}
	mysqli_query($conn, "INSERT INTO dia_chi(user_id,ho_ten,dien_thoai,dia_chi,email,xa,huyen,tinh,ten_xa,ten_huyen,ten_tinh,active)VALUES('$user_id','$ho_ten','$dien_thoai','$dia_chi','$email','$xa','$huyen','$tinh','$ten_xa','$ten_huyen','$ten_tinh','$active')");
	echo json_encode(array('ok' => 1, 'thongbao' => 'Thêm địa chỉ mới thành công'));
} else if ($action == 'update_diachi') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$tinh = addslashes(strip_tags($_REQUEST['tinh']));
	$huyen = addslashes(strip_tags($_REQUEST['huyen']));
	$xa = addslashes(strip_tags($_REQUEST['xa']));
	$ten_tinh = addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen = addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa = addslashes(strip_tags($_REQUEST['ten_xa']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$active = intval($_REQUEST['active']);
	$id = intval($_REQUEST['id']);
	if ($active == 1) {
		mysqli_query($conn, "UPDATE dia_chi SET active='0' WHERE user_id='$user_id'");
	}
	mysqli_query($conn, "UPDATE dia_chi SET ho_ten='$ho_ten',dien_thoai='$dien_thoai',dia_chi='$dia_chi',email='$email',xa='$xa',huyen='$huyen',tinh='$tinh',ten_xa='$ten_xa',ten_huyen='$ten_huyen',ten_tinh='$ten_tinh',active='$active' WHERE id='$id' AND user_id='$user_id'");
	echo json_encode(array('ok' => 1, 'thongbao' => 'Cập nhật địa chỉ thành công'));
} else if ($action == 'apply_coupon') {
	$coupon = addslashes(strip_tags($_REQUEST['coupon']));
	$thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='$coupon' AND shop='$shop'");
	$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
	if ($r_coupon['total'] == 0) {
		$ok = 0;
		$thongbao = 'Mã giảm giá không tồn tại';
	} else {
		if ($r_coupon['expired'] > time() and $r_coupon['start'] <= time()) {
			/*			if($r_coupon['dieu_kien']>0){
				$_SESSION['coupon'] = $r_coupon['ma'];
				$list_pl='';
				$list_id='';
				foreach ($_SESSION['cart'] as $key => $value) {
					$list_id_cart[]=$key;
					$list_pl.=$value['pl'].',';
				}
				$list_id=implode(',', $list_id_cart);
				if($list_pl!=''){
					$list_pl=substr($list_pl, 0,-1);
					$thongtin_pl=mysqli_query($conn,"SELECT * FROM phanloai_sanpham WHERE id IN ($list_pl) ORDER BY id ASC");
					while($r_pl=mysqli_fetch_assoc($thongtin_pl)){
						$sp_pl=$r_pl['sp_id'];
						$product_pl[$sp_pl]['gia_cu']=$r_pl['gia_cu'];
						$product_pl[$sp_pl]['gia_moi']=$r_pl['gia_moi'];
						$product_pl[$sp_pl]['gia_drop']=$r_pl['gia_drop'];
						$product_pl[$sp_pl]['gia_ctv']=$r_pl['gia_ctv'];
						$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
						$product_pl[$sp_pl]['color']=$r_pl['color'];
						$product_pl[$sp_pl]['size']=$r_pl['size'];
						$product_pl[$sp_pl]['can_nang']=$r_pl['can_nang'];
						$product_pl[$sp_pl]['ten_color']=$r_pl['ten_color'];
						$product_pl[$sp_pl]['ten_size']=$r_pl['ten_size'];
					}
				}
				$list_id = substr($list_id, 0, -1);
				$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
				while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
					$id_sp = $r_cart['id'];
					if($_SESSION['cart'][$id_sp]['tang']==1){
						$tongtien+=0;
					}else if(isset($list_c[$id_sp])){
						$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
					}else{
						$r_cart['ten_sanpham']=$r_cart['tieu_de'];
						$tongtien += $product_pl[$id_sp]['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
						$r_cart['gia_moi'] = number_format($product_pl[$id_sp]['gia_moi']);
						$r_cart['ten_color'] = $product_pl[$id_sp]['ten_color'];
						$r_cart['ten_size'] = $product_pl[$id_sp]['ten_size'];
						$r_cart['gia_cu'] = number_format(preg_replace('/[^0-9]/', '', $product_pl[$id_sp]['gia_cu']));
						$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
						if($product_pl[$id_sp]['color']==''){
							$r_cart['ten_color']='';
						}else{
							$r_cart['ten_color']='<div class="color_content"><div class="text">'.$product_pl[$id_sp]['ten_color'].'</div></div>';
						}
						if($product_pl[$id_sp]['size']==''){
							$r_cart['ten_size']='';
						}else{
							$r_cart['ten_size']='<div class="color_content"><div class="text">'.$product_pl[$id_sp]['ten_size'].'</div></div>';
						}
						$list_shopcart.=$skin->skin_replace('skin/box_li/li_shopcart',$r_cart);
						$list_shopcart_mobile.=$skin->skin_replace('skin/box_li/li_shopcart_mobile',$r_cart);
					}
				}
			}else{*/
			if ($r_coupon['kieu'] == 'all') {
				$_SESSION['coupon'] = $r_coupon['ma'];
				$thongbao = 'Đã áp dụng mã giảm giá';
				$ok = 1;
			} else if ($r_coupon['kieu'] == 'baohanh') {
				if ($r_coupon['status'] == 1) {
					$ok = 0;
					$thongbao = 'Thất bại! Mã giảm giá đã được sử dụng';
				} else {
					$_SESSION['coupon'] = $r_coupon['ma'];
					$thongbao = 'Đã áp dụng mã giảm giá';
					$ok = 1;
				}
			} else if ($r_coupon['kieu'] == 'sanpham') {
				$tach_sanpham = explode(',', $r_coupon['sanpham']);
				foreach ($_SESSION['cart'] as $key => $value) {
					$list_id_cart[] = $key;
				}
				$id_apdung = array_intersect($tach_sanpham, $list_id_cart);
				$total_id = count((array)$id_apdung);
				if ($total_id > 0) {
					$_SESSION['coupon'] = $r_coupon['ma'];
					$thongbao = 'Đã áp dụng mã giảm giá';
					$ok = 1;
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Sản phẩm không phù hợp';
				}
			}
			//}
		} else {
			$ok = 0;
			$thongbao = 'Mã giảm giá đã hết hạn sử dụng';
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'load_price') {
	$sp_id = intval($_REQUEST['sp_id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='$sp_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	echo json_encode(array('gia' => number_format($r_tt['gia_moi']) . 'đ'));
} else if ($action == 'add_muakem') {
	$main_product = intval($_REQUEST['main_product']);
	$list_id = addslashes(strip_tags($_REQUEST['list_id']));
	$hientai = time();
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE FIND_IN_SET($main_product,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' ORDER BY id DESC LIMIT 1");
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
}
// Hào 
else if ($action == 'add_to_cart') {
    $sp_id = intval($_REQUEST['sp_id']);
    $mau = addslashes(strip_tags($_REQUEST['mau']));
    $size = addslashes(strip_tags($_REQUEST['size'])); // Có thể rỗng
    $quantity = intval($_REQUEST['quantity']);
    $flash_sale = intval($_REQUEST['flash_sale']);
    $loai = addslashes(strip_tags($_REQUEST['loai']));
    $pl = intval($_REQUEST['pl']);
    $hientai = time();

    // Kiểm tra số lượng hợp lệ
    if ($quantity <= 0) {
        $ok = 0;
        $thongbao = 'Số lượng không hợp lệ!';
        echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
        exit();
    }

    // Lấy thông tin sản phẩm cơ bản từ bảng sanpham
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='$sp_id'");
    if (!$thongtin || mysqli_num_rows($thongtin) == 0) {
        $ok = 0;
        $thongbao = 'Sản phẩm không tồn tại!';
        echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
        exit();
    }
    $r_tt = mysqli_fetch_assoc($thongtin);

    // Kiểm tra xem sản phẩm có biến thể hay không
    $has_variant = false;
    $variant = null;
    $kho = 0;
    $gia_moi = $r_tt['gia_moi'];
    $gia_cu = $r_tt['gia_cu'];
    $ten_color = '';
    $ten_size = '';

    // Nếu $pl > 0, kiểm tra xem phân loại có tồn tại không
    if ($pl > 0) {
        $thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE id='$pl' AND sp_id='$sp_id' LIMIT 1");
        if ($thongtin_phanloai && mysqli_num_rows($thongtin_phanloai) > 0) {
            $has_variant = true;
            $variant = mysqli_fetch_assoc($thongtin_phanloai);
        }
    }

    if ($has_variant) {
        // Lấy ten_color và ten_size từ bảng phanloai_sanpham
        $ten_color = $variant['ten_color'] ?? '';
        $ten_size = $variant['ten_size'] ?? '';
        $kho = max(0, $variant['kho_sanpham_socdo'] ?? 0);
        $gia_moi = $variant['gia_moi'] ?? $r_tt['gia_moi'];
        $gia_cu = $variant['gia_cu'] ?? $r_tt['gia_cu'];

        // Nếu kho của phân loại là 0, thử lấy kho từ bảng sanpham
        if ($kho == 0) {
            $kho = max(0, $r_tt['kho'] ?? 0);
        }
    } else {
        // Nếu không có biến thể hoặc $pl không hợp lệ, lấy thông tin từ bảng sanpham
        $kho = max(0, $r_tt['kho'] ?? 0);
        $gia_moi = $r_tt['gia_moi'];
        $gia_cu = $r_tt['gia_cu'];
        $ten_color = !empty($mau) ? $mau : '';
        $ten_size = !empty($size) ? $size : '';
        $pl = 0;
    }

    // Ghi log để debug
    error_log("sp_id: $sp_id, pl: $pl, has_variant: " . ($has_variant ? 'true' : 'false') . ", kho: $kho, quantity: $quantity");

    // Kiểm tra tồn kho
    if ($kho < $quantity) {
        $ok = 0;
        $thongbao = 'Thất bại! Sản phẩm đã hết hàng' . ($has_variant ? ' (phân loại hết hàng)' : '');
        echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
        exit();
    }

    // Xử lý logic Flash Sale (nếu có)
    if ($loai == 'flash_sale') {
        $thongtin_flash = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
        $total_flash = mysqli_num_rows($thongtin_flash);
        if ($total_flash == 0) {
            $ok = 0;
            $thongbao = 'Thất bại! Flash sale đã hết hạn';
            echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
            exit();
        } else {
            $r_flash = mysqli_fetch_assoc($thongtin_flash);
            $tach_sp_flash = json_decode($r_flash['sub_product'], true);
            $so_luong_con = 0;
            foreach ($tach_sp_flash as $key => $value) {
                if ($value['sp_id'] == $sp_id) {
                    if ($has_variant) {
                        foreach ($value['list_pl'] as $k => $v) {
                            if ($v['pl'] == $pl) {
                                $so_luong_con = $v['so_luong'];
                            }
                        }
                    } else {
                        $so_luong_con = $value['so_luong'] ?? 0;
                    }
                }
            }
            if ($so_luong_con <= 0) {
                $ok = 0;
                $thongbao = 'Thất bại! Số lượng khuyến mại đã hết';
                echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
                exit();
            }
            if ($so_luong_con < $quantity) {
                $ok = 0;
                $thongbao = 'Thất bại! Số lượng khuyến mại không đủ';
                echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
                exit();
            }
            $gia_moi = $so_luong_con > 0 ? $r_flash['gia'] : $gia_moi;
        }
    }

    // Thêm vào giỏ hàng
    $ok = 1;
    $thongbao = 'Thêm giỏ hàng thành công';
    $_SESSION['cart'][$sp_id . '_' . $pl] = [
        'flash_sale' => $loai == 'flash_sale' ? 1 : 0,
        'quantity' => $quantity > 1 ? $quantity : 1,
        'size' => $ten_size,
        'color' => $ten_color,
        'pl' => $pl,
        'gia_moi' => $gia_moi,
        'gia_cu' => $gia_cu
    ];

    // Xử lý quà tặng
    $thongtin_tang = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='tang' AND shop='0' ORDER BY id DESC LIMIT 1");
    $r_tang = mysqli_fetch_assoc($thongtin_tang);
    $total_tang = mysqli_num_rows($thongtin_tang);
    if ($total_tang > 0) {
        $tach_tang = explode(',', $r_tang['sub_id']);
        foreach ($tach_tang as $key => $value) {
            $_SESSION['cart'][$value . '_0'] = [
                'quantity' => 1,
                'tang' => 1,
                'main_product' => $sp_id,
                'gia_moi' => 0,
                'gia_cu' => 0
            ];
        }
    }

    // Tạo danh sách sản phẩm trong giỏ hàng để hiển thị
    $name = '<a href="/product/' . $r_tt['link'] . '.html" style="color:red;" title="' . $r_tt['tieu_de'] . '">' . $r_tt['tieu_de'] . '</a>';
    $list = '';
    $tongtien = 0;
    $list_id = '';
    $list_check_product = [];

    foreach ($_SESSION['cart'] as $key => $value) {
        list($sp_id, $pl) = explode('_', $key);
        $list_id .= $sp_id . ',';
        if ($value['flash_sale'] == 1) {
            $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='0' ORDER BY id DESC LIMIT 1");
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
    $thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id) ASC");

    while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
        $id_sp = $r_cart['id'];
        foreach ($_SESSION['cart'] as $key => $value) {
            list($cart_sp_id, $cart_pl) = explode('_', $key);
            if ($cart_sp_id == $id_sp) {
                $r_cart['color'] = !empty($value['color']) ? 'Màu: ' . $value['color'] : '';
                $r_cart['size'] = !empty($value['size']) ? 'Size: ' . $value['size'] : '';

                if ($value['tang'] == 1) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
                    $tongtien += 0;
                    $r_cart['thanhtien'] = '0 đ';
                    $r_cart['gia_moi'] = '0 đ';
                    $r_cart['quantity'] = 1;
                    $list .= $skin->skin_replace('skin/box_li/li_cart_pop_tang', $r_cart);
                } else if (isset($list_c[$id_sp])) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
                    $gia_moi = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $tongtien += $gia_moi * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                    $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                    $r_cart['quantity'] = $value['quantity'];
                    $list .= $skin->skin_replace('skin/box_li/li_cart_pop', $r_cart);
                } else {
                    $gia_moi = $value['gia_moi'] ?? $r_cart['gia_moi'];
                    $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                    $tongtien += $gia_moi * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                    $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                    $r_cart['quantity'] = $value['quantity'];
                    $list .= $skin->skin_replace('skin/box_li/li_cart_pop', $r_cart);
                }
            }
        }
    }

    $total_price = number_format($tongtien, 0, ',', '.') . ' đ';

    // Xử lý Deal Mua Kèm (nếu có)
    if (isset($_SESSION['muakem'])) {
        $list_main_id = '';
        $list_id_mk = '';
        $list_sub_product = [];
        foreach ($_SESSION['main_product'] as $key => $value) {
            $list_main_id .= $value . ',';
            $thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='0' ORDER BY id DESC LIMIT 1");
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

        $thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id) ASC");
        $list = '';
        $tongtien = 0;
        while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
            $id_sp = $r_cart['id'];
            foreach ($_SESSION['cart'] as $key => $value) {
                list($cart_sp_id, $cart_pl) = explode('_', $key);
                if ($cart_sp_id == $id_sp) {
                    $r_cart['color'] = !empty($value['color']) ? 'Màu: ' . $value['color'] : '';
                    $r_cart['size'] = !empty($value['size']) ? 'Size: ' . $value['size'] : '';

                    if ($value['tang'] == 1) {
                        $r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
                        $tongtien += 0;
                        $r_cart['thanhtien'] = '0 đ';
                        $r_cart['gia_moi'] = '0 đ';
                        $r_cart['quantity'] = 1;
                        $list .= $skin->skin_replace('skin/box_li/li_cart_pop_tang', $r_cart);
                    } else if (in_array($id_sp, $tach_list_id_mk)) {
                        $r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
                        if ($list_s[$id_sp]['gia'] != '') {
                            $gia_moi = preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']);
                            $tongtien += $gia_moi * $value['quantity'];
                            $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                            $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                        } else {
                            $gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $list_s[$id_sp]['sale'];
                            $tongtien += $gia_moi * $value['quantity'];
                            $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                            $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                        }
                        $r_cart['quantity'] = $value['quantity'];
                        $list .= $skin->skin_replace('skin/box_li/li_cart_pop_tang', $r_cart);
                    } else if (isset($list_c[$id_sp])) {
                        $r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
                        $gia_moi = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                        $tongtien += $gia_moi * $value['quantity'];
                        $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                        $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                        $r_cart['quantity'] = $value['quantity'];
                        $list .= $skin->skin_replace('skin/box_li/li_cart_pop', $r_cart);
                    } else {
                        $gia_moi = $value['gia_moi'] ?? $r_cart['gia_moi'];
                        $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                        $tongtien += $gia_moi * $value['quantity'];
                        $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity'], 0, ',', '.') . ' đ';
                        $r_cart['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                        $r_cart['quantity'] = $value['quantity'];
                        $list .= $skin->skin_replace('skin/box_li/li_cart_pop', $r_cart);
                    }
                }
            }
        }
        $total_price = number_format($tongtien, 0, ',', '.') . ' đ';
    }

    // Trả về kết quả
    echo json_encode(array(
        'ok' => $ok,
        'thongbao' => $thongbao,
        'total' => count((array)$_SESSION['cart']),
        'name' => $name,
        'list' => $list,
        'total_cart' => count((array)$_SESSION['cart']),
        'total_price' => $total_price,
        'gia_moi' => number_format($gia_moi, 0, ',', '.') . ' đ',
        'gia_cu' => number_format($gia_cu, 0, ',', '.') . ' đ'
    ));
} else if ($action == 'update_shopcart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$pl = intval($_REQUEST['pl']);
	$quantity = intval($_REQUEST['quantity']);
	$hientai = time();

	$key = $sp_id . '_' . $pl;

	error_log("Update shopcart - Key: " . $key . ", Quantity: " . $quantity);
	error_log("Cart before update: " . print_r($_SESSION['cart'], true));

	if (isset($_SESSION['cart'][$key])) {
		if ($_SESSION['cart'][$key]['flash_sale'] == 1) {
			$_SESSION['cart'][$key]['quantity'] = 1;
			$quantity = 1;
		} else if ($quantity > 0) {
			$_SESSION['cart'][$key]['quantity'] = $quantity;
		} else {
			$_SESSION['cart'][$key]['quantity'] = 1;
		}

		$gia_moi = $_SESSION['cart'][$key]['gia_moi'];

		$thanhtien = $gia_moi * $quantity;

		$tongtien = 0;
		$total_cart = 0;
		foreach ($_SESSION['cart'] as $cart_key => $value) {
			$tongtien += $value['gia_moi'] * $value['quantity'];
			$total_cart++;
		}

		$info = array(
			'ok' => 1,
			'thongbao' => 'Đã cập nhật số lượng',
			'sp_id' => $sp_id,
			'pl' => $pl,
			'quantity' => $quantity,
			'gia_moi' => number_format($gia_moi, 0, ',', '.') . ' đ',
			'thanhtien' => number_format($thanhtien, 0, ',', '.') . ' đ',
			'total_cart' => $total_cart,
			'tongtien' => number_format($tongtien, 0, ',', '.') . ' đ'
		);
	} else {
		$info = array(
			'ok' => 0,
			'thongbao' => 'Không tìm thấy sản phẩm trong giỏ hàng'
		);
	}

	error_log("Cart after update: " . print_r($_SESSION['cart'], true));
	echo json_encode($info);
	exit;
} else if ($action == 'remove_shopcart') {
	$sp_id = intval($_REQUEST['sp_id']);
	$pl = intval($_REQUEST['pl']);
	$hientai = time();

	$key_to_remove = $sp_id . '_' . $pl;

	error_log("Key to remove: " . $key_to_remove);
	error_log("Cart before removal: " . print_r($_SESSION['cart'], true));

	$removed = false;
	if (isset($_SESSION['cart'][$key_to_remove])) {
		unset($_SESSION['cart'][$key_to_remove]);
		$removed = true;
		error_log("Removed key: " . $key_to_remove);
	}

	if (count((array)$_SESSION['cart']) == 0) {
		$info['empty'] = 1;
		unset($_SESSION['cart']);
		unset($_SESSION['muakem']);
		unset($_SESSION['main_product']);
	} else {
		$info['empty'] = 0;

		foreach ($_SESSION['cart'] as $key => $value) {
			if (isset($value['main_product']) && $value['main_product'] == $sp_id) {
				unset($_SESSION['cart'][$key]);
				error_log("Removed related gift: " . $key);
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

			$thongtin_main = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($sp_id,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='0' ORDER BY id DESC LIMIT 1");
			$r_main = mysqli_fetch_assoc($thongtin_main);
			if ($r_main) {
				$tach_sub = json_decode($r_main['sub_product'], true);
				foreach ($tach_sub as $sub_key => $sub_value) {
					$sub_sp_id = $sub_value['sp_id'] ?? 0;
					$sub_pl = $sub_value['pl'] ?? 0;
					$sub_key_to_remove = $sub_sp_id . '_' . $sub_pl;
					if (isset($_SESSION['cart'][$sub_key_to_remove])) {
						unset($_SESSION['cart'][$sub_key_to_remove]);
						error_log("Removed deal item: " . $sub_key_to_remove);
					}
				}
			}
		}
	}

	if (count((array)$_SESSION['cart']) > 0) {
		$list_sp_id = '';
		$list_pl = '';
		$tamtinh = 0;
		$giam = 0;

		foreach ($_SESSION['cart'] as $key => $value) {
			list($cart_sp_id, $cart_pl) = explode('_', $key);
			$list_sp_id .= $cart_sp_id . ',';
			$list_pl .= $cart_pl . ',';
		}
		$list_sp_id = rtrim($list_sp_id, ',');
		$list_pl = rtrim($list_pl, ',');

		$product_pl = [];
		if ($list_pl) {
			$thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE id IN ($list_pl)");
			while ($r_pl = mysqli_fetch_assoc($thongtin_pl)) {
				$sp_id_pl = $r_pl['sp_id'] . '_' . $r_pl['id'];
				$product_pl[$sp_id_pl] = $r_pl;
			}
		}

		if (isset($_SESSION['coupon'])) {
			$thongtin_counpon = mysqli_query($conn, "SELECT *, COUNT(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='0'");
			$r_coupon = mysqli_fetch_assoc($thongtin_counpon);
			if ($r_coupon['total'] > 0 && $r_coupon['kieu'] == 'sanpham') {
				$tach_list_sp_id = explode(',', $list_sp_id);
				$tach_sanpham_id = explode(',', $r_coupon['sanpham']);
				$id_apdung = array_intersect($tach_sanpham_id, $tach_list_sp_id);
			}
		}

		$list_shopcart = '';
		if ($list_sp_id) {
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_sp_id) ORDER BY FIELD(id, $list_sp_id)");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$id_sp = $r_cart['id'];
				foreach ($_SESSION['cart'] as $key => $value) {
					list($cart_sp_id, $cart_pl) = explode('_', $key);
					if ($cart_sp_id == $id_sp) {
						$pl_key = $id_sp . '_' . $cart_pl;
						if (isset($value['tang']) && $value['tang'] == 1) {
							$tamtinh += 0;
						} else {
							$gia_moi = $product_pl[$pl_key]['gia_moi'] ?? $value['gia_moi'] ?? 0;
							$quantity = $value['quantity'] ?? 1;
							$tamtinh += $gia_moi * $quantity;

							if (isset($_SESSION['coupon']) && $r_coupon['total'] > 0) {
								if ($r_coupon['kieu'] == 'all' || $r_coupon['kieu'] == 'baohanh') {
									$giam += ($r_coupon['loai'] == 'phantram') ? ceil(($gia_moi * $quantity / 100) * $r_coupon['giam']) : $r_coupon['giam'];
								} elseif (in_array($id_sp, $id_apdung)) {
									$giam += ($r_coupon['loai'] == 'phantram') ? ceil(($gia_moi * $quantity / 100) * $r_coupon['giam']) : $r_coupon['giam'];
								}
							}
						}

						$r_cart['ten_sanpham'] = $r_cart['tieu_de'];
						$r_cart['gia_moi'] = number_format($value['gia_moi'], 0, ',', '.') . ' đ';
						$r_cart['gia_cu'] = number_format($value['gia_cu'], 0, ',', '.') . ' đ';
						$r_cart['quantity'] = $value['quantity'];
						$r_cart['thanhtien'] = number_format($value['gia_moi'] * $value['quantity'], 0, ',', '.') . ' đ';
						$r_cart['sp_id'] = $cart_sp_id;
						$r_cart['pl'] = $cart_pl;
						if (isset($product_pl[$pl_key])) {
							$r_cart['ten_color'] = $product_pl[$pl_key]['ten_color'] ? '<div class="color_content"><div class="text">' . $product_pl[$pl_key]['ten_color'] . '</div></div>' : '';
							$r_cart['ten_size'] = $product_pl[$pl_key]['ten_size'] ? '<div class="color_content"><div class="text">' . $product_pl[$pl_key]['ten_size'] . '</div></div>' : '';
						} else {
							$r_cart['ten_color'] = '';
							$r_cart['ten_size'] = '';
						}
						$list_shopcart .= $skin->skin_replace('skin/box_li/li_shopcart', $r_cart);
					}
				}
			}
		}

		$tongtien = $tamtinh - $giam;
		$total_price = number_format($tongtien, 0, ',', '.') . ' đ';
		$hoantien = round(($tongtien / 100) * 1.5);

		$info = array(
			'ok' => 1,
			'empty' => 0,
			'thongbao' => $removed ? 'Đã xóa sản phẩm khỏi giỏ hàng' : 'Không tìm thấy sản phẩm để xóa',
			'text_tongdon' => count((array)$_SESSION['cart']),
			'text_tamtinh' => number_format($tamtinh, 0, ',', '.') . ' đ',
			'text_hoantien' => number_format($hoantien, 0, ',', '.') . ' đ',
			'tamtinh' => number_format($tamtinh, 0, ',', '.') . ' đ',
			'tietkiem' => '',
			'giam' => number_format($giam, 0, ',', '.') . ' đ',
			'tongtien' => $total_price,
			'tong_tietkiem' => '',
			'list_shopcart' => $list_shopcart
		);
	} else {
		$info = array(
			'ok' => 1,
			'empty' => 1,
			'thongbao' => 'Giỏ hàng đã trống',
			'text_tongdon' => 0,
			'text_tamtinh' => '0 đ',
			'text_hoantien' => '0 đ',
			'tamtinh' => '0 đ',
			'tietkiem' => '',
			'giam' => '0 đ',
			'tongtien' => '0 đ',
			'tong_tietkiem' => '',
			'list_shopcart' => ''
		);
	}

	error_log("Cart after removal: " . print_r($_SESSION['cart'], true));
	echo json_encode($info);
	exit;
} else if ($action == 'get_opt') {
	include "./speedsms/SpeedSMSAPI.php";
	include "./speedsms/TwoFactorAPI.php";
	function sendSMS($phone, $content)
	{
		$sms = new SpeedSMSAPI("PW09ibbUnZ-NwmfuK2OOCtek9nFK-Jh2");
		$return = $sms->sendSMS([$phone], $content, SpeedSMSAPI::SMS_TYPE_GATEWAY, "058c42d2388c8eb5");
	}
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$thongtin_dienthoai = mysqli_query($conn, "SELECT * FROM user_info WHERE mobile='$dien_thoai' AND shop='0' AND active='1'");
	$total_dienthoai = mysqli_num_rows($thongtin_dienthoai);
	if ($total_dienthoai > 0) {
		$ok = 0;
		$thongbao = 'Thất bại! Số điện thoại đã tồn tại';
	} else {
		$thongtin = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' ORDER BY id DESC LIMIT 1");
		$total = mysqli_num_rows($thongtin);
		$code_otp = $check->random_number(6);
		$hientai = time();
		if ($total < 1) {
			$thongtin_ip = mysqli_query($conn, "SELECT * FROM code_otp WHERE ip_address='$ip_address'");
			$total_ip = mysqli_num_rows($thongtin_ip);
			if ($total_ip < 2) {
				try {
					$dau = substr($dien_thoai, 0, -1);
					if ($dau == 0) {
						$dien_thoai = '84' . substr($dien_thoai, 1);
					} else {
					}
					sendSMS($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp);
					$ok = 1;
					$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
					mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
				} catch (Exception $e) {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
			}
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ((time() - $r_tt['date_post']) > 60) {
				try {
					$dau = substr($dien_thoai, 0, -1);
					if ($dau == 0) {
						$dien_thoai = '84' . substr($dien_thoai, 1);
					} else {
					}
					sendSMS($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp);
					mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
					$ok = 1;
					$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
				} catch (Exception $e) {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'code' => $code
	);
	echo json_encode($info);
} else if ($action == 'get_opt_password') {
	include "./speedsms/SpeedSMSAPI.php";
	include "./speedsms/TwoFactorAPI.php";
	function sendSMS($phone, $content)
	{
		$sms = new SpeedSMSAPI("PW09ibbUnZ-NwmfuK2OOCtek9nFK-Jh2");
		$return = $sms->sendSMS([$phone], $content, SpeedSMSAPI::SMS_TYPE_GATEWAY, "058c42d2388c8eb5");
	}
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	if (strlen($dien_thoai) < 10) {
		$ok = 0;
		$thongbao = 'Thất bại! Chưa nhập số điện thoại';
	} else {
		$thongtin_dienthoai = mysqli_query($conn, "SELECT * FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
		$total_dienthoai = mysqli_num_rows($thongtin_dienthoai);
		if ($total_dienthoai == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại không tồn tại';
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' ORDER BY id DESC");
			$total = mysqli_num_rows($thongtin);
			$code_otp = $check->random_number(6);
			$hientai = time();
			if ($total < 1) {
				$thongtin_ip = mysqli_query($conn, "SELECT * FROM code_otp WHERE ip_address='$ip_address'");
				$total_ip = mysqli_num_rows($thongtin_ip);
				if ($total_ip < 2) {
					try {
						$dau = substr($dien_thoai, 0, -1);
						if ($dau == 0) {
							$dien_thoai = '84' . substr($dien_thoai, 1);
						} else {
						}
						sendSMS($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp);
						$ok = 1;
						$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
						mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
					} catch (Exception $e) {
						$ok = 0;
						$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
				}
			} else {
				if ($total >= 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Bạn đã yêu cầu mã quá nhiều lần!<br>Hãy liên hệ hotline để được hỗ trợ';
				} else {
					$r_tt = mysqli_fetch_assoc($thongtin);
					if ((time() - $r_tt['date_post']) > 60) {
						try {
							$dau = substr($dien_thoai, 0, -1);
							if ($dau == 0) {
								$dien_thoai = '84' . substr($dien_thoai, 1);
							} else {
							}
							sendSMS($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp);
							mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
							$ok = 1;
							$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
						} catch (Exception $e) {
							$ok = 0;
							$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
						}
					} else {
						$ok = 0;
						$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
					}
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'code' => $code
	);
	echo json_encode($info);
} else if ($action == 'update_info') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['mobile']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$avatar = addslashes(strip_tags($_REQUEST['avatar']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_password = addslashes(strip_tags($_REQUEST['re_password']));
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
		$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
		if ($r_mobile['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại đã đăng ký';
		} else {
			$ok = 1;
			$thongbao = 'Đăng ký tài khoản thành công';
			$pass = md5($password);
			$hientai = time();
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$domain = '';
			$ngaysinh = '';
			$gioi_tinh = '';
			$cmnd = '';
			$ngaycap = '';
			$noicap = '';
			$dia_chi = '';
			$maso_thue = '';
			$maso_thue_cap = '';
			$maso_thue_noicap = '';
			$code_active = '';
			$active = '1';
			$nhan_vien = '0';
			$chinh_thuc = '0';
			$dropship = '0';
			$ctv = '0';
			$leader = '0';
			$leader_start = '';
			$gia_leader = '0';
			$doitac = '';
			$about = '';
			$nhom = '';
			$aff = $_COOKIE['affgroup'];
			if (isset($aff)) {
				$thongtin_doitac = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$aff'");
				$r_dt = mysqli_fetch_assoc($thongtin_doitac);
				$doitac = $r_dt['doitac'];
			} else {
				$aff = '';
				$doitac = '';
			}
			mysqli_query($conn, "INSERT INTO user_info(shop,username,password,email,name,avatar,user_money,user_money2,mobile,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,tinh,huyen,xa,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,code_active,active,nhan_vien,chinh_thuc,dropship,ctv,leader,leader_start,gia_leader,aff,doitac,about,nhom,created,date_update,ip_address,logined,end_online)VALUES('0','$dien_thoai','$pass','$email','$ho_ten','$avatar','0','0','$dien_thoai','$domain','$ngaysinh','$gioi_tinh','$cmnd','$ngaycap','$noicap','0','0','0','$dia_chi','$maso_thue','$maso_thue_cap','$maso_thue_noicap','$code_active','$active','$nhan_vien','$chinh_thuc','$dropship','$ctv','$leader','$leader_start','$gia_leader','$aff','$doitac','$about','$nhom','$hientai','$hientai','$ip_address','$hientai','')");
			$thongtin_moi = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$dien_thoai' ORDER BY user_id DESC LIMIT 1");
			$r_m = mysqli_fetch_assoc($thongtin_moi);
			setcookie("user_id", $check->token_login($r_m['user_id'], $r_m['password']), time() + 2593000, '/');
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'register') {
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_password = addslashes(strip_tags($_REQUEST['re_password']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	/*$ma_xacnhan=addslashes(strip_tags($_REQUEST['ma_xacnhan']));*/
	$aff = $_COOKIE['affgroup'];
	if (isset($aff)) {
		$thongtin_doitac = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$aff'");
		$r_dt = mysqli_fetch_assoc($thongtin_doitac);
		$doitac = $r_dt['doitac'];
	} else {
		$doitac = '';
	}
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 10) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		/*		$thongtin_otp=mysqli_query($conn,"SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' AND otp='$ma_xacnhan'");
		$total_otp=mysqli_num_rows($thongtin_otp);
		if($total_otp==0){
			$ok=0;
			$thongbao='Thất bại! Mã xác nhận không đúng';
		}else{*/
		$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
		$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
		if ($r_mobile['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại đã tồn tại trên hệ thống';
		} else {
			$ok = 1;
			$thongbao = 'Đăng ký tài khoản thành công';
			$pass = md5($password);
			$hientai = time();
			$ip_address = $_SERVER['REMOTE_ADDR'];
			mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,tinh,huyen,xa,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,dropship,ctv,leader,leader_start,code_active,active,nhan_vien,chinh_thuc,created,date_update,ip_address,logined,end_online,aff,doitac,about,nhom,gia_leader)VALUES('$dien_thoai','0','0','0','$email','$pass','$ho_ten','','$dien_thoai','$domain','$ngaysinh','','$cmnd','$ngaycap','$noicap','0','0','0','$dia_chi','$maso_thue','$maso_thue_cap','$maso_thue_noicap','0','0','0','','','1','0','0','$hientai','$hientai','$ip_address','','','$aff','$doitac','','$nhom','0')");
			mysqli_query($conn, "DELETE FROM code_otp WHERE dien_thoai='$dien_thoai'");
			$thongtin_moi = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$dien_thoai' ORDER BY user_id DESC LIMIT 1");
			$r_m = mysqli_fetch_assoc($thongtin_moi);
			setcookie("user_id", $check->token_login($r_m['user_id'], $r_m['password']), time() + 2593000, '/');
		}
		//}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'register_banhang') {
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_passpord = addslashes(strip_tags($_REQUEST['re_password']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$ma_gioithieu = addslashes(strip_tags($_REQUEST['ma_gioithieu']));
	$maso_thue = addslashes(strip_tags($_REQUEST['maso_thue']));
	$maso_thue_cap = addslashes(strip_tags($_REQUEST['maso_thue_cap']));
	$maso_thue_noicap = addslashes(strip_tags($_REQUEST['maso_thue_noicap']));
	$tinh = intval($_REQUEST['tinh']);
	$huyen = intval($_REQUEST['huyen']);
	$xa = intval($_REQUEST['xa']);
	$dia_chi = addslashes($_REQUEST['dia_chi']);
	$aff = $_COOKIE['affgroup'];
	if (isset($aff)) {
		$thongtin_doitac = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$aff'");
		$r_dt = mysqli_fetch_assoc($thongtin_doitac);
		$doitac = $r_dt['doitac'];
	} else {
		$doitac = '';
	}
	//$ma_xacnhan=addslashes(strip_tags($_REQUEST['ma_xacnhan']));
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 10) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($maso_thue) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập mã số thuế/ số cccd';
	} else if (strlen($maso_thue_cap) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Chưa nhập ngày cấp mã số thuế/số cccd';
	} else if (strlen($maso_thue_noicap) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Chưa nhập nơi cấp mã số thuế/số cccd';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_passpord) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		/*		$thongtin_otp=mysqli_query($conn,"SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' AND otp='$ma_xacnhan'");
		$total_otp=mysqli_num_rows($thongtin_otp);
		if($total_otp==0){
			$ok=0;
			$thongbao='Thất bại! Mã xác nhận không đúng';
		}else{*/
		$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
		$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
		if ($r_mobile['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại đã đăng ký';
		} else {
			$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='0'");
			$r_email = mysqli_fetch_assoc($thongtin_email);
			if ($r_email['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Địa chỉ Email đã đăng ký';
			} else {
				$ok = 1;
				$thongbao = 'Đăng ký tài khoản thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				if ($ma_gioithieu == 'socdo.vn' or $ma_gioithieu == 'SOCDO.VN' or $ma_gioithieu == 'socdo') {
					mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,maso_thue,maso_thue_cap,maso_thue_noicap,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,tinh,huyen,xa,dia_chi,dropship,ctv,leader,leader_start,code_active,active,chinh_thuc,nhan_vien,created,date_update,ip_address,logined,end_online,aff,doitac,about,nhom,gia_leader)VALUES('$dien_thoai','0','0','0','$email','$pass','$ho_ten','','$dien_thoai','$maso_thue','$maso_thue_cap','$maso_thue_noicap','$domain','$ngaysinh','','$cmnd','$ngaycap','$noicap','$tinh','$huyen','$xa','$dia_chi','1','0','0','','','1','0','1','$hientai','$hientai','$ip_address','','','$aff','$doitac','$about','$nhom','0')");
				} else {
					mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,maso_thue,maso_thue_cap,maso_thue_noicap,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,tinh,huyen,xa,dia_chi,dropship,ctv,leader,leader_start,code_active,active,nhan_vien,chinh_thuc,created,date_update,ip_address,logined,end_online,aff,doitac,about,nhom,gia_leader)VALUES('$dien_thoai','0','0','0','$email','$pass','$ho_ten','','$dien_thoai','$maso_thue','$maso_thue_cap','$maso_thue_noicap','$domain','$ngaysinh','','$cmnd','$ngaycap','$noicap','$tinh','$huyen','$xa','$dia_chi','1','0','0','','','1','0','0','$hientai','$hientai','$ip_address','','','$aff','$doitac','$about','$nhom','0')");
				}

				mysqli_query($conn, "DELETE FROM code_otp WHERE dien_thoai='$dien_thoai'");
				$thongtin_moi = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$dien_thoai' ORDER BY user_id DESC LIMIT 1");
				$r_m = mysqli_fetch_assoc($thongtin_moi);
				setcookie("user_id", $check->token_login($r_m['user_id'], $r_m['password']), time() + 2593000, '/');
			}
		}
		//}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
}
// nhatthem94
// nhatthem104

else if ($action == 'register_ncc') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$maso_thue = addslashes(strip_tags($_REQUEST['maso_thue']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_password = addslashes(strip_tags($_REQUEST['re_password']));

	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên công ty/Hộ kinh doanh';
	} else if (strlen($dien_thoai) < 10) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập số điện thoại hợp lệ';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Mật khẩu phải từ 6 ký tự';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Mật khẩu nhập lại không khớp';
	} else {
		$check_phone = mysqli_query($conn, "SELECT * FROM user_info WHERE mobile='$dien_thoai'");
		if (mysqli_num_rows($check_phone) > 0) {
			$ok = 0;
			$thongbao = 'Số điện thoại đã được đăng ký';
		} else {
			$pass = md5($password);
			$time = time();
			$ip_address = $_SERVER['REMOTE_ADDR'];

			$sql = "INSERT INTO user_info (
                username, shop, user_money, user_money2, email, password, name, avatar,
                mobile, maso_thue, maso_thue_cap, maso_thue_noicap, domain, ngaysinh,
                gioi_tinh, cmnd, ngaycap, noicap, tinh, huyen, xa, dia_chi, dropship,
                ctv, leader, leader_start, code_active, active, nhan_vien, chinh_thuc,
                created, date_update, ip_address, logined, end_online, aff, doitac,
                about, nhom, gia_leader, status_cre
            ) VALUES (
                '$dien_thoai', '0', '0', '0', '', '$pass', '$ho_ten', '',
                '$dien_thoai', '$maso_thue', '', '', '', '',
                '', '', '', '', '0', '0', '0', '', '0',
                '1', '0', '', '', '1', '0', '0',
                '$time', '$time', '$ip_address', '', '', '', '',
                '', '', '0', '3'
            )";

			if (mysqli_query($conn, $sql)) {
				$user_id = mysqli_insert_id($conn);
				$_SESSION['user_id'] = $user_id;
				// Đánh dấu là đã đăng ký thành công
				$_SESSION['registration_success'] = true;
				$_SESSION['show_welcome_setup'] = true;
				setcookie("user_id", $check->token_login($user_id, $pass), time() + 2593000, '/');
				$ok = 1;
				$thongbao = 'Chúc mừng bạn đã đăng ký tài khoản thành công.';
				$redirect = '/ncc/welcome_setup.php'; // Chuyển hướng đến welcome_setup
			} else {
				$ok = 0;
				$thongbao = 'Có lỗi xảy ra, vui lòng thử lại!';
			}
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao, 'redirect' => $redirect));
} else if ($action == 'change_profile') {
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
	} else if (strlen($dien_thoai) < 10) {
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
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='0'");
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
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'update_profile') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$ngay_sinh = addslashes(strip_tags($_REQUEST['ngay_sinh']));
	$gioi_tinh = addslashes(strip_tags($_REQUEST['gioi_tinh']));
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Họ và tên quá ngắn';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Địa chỉ email không đúng';
	} else if (strlen($ngay_sinh) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập ngày sinh';
	} else {
		if ($email != $user_info['email']) {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='0'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Email đã tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Lưu thay đổi thành công!';
				mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',ngaysinh='$ngay_sinh',gioi_tinh='$gioi_tinh' WHERE user_id='$user_id'");
			}
		} else {
			$ok = 1;
			$thongbao = 'Lưu thay đổi thành công!';
			mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',ngaysinh='$ngay_sinh',gioi_tinh='$gioi_tinh' WHERE user_id='$user_id'");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'save_baohanh') {
	$hientai = time();
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$san_pham = addslashes(strip_tags($_REQUEST['san_pham']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$expired = time() + 15 * 24 * 3600;
	$thongtin_baohanh = mysqli_query($conn, "SELECT * FROM kichhoat_baohanh WHERE ip_address='$ip_address' ORDER BY id DESC LIMIT 1");
	$total_baohanh = mysqli_num_rows($thongtin_baohanh);
	if ($total_baohanh == 0) {
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE (mobile='$dien_thoai' OR username='$dien_thoai') AND shop='0'");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if (strlen($ho_ten) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
			} else if (strlen($dien_thoai) < 10) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
			} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == false) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng chọn file đơn hàng';
			} else {
				$minh_hoa = '/uploads/bao-hanh/' . $check->blank($_FILES['file']['name']) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
				$ok = 1;
				$add_user = 1;
				$thongbao = 'Thành công! Đã kích hoạt bảo hành';
				$coupon = $class_index->creat_random($conn, 'coupon');
				$password = '12345678';
				$pass = md5($password);
				mysqli_query($conn, "INSERT INTO coupon(shop,ma,giam,dieu_kien,loai,kieu,sanpham,start,expired,status)VALUES('0','$coupon','{$index_setting['coupon_baohanh_giam']}','0','{$index_setting['coupon_baohanh_loai']}','baohanh','','$hientai','$expired','0')");
				mysqli_query($conn, "INSERT INTO kichhoat_baohanh(ho_ten,dien_thoai,don_hang,san_pham,coupon,expired,status,note,ip_address,update_post,date_post)VALUES('$ho_ten','$dien_thoai','$minh_hoa','$san_pham','$coupon','$expired','0','','$ip_address','$hientai','$hientai')");
				mysqli_query($conn, "INSERT INTO user_info(shop,username,password,email,name,avatar,user_money,user_money2,mobile,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,code_active,active,nhan_vien,chinh_thuc,dropship,ctv,aff,about,nhom,created,date_update,ip_address,logined,end_online,leader,leader_start,gia_leader,doitac)VALUES('0','$dien_thoai','$pass','','$ho_ten','','0','0','$dien_thoai','','','','','','','','','','','','1','0','0','0','0','','','','$hientai','$hientai','$ip_address','','$hientai','0','','0','')");
			}
		} else {
			if (strlen($ho_ten) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
			} else if (strlen($dien_thoai) < 10) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
			} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == false) {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng chọn file đơn hàng';
			} else {
				$minh_hoa = '/uploads/bao-hanh/' . $check->blank($_FILES['file']['name']) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
				$ok = 1;
				$add_user = 0;
				$thongbao = 'Thành công! Đã kích hoạt bảo hành';
				$coupon = $class_index->creat_random($conn, 'coupon');
				mysqli_query($conn, "INSERT INTO coupon(shop,ma,giam,dieu_kien,loai,kieu,sanpham,start,expired,status)VALUES('0','$coupon','{$index_setting['coupon_baohanh_giam']}','0','{$index_setting['coupon_baohanh_loai']}','baohanh','','$hientai','$expired','0')");
				mysqli_query($conn, "INSERT INTO kichhoat_baohanh(ho_ten,dien_thoai,don_hang,san_pham,coupon,expired,status,note,ip_address,update_post,date_post)VALUES('$ho_ten','$dien_thoai','$minh_hoa','$san_pham','$coupon','$expired','0','','$ip_address','$hientai','$hientai')");
			}
		}
	} else {
		$r_bh = mysqli_fetch_assoc($thongtin_baohanh);
		if (time() - $r_bh['date_post'] > 10) {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE (mobile='$dien_thoai' OR username='$dien_thoai') AND shop='0'");
			$total = mysqli_num_rows($thongtin);
			if ($total == 0) {
				if (strlen($ho_ten) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
				} else if (strlen($dien_thoai) < 10) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
				} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == false) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng chọn file đơn hàng';
				} else {
					$minh_hoa = '/uploads/bao-hanh/' . $check->blank($_FILES['file']['name']) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
					$ok = 1;
					$add_user = 1;
					$thongbao = 'Thành công! Đã kích hoạt bảo hành';
					$coupon = $class_index->creat_random($conn, 'coupon');
					$password = '12345678';
					$pass = md5($password);
					mysqli_query($conn, "INSERT INTO coupon(shop,ma,giam,dieu_kien,loai,kieu,sanpham,start,expired,status)VALUES('0','$coupon','{$index_setting['coupon_baohanh_giam']}','0','{$index_setting['coupon_baohanh_loai']}','baohanh','','$hientai','$expired','0')");
					mysqli_query($conn, "INSERT INTO kichhoat_baohanh(ho_ten,dien_thoai,san_pham,don_hang,coupon,expired,status,note,ip_address,update_post,date_post)VALUES('$ho_ten','$dien_thoai','$san_pham','$minh_hoa','$coupon','$expired','0','','$ip_address','$hientai','$hientai')");
					mysqli_query($conn, "INSERT INTO user_info(shop,username,password,email,name,avatar,user_money,user_money2,mobile,domain,ngaysinh,gioi_tinh,cmnd,ngaycap,noicap,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,code_active,active,nhan_vien,chinh_thuc,dropship,ctv,aff,about,nhom,created,date_update,ip_address,logined,end_online,leader,leader_start,gia_leader,doitac)VALUES('0','$dien_thoai','$pass','','$ho_ten','','0','0','$dien_thoai','','','','','','','','','','','','1','0','0','0','0','','','','$hientai','$hientai','$ip_address','','$hientai','0','','0','')");
				}
			} else {
				if (strlen($ho_ten) < 2) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
				} else if (strlen($dien_thoai) < 10) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
				} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == false) {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng chọn file đơn hàng';
				} else {
					$minh_hoa = '/uploads/bao-hanh/' . $check->blank($_FILES['file']['name']) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
					$ok = 1;
					$add_user = 0;
					$thongbao = 'Thành công! Đã kích hoạt bảo hành';
					$coupon = $class_index->creat_random($conn, 'coupon');
					mysqli_query($conn, "INSERT INTO coupon(shop,ma,giam,dieu_kien,loai,kieu,sanpham,start,expired,status)VALUES('0','$coupon','{$index_setting['coupon_baohanh_giam']}','0','{$index_setting['coupon_baohanh_loai']}','baohanh','','$hientai','$expired','0')");
					mysqli_query($conn, "INSERT INTO kichhoat_baohanh(ho_ten,dien_thoai,don_hang,san_pham,coupon,expired,status,note,ip_address,update_post,date_post)VALUES('$ho_ten','$dien_thoai','$minh_hoa','$san_pham','$coupon','$expired','0','','$ip_address','$hientai','$hientai')");
				}
			}
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Vui lòng thử lại sau 5 phút nữa';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'coupon' => $coupon,
		'password' => $password,
		'dien_thoai' => $dien_thoai,
		'expired' => date('H\h\:i d/m/Y', $expired),
		'add_user' => intval($add_user)
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
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'dangky_dropship') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($user_info['dropship'] == 1) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn đã trở thành dropship';
	} else if ($user_info['ctv'] == 1 or $user_info['ctv'] == 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn đã đăng ký làm cộng tác viên';
	} else if ($user_info['dropship'] == 2) {
		$ok = 1;
		$thongbao = 'Thành công! Yêu cầu của bạn đã được gửi';
	} else {
		$thongbao = 'Thành công! Yêu cầu của bạn đã được gửi';
		$ok = 1;
		mysqli_query($conn, "UPDATE user_info SET dropship='1' WHERE user_id='$user_id'");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'dangky_ctv') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($user_info['dropship'] == 1) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn đã trở thành dropship';
	} else if ($user_info['dropship'] == 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn đã đăng ký drop';
	} else if ($user_info['ctv'] == 1) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn đã trở thành cộng tác viên';
	} else if ($user_info['dropship'] == 2) {
		$ok = 1;
		$thongbao = 'Thành công! Yêu cầu của bạn đã được gửi';
	} else {
		$thongbao = 'Thành công! Yêu cầu của bạn đã được gửi';
		$ok = 1;
		mysqli_query($conn, "UPDATE user_info SET ctv='1' WHERE user_id='$user_id'");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
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
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'forgot_password') {
	if (isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Bạn đã đăng nhập...'));
		exit();
	}
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_passpord = addslashes(strip_tags($_REQUEST['re_password']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$ma_xacnhan = addslashes(strip_tags($_REQUEST['ma_xacnhan']));
	if (strlen($dien_thoai) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_passpord) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin_otp = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' AND otp='$ma_xacnhan'");
		$total_otp = mysqli_num_rows($thongtin_otp);
		if ($total_otp == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Mã xác nhận không đúng';
		} else {
			$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
			$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
			if ($r_mobile['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Số điện thoại không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Đổi mật khẩu tài khoản thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				mysqli_query($conn, "UPDATE user_info SET password='$pass' WHERE mobile='$dien_thoai' AND shop='0'");
				mysqli_query($conn, "DELETE FROM code_otp WHERE dien_thoai='$dien_thoai'");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}
/* else if ($action == 'forgot_password') {
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
				$mailer->AddAddress('hotro.socdo.vn@gmail.com', 'Hỗ trợ sóc đỏ'); //thêm mail của admin
				$mailer->Subject = 'Lấy lại mật khẩu';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				$mailer->Body = 'Mật khẩu mới của '.$email.' tại ' . $index_setting['link_domain'] . ' là: ' . $passnew . ', vui lòng bấm vào link <a href="' . $link_active . '">' . $link_active . '</a> để xác nhận thay đổi';
				$mailer->Send();
			} else {
				$ok = 0;
				$thongbao = 'Gặp lỗi trong quá trình gửi mail';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}*/ 
else if ($action == 'dangky_nnc') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$cong_ty = addslashes(strip_tags($_REQUEST['cong_ty']));
	$nganh_hang = addslashes(strip_tags($_REQUEST['nganh_hang']));
	$ghi_chu = addslashes(strip_tags($_REQUEST['ghi_chu']));
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 10) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại liên hệ';
	} else if (strlen($dia_chi) < 10) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ liên hệ';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Email không đúng định dạng';
	} else if (strlen($cong_ty) < 5) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng website công ty';
	} else if (strlen($nganh_hang) < 4) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập ngành hàng';
	} else {
		if (isset($_SESSION['dk_nnc'])) {
			if (time() - $_SESSION['dk_nnc'] > 15) {
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
				$mailer->AddAddress('socdogroup@gmail.com', 'Sóc đỏ'); //thêm mail của admin
				$mailer->Subject = 'Đăng ký nhà cung cấp';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				$mailer->Body = 'Thông tin đăng ký làm nhà cung cấp<br><br>Họ và tên: ' . $ho_ten . '<br>Điện thoại: ' . $dien_thoai . '<br>Địa chỉ: ' . $dia_chi . '<br>Email: ' . $email . '<br>Công ty: ' . $cong_ty . '<br>Ngành hàng: ' . $nganh_hang . '<br>Ghi chú: ' . $ghi_chu;
				if ($mailer->Send() == true) {
					$ok = 1;
					$thongbao = 'Thành công! Liên hệ của bạn đã được gửi đi';
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi trong quá trình xử lý';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Bạn thực hiện quá nhanh';
			}
		} else {
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
			$mailer->AddAddress('socdogroup@gmail.com', 'Sóc đỏ'); //thêm mail của admin
			$mailer->Subject = 'Đăng ký nhà cung cấp';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = 'Thông tin đăng ký làm nhà cung cấp<br><br>Họ và tên: ' . $ho_ten . '<br>Điện thoại: ' . $dien_thoai . '<br>Địa chỉ: ' . $dia_chi . '<br>Email: ' . $email . '<br>Công ty: ' . $cong_ty . '<br>Ngành hàng: ' . $nganh_hang . '<br>Ghi chú: ' . $ghi_chu;
			if ($mailer->Send() == true) {
				$ok = 1;
				$thongbao = 'Thành công! Liên hệ của bạn đã được gửi đi';
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Gặp lỗi trong quá trình xử lý';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
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
		'thongbao' => $thongbao,
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
			$list .= $skin->skin_replace('skin/box_li/li_timkiem', $r_tt);
		}
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
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
		mysqli_query($conn, "INSERT INTO contact (name,email,subject,message,date_post)VALUES('$name','$email','$subject','$message'," . time() . ")");
		$_SESSION['contact'] = time();
		$thongbao = 'Cảm ơn bạn! Việc liên hệ đã thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'dangky_nhantin') {
	$email = addslashes(strip_tags($_REQUEST['email']));
	if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ email';
	} else {
		$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM dangky_nhantin WHERE email='$email' AND shop='0'");
		$r_tt = mysqli_fetch_assoc($thongtin_email);
		if ($r_tt['total'] == 0) {
			$ok = 1;
			mysqli_query($conn, "INSERT INTO dangky_nhantin (shop,email,date_post)VALUES('0','$email'," . time() . ")");
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
} else if($action == 'goiy_home'){
	$limit = intval($_REQUEST['limit']);
	$data = $class_index->list_home_goiy($conn,$limit);
	$info = array(
		'ok' => 1,
		'data' => $data,
	);
	echo json_encode($info);
}
else if ($action == 'fee_ship') {
	$sender_province = addslashes(strip_tags($_REQUEST['sender_province'] ?? ''));
	$sender_district = addslashes(strip_tags($_REQUEST['sender_district'] ?? ''));
	$receiver_province = addslashes(strip_tags($_REQUEST['receiver_province'] ?? ''));
	$receiver_district = addslashes(strip_tags($_REQUEST['receiver_district'] ?? ''));
	$weight = intval($_REQUEST['weight'] ?? 0);
	$amount = intval($_REQUEST['amount'] ?? 0);

	// $data_ship = $class_supership->get_tax($sender_province,$sender_district,$receiver_province,$receiver_district,$weight, $amount, $accessToken);
	$data_ship = $class_supership->get_tax($sender_province, $sender_district, $receiver_province, $receiver_district, $weight, $amount, $accessToken);	
	//$phi_ship = $data_ship['results'][0]['fee'];
	$phi_ship = isset($data_ship['results'][0]['fee']) ? $data_ship['results'][0]['fee'] : 0;
	
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
} 
else {
	echo "Không có hành động nào được xử lý";
}
