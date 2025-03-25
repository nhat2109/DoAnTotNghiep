<?php

$class_index = $tlca_do->load_skin($s, 'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);
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
$limit = 10;
if (isset($_COOKIE['user_id'])) {
	$box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header_login');
	$header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/tpl/header_menu_mobile_login');
	$class_member = $tlca_do->load('class_member');
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
} else {
	$box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header');
	$header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/tpl/header_menu_mobile');
}
$blank = addslashes(strip_tags($_REQUEST['blank']));
$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE link='$blank' AND shop='$shop'");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['total'] == 0) {
	$thongbao = "Dữ liệu không tồn tại.";
	$replace = array(
		'title' => 'Dữ liệu không tồn tại',
		'thongbao' => $thongbao,
		'link' => '/',
	);
	echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
	exit();
}
if ($r_tt['kho'] > 50) {
	$r_tt['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_tt['kho'] . '</b> sản phẩm</div>';
} else {
	$r_tt['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
}
$phantram = 100 - ($r_tt['kho'] / 100) * 100;
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
$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$sp_id = $r_tt['id'];
if (!isset($_SESSION['daxem'][$sp_id])) {
	$_SESSION['daxem'][$sp_id] = $sp_id;
}
$list_id = implode(",", $_SESSION['daxem']);
if ($r_tt['kho'] > 0 OR $r_tt['kho_hang'] > 0) {
	$r_tt['tinh_trang'] = 'Còn hàng';
	$disabled = '';
	$text_button = 'Thêm vào giỏ hàng';
} else {
	$r_tt['tinh_trang'] = 'Hết hàng';
	$disabled = ' disabled';
	$text_button = 'Hết Hàng';
}

if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
	$giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
	$r_tt['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
} else {
	$r_tt['label_sale'] = '';
}
if (strlen($r_tt['thongtin']) > 3) {
	$tach_thongso = explode('|', $r_tt['thongtin']);
	foreach ($tach_thongso as $key => $value) {
		$tach_value = explode('&&', $value);
		$list_thongso .= '<tr><td width="120">' . $tach_value[0] . '</td><td>' . $tach_value[1] . '</td></tr>';
	}
} else {
	$list_thongso = '<tr><td colspan="2">Đang cập nhật</td></tr>';
}
if ($r_tt['mau'] != '') {
	$mau = $r_tt['mau'];
	$thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
	$m = 0;
	while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
		$m++;
		if ($m == 1) {
			$list_mau .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" checked />
	                        <label for="mau-' . $r_m['id'] . '">
	                            ' . $r_m['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                        </label>
	                    </div>';

		} else {
			$list_mau .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '"/>
	                        <label for="mau-' . $r_m['id'] . '">
	                            ' . $r_m['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                        </label>
	                    </div>';
		}
	}
	$option_mau = '<div class="swatch-div">
                    <div id="variant-swatch-0 "   class="swatch clearfix swatch clearfix swatch-color">
                        <div class="header">Màu sắc:</div>
                        <div class="select-swap">
                        ' . $list_mau . '
                        </div>
                    </div>
                </div>';
} else {
	$option_mau = '';
}
if ($r_tt['size'] != '') {
	$size = $r_tt['size'];
	$thongtin_size = mysqli_query($conn, "SELECT * FROM kich_co WHERE id IN($size) ORDER BY thu_tu ASC");
	$ss = 0;
	while ($r_size = mysqli_fetch_assoc($thongtin_size)) {
		$ss++;
		if ($ss == 1) {
			$list_size .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="size-' . $r_size['id'] . '" type="radio" name="size" value="' . $r_size['tieu_de'] . '" checked />
	                        <label for="mau-' . $r_size['id'] . '">
	                            ' . $r_size['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_size['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_size['tieu_de'] . '" />
	                        </label>
	                    </div>';
		} else {
			$list_size .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="size-' . $r_size['id'] . '" type="radio" name="size" value="' . $r_size['tieu_de'] . '"/>
	                        <label for="mau-' . $r_size['id'] . '">
	                            ' . $r_size['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_size['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_size['tieu_de'] . '" />
	                        </label>
	                    </div>';
		}
	}
	$option_size = '<div class="select-swatch">
                    <div id="variant-swatch-0" class="swatch clearfix" data-option="option1" data-option-index="0">
                        <div class="header">Size</div>
                        <div class="select-swap">
                        ' . $list_size . '
                        </div>
                    </div>
                </div>';
} else {
	$option_size = '';
}
if ($r_tt['thuong_hieu'] != '') {
	$thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
	$r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
	$thuong_hieu = '<div class="inve_brand">
                    <span class="stock-brand-title"><strong>Thương hiệu:</strong></span>
                    <span class="a-brand" itemprop="brand" itemscope itemtype="https://schema.org/brand">' . $r_th['tieu_de'] . '</span>
                </div>';

} else {
	$thuong_hieu = '';
}
if ($r_tt['ma_sanpham'] != '') {
	$thongtin_masanpham = mysqli_query($conn, "SELECT * FROM sanpham");
	$r_th = mysqli_fetch_assoc($thongtin_masanpham);
	$ma_sanpham = '<div class="inve_brand">
                    <span class="stock-brand-title"><strong>Mã sản phẩm:</strong></span>
                    <span class="a-brand" itemprop="brand" itemscope itemtype="https://schema.org/brand">' . $r_th['ma_sanpham'] . '</span>
                </div>';

} else {
	$ma_sanpham = '';
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
// Lưu sản phẩm đã xem vào session
if (!isset($_SESSION['viewed_products'])) {
    $_SESSION['viewed_products'] = [];
}
if (!in_array($r_tt['id'], $_SESSION['viewed_products'])) {
    $_SESSION['viewed_products'][] = $r_tt['id'];
}
// echo $list_coupon_code.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_coupon_code',$r_cp);
// exit();
$list_muakem_id=substr($list_muakem_id, 0,-1);
$list_flashsale_id=substr($list_flashsale_id, 0,-1);
$list_tang_id=substr($list_tang_id, 0,-1);
if(strlen($where)<5){
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham_shop WHERE shop='{$r_shop['user_id']}'");
}else{
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham_shop WHERE ".$where." AND shop='{$r_shop['user_id']}'");
}
$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
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

$list_muakem_id = substr($list_muakem_id, 0, -1);
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$list_tang_id = substr($list_tang_id, 0, -1);
$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);

$sql_1 = "SELECT id, sp_id, shop, tieu_de, minh_hoa, link, link_aff, cat, kho_hang, gia_cu, gia_moi, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, ban, title, description, view, date_post, giao_hang, doi_tra FROM sanpham_shop WHERE id = '{$r_tt['id']}'";
$result_1 = mysqli_query($conn, $sql_1);

if (!$result_1) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$data_1 = mysqli_fetch_assoc($result_1);

// Kiểm tra giá trị của $data
// echo '<pre>';
// print_r($data['doi_tra']);
// echo '</pre>';
// exit();
$sql_2 = "SELECT name, value FROM index_setting WHERE name IN ('banner_mot', 'banner_2','banner_mot_text', 'banner_2_text', 'modal_header')";
$result = mysqli_query($conn, $sql_2);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['name']] = $row['value'];
}


$replace = array(
	'box_banner' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_banner'),
	'noidung_header' => $_SESSION['noidung_header'], // Ghi đè giá trị của noidung_header
	'modal_header' => $data['modal_header'], // Ghi đè giá trị của modal_header
	'box_coupons'=>$box_coupons,
	'list_coupon'=>$list_coupon,
	'list_coupon_code'=>$list_coupon_code,
	'box_coupons'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/box_coupons'),
	'header' => $skin->skin_normal('skin_shop/' . $s . '/tpl/header_view'),
	'box_header' => $box_header,
	'box_deal_soc' => $box_deal_soc,
	'box_flash_sale' => $box_flash_sale,
	'list_category_sub'=>$list_category_sub,
	'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
	'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
	'header_menu_mobile' => $header_menu_mobile,
	'title' => $r_tt['title'],
	'description' => $index_setting['description'],
	'site_name' => $index_setting['site_name'],
	'limit' => $limit,
	'logo' => $index_setting['logo'],
	'text_footer' => $index_setting['text_footer'],
	'google_analytics' => $google_analytics,
	'script_chat' => $script_chat,
	'text_contact_footer' => $index_setting['text_contact_footer'],
	'text_about' => $index_setting['text_about'],
	'link_xem' => $link_xem,
	'hotline' => $index_setting['hotline'],
	'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'text_hotline' => $index_setting['text_hotline'],
	'link_facebook' => $index_setting['link_facebook'],
	'link_google' => $index_setting['link_google'],
	'link_youtube' => $index_setting['link_youtube'],
	'link_twitter' => $index_setting['link_twitter'],
	'link_instagram' => $index_setting['link_instagram'],
	'bg_backgroud' => $giaodien['background'],
	'bg_header' => $giaodien['header'],
	'bg_topbar' => $giaodien['topbar'],
	'bg_hotline' => $giaodien['hotline'],
	'bg_menu' => $giaodien['menu'],
	'bg_title_menu' => $giaodien['title_menu'],
	'bg_title_box' => $giaodien['title_box'],
	'bg_button_top' => $giaodien['button_top'],
	'bg_subcribe' => $giaodien['subcribe'],
	'bg_top_menu_mobile' => $giaodien['top_menu_mobile'],
	'bg_label_sale' => $giaodien['label_sale'],
	'bg_ma_giamgia' => $giaodien['ma_giamgia'],
	'bg_top_footer' => $giaodien['top_footer'],
	'bg_bottom_footer' => $giaodien['bottom_footer'],
	'color_text_top_footer' => $giaodien['text_top_footer'],
	'color_text_bottom_footer' => $giaodien['text_bottom_footer'],
	'bg_timkiem' => $giaodien['timkiem'],
	'bg_nhantin' => $giaodien['nhantin'],
	'color_text_title_top_footer' => $giaodien['text_title_top_footer'],
	'menu_chinhsach' => $tach_menu['chinhsach'],
	'menu_huongdan' => $tach_menu['huongdan'],
	'menu_top' => $tach_menu['top'],
	'menu_mobile' => $tach_menu['menu_mobile'],
	'category_mobile' => $class_index->list_category_sanpham_mobile($conn, $r_shop['user_id']),
	'list_category_nav' => $tach_category['list'],
	'list_category_left' => $tach_category['list_left'],
	'lienhe' => $index_setting['lienhe'],
	'photo' => $index_setting['photo'],
	'photo_1' => $index_setting['photo_1'],
	'phantrang' => $phantrang,
	'fanpage' => $index_setting['fanpage'],
	'name' => $user_info['name'],
	'avatar' => $user_info['avatar'],
	'gioithieu' => $index_setting['gioithieu'],
	'tieu_de' => $r_tt['tieu_de'],
	'gia_moi' => number_format($r_tt['gia_moi']),
	'gia_cu' => number_format($r_tt['gia_cu']),
	'gia_drop' => number_format($r_tt['gia_drop']),
	
	
	'noi_bat' => $r_tt['noi_bat'],
    'noi_dung' => $r_tt['noi_dung'],
	'giao_hang' => $data_1['giao_hang'], // Ghi đè giá trị của giao_hang
    'doi_tra' => $data_1['doi_tra'], // Ghi đè giá trị của doi_tra
	'minh_hoa' => $r_tt['minh_hoa'],
	'list_photo' => $list_anh,
	'list_photo_1' => $list_anh_1,
	'tinh_trang' => $r_tt['tinh_trang'],
	'option_size' => $option_size,
	'option_mau' => $option_mau,
	'thuong_hieu' => $thuong_hieu,
	
	'list_thongso' => $list_thongso,
	'label_sale' => $r_tt['label_sale'],
	'text_flash_sale' => $text_flash_sale,
	'phantram' => $phantram,
	'time_conlai' => $time_conlai,
	'list_muakem' => $list_muakem,
	'loai' => $loai,
	'list_lienquan' => $class_index->list_sanpham_lienquan($conn, $s, $r_shop['user_id'], $r_tt['id'], $r_tt['cat'], $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, 5),
	'list_daxem' => $class_index->list_sanpham_daxem($conn, $s, $r_shop['user_id'], $list_id, $r_tt['id'], $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, 5),
	'sp_id' => $r_tt['id'],
	'disabled' => $disabled,
	
	'text_button' => $text_button,
	'link_aff' => $r_tt['link_aff'],
	'tongtien'=>number_format($tongtien),
	'shop' => $r_shop['user_id'],
	
);


// $sql_3 = "SELECT link, minh_hoa, title FROM sanpham_shop LIMIT 9";
// $result = mysqli_query($conn, $sql_3);

// if (!$result) {
//     die("Lỗi truy vấn: " . mysqli_error($conn));
// }

// $salePopArr = [];
// while ($row = mysqli_fetch_assoc($result)) {
//     $salePopArr[] = [
//         'img_url' => $row['minh_hoa'],
//         'pd_title' => $row['title'],
//         'pd_url' => $row['link']
//     ];
// }
// $current_dir = dirname(__FILE__);
// $file = $current_dir . '/salePopArr.json';
// file_put_contents($file, json_encode($salePopArr));

if ($r_tt['link_aff'] != '') {
	echo $skin->skin_replace('skin_shop/' . $s . '/tpl/view_aff', $replace);
} else {
	echo $skin->skin_replace('skin_shop/' . $s . '/tpl/view', $replace);
}
?>