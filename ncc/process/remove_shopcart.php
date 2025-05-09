<?php
			$sp_id = intval($_REQUEST['sp_id']);
			unset($_SESSION['drop_cart'][$sp_id]);
			if (count((array)$_SESSION['drop_cart']) > 0) {
				foreach ($_SESSION['drop_cart'] as $key => $value) {
					if (intval($key) > 0) {
						$list_id .= $key . ',';
					}
					if (intval($value['pl']) > 0) {
						$list_pl .= $value['pl'] . ',';
					}
				}
				$list_id = substr($list_id, 0, -1);
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
					$product_pl[$sp_pl]['color']=$r_pl['color'];
					$product_pl[$sp_pl]['size']=$r_pl['size'];
					$product_pl[$sp_pl]['can_nang']=$r_pl['can_nang'];
					$product_pl[$sp_pl]['ten_color']=$r_pl['ten_color'];
					$product_pl[$sp_pl]['ten_size']=$r_pl['ten_size'];
				}
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
					$color = $_SESSION['drop_cart'][$id_sp]['color'];
					$size = $_SESSION['drop_cart'][$id_sp]['size'];
					$list_id_color=array();
					$list_id_size=array();
					$r_cart['list_size']='';
					$r_cart['list_color']='';
					if($size==''){
						$r_cart['list_size']='';
					}else{
						$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$id_sp' ORDER BY id ASC");
						$m = 0;
						while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
							$m++;
							if ($r_pl['size'] == $_SESSION['drop_cart'][$id_sp]['size']) {
								if(in_array($r_pl['size'], $list_id_size)==false){
									$list_id_size[].=$r_pl['size'];
									$list_size .= '<option value="'.$r_pl['size'].'" selected>'.$r_pl['ten_size'].'</option>';
									if($color==$r_pl['color']){
										if(in_array($r_pl['color'], $list_id_color)==false){
											$list_id_color[].=$r_pl['color'];
											$list_color.='<option value="'.$r_pl['color'].'" selected>'.$r_pl['ten_color'].'</option>';
										}
									}else{
										if(in_array($r_pl['color'], $list_id_color)==false){
											$list_id_color[].=$r_pl['color'];
											$list_color.='<option value="'.$r_pl['color'].'">'.$r_pl['ten_color'].'</option>';
										}	
									}
								}
							} else {
								if(in_array($r_pl['size'], $list_id_size)==false){
									$list_id_size[].=$r_pl['size'];
									$list_size .= '<option value="'.$r_pl['size'].'">'.$r_pl['ten_size'].'</option>';
								}
							}
						}
						$r_cart['list_size'] = '<select name="size[]" sp_id="'.$id_sp.'">'.$list_size.'</select>';
						unset($list_size);
						$r_cart['list_color'] = '<select name="color[]" sp_id="'.$id_sp.'">'.$list_color.'</select>';
						unset($list_color);
					}
					$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart', $r_cart);
					unset($list_id_color);
					unset($list_id_size);
				}
				$total_price = number_format($total_price) . 'đ';
			} else {
				unset($_SESSION['drop_cart']);
			}
			$list_shopcart = '<div class="li_shopcart th">
			                    <div class="minh_hoa">
			                        Minh họa
			                    </div>
			                    <div class="info">
			                        <div class="tieude">
			                            Sản phẩm
			                        </div>
			                        <div class="list_size">
			                            Kích cỡ sản phẩm
			                        </div>
			                        <div class="list_color">
			                            Màu sản phẩm
			                        </div>
			                        <div class="box_quantity">
			                            Số lượng
			                        </div>
			                        <div class="price">Giá nhập</div>
			                        <div class="thanhtien">Thành tiền</div>
			                    </div>
			                </div>' . $list_shopcart;
			echo json_encode(array('ok' => 1, 'list_shopcart' => $list_shopcart, 'list_shopcart_mobile' => $list_shopcart_mobile, 'total_cart' => count((array)$_SESSION['drop_cart']), 'tongtien' => $total_price, 'thongbao' => 'Cập nhật giỏ hàng thành công'));
?>