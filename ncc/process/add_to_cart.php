<?php
			$sp_id = intval($_REQUEST['sp_id']);
			$mau = addslashes(strip_tags($_REQUEST['mau']));
			$size = addslashes(strip_tags($_REQUEST['size']));
			$pl = intval($_REQUEST['pl']);
			$quantity = intval($_REQUEST['quantity']);
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham WHERE id='$sp_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Sản phẩm không tồn tại';
			} else if ($r_tt['kho'] < $quantity AND $kho == 'kho') {
				$ok = 0;
				$thongbao = 'Thất bại! Hàng trong kho không đủ';
			} else if ($r_tt['kho_hcm'] < $quantity AND $kho == 'kho_hcm') {
				$ok = 0;
				$thongbao = 'Thất bại! Hàng trong kho không đủ';
			} else {
				$ok = 1;
				$thongbao = 'Thêm vào giỏ hàng thành công';
				if (isset($_SESSION['drop_cart'][$sp_id]) AND $quantity > 1) {
					$_SESSION['drop_cart'][$sp_id]['quantity'] = $quantity;
					$_SESSION['drop_cart'][$sp_id]['size'] = $size;
					$_SESSION['drop_cart'][$sp_id]['color'] = $mau;
					$_SESSION['drop_cart'][$sp_id]['kho'] = $kho;
					$_SESSION['drop_cart'][$sp_id]['pl'] = $pl;
				} else {
					$_SESSION['drop_cart'][$sp_id]['quantity'] = 1;
					$_SESSION['drop_cart'][$sp_id]['size'] = $size;
					$_SESSION['drop_cart'][$sp_id]['color'] = $mau;
					$_SESSION['drop_cart'][$sp_id]['kho'] = $kho;
					$_SESSION['drop_cart'][$sp_id]['pl'] = $pl;
				}
				$_SESSION['new_sp'] = $sp_id;
			}
			$name = '<a href="/product/' . $r_tt['link'] . '.html" style="color:red;" title="' . $r_tt['tieu_de'] . '">' . $r_tt['tieu_de'] . '</a>';
			$list_pl='';
			foreach ($_SESSION['drop_cart'] as $key => $value) {
				if (intval($key) > 0) {
					$list_id .= $key . ',';
				}
				if (intval($value['pl']) > 0) {
					$list_pl .= $value['pl'] . ',';
				}

			}
			if($list_id==''){

			}else{
				$list_id = substr($list_id, 0, -1);
			}
			if($list_pl==''){
			}else{
				$list_pl = substr($list_pl, 0, -1);
				$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
				$product_pl=array();
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$sp_pl=$r_pl['sp_id'];
					$product_pl[$sp_pl]['gia_cu']=$r_pl['gia_cu'];
					$product_pl[$sp_pl]['gia_moi']=$r_pl['gia_moi'];
					$product_pl[$sp_pl]['gia_drop']=$r_pl['gia_drop'];
					$product_pl[$sp_pl]['gia_ncc']=$r_pl['gia_ncc'];
					$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
				}
			}
			if($list_id!=''){
				$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
				while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
					$id_sp = $r_cart['id'];
					if($user_info['leader']==1 OR $user_info['gia_leader']==1){
						$total_price += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
					}else{
						$total_price += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ncc']);
					}
					$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
					if ($_SESSION['new_sp'] == $r_cart['id']) {
						$r_cart['sanpham_moi'] = '<p class="addpass" style="color:#fff;"><span class="add_sus" style="color:#898989;"><i style="margin-right:5px; color:red; font-size:13px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm!</span></p>';
					} else {
						$r_cart['sanpham_moi'] = '';
					}
					$list .= $skin->skin_replace('skin_ncc/box_action/li_sanpham_drop', $r_cart);
				}
				$total_price = number_format($total_price) . 'đ';
			}else{

			}
			echo json_encode(array('ok' => $ok, 'total' => count((array)$_SESSION['drop_cart']), 'name' => $name, 'list' => $list, 'total_cart' => count((array)$_SESSION['drop_cart']), 'total_price' => $total_price, 'thongbao' => $thongbao));
?>