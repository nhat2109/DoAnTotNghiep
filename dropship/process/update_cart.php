<?php
			$sp_id = intval($_REQUEST['sp_id']);
			$quantity = intval($_REQUEST['quantity']);
			$kho = $_SESSION['drop_cart'][$sp_id]['kho'];
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham WHERE id='$sp_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if (($kho == 'kho' AND $quantity <= $r_tt['kho']) OR ($kho == 'kho_hcm' AND $quantity <= $r_tt['kho_hcm'])) {
				if (isset($_SESSION['drop_cart'][$sp_id]) AND $quantity > 1) {
					$_SESSION['drop_cart'][$sp_id]['quantity'] = $quantity;
				} else {
					$_SESSION['drop_cart'][$sp_id]['quantity'] = 1;
				}
			}
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
					$product_pl[$sp_pl]['gia_ctv']=$r_pl['gia_ctv'];
					$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
					$product_pl[$sp_pl]['color']=$r_pl['color'];
					$product_pl[$sp_pl]['size']=$r_pl['size'];
					$product_pl[$sp_pl]['can_nang']=$r_pl['can_nang'];
					$product_pl[$sp_pl]['ten_color']=$r_pl['ten_color'];
					$product_pl[$sp_pl]['ten_size']=$r_pl['ten_size'];
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
						$total_price += $product_pl[$id_sp]['gia_ctv'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ctv'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ctv']);
					}
					$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
					if ($_SESSION['new_sp'] == $r_cart['id']) {
						$r_cart['sanpham_moi'] = '<p class="addpass" style="color:#fff;"><span class="add_sus" style="color:#898989;"><i style="margin-right:5px; color:red; font-size:13px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm!</span></p>';
					} else {
						$r_cart['sanpham_moi'] = '';
					}
					$list .= $skin->skin_replace('skin_dropship/box_action/li_sanpham_drop', $r_cart);
				}
				$total_price = number_format($total_price) . 'đ';
			}else{

			}
			echo json_encode(array('ok' => 1, 'total' => count((array)$_SESSION['drop_cart']), 'list' => $list, 'total_cart' => count((array)$_SESSION['drop_cart']), 'total_price' => $total_price, 'thongbao' => 'Thêm vào giỏ hàng thành công'));
?>