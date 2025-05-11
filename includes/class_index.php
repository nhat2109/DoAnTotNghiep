<?php

class class_index extends class_manage
{
	function list_menu($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM menu ORDER BY menu_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$vitri = $r_tt['menu_vitri'];
			$list[$vitri] .= $skin->skin_replace('skin/box_li/li_menu_' . $vitri, $r_tt);
		}
		return json_encode($list);
	}
	/////////////////
	function list_banner($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM banner  ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$vitri = $r_tt['vi_tri'];
			$list[$vitri] .= $skin->skin_replace('skin/box_li/li_banner_' . $vitri, $r_tt);
		}
		return json_encode($list);
	}
	/////////////////
	function list_banner_page($conn, $loai)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$loai_mobile = $loai . '_mobile';
		$thongtin = mysqli_query($conn, "SELECT * FROM banner  WHERE vi_tri='$loai' AND shop_id='0' ORDER BY thu_tu ASC LIMIT 1");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_mobile = mysqli_query($conn, "SELECT * FROM banner WHERE vi_tri='$loai_mobile' AND shop_id='0' ORDER BY thu_tu ASC LIMIT 1");
			$r_m = mysqli_fetch_assoc($thongtin_mobile);
			$r_tt['minh_hoa_mobile'] = $r_m['minh_hoa'];
			$list .= $skin->skin_replace('skin/box_li/li_banner_banner_index', $r_tt);
		}
		return $list;
	}
	/////////////////
	function list_banner_index($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM banner WHERE vi_tri='banner_index' ORDER BY thu_tu ASC");
		$list = '';
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_mobile = mysqli_query($conn, "SELECT * FROM banner WHERE vi_tri='banner_index_mobile' ORDER BY thu_tu ASC LIMIT 3");
			$r_m = mysqli_fetch_assoc($thongtin_mobile);
			$r_tt['minh_hoa_mobile'] = $r_m['minh_hoa'] ?? '';
			$list .= $skin->skin_replace('skin/box_li/li_banner_banner_index', $r_tt);
		}
		return $list;
	}
	/////////////////
	function list_banner_baohanh($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM banner WHERE vi_tri='banner_baohanh' AND shop_id='0' ORDER BY thu_tu ASC LIMIT 1");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_mobile = mysqli_query($conn, "SELECT * FROM banner WHERE vi_tri='banner_baohanh_mobile' AND shop_id='0' ORDER BY thu_tu ASC LIMIT 1");
			$r_m = mysqli_fetch_assoc($thongtin_mobile);
			$r_tt['minh_hoa_mobile'] = $r_m['minh_hoa'];
			$list .= $skin->skin_replace('skin/box_li/li_banner_banner_baohanh', $r_tt);
		}
		return $list;
	}
	/////////////////
	function list_chinhsach($conn, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE (tieu_de LIKE '%chính sách%' OR tieu_de LIKE '%Quy định%' OR tieu_de LIKE '%Quy chế%') AND tieu_de NOT LIKE '%Chính sách lao động%' ORDER BY id ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$vitri = $r_tt['vi_tri'];
			$list .= $skin->skin_replace('skin/box_li/li_chinhsach', $r_tt);
		}
		return $list;
	}
	/////////////////
	public function list_phanloai_size($conn, $sp_id, $color, $sub_product)
	{
		$list_size = '';
		$ten_size = '';
		$css = '';

		// Truy vấn danh sách kích thước từ bảng phanloai_sanpham
		$query = "SELECT id, size, ten_size, gia_moi, gia_cu, kho_sanpham_socdo FROM phanloai_sanpham WHERE sp_id = ? AND color = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ii', $sp_id, $color);
		$stmt->execute();
		$result = $stmt->get_result();

		$first = true; // Để đánh dấu kích thước đầu tiên là active
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$size = htmlspecialchars($row['size']);
				$ten_size = htmlspecialchars($row['ten_size']);
				$gia_moi = isset($row['gia_moi']) ? intval($row['gia_moi']) : 0;
				$gia_cu = isset($row['gia_cu']) ? intval($row['gia_cu']) : 0;
				$kho = isset($row['kho_sanpham_socdo']) ? intval($row['kho_sanpham_socdo']) : 0;
				$pl = intval($row['id']); // ID phân loại

				// Tính toán sale dựa trên gia_moi và gia_cu
				$sale = ($gia_cu > 0 && $gia_moi < $gia_cu) ? round((($gia_cu - $gia_moi) / $gia_cu) * 100) : 0;

				// Xử lý flash sale nếu có $sub_product
				if (!empty($sub_product) && is_array(json_decode($sub_product, true))) {
					$sub_product_data = json_decode($sub_product, true);
					if (isset($sub_product_data[$sp_id])) {
						$gia_moi = $sub_product_data[$sp_id]['gia'] ?? $gia_moi;
						$sale = ($gia_cu > 0 && $gia_moi < $gia_cu) ? round((($gia_cu - $gia_moi) / $gia_cu) * 100) : 0;
					}
				}

				// Xác định trạng thái disabled
				$disabled = ($kho <= 0) ? 'disabled' : '';

				// Đánh dấu kích thước đầu tiên là active
				$active = $first ? 'active' : '';
				$first = false;

				// Tạo HTML cho kích thước
				$list_size .= '<div class="li_size ' . $active . ' ' . $disabled . '" sp_id="' . $sp_id . '" size="' . $size . '" gia_cu="' . $gia_cu . '" pl="' . $pl . '" gia_moi="' . $gia_moi . '" sale="' . $sale . '" tieu_de="' . $ten_size . '">
					<span>' . $ten_size . '</span>
				</div>';

				// Lưu tên kích thước đầu tiên
				if ($active) {
					$ten_size = $ten_size;
				}
			}

			// Thêm CSS một lần duy nhất
			$css = '<style>
				.li_color,
				.li_size {
					cursor: pointer;
					padding: 5px 10px;
					border: 1px solid #ccc;
					display: inline-block;
					margin: 5px;
				}
	
				.li_color.active,
				.li_size.active {
					border-color: #007bff;
					background-color: #e7f0ff;
				}
	
				.li_size.disabled {
					cursor: not-allowed;
					opacity: 0.5;
				}
			</style>';
		} else {
			$list_size = '<div>Không có kích thước nào</div>';
		}

		$stmt->close();

		return json_encode(array(
			'list_size' => $list_size . $css,
			'ten_size' => $ten_size
		));
	}
	/////////////////
	function list_phanloai($conn, $sp_id, $color, $flash_sale_pl)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if ($flash_sale_pl == '') {
			$thongtin = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' ORDER BY id ASC");
			$i = 0;
			$list_id_color = array();
			$list_id_size = array();
			$list_color = '';
			$list_size = '';
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$ok_x = 0;
				if ($r_tt['so_luong'] > 0) {
					if ($ok_x == 0) {
						$ok_x = 1;
						$r_tt['active'] = 'active';
						$ten_color = $r_tt['ten_color'];
						$ten_size = $r_tt['ten_size'];
					}
				} else {
				}
				if ($ok_x == 0) {
					if ($i == 1) {
						$r_tt['active'] = 'active';
						$ten_color = $r_tt['ten_color'];
						$ten_size = $r_tt['ten_size'];
					} else {
						$r_tt['active'] = '';
					}
				}
				if ($r_tt['gia_cu'] > 0) {
					$sale = (($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100;
					$sale = round($sale);
				} else {
					$sale = '0';
				}
				$r_tt['sale'] = $sale;
				$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
				$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
				if ($r_tt['color'] == $color) {
					if (in_array($r_tt['size'], $list_id_size) == false and $r_tt['size'] != '') {
						$list_id_size[] .= $r_tt['size'];
						$list_size .= $skin->skin_replace('skin/box_li/li_size', $r_tt);
					}
				}
				if (in_array($r_tt['color'], $list_id_color) == false and $r_tt['color'] != '') {
					$list_id_color[] .= $r_tt['color'];
					$list_color .= $skin->skin_replace('skin/box_li/li_color', $r_tt);
				}
			}
		} else {
			$list_id_color = array();
			$list_id_size = array();
			$list_color = '';
			$list_size = '';
			$tach_flash = json_decode($flash_sale_pl, true);
			foreach ($tach_flash as $key => $value) {
				if ($value['sp_id'] == $sp_id) {
					$i = 0;
					foreach ($value['list_pl'] as $k => $v) {
						if ($v['gia_cu'] > 0) {
							$sale = ((preg_replace('/[^0-9]/', '', $v['gia_cu']) - preg_replace('/[^0-9]/', '', $v['gia'])) / preg_replace('/[^0-9]/', '', $v['gia_cu'])) * 100;
							$sale = round($sale);
						} else {
							$sale = '0';
						}
						$v['sale'] = $sale;
						$v['id'] = $v['pl'];
						$v['sp_id'] = $value['sp_id'];
						$v['gia_moi'] = $v['gia'];
						if ($v['color'] == $color) {
							$i++;
							if ($i == 1) {
								$v['active'] = 'active';
								$ten_color = $v['ten_color'];
								$ten_size = $v['ten_size'];
							} else {
								$v['active'] = '';
							}
							if (in_array($v['size'], $list_id_size) == false and $v['size'] != '') {
								$list_id_size[] .= $v['size'];
								$list_size .= $skin->skin_replace('skin/box_li/li_size', $v);
							}
						}
						if (in_array($v['color'], $list_id_color) == false and $v['color'] != '') {
							$list_id_color[] .= $v['color'];
							$list_color .= $skin->skin_replace('skin/box_li/li_color', $v);
						}
					}
				}
			}
		}
		$bien = array(
			'list_color' => $list_color,
			'list_size' => $list_size,
			'ten_size' => $ten_size,
			'ten_color' => $ten_color
		);
		return json_encode($bien);
	}
	/////////////////
	function list_diachi($conn, $user_id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM dia_chi WHERE user_id='$user_id' ORDER BY active DESC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['active'] == 1) {
				$list .= $skin->skin_replace('skin/box_li/li_diachi_macdinh', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin/box_li/li_diachi', $r_tt);
			}
		}
		$info = array(
			'list' => $list,
			'total' => $i
		);
		return json_encode($info);
	}
	function creat_random($conn, $loai)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if ($loai == 'coupon') {
			$string = $check->random_number(6);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='$string'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$this->creat_random($conn, $loai);
			} else {
				return $string;
			}
		} else if ($loai == 'donhang') {
			$string = $check->random_number(6);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE ma_don='$string'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$this->creat_random($conn, $loai);
			} else {
				return $string;
			}
		}
	}
	/////////////////
	function list_skin($conn, $total, $loai, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($loai == 'vip') {
			$thongtin = mysqli_query($conn, "SELECT * FROM giaodien WHERE gia_moi>'0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		} else if ($loai == 'free') {
			$thongtin = mysqli_query($conn, "SELECT * FROM giaodien WHERE gia_moi='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM giaodien  WHERE is_new='1' ORDER BY thu_tu ASC LIMIT $start,$limit");
		}
		$i = 0;
		$end = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$end++;
			$r_tt['blank'] = $check->blank($r_tt['tieu_de']);
			if ($r_tt['gia_moi'] == '0') {
				$r_tt['gia_moi'] = 'Miễn phí';
			} else {
				$r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
			$list .= $skin->skin_replace('skin/box_li/li_skin', $r_tt);
		}
		$info = array(
			'total' => $i,
			'end' => $end,
			'list' => $list,
		);
		return json_encode($info);
	}
	/////////////////
	function list_video_skin($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE loai='all' ORDER BY view ASC");
		$i = 0;
		$end = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$param_url = parse_url($r_tt['link_video']);
			parse_str($param_url['query'], $url_query);
			$id_video = addslashes($url_query['v']);
			$r_tt['id_video'] = $id_video;
			/*            if($i==1){
//$list_big='<iframe width="560" height="315" src="https://www.youtube.com/embed/lZbZNwNg1Ps?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
$list_big.=$skin->skin_replace('skin/box_li/li_video_skin_big',$r_tt);
}else{*/
			$list_small .= $skin->skin_replace('skin/box_li/li_video_skin_small', $r_tt);
			/*            }*/
		}
		$info = array(
			'list_big' => $list_big,
			'list_small' => $list_small,
		);
		return json_encode($info);
	}
	///////////////////
	function list_option_tinh($conn, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_huyen($conn, $tinh, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_xa($conn, $huyen, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_tichdiem($conn, $shop, $user_id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM tich_diem WHERE shop='$shop' AND user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
		$i = $start;
		$tach_id = explode('*', $id);
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã cộng';
			} else {
				$r_tt['status'] = 'Tạm giữ';
			}
			$r_tt['diem'] = number_format($r_tt['diem']);
			$list .= $skin->skin_replace('skin/box_li/li_tichdiem', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_vi_voucher($conn, $user_id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM vi_voucher WHERE user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
		$i = $start;
		$total = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã cộng';
			} else {
				$r_tt['status'] = 'Tạm giữ';
			}
			$r_tt['diem'] = number_format($r_tt['diem']);
			$list .= $skin->skin_replace('skin/box_li/li_vi_voucher', $r_tt);
		}
		if ($total == 0) {
			$list = 'Không có voucher nào!';
		}
		$info = array(
			'list' => $list,
			'total' => $total
		);
		return json_encode($info);
	}
	///////////////////
	function list_danhgia($conn, $user_id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM vi_voucher WHERE user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
		$i = $start;
		$total = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã cộng';
			} else {
				$r_tt['status'] = 'Tạm giữ';
			}
			$r_tt['diem'] = number_format($r_tt['diem']);
			$list .= $skin->skin_replace('skin/box_li/li_danhgia', $r_tt);
		}
		if ($total == 0) {
			$list = ' <tr>
                        <td colspan="5" align="center">Không có đánh giá nào!</td>
                    </tr>';
		}
		$info = array(
			'list' => $list,
			'total' => $total
		);
		return json_encode($info);
	}
	///////////////////
	function list_donhang($conn, $user_id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = ($page * $limit) - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id='$user_id' ORDER BY date_post DESC LIMIT $start, $limit");
		$i = $start;
		$k = 0;
		$list = '';

		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$k++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['active'] = ($k == 1) ? 'active' : '';

			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . ' đ';

			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);

			if ($r_tt['status'] == 0) {
				$r_tt['trang_thai'] = 'Chờ xử lý';
				$r_tt['class_status'] = 'wait';
			} else if ($r_tt['status'] == 1) {
				$r_tt['trang_thai'] = 'Đã tiếp nhận';
				$r_tt['class_status'] = 'xac_nhan';
			} else if ($r_tt['status'] == 2) {
				$r_tt['trang_thai'] = 'Đang vận chuyển';
				$r_tt['class_status'] = 'shipping';
			} else if ($r_tt['status'] == 3) {
				$r_tt['trang_thai'] = 'Yêu cầu hủy đơn';
				$r_tt['class_status'] = 'request_cancel';
			} else if ($r_tt['status'] == 4) {
				$r_tt['trang_thai'] = 'Đã hủy đơn';
				$r_tt['class_status'] = 'cancel';
			} else if ($r_tt['status'] == 5) {
				$r_tt['trang_thai'] = 'Đã nhận hàng';
				$r_tt['class_status'] = 'success';
			} else if ($r_tt['status'] == 6) {
				$r_tt['trang_thai'] = 'Đã hoàn đơn';
				$r_tt['class_status'] = 'cancel';
			} else {
				$r_tt['trang_thai'] = 'Chờ xử lý';
				$r_tt['class_status'] = 'wait';
			}

			$sanpham_data = mb_convert_encoding($r_tt['sanpham'], 'UTF-8', 'auto');
			error_log("Sanpham JSON for order {$r_tt['ma_don']}: " . $sanpham_data);

			$tach_sanpham = parse_json_with_duplicate_keys($sanpham_data);
			$list_sanpham = '';

			if (empty($tach_sanpham)) {
				error_log("JSON Parse Error for order {$r_tt['ma_don']}: Không thể phân tích JSON");
				$list_sanpham = '<tr><td colspan="5" class="text-center">Lỗi dữ liệu sản phẩm: JSON không hợp lệ.</td></tr>';
			} else {
				foreach ($tach_sanpham as $value) {
					if (!is_array($value)) {
						error_log("Dữ liệu sản phẩm không hợp lệ: " . json_encode($value));
						continue;
					}

					$value['size'] = isset($value['size']) && $value['size'] != '' ? 'Size: ' . strtoupper($value['size']) : '';
					$value['color'] = isset($value['color']) && $value['color'] != '' ? 'Màu: ' . $value['color'] : '';
					$value['soluong'] = isset($value['soluong']) ? $value['soluong'] : '1';
					$value['minh_hoa'] = isset($value['minh_hoa']) ? $value['minh_hoa'] : '';
					$value['link'] = isset($value['link']) ? $value['link'] : '#';
					$value['tieu_de'] = isset($value['tieu_de']) ? $value['tieu_de'] : 'Sản phẩm không xác định';
					$value['gia_moi'] = isset($value['gia_moi']) ? number_format((float)str_replace(',', '', $value['gia_moi'])) . ' đ' : '0 đ';
					$value['gia_cu'] = isset($value['gia_cu']) && $value['gia_cu'] != '' ? number_format((float)str_replace(',', '', $value['gia_cu'])) . ' đ' : '';
					$value['thanhtien'] = isset($value['thanhtien']) ? number_format((float)str_replace(',', '', $value['thanhtien'])) . ' đ' : '0 đ';

					error_log("Dữ liệu sản phẩm: " . json_encode($value));

					$list_sanpham .= $skin->skin_replace('skin/box_li/li_sanpham_order', $value);
				}
			}

			$r_tt['list_sanpham'] = $list_sanpham;

			$list .= $skin->skin_replace('skin/box_li/li_donhang', $r_tt);
		}

		return $list;
	}
	///////////////////
	function list_thongbao($conn, $user_id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE shop='0' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') ORDER BY date_post DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$tach_doc = explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc) == true) {
				$r_tt['status'] = '<i class="fa fa-eye"></i> đã đọc';
				$r_tt['new'] = '';
			} else {
				$r_tt['status'] = '<i class="fa fa-eye-slash"></i> chưa đọc';
				$r_tt['new'] = '<span>new</span>';
			}
			$list .= $skin->skin_replace('skin/box_li/li_thongbao', $r_tt);
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////
	function list_category($conn)
	{
		$check = $this->load('class_check');
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub < 10) {
				$col = "col_1";
			} else if ($total_sub < 30) {
				$col = "col_2";
			} else {
				$col = "col_3";
			}
			if ($total_sub > 0) {
				while ($r_sub = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_sub['cat_id']}' ORDER BY cat_thutu ASC");
					$total_sub_sub = mysqli_num_rows($thongtin_sub_sub);
					if ($total_sub_sub > 0) {
						while ($r_sub_sub = mysqli_fetch_assoc($thongtin_sub_sub)) {
							$list_sub_sub .= '<span class="submenu__item submenu__item"><a class="link" href="/san-pham/' . $r_sub_sub['cat_blank'] . '.html" title="' . $r_sub_sub['cat_tieude'] . '">' . $r_sub_sub['cat_tieude'] . '</a></span>';
						}
					} else {
						$list_sub_sub = '';
					}
					$list_sub .= '<li class="submenu__col"><span class="submenu__item submenu__item--main"><a class="link" href="/san-pham/' . $r_sub['cat_blank'] . '.html" title="">' . $r_sub['cat_tieude'] . '</a></span>' . $list_sub_sub . '</li>';
					unset($list_sub_sub);
					$list_top_sub .= '<li><a href="/san-pham/' . $r_sub['cat_blank'] . '.html">' . $r_sub['cat_tieude'] . '</a></li>';
				}
				$duoi = $check->duoi_file($r_tt['cat_icon']);
				if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {
					$cat_icon = '<img class="lazyload loaded" src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '" data-was-processed="true">';
				} else {
					$cat_icon = $r_tt['cat_icon'];
				}
				$list .= '<li class="menu-item list-group-item">
                            <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="menu-item__link d-flex justify-content-between align-items-center" title="' . $r_tt['cat_tieude'] . '">
                                <span>' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</span>
                                <i class="fa fa-chevron-right float-right" data-toggle-submenu=""></i>
                            </a>
                            <div class="submenu scroll">
                                <ul class="submenu__list">
                                ' . $list_sub . '
                                </ul>
                            </div>
                        </li>';
				// đây nó đang ăn giao diện chỗ này này .
				// <ul class="' . $col . '">' . $list_top_sub . '</ul> 
				$list_top .= '<li>
								<a href="/san-pham/' . $r_tt['cat_blank'] . '.html">' . $r_tt['cat_icon'] . ' ' . $r_tt['cat_tieude'] . '</a>
								
							</li>';
				$list_mobile .= '<li class="menu-item list-group-item">
                            <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="menu-item__link d-flex justify-content-between align-items-center" title="' . $r_tt['cat_tieude'] . '">
                                <span>' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</span>
                                <i class="fa fa-chevron-right float-right" data-toggle-submenu=""></i>
                            </a>
                            <div class="submenu scroll">
                                <div class="toggle-submenu">
                                    <i class="fa fa-chevron-left mr-3"></i>
                                    <span>' . $r_tt['cat_tieude'] . '</span>
                                </div>
                                <ul class="submenu__list">
                                ' . $list_sub . '
                                </ul>
                            </div>
                        </li>';
				unset($list_sub);
				unset($list_top_sub);
			} else {
				$list_sub = '';
				$duoi = $check->duoi_file($r_tt['cat_icon']);
				if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {
					$cat_icon = '<img class="lazyload loaded" src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '" data-was-processed="true">';
				} else {
					$cat_icon = $r_tt['cat_icon'];
				}
				$list .= '<li class="menu-item list-group-item">
                            <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="menu-item__link d-flex justify-content-between align-items-center" title="' . $r_tt['cat_tieude'] . '">
                                <span>' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</span>
                            </a>
                        </li>';
				$list_top .= '<li>
						<a href="/san-pham/' . $r_tt['cat_blank'] . '.html">' . $r_tt['cat_icon'] . ' ' . $r_tt['cat_tieude'] . '</a>
					</li>';
				$list_mobile .= '<li class="menu-item list-group-item">
                            <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="menu-item__link d-flex justify-content-between align-items-center" title="' . $r_tt['cat_tieude'] . '">
                                <span>' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</span>
                            </a>
                        </li>';
			}
		}
		mysqli_free_result($thongtin);
		return json_encode(array('list' => $list, 'list_top' => $list_top, 'list_mobile' => $list_mobile));
	}

	function list_category_danhmuc_top($conn)
	{
		$check = $this->load('class_check');
		$list_parent = '<ul class="new-parent-menu">';
		$list_sub = '<div class="new-sub-menu-container">';

		// Lấy danh mục cha
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");

		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$duoi = $check->duoi_file($r_tt['cat_icon']);
			if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp'))) {
				// Nếu là ảnh, thêm class 'cat-icon-img'
				$cat_icon = '<img class="cat-icon_dm cat-icon-img lazyload loaded" src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '" data-was-processed="true">';
			} else {
				// Nếu không phải ảnh, thêm class 'cat-icon-text'
				$cat_icon = '<span class="cat-icon_dm cat-icon-text">' . $r_tt['cat_icon'] . '</span>';
			}

			// Thêm danh mục cha
			$list_parent .= '<li class="parent-item" data-target="submenu-' . $r_tt['cat_id'] . '">';
			$list_parent .= '<a href="/san-pham/' . $r_tt['cat_blank'] . '.html">' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</a>';
			$list_parent .= '</li>';

			// Thêm danh mục con
			$list_sub .= '<div id="submenu-' . $r_tt['cat_id'] . '" class="submenu">';
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
			if (mysqli_num_rows($thongtin_sub) > 0) {
				$list_sub .= '<ul>';
				while ($r_sub = mysqli_fetch_assoc($thongtin_sub)) {
					$list_sub .= '<li><a href="/san-pham/' . $r_sub['cat_blank'] . '.html">' . $r_sub['cat_tieude'] . '</a></li>';
				}
				$list_sub .= '</ul>';
			}
			$list_sub .= '</div>';
		}

		$list_parent .= '</ul>';
		$list_sub .= '</div>';

		return json_encode([
			'list_parent' => $list_parent,
			'list_sub' => $list_sub
		]);
	}

	// tìm kiếm nâng cao
	// function list_category_noibat_timkiem($conn) {
	// 	$skin = $this->load('class_skin');
	// 	$check = $this->load('class_check');
	// 	$tach_category = explode(',', $category);
	// 	$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_noibat='1' ORDER BY cat_thutu ASC LIMIT 8");
	// 	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	// 		$list .= $skin->skin_replace('skin/box_li/li_danhmuc_noibat_timkiem', $r_tt);
	// 	}
	// 	mysqli_free_result($thongtin);
	// 	return $list;
	// }
	// function list_category_noibat_timkiem($conn) {
	// 	$skin = $this->load('class_skin');
	// 	$list = '';

	// 	// Tìm danh mục cha có tiêu đề "Điện tử - điện máy" (bỏ qua chữ hoa/thường)
	// 	$query_parent = "SELECT * FROM category_sanpham WHERE LOWER(cat_tieude) = LOWER('Điện tử - điện máy') LIMIT 1";
	// 	$result_parent = mysqli_query($conn, $query_parent);

	// 	if ($parent = mysqli_fetch_assoc($result_parent)) {
	// 		$parent_id = $parent['cat_id'];

	// 		// Lấy danh sách danh mục con của danh mục cha tìm được
	// 		$query_children = "SELECT * FROM category_sanpham WHERE cat_main = '$parent_id' ORDER BY cat_thutu ASC LIMIT 4";
	// 		$result_children = mysqli_query($conn, $query_children);

	// 		while ($child = mysqli_fetch_assoc($result_children)) {
	// 			$list .= $skin->skin_replace('skin/box_li/li_danhmuc_noibat_timkiem', $child);
	// 		}

	// 		mysqli_free_result($result_children);
	// 	}

	// 	mysqli_free_result($result_parent);
	// 	return $list;
	// }
	function list_category_noibat_timkiem($conn)
	{
		$skin = $this->load('class_skin');

		$check = $this->load('class_check');
		$list = '';

		// Tìm danh mục cha có tiêu đề "Điện tử - điện máy"
		$query_parent = "SELECT * FROM category_sanpham WHERE LOWER(cat_tieude) = LOWER('Điện tử - điện máy') LIMIT 1";
		$result_parent = mysqli_query($conn, $query_parent);

		if ($parent = mysqli_fetch_assoc($result_parent)) {
			$parent_id = $parent['cat_id'];

			// Lấy danh sách danh mục con của danh mục cha
			$query_children = "SELECT * FROM category_sanpham WHERE cat_main = '$parent_id' ORDER BY cat_thutu ASC LIMIT 4";
			$result_children = mysqli_query($conn, $query_children);

			while ($child = mysqli_fetch_assoc($result_children)) {
				$cat_id = $child['cat_id'];

				// Lấy sản phẩm có mức giảm giá cao nhất trong danh mục con
				$query_sale = "SELECT *, (gia_cu - gia_moi) / gia_cu * 100 AS discount 
							   FROM sanpham 
							   WHERE FIND_IN_SET('$cat_id', cat) > 0 
							   ORDER BY discount DESC 
							   LIMIT 1";
				$result_sale = mysqli_query($conn, $query_sale);

				if ($highest_sale = mysqli_fetch_assoc($result_sale)) {
					if ($highest_sale['gia_cu'] > 0 && $highest_sale['gia_moi'] > 0) {
						$giam = round(($highest_sale['gia_cu'] - $highest_sale['gia_moi']) / $highest_sale['gia_cu'] * 100);
						$child['label_sale'] = '<div class="label_product_timkiem"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$child['label_sale'] = '';
					}
				} else {
					$child['label_sale'] = ''; // Nếu không có sản phẩm giảm giá
				}

				mysqli_free_result($result_sale);

				// Thêm vào danh sách hiển thị
				$list .= $skin->skin_replace('skin/box_li/li_danhmuc_noibat_timkiem', $child);
			}

			mysqli_free_result($result_children);
		}

		mysqli_free_result($result_parent);
		return $list;
	}


	function list_category_noibat($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_noibat='1' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .= $skin->skin_replace('skin/box_li/li_danhmuc_noibat', $r_tt);
		}
		mysqli_free_result($thongtin);
		return $list;
	}


	//////////////////////////////////////////////////////////////////
	function list_xuhuong($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT DISTINCT cs.* FROM category_sanpham cs INNER JOIN sanpham sp ON FIND_IN_SET(cs.cat_id,sp.cat)>0 WHERE cs.cat_trend='1' ORDER BY rand() ASC LIMIT 4");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$cat_id = $r_tt['cat_id'];
			$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>'0' AND gia_moi>'1000' AND FIND_IN_SET($cat_id,cat)>0 ORDER BY gia_moi ASC LIMIT 1");
			$r_sp = mysqli_fetch_assoc($thongtin_sanpham);
			$r_tt['minh_hoa'] = $r_tt['cat_img'];
			$r_tt['gia'] = number_format($r_sp['gia_moi']);
			$list .= $skin->skin_replace('skin/box_li/li_danhmuc_xuhuong', $r_tt);
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_option_danhmuc($conn, $category)
	{
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	///////////////////
	function list_sanpham_deal($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND box_flash='1' ORDER BY box_flash DESC, (gia_cu - gia_moi) DESC LIMIT $limit");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
				$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
				$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
			} else {
				$r_sp['label_sale'] = '';
			}
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			if ($r_sp['kho'] > 50) {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_sp['kho'] . '</b> sản phẩm</div>';
			} else {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
			}
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_sp['loai'] = 'flash_sale';
				} else {
					$r_sp['loai'] = 'muakem';
				}
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_muakem', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
				$r_sp['loai'] = 'tang';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_tang', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				}
				$r_sp['loai'] = 'flash_sale';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal', $r_sp);
			} else {
				$r_sp['loai'] = '';
				$r_sp['frame'] = '';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_deal_index($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT s.*,p.id AS pl FROM sanpham as s LEFT JOIN phanloai_sanpham as p on s.id = p.sp_id  WHERE s.kho>0 AND s.box_flash='1' AND s.gia_moi = p.gia_moi GROUP BY s.id ORDER BY s.box_flash DESC, (s.gia_cu - s.gia_moi) DESC LIMIT $limit ");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			$r_sp['giam'] = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			if ($r_sp['kho'] > 5) {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">Còn <b class="flashsale__sold-qty">' . $r_sp['kho'] . '</b></div>';
			} else {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết</div>';
			}
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (isset($list_c[$id_sp])) {
				$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
			}
			$r_sp['loai'] = 'flash_sale';
			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
			$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal_index', $r_sp);
		}
		return $list;
	}
	function list_sanpham_deal_cart_emty($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND box_flash='1' ORDER BY box_flash DESC, (gia_cu - gia_moi) DESC LIMIT $limit");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			$r_sp['giam'] = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			if ($r_sp['kho'] > 50) {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_sp['kho'] . '</b> sản phẩm</div>';
			} else {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
			}
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (isset($list_c[$id_sp])) {
				$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
			}
			$r_sp['loai'] = 'flash_sale';
			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
			$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal_shopcart_emty', $r_sp);
		}
		return $list;
	}
	///////////////////
	function list_deal_soc($conn, $list_flashsale_id, $list_tang, $list_muakem, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$list_id = array_unique($tach_list_flashsale_id);
		$list_id = implode(',', $list_id);

		$tach_list_tang_id = explode(',', $list_tang);
		$list_tang_id = array_unique($tach_list_tang_id);
		$tach_list_muakem_id = explode(',', $list_muakem);
		$list_muakem_id = array_unique($tach_list_muakem_id);
		$start = $page * $limit - $limit;
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC LIMIT $start,$limit");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$giam = ceil((($r_sp['gia_cu'] - (int)preg_replace('/[^0-9]/', '', $r_sp['gia_moi'])) / $r_sp['gia_cu']) * 100);
			$r_sp['gia_moi'] = number_format((int)preg_replace('/[^0-9]/', '', $r_sp['gia_moi']));
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['giam'] = $giam;
			$r_sp['so_luong'] = intval($list_c[$id_sp]['so_luong']);
			$tach_date_start = explode(' ', $list_c[$id_sp]['date_start']);
			$tach_time_start = explode(':', $tach_date_start[0]);
			$tach_ngay_start = explode('/', $tach_date_start[1]);
			$date_start = mktime((int)$tach_time_start[0], (int)$tach_time_start[1], 0, (int)$tach_ngay_start[1], (int)$tach_ngay_start[0], (int)$tach_ngay_start[2]);
			$tach_date_end = explode(' ', $list_c[$id_sp]['date_end']);
			$tach_time_end = explode(':', $tach_date_end[0]);
			$tach_ngay_end = explode('/', $tach_date_end[1]);
			$date_end = mktime((int)$tach_time_end[0], (int)$tach_time_end[1], 0, (int)$tach_ngay_end[1], (int)$tach_ngay_end[0], (int)$tach_ngay_end[2]);
			$r_sp['time_start'] = $date_start - time();
			$r_sp['time'] = $date_end - time();
			if ($r_sp['time_start'] > 0) {
				$r_sp['text'] = 'Bắt đầu sau';
			} else {
				$r_sp['text'] = 'Còn';
			}
			if (in_array($id_sp, $list_tang_id) == true and in_array($id_sp, $list_muakem_id) == true) {
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal_soc_tangmua', $r_sp);
			} else if (in_array($id_sp, $list_tang_id) == true) {
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal_soc_tang', $r_sp);
			} else if (in_array($id_sp, $list_muakem_id) == true) {
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_deal_soc_muakem', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_flash_sale($conn, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$list_id = array_unique($tach_list_flashsale_id);
		$list_id = implode(',', $list_id);
		$start = $page * $limit - $limit;
		$hientai = time();
		foreach ($list_c as $key => $value) {
			$id_x = $value['sp_id'];
			$ok_x = 0;
			foreach ($value['list_pl'] as $k => $v) {
				if ($v['so_luong'] > 0) {
					$ok_x = 1;
					if (!isset($list_pl[$id_x])) {
						$list_pl[$id_x] = $v;
					}
				}
			}
			if ($ok_x == 0) {
				$list_pl[$id_x] = $value['list_pl'][0];
			}
		}
		if ($list_id == '') {
			$list = '';
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC LIMIT $start,$limit");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				$id_sp = $r_sp['id'];
				$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE loai='flash_sale' AND FIND_IN_SET($id_sp,main_product)>0 AND date_end>='$hientai' AND date_start<='$hientai' ORDER BY id DESC LIMIT 1");
				$r_d = mysqli_fetch_assoc($thongtin_deal);
				if ($list_pl[$id_sp]['gia_cu'] == 0) {
					$giam = '100';
				} else {
					$giam = ceil(((preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu']) - (int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia'])) / preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu'])) * 100);
				}
				$r_sp['gia_moi'] = number_format((int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia']));
				$r_sp['gia_cu'] = number_format((int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu']));
				$r_sp['giam'] = $giam;
				$r_sp['so_luong'] = intval($list_pl[$id_sp]['so_luong']);
				$date_start = $r_d['date_start'];
				$date_end = $r_d['date_end'];
				$r_sp['time_start'] = $date_start - time();
				$r_sp['time'] = $date_end - time();
				if ($r_sp['time_start'] > 0) {
					$r_sp['text'] = 'Bắt đầu sau';
				} else {
					$r_sp['text'] = 'Còn';
				}
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_flash_sale', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_sieu_sale($conn, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$list_id = array_unique($tach_list_flashsale_id);
		$list_id = implode(',', $list_id);
		$start = $page * $limit - $limit;
		foreach ($list_c as $key => $value) {
			$id_x = $value['sp_id'];
			$ok_x = 0;
			foreach ($value['list_pl'] as $k => $v) {
				if ($v['so_luong'] > 0) {
					$ok_x = 1;
					if (!isset($list_pl[$id_x])) {
						$list_pl[$id_x] = $v;
					}
				}
			}
			if ($ok_x == 0) {
				$list_pl[$id_x] = $value['list_pl'][0];
			}
		}
		if ($list_id == '') {
			$list = '';
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC LIMIT $start,$limit");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				$id_sp = $r_sp['id'];
				$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE loai='flash_sale' AND FIND_IN_SET($id_sp,main_product)>0 ORDER BY id DESC LIMIT 1");
				$r_d = mysqli_fetch_assoc($thongtin_deal);
				if ($list_pl[$id_sp]['gia_cu'] == 0) {
					$giam = 100;
				} else {
					$giam = ceil(((preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu']) - (int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia'])) / preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu'])) * 100);
				}

				$r_sp['gia_moi'] = number_format((int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia']));
				$r_sp['gia_cu'] = number_format((int)preg_replace('/[^0-9]/', '', $list_pl[$id_sp]['gia_cu']));
				$r_sp['giam'] = $giam;
				$r_sp['so_luong'] = intval($list_pl[$id_sp]['so_luong']);
				$date_start = $r_d['date_start'];
				$date_end = $r_d['date_end'];
				$r_sp['time_start'] = $date_start - time();
				$r_sp['time'] = $date_end - time();
				if ($r_sp['time_start'] > 0) {
					$r_sp['text'] = 'Bắt đầu sau';
				} else {
					$r_sp['text'] = 'Còn';
				}
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_sieu_sale', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_coupon($conn, $ma, $giam, $loai, $start, $expired, $list_id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($list_id == '') {
			$list = '';
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE/* kho>0 AND */id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				$id_sp = $r_sp['id'];
				$r_sp['time_start'] = $start - time();
				$r_sp['time'] = $expired - time();
				if ($r_sp['time_start'] > 0) {
					$r_sp['text'] = 'Bắt đầu sau';
				} else {
					$r_sp['text'] = 'Còn';
				}
				$r_sp['ma'] = $ma;
				if ($loai == 'tru') {
					$r_sp['giam'] = number_format($giam / 1000) . 'K';
				} else {
					$r_sp['giam'] = number_format($giam) . '%';
				}
				$r_sp['expired'] = date('H:i d/m/Y', $expired);
				$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
				$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
				$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_coupon', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_coupon($conn, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$list_id = array_unique($tach_list_flashsale_id);
		$list_id = implode(',', $list_id);
		$start = $page * $limit - $limit;
		$hientai = time();
		$thongtin = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='0' AND start<'$hientai' AND expired>='$hientai' AND kieu!='baohanh' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['expired'] = date('d/m/Y', $r_tt['expired']);
			if ($r_tt['loai'] == 'tru') {
				$r_tt['giam'] = number_format($r_tt['giam']) . 'đ';
			} else if ($r_tt['loai'] == 'phantram') {
				$r_tt['giam'] = $r_tt['giam'] . '%';
			}
			$list .= $skin->skin_replace('skin/box_li/li_coupon', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_banchay($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 ORDER BY box_banchay DESC, id DESC LIMIT 8");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
				$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
				$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
			} else {
				$r_sp['label_sale'] = '';
			}
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			if ($r_sp['kho'] > 50) {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_sp['kho'] . '</b> sản phẩm</div>';
			} else {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
			}
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_sp['loai'] = 'flash_sale';
				} else {
					$r_sp['loai'] = 'muakem';
				}
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_banchay_muakem', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
				$r_sp['loai'] = 'tang';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_banchay_tang', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				}
				$r_sp['loai'] = 'flash_sale';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_banchay_deal', $r_sp);
			} else {
				$r_sp['loai'] = '';
				$r_sp['frame'] = '';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_banchay', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_sub($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $cat_id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 ORDER BY id DESC LIMIT 8");
		$i = 0; // số lượng ảo
		$today = date('Ymd');
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$i++;
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
				$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
				$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
			} else {
				$r_sp['label_sale'] = '';
			}
			// Số lượng ảo cố định dựa trên ID sản phẩm
			srand($r_sp['id']);
			$total_sold = rand(200, 500);


			$start_date = "20250312";
			$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));

			srand($r_sp['id'] + $days_passed);
			$random_increment = rand(1, 5);


			$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));


			$r_sp['total'] = $total_sold;
			$r_sp['sold'] = $sold_today;

			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
		}
		return json_encode(array('total' => $i, 'list' => $list_sp));
	}
	///////////////////
	function list_sanpham_noibat($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 ORDER BY box_noibat DESC, view DESC LIMIT 8");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
				$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
				$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
			} else {
				$r_sp['label_sale'] = '';
			}
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			if ($r_sp['kho'] > 50) {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_sp['kho'] . '</b> sản phẩm</div>';
			} else {
				$r_sp['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
			}
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
					$r_sp['loai'] = 'flash_sale';
				} else {
					$r_sp['loai'] = 'muakem';
				}
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_noibat_muakem', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
				$r_sp['loai'] = 'tang';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_noibat_tang', $r_sp);
			} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
				if (isset($list_c[$id_sp])) {
					$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				}
				$r_sp['loai'] = 'flash_sale';
				$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_noibat_deal', $r_sp);
			} else {
				$r_sp['loai'] = '';
				$r_sp['frame'] = '';
				$list .= $skin->skin_replace('skin/box_li/li_sanpham_noibat', $r_sp);
			}
		}
		return $list;
	}
	///////////////////
	function list_box($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_index='1' ORDER BY cat_thutu ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC LIMIT 3");
			$s = 0;
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub > 0) {
				while ($r_sub = mysqli_fetch_assoc($thongtin_sub)) {
					$s++;
					if ($s == 1) {
						$cat_id = $r_tt['cat_id'];
						// số lượng ảo
						$today = date('Ymd');
						$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 ORDER BY id DESC LIMIT 10");
						while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
							$id_sp = $r_sp['id'];
							$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
							if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
								$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
								$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
							} else {
								$r_sp['label_sale'] = '';
							}
							// Số lượng ảo cố định dựa trên ID sản phẩm
							srand($id_sp);
							$total_sold = rand(200, 500);


							$start_date = "20250312";
							$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));


							srand($id_sp + $days_passed);
							$random_increment = rand(1, 5);


							$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));


							$r_sp['total'] = $total_sold;
							$r_sp['sold'] = $sold_today;


							$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
							$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
							$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
							if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
								if (isset($list_c[$id_sp])) {
									$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
									$r_sp['loai'] = 'flash_sale';
								} else {
									$r_sp['loai'] = 'muakem';
								}
								$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
								$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_muakem', $r_sp);
							} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
								$r_sp['loai'] = 'tang';
								$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
								$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_tang', $r_sp);
							} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
								if (isset($list_c[$id_sp])) {
									$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
								}
								$r_sp['loai'] = 'flash_sale';
								$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
								$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_deal', $r_sp);
							} else {
								$r_sp['loai'] = '';
								$r_sp['frame'] = '';
								$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
							}
						}
						$r_tt['list_sanpham'] = $list_sp;
						unset($list_sp);
						//$list_sub.='<li class="current load_product_sub" cat_id="'.$r_sub['cat_id'].'">'.$r_sub['cat_tieude'].'</li>';
						$list_sub .= '<li class="load_product_sub" cat_id="' . $r_sub['cat_id'] . '">' . $r_sub['cat_tieude'] . '</li>';
					} else {
						$list_sub .= '<li class="load_product_sub" cat_id="' . $r_sub['cat_id'] . '">' . $r_sub['cat_tieude'] . '</li>';
					}
				}
			} else {
				$list_sub = '';
				$cat_id = $r_tt['cat_id'];
				// số lượng ảo
				$today = date('Ymd');
				$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 ORDER BY id DESC LIMIT 8");
				while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
					$id_sp = $r_sp['id'];
					$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
					if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
						$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
						$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sp['label_sale'] = '';
					}
					// Số lượng ảo cố định dựa trên ID sản phẩm
					srand($id_sp);
					$total_sold = rand(200, 500);


					$start_date = "20250312";
					$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));


					srand($id_sp + $days_passed);
					$random_increment = rand(1, 5);


					$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));


					$r_sp['total'] = $total_sold;
					$r_sp['sold'] = $sold_today;

					$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
					$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
					$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
					if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
						if (isset($list_c[$id_sp])) {
							$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
							$r_sp['loai'] = 'flash_sale';
						} else {
							$r_sp['loai'] = 'muakem';
						}
						$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
						$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_muakem', $r_sp);
					} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
						$r_sp['loai'] = 'tang';
						$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
						$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_tang', $r_sp);
					} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
						if (isset($list_c[$id_sp])) {
							$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
						}
						$r_sp['loai'] = 'flash_sale';
						$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
						$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_deal', $r_sp);
					} else {
						$r_sp['loai'] = '';
						$r_sp['frame'] = '';
						$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
					}
				}
				$r_tt['list_sanpham'] = $list_sp;
				unset($list_sp);
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['list_sub'] = $list_sub;
			unset($list_sub);
			if (strlen($r_tt['cat_img']) > 5) {
				$list .= $skin->skin_replace('skin/box_index_banner', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin/box_index', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_box_index($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_list_muakem_id = explode(',', $list_muakem_id);
		$tach_list_tang_id = explode(',', $list_tang_id);
		$tach_list_flashsale_id = explode(',', $list_flashsale_id);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_index='1' ORDER BY cat_thutu ASC");
		$i = 0;
		// số lượng ảo
		$today = date('Ymd');
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$cat_id = $r_tt['cat_id'];
			$thongtin_sanpham = mysqli_query($conn, "SELECT *,((gia_cu - gia_moi) / gia_cu) * 100 AS giam_gia FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 ORDER BY giam_gia DESC LIMIT 10");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				$id_sp = $r_sp['id'];
				$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
				if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
					$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
					$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
				} else {
					$r_sp['label_sale'] = '';
				}
				// Số lượng ảo cố định dựa trên ID sản phẩm
				srand($id_sp);
				$total_sold = rand(200, 500);


				$start_date = "20250312";
				$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));


				srand($id_sp + $days_passed);
				$random_increment = rand(1, 5);


				$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));


				$r_sp['total'] = $total_sold;
				$r_sp['sold'] = $sold_today;




				$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
				$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
				$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
				$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
			}
			$r_tt['list_sanpham'] = $list_sp;
			unset($list_sp);
			if (strlen($r_tt['cat_img']) > 5) {
				$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC LIMIT 10");
			} else {
				$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC LIMIT 3");
			}
			$s = 0;
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub > 0) {
				while ($r_sub = mysqli_fetch_assoc($thongtin_sub)) {
					if ($s % 2 == 0) {
						$list_sub_box .= '<div class="li_category">';
					}
					$s++;
					$list_sub .= '<li class="load_product_sub" cat_id="' . $r_sub['cat_id'] . '"><a href="/san-pham/' . $r_sub['cat_blank'] . '.html">' . $r_sub['cat_tieude'] . '</a></li>';
					$list_sub_box .= '<div class="li_danhmuc">
										<a href="/san-pham/' . $r_sub['cat_blank'] . '.html">
											<div class="minh_hoa">
												<img src="' . $r_sub['cat_minhhoa'] . '" onerror="this.src=\'/skin/css/images/load.png\'" alt="' . $r_sub['cat_tieude'] . '">
											</div>                        
											<div class="tieu_de">' . $r_sub['cat_tieude'] . '</div>
										</a>
									</div>';
					if ($s % 2 == 0 or $s == $total_sub) {
						$list_sub_box .= '</div>';
					}
				}
			} else {
				$list_sub = '';
				$list_sub_box = '';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['list_sub'] = $list_sub;
			$r_tt['list_sub_box'] = $list_sub_box;
			if (strlen($r_tt['cat_img']) > 5 and strlen($list_sub) > 5) {
				$list .= $skin->skin_replace('skin/box_index_banner', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin/box_index', $r_tt);
			}
			unset($list_sub);
			unset($list_sub_box);
		}
		return $list;
	}
	///////////////////
	function list_slide($conn)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='0' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin/box_li/li_slide', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_brand($conn, $cat_id, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$list_thuonghieu = '';
		if ($cat_id == '') {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT thuong_hieu FROM sanpham");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['thuong_hieu'] != '') {
					$list_thuonghieu .= $r_sp['thuong_hieu'] . ',';
				}
			}
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT thuong_hieu FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 AND kho>'0'");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['thuong_hieu'] != '') {
					$list_thuonghieu .= $r_sp['thuong_hieu'] . ',';
				}
			}
		}
		if ($list_thuonghieu != '') {
			$list_thuonghieu = substr($list_thuonghieu, 0, -1);
			$thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='0' AND id IN ($list_thuonghieu) ORDER BY tieu_de ASC");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				if ($r_tt['id'] == $id) {
					// $list .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="brand-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?brand=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="brand-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?brand=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				} else {
					// $list .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="brand-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?brand=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="brand-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?brand=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				}
			}
			return json_encode(array('list' => $list, 'list_mobile' => $list_mobile));
		} else {
			return json_encode(array('list' => '', 'list_mobile' => ''));
		}
	}
	///////////////////
	function list_color($conn, $cat_id, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($cat_id == '') {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT mau FROM sanpham");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['mau'] != '') {
					$list_mau .= $r_sp['mau'] . ',';
				}
			}
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT mau FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['mau'] != '') {
					$list_mau .= $r_sp['mau'] . ',';
				}
			}
		}
		if ($list_mau != '') {
			$list_mau = substr($list_mau, 0, -1);
			$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN ($list_mau) ORDER BY tieu_de ASC");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				if ($r_tt['id'] == $id) {
					// $list .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="color-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?color=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="color-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?color=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				} else {
					// $list .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="color-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?color=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="color-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?color=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				}
			}
			return json_encode(array('list' => $list, 'list_mobile' => $list_mobile));
		} else {
		}
	}
	///////////////////
	function list_size($conn, $cat_id, $id)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($cat_id == '') {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT size FROM sanpham");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['size'] != '') {
					$list_size .= $r_sp['size'] . ',';
				}
			}
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT DISTINCT size FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0");
			while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
				if ($r_sp['size'] != '') {
					$list_size .= $r_sp['size'] . ',';
				}
			}
		}
		if ($list_size != '') {
			$list_size = substr($list_size, 0, -1);
			$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE id IN ($list_size) ORDER BY tieu_de ASC");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				if ($r_tt['id'] == $id) {
					// $list .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="size-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?size=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="size-box selected" data-id="' . $r_tt['id'] . '" data-url="/san-pham?size=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				} else {
					// $list .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					// $list_mobile .= '<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
					$list .= '<div class="size-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?size=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
					$list_mobile .= '<div class="size-box" data-id="' . $r_tt['id'] . '" data-url="/san-pham?size=' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				}
			}
			return json_encode(array('list' => $list, 'list_mobile' => $list_mobile));
		} else {
		}
	}
	///////////////////
	function list_khoang_gia($conn, $price)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM khoang_gia ORDER BY thu_tu ASC");
		$i = $start;
		$tach_id = explode('*', $id);
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['kieu'] == 'nho') {
				$r_tt['khoang'] = '<span>Dưới</span> ' . number_format($r_tt['max_price']) . '₫';
				$r_tt['price'] = '0-' . $r_tt['max_price'];
			} else if ($r_tt['kieu'] == 'lon') {
				$r_tt['khoang'] = '<span>Trên</span> ' . number_format($r_tt['min_price']) . '₫';
				$r_tt['price'] = $r_tt['min_price'] . '-999999999999';
			} else {
				$r_tt['khoang'] = number_format($r_tt['min_price']) . '₫ - ' . number_format($r_tt['max_price']) . '₫';
				$r_tt['price'] = $r_tt['min_price'] . '-' . $r_tt['max_price'];
			}
			if ($r_tt['price'] == $price) {
				// $list .= '<option value="'.$r_tt['price'].'" selected>'.$r_tt['khoang'].'</option>';
				// $list_mobile .= '<option value="'.$r_tt['price'].'" selected>'.$r_tt['khoang'].'</option>';
				$list .= '<div class="price-box_nhat selected" data-price="' . $r_tt['price'] . '" data-url="/san-pham?price=' . $r_tt['id'] . '">' . $r_tt['khoang'] . '</div>';
				$list_mobile .= '<div class="price-box_nhat selected" data-price="' . $r_tt['price'] . '" data-url="/san-pham?price=' . $r_tt['id'] . '">' . $r_tt['khoang'] . '</div>';
			} else {
				// $list .= '<option value="'.$r_tt['price'].'">'.$r_tt['khoang'].'</option>';
				// $list_mobile .= '<option value="'.$r_tt['price'].'">'.$r_tt['khoang'].'</option>';
				$list .= '<div class="price-box_nhat" data-price="' . $r_tt['price'] . '" data-url="/san-pham?price=' . $r_tt['id'] . '">' . $r_tt['khoang'] . '</div>';
				$list_mobile .= '<div class="price-box_nhat" data-price="' . $r_tt['price'] . '" data-url="/san-pham?price=' . $r_tt['id'] . '">' . $r_tt['khoang'] . '</div>';
			}
		}
		return json_encode(array('list' => $list, 'list_mobile' => $list_mobile));
	}
	///////////////////
	function list_tintuc_index($conn, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC LIMIT $limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$cat = $r_tt['cat'];
			if ($cat == '') {
				$list_cat = '';
			} else {
				$thongtin_cat = mysqli_query($conn, "SELECT * FROM category WHERE cat_id IN ($cat) ORDER BY cat_thutu ASC");
				while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
					$list_cat .= $r_c['cat_tieude'] . ',';
				}
				$list_cat = substr($list_cat, 0, -1);
			}
			$r_tt['list_cat'] = $list_cat;
			unset($list_cat);
			if ($i == 1) {
				$r_tt['trich'] = $check->words($r_tt['noidung'], 30);
				$list['big'] .= $skin->skin_replace('skin/box_li/li_tintuc_index', $r_tt);
			} else {
				$r_tt['trich'] = $check->words($r_tt['noidung'], 25);
				$list['small'] .= $skin->skin_replace('skin/box_li/li_tintuc_index_small', $r_tt);
			}
		}
		return json_encode($list);
	}
	//////////////////////////////
	function list_baiviet_right($conn, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$cat = 'cat' . $id;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC LIMIT $limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich'] = $check->words($r_tt['noidung'], 35);
			$list .= $skin->skin_replace('skin/box_li/li_tintuc_right', $r_tt);
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	//////////////////////////////
	function list_baiviet_category($conn, $id, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$cat = 'cat' . $id;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE FIND_IN_SET($id,cat)>0 ORDER BY id DESC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$thongtin_cat = mysqli_query($conn, "SELECT * FROM category WHERE cat_id IN ({$r_tt['cat']}) ORDER BY cat_thutu ASC");
			while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
				$list_cat .= '<a href="/bai-viet/' . $r_c['cat_blank'] . '.html">' . $r_c['cat_tieude'] . '</a>, ';
			}
			$list_cat = substr($list_cat, 0, -2);
			$r_tt['list_cat'] = $list_cat;
			unset($list_cat);
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich'] = $check->words($r_tt['noidung'], 35);
			$list .= $skin->skin_replace('skin/box_li/li_tintuc', $r_tt);
		}
		mysqli_free_result($thongtin);
		$info = array(
			'total' => $i,
			'list' => $list,
		);
		return json_encode($info);
	}
	//////////////////////////////
	function list_sanpham_lienquan($conn, $id, $cat, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id IN ($cat) AND cat_main>0");
		$total_cat = mysqli_num_rows($thongtin_cat);
		if ($total_cat == 0) {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id!='$id' AND kho>'0' ORDER BY id DESC LIMIT $limit");
		} else {
			if ($total_cat == 1) {
				$r_c = mysqli_fetch_assoc($thongtin_cat);
				$c_cat = $r_c['cat_id'];
				$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE FIND_IN_SET($c_cat,cat)>0 AND id!='$id' AND kho>'0' ORDER BY id DESC LIMIT $limit");
			} else {
				$n = 0;
				while ($r_c = mysqli_fetch_assoc($thongtin_cat)) {
					$n++;
					$c_cat = $r_c['cat_id'];
					if ($i == 0) {
						$where .= "(FIND_IN_SET($c_cat,cat)>0 ";
					} else {
						$where .= "OR FIND_IN_SET($c_cat,cat)>0 ";
					}
				}
				$where = $where . ")";
				$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND id!='$id' ORDER BY id DESC LIMIT $limit");
			}
		}
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
				$giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
				$r_tt['label_sale'] = '<div class="label_product"><div class="label_wrapper">' . $giam . '%</div></div>';
			} else {
				$r_tt['label_sale'] = '';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$list .= $skin->skin_replace('skin/box_li/li_sanpham_lienquan', $r_tt);
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	//////////////////////////////
	function list_lienquan($conn, $id, $cat, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if (strpos($cat, ',') !== false) {
			$tach_cat = explode(',', $cat);
			$total_cat = count($tach_cat);
			for ($i = 0; $i < $total_cat; $i++) {
				if ($i == 0) {
					$where .= "(FIND_IN_SET($tach_cat[$i],cat)>0 ";
				} else {
					if ($tach_cat[$i] == '') {
					} else {
						$where .= "OR FIND_IN_SET($tach_cat[$i],cat)>0 ";
					}
				}
			}
			$where = $where . ")";
		} else {
			$where = "FIND_IN_SET($cat,cat)>0";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE $where AND id!='$id' ORDER BY id DESC LIMIT $limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich'] = $check->words($r_tt['noidung'], 80);
			$list .= $skin->skin_replace('skin/box_li/li_baiviet', $r_tt);
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	///////////////////
	function list_timkiem($conn, $key, $page, $limit)
	{
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE tieu_de LIKE '%$key%' ORDER BY tieu_de ASC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich'] = $check->words($r_tt['noidung'], 80);
			$list .= $skin->skin_replace('skin/box_li/li_baiviet', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		$info = array(
			'total' => $i,
			'list' => $list,
		);
		return json_encode($info);
	}
	///////////////////
	function list_sanpham_daxem($conn, $list_id, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT s.*, p.id as pl FROM sanpham s LEFT JOIN phanloai_sanpham p on s.id = p.sp_id WHERE s.id IN ($list_id) ORDER BY rand() ASC LIMIT $limit");


		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;

			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
				$giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
				$r_tt['label_sale'] = '<div class="label_product"><div class="label_wrapper">' . $giam . '%</div></div>';
			} else {
				$r_tt['label_sale'] = '';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$list .= $skin->skin_replace('skin/box_li/li_daxem', $r_tt);
			$list_daxem_cart_emty .= $skin->skin_replace('skin/box_li/li_daxem_cart_emty', $r_tt);
		}
		return $list;
	}
	//////////////////////////
	function list_top_deal_soc($conn, $cat_id, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if ($cat_id == '') {
			$thongtin_sanpham = mysqli_query($conn, "SELECT *,((gia_cu - gia_moi) / gia_cu) * 100 AS giam_gia FROM sanpham WHERE kho>'0' ORDER BY giam_gia DESC LIMIT $limit");
		} else {
			$thongtin_sanpham = mysqli_query($conn, "SELECT *,((gia_cu - gia_moi) / gia_cu) * 100 AS giam_gia FROM sanpham WHERE FIND_IN_SET($cat_id,cat)>0 AND kho>'0' ORDER BY giam_gia DESC LIMIT $limit");
		}
		$i = 0;
		// số lượng ảo
		$today = date('Ymd');
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
				$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
				$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
			} else {
				$r_sp['label_sale'] = '';
			}
			// Số lượng ảo cố định dựa trên ID sản phẩm
			srand($id_sp);
			$total_sold = rand(200, 500);


			$start_date = "20250312";
			$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));


			srand($id_sp + $days_passed);
			$random_increment = rand(1, 5);


			$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));


			$r_sp['total'] = $total_sold;
			$r_sp['sold'] = $sold_today;

			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			$r_sp['loai'] = '';
			$r_sp['frame'] = '';
			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
		}
		return $list_sp;
	}
	//////////////////////////
	function list_timkiem_nhieu($conn, $cat_id, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM timkiem_nhieu WHERE cat='$cat_id' ORDER BY tieu_de DESC LIMIT $limit");
		$i = 0;
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$list_sp .= $skin->skin_replace('skin/box_li/li_timkiem_nhieu', $r_sp);
		}
		return $list_sp;
	}


	// //////////////////////////
	// function list_sanpham_timkiem($conn, $where, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $order, $page, $limit)
	// {
	// 	$skin = $this->load('class_skin');
	// 	$check = $this->load('class_check');
	// 	$start = $page * $limit - $limit;
	// 	$tach_list_muakem_id = explode(',', $list_muakem_id);
	// 	$tach_list_tang_id = explode(',', $list_tang_id);
	// 	$tach_list_flashsale_id = explode(',', $list_flashsale_id);

	// 	if (strlen($where) < 5) {
	// 		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY $order LIMIT $start,$limit");
	// 	} else {
	// 		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE " . $where . " ORDER BY $order LIMIT $start,$limit");
	// 	}
	// 	$i = 0;
	// 	$today = date('Ymd');
	// 	while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
	// 		$id_sp = $r_sp['id'];
	// 		$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
	// 		if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
	// 			$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
	// 			$r_sp['label_sale'] = '<div class="label_product">
	//     <div class="label_wrapper">-' . $giam . '%</div>
	// </div>';
	// 		} else {
	// 			$r_sp['label_sale'] = '';
	// 		} // Số lượng ảo cố định dựa trên ID sản phẩm srand($id_sp);
	// 		$total_sold = rand(200, 500);
	// 		$start_date = "20250312";
	// 		$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));
	// 		srand($id_sp + $days_passed);
	// 		$random_increment = rand(1, 5);
	// 		$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));
	// 		$r_sp['total'] = $total_sold;
	// 		$r_sp['sold'] = $sold_today;
	// 		$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
	// 		$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
	// 		$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
	// 		if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
	// 			if (isset($list_c[$id_sp])) {
	// 				$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
	// 				$r_sp['loai'] = 'flash_sale';
	// 			} else {
	// 				$r_sp['loai'] = 'muakem';
	// 			}
	// 			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
	// 			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_muakem', $r_sp);
	// 		} else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
	// 			$r_sp['loai'] = 'tang';
	// 			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_tang.png?v=113">';
	// 			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_tang', $r_sp);
	// 		} else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
	// 			if (isset($list_c[$id_sp])) {
	// 				$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
	// 			}
	// 			$r_sp['loai'] = 'flash_sale';
	// 			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
	// 			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index_deal', $r_sp);
	// 		} else {
	// 			$r_sp['loai'] = '';
	// 			$r_sp['frame'] = '';
	// 			$list_sp .= $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp);
	// 		}
	// 	}
	// 	return $list_sp;
	// }


	function list_sanpham_timkiem($conn, $where, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $order, $page, $limit)
	{
		$list_sp = '';
		$today = date('Y-m-d');
		$start = ($page - 1) * $limit;
		global $skin;

		if (preg_match('/FIND_IN_SET\((\d+),cat\)>0/', $where, $matches)) {
			$category_id = intval($matches[1]);
			$query_check_parent = "SELECT * FROM category_sanpham WHERE cat_id = $category_id AND cat_main = 0";
			$result_check_parent = mysqli_query($conn, $query_check_parent);

			if (mysqli_num_rows($result_check_parent) > 0) {
				$parent_category_id = $category_id;
				$query_subcategories = "
                SELECT cs.*, 
                    (SELECT COUNT(*) FROM sanpham WHERE FIND_IN_SET(cs.cat_id, cat) > 0) AS product_count
                FROM category_sanpham cs
                WHERE cs.cat_main = $parent_category_id
                ORDER BY product_count DESC
                LIMIT 5";
				$result_subcategories = mysqli_query($conn, $query_subcategories);

				while ($subcategory = mysqli_fetch_assoc($result_subcategories)) {
					$subcat_id = $subcategory['cat_id'];
					$subcat_title = $subcategory['cat_tieude'];
					$query_products = "SELECT * FROM sanpham WHERE FIND_IN_SET($subcat_id, cat) > 0 ORDER BY $order LIMIT $start, $limit";
					$result_products = mysqli_query($conn, $query_products);

					if (mysqli_num_rows($result_products) > 0) {
						$list_sp .= '<div class="subcategory-products-wrapper">';
						$list_sp .= '<button class="scroll-btn prev-btn"><i class="fas fa-chevron-left"></i></button>';
						$list_sp .= "<h4>$subcat_title</h4>";
						$list_sp .= '<div class="subcategory-products">';

						while ($r_sp = mysqli_fetch_assoc($result_products)) {
							$id_sp = $r_sp['id'];
							srand($id_sp);
							$total_sold = rand(200, 500);
							if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
								$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
								$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
							} else {
								$r_sp['label_sale'] = '';
							}
							$start_date = "20250312";
							$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));
							srand($id_sp + $days_passed);
							$random_increment = rand(1, 5);
							$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));

							$r_sp['total'] = $total_sold;
							$r_sp['sold'] = $sold_today;
							$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
							$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
							$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);

							if (in_array($r_sp['id'], explode(',', $list_muakem_id))) {
								$r_sp['loai'] = 'muakem';
								$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_muakem.png?v=113">';
								$list_sp .= '<div class="li_product">' . $skin->skin_replace('skin/box_li/li_sanpham_box_index_muakem', $r_sp) . '</div>';
							} else {
								$r_sp['loai'] = '';
								$r_sp['frame'] = '';
								$list_sp .= '<div class="li_product">' . $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp) . '</div>';
							}
						}

						$list_sp .= '</div>';
						$list_sp .= '<button class="scroll-btn next-btn"><i class="fas fa-chevron-right"></i></button>';
						$list_sp .= '</div>';
					}
				}
			} else {
				$query_products = "SELECT * FROM sanpham WHERE $where ORDER BY $order LIMIT $start, $limit";
				$result_products = mysqli_query($conn, $query_products);

				if (mysqli_num_rows($result_products) > 0) {
					// $list_sp .= '<div class="subcategory-products-wrapper">';
					// $list_sp .= '<button class="scroll-btn prev-btn"><i class="fas fa-chevron-left"></i></button>';
					// $list_sp .= '<div class="subcategory-products">';

					while ($r_sp = mysqli_fetch_assoc($result_products)) {
						$id_sp = $r_sp['id'];
						srand($id_sp);
						$total_sold = rand(200, 500);
						if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
							$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
							$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
						} else {
							$r_sp['label_sale'] = '';
						}
						$start_date = "20250312";
						$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));
						srand($id_sp + $days_passed);
						$random_increment = rand(1, 5);
						$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));

						$r_sp['total'] = $total_sold;
						$r_sp['sold'] = $sold_today;
						$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
						$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
						$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
						$list_sp .= '<div class="li_product">' . $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp) . '</div>';
					}
					// $list_sp .= '</div>';
					// $list_sp .= '</div>';
					// $list_sp .= '<button class="scroll-btn next-btn"><i class="fas fa-chevron-right"></i></button>';
					// $list_sp .= '</div>';
				}
			}
		} else {
			$query_products = "SELECT * FROM sanpham WHERE $where ORDER BY $order LIMIT $start, $limit";
			$result_products = mysqli_query($conn, $query_products);

			if (mysqli_num_rows($result_products) > 0) {
				// $list_sp .= '<div class="subcategory-products-wrapper">';
				// $list_sp .= '<button class="scroll-btn prev-btn"><i class="fas fa-chevron-left"></i></button>';
				// $list_sp .= '<div class="subcategory-products">';

				while ($r_sp = mysqli_fetch_assoc($result_products)) {
					$id_sp = $r_sp['id'];
					srand($id_sp);
					$total_sold = rand(200, 500);
					if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
						$giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
						$r_sp['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
					} else {
						$r_sp['label_sale'] = '';
					}
					$start_date = "20250312";
					$days_passed = (int)((strtotime($today) - strtotime($start_date)) / (60 * 60 * 24));
					srand($id_sp + $days_passed);
					$random_increment = rand(1, 5);
					$sold_today = min($total_sold, rand(20, 100) + ($days_passed * $random_increment));

					$r_sp['total'] = $total_sold;
					$r_sp['sold'] = $sold_today;
					$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
					$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
					$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
					$list_sp .= '<div class="li_product">' . $skin->skin_replace('skin/box_li/li_sanpham_box_index', $r_sp) . '</div>';
				}
				// $list_sp .= '</div>';
				// $list_sp .= '</div>';
				// $list_sp .= '<button class="scroll-btn next-btn"><i class="fas fa-chevron-right"></i></button>';
				// $list_sp .= '</div>';
			}
		}

		return $list_sp;
	}
	///////////////////


	function phantrang_sanpham($page, $total, $link)
	{
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 and $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}
			}
		}
	}
	///////////////////////
	function phantrang($page, $total, $link)
	{
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 and $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}
			}
		}
	}
	///////////////////////
	function phantrang_timkiem($page, $total, $link)
	{
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 and $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}
			}
		}
	}
	// Bạn cần định nghĩa hàm này trong class_index
	public function list_thanhvien_banhang($conn, $total, $page, $limit)
	{
		$start = ($page - 1) * $limit;
		$html = '';

		// Debug query
		error_log("Executing query with: total=$total, page=$page, limit=$limit, start=$start");

		$query = "SELECT u.*,
			(SELECT COUNT(*) FROM donhang WHERE user_id = u.user_id AND status NOT IN (3,4)) as total_orders,
			(SELECT SUM(thanhtien) FROM donhang WHERE user_id = u.user_id AND status NOT IN (3,4)) as total_revenue
		FROM user_info u 
		WHERE u.leader = '1'
		ORDER BY u.user_id DESC 
		LIMIT $start, $limit";

		$result = mysqli_query($conn, $query);
		if (!$result) {
			error_log("SQL Error: " . mysqli_error($conn));
			return "Lỗi truy vấn dữ liệu";
		}

		$stt = $total - $start;
		while ($row = mysqli_fetch_assoc($result)) {
			// Format date
			$date_post = $row['date_post'] ? date('d/m/Y', strtotime($row['date_post'])) : '';
			$date_contact = $row['date_contact'] ? date('d/m/Y', strtotime($row['date_contact'])) : 'Chưa liên hệ';

			// Format status
			$status_text = $this->getStatusText($row['status']);

			$html .= '<tr>
				<td style="text-align: center;" class="hide_mobile">' . $stt . '</td>
				<td style="text-align: left;">' . htmlspecialchars($row['name']) . '</td>
				<td style="text-align: center;" class="hide_mobile">' . htmlspecialchars($row['phone']) . '</td>
				<td style="text-align: center;" class="hide_mobile">' . htmlspecialchars($row['nhiem_vu'] ?? 'Chưa có') . '</td>
				<td style="text-align: center;" class="hide_mobile">' . $status_text . '</td>
				<td style="text-align: center;" class="hide_mobile">' . $date_post . '</td>
				<td style="text-align: center;" class="hide_mobile">' . $date_contact . '</td>
				<td style="text-align: center;">
					<a href="/admincp/member/' . $row['user_id'] . '" class="btn btn-info btn-sm">
						<i class="fas fa-eye"></i> Xem
					</a>
				</td>
			</tr>';

			$stt--;
		}

		// Debug output
		error_log("Generated HTML rows: " . substr($html, 0, 500));

		return $html ?: '<tr><td colspan="8" align="center">Chưa có thành viên nào</td></tr>';
	}
	///////////////////////////////////////////
	// huyphuc14/04/2025
	function list_thuong_hieu($conn, $page, $limit)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;

		// Lấy danh sách thương hiệu
		$thong_tin_thuong_hieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE status=1 LIMIT $start, $limit");

		$list = '';
		$items = [];
		$i = $start;

		// Lưu tất cả thương hiệu vào mảng
		while ($r_tt = mysqli_fetch_assoc($thong_tin_thuong_hieu)) {
			$i++;
			$r_tt['i'] = $i;
			$items[] = $r_tt;
		}

		// Nếu không có thương hiệu, trả về rỗng
		if (empty($items)) {
			return '';
		}

		// Kiểm tra thiết bị (mobile hay desktop)
		$is_mobile = false;
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$mobile_agents = ['Android', 'iPhone', 'iPad', 'iPod', 'webOS', 'BlackBerry', 'Windows Phone'];
			foreach ($mobile_agents as $agent) {
				if (stripos($user_agent, $agent) !== false) {
					$is_mobile = true;
					break;
				}
			}
		}

		// Thiết lập số lượng thương hiệu trên mỗi box và slide
		if ($is_mobile) {
			// Trên mobile: 2 ảnh mỗi box, 2 box mỗi slide (tổng 4 ảnh mỗi slide)
			$items_per_box = 2;
			$boxes_per_slide = 2;
		} else {
			// Trên desktop: 6 ảnh mỗi box, 2 box mỗi slide (tổng 12 ảnh mỗi slide)
			$items_per_box = 6;
			$boxes_per_slide = 2;
		}

		// Nhóm thương hiệu vào box
		$boxes = array_chunk($items, $items_per_box);

		// Nhóm box vào slide
		$slides = array_chunk($boxes, $boxes_per_slide);

		// Bắt đầu HTML của slider
		$list .= '<div class="swiper-wrapper">';

		foreach ($slides as $slide) {
			$list .= '<div class="swiper-slide">';
			$list .= '<div class="thuong-hieu-slide">';

			// Tạo từng box trong slide
			foreach ($slide as $box) {
				$list .= '<div class="thuong-hieu-box">';

				// Tạo từng thương hiệu trong box
				foreach ($box as $item) {
					$list .= $skin->skin_replace('skin/box_li/li_thuong_hieu', $item);
				}

				$list .= '</div>'; // Đóng box
			}

			$list .= '</div>'; // Đóng slide
			$list .= '</div>'; // Đóng swiper-slide
		}

		$list .= '</div>'; // Đóng swiper-wrapper

		return $list;
	}


	function list_home_goiy($conn, $limit = 0)
	{
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$default_limit = 20;
		$total_limit = $default_limit + (int)$limit;
		$one_month_ago = date('Ymd', strtotime('-3 month'));
		$thongtin_sanpham = mysqli_query($conn, "SELECT s.*,p.id AS pl FROM sanpham as s LEFT JOIN phanloai_sanpham as p on s.id = p.sp_id  WHERE s.kho>0 AND s.date_post >= UNIX_TIMESTAMP('$one_month_ago')  AND s.date_post <= UNIX_TIMESTAMP(NOW())  AND s.gia_moi = p.gia_moi GROUP BY s.id ORDER BY s.box_flash DESC, (s.gia_cu - s.gia_moi) DESC LIMIT  $total_limit");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
			$r_sp['giam'] = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
			$r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
			$phantram = 100 - ($r_sp['kho'] / 100) * 100;
			$r_sp['phantram'] = $phantram;
			if (isset($list_c[$id_sp])) {
				$r_sp['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
			}
			$r_sp['loai'] = 'flash_sale';
			$r_sp['frame'] = '<img class="product-frame" src="/skin/css/images/frame_flash_sale.png?v=113">';
			$list .= $skin->skin_replace('skin/box_li/li_sanpham_goiy_index', $r_sp);
		}
		return $list;
	}
}
