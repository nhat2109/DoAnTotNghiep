<?php
			$loai_don=addslashes($_REQUEST['loai_don']);
			$don=intval($_REQUEST['don']);
			$total_sp = 0;
			foreach ($_SESSION['drop_cart'] as $key => $value) {
				if (intval($key) > 0) {
					$list_id .= $key . ',';
					$total_sp++;
				}
				if (intval($value['pl']) > 0) {
					$list_pl .= $value['pl'] . ',';
				}
			}
			$list_id = substr($list_id, 0, -1);
			if($total_sp==0){
				$ok=0;
				$thongbao='Thất bại! Không có sản phẩm trong giỏ hàng';
			}else{
				$list_pl = substr($list_pl, 0, -1);
				$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
				$product_pl=array();
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$sp_pl=$r_pl['sp_id'];
					$product_pl[$sp_pl]['ma_sp']=$r_pl['ma_sp'];
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
			if($loai_don=='khach_socdo'){
				$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
				$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
				$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
				$ghi_chu = addslashes(strip_tags($_REQUEST['ghi_chu']));
				$tinh = intval($_REQUEST['tinh']);
				$huyen = intval($_REQUEST['huyen']);
				$xa = intval($_REQUEST['xa']);
				$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
				$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
				$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
				$chiu_ship=addslashes(strip_tags($_REQUEST['chiu_ship']));
				$dichvu_ship=addslashes(strip_tags($_REQUEST['dichvu_ship']));
				$congty_ship=addslashes(strip_tags($_REQUEST['congty_ship']));
				$cod=preg_replace('/[^0-9]/', '', addslashes(strip_tags($_REQUEST['cod'])));
				$cod=intval($cod);
				$noti=0;
				if($ho_ten==''){
					$ok=0;
					$thongbao='Vui lòng nhập họ và tên khách hàng';
				}else if($dien_thoai==''){
					$ok=0;
					$thongbao='Vui lòng nhập số điện thoại khách hàng';
				}else if($tinh==''){
					$ok=0;
					$thongbao='Vui lòng chọn tỉnh/thành phố';
				}else if($huyen==''){
					$ok=0;
					$thongbao='Vui lòng chọn quận/huyện';
				}else if($xa==''){
					$ok=0;
					$thongbao='Vui lòng chọn xã/phường';
				}else if($dia_chi==''){
					$ok=0;
					$thongbao='Vui lòng nhập địa chỉ nhận hàng';
				}else if($congty_ship==''){
					$ok=0;
					$thongbao='Vui lòng chọn công ty vận chuyển';
				}else if($dichvu_ship==''){
					$ok=0;
					$thongbao='Vui lòng chọn dịch vụ giao hàng';
				}else{
					$total_sp = 0;
					foreach ($_SESSION['don'][$don] as $key => $value) {

						if (intval($value) > 0) {
							$list_id_gop .= $value . ',';
							$so_luong[$value]++;
							$gg[$value][]=$key;
						}
					}
					$list_id_gop = substr($list_id_gop, 0, -1);
					$k=0;
					$thongtin_cart_don = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id_gop) ORDER BY FIELD(id,$list_id_gop)");
					while ($r_cart_don = mysqli_fetch_assoc($thongtin_cart_don)) {
						$id_sp = $r_cart_don['id'];
						for ($i=0; $i < $so_luong[$id_sp]; $i++) {
							$k++;
							if($gg[$id_sp][$i]==1){
								$giam_sp=0;
							}else if ($gg[$id_sp][$i]==2) {
								$giam_sp=0;
							}else if ($gg[$id_sp][$i]==3) {
								$giam_sp=2;
							}else if ($gg[$id_sp][$i]==4) {
								$giam_sp=3;
							}else if ($gg[$id_sp][$i]==5) {
								$giam_sp=5;
							}else{
								$giam_sp=0;
							}
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$tamtinh += $product_pl[$id_sp]['gia_drop'];
								$thanhtien=$product_pl[$id_sp]['gia_drop'];
								$thanhtien_gop += $thanhtien - ($thanhtien/100)*$giam_sp;
								$tong_giam+=($thanhtien/100)*$giam_sp;
								$r_cart_don['giam'] = number_format(($thanhtien/100)*$giam_sp);
								$r_cart_don['thanhtien_gop'] = number_format($thanhtien - ($thanhtien/100)*$giam_sp);
								$r_cart_don['gia_ctv'] = number_format($product_pl[$id_sp]['gia_drop']);
								$r_cart_don['gia_moi_don'] = number_format(str_replace(',', '', $product_pl[$id_sp]['gia_moi']));
								$r_cart_don['quantity'] = 1;
								if ($k == 1) {
									$list .= '"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart_don['tieu_de']) . '","soluong":"1","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $product_pl[$id_sp]['gia_moi'] . '","can_nang":"'.str_replace(',', '.', $product_pl[$id_sp]['can_nang']).'","gia_ctv":"' . $r_cart_don['gia_ctv'] . '","minh_hoa":"' . $r_cart_don['minh_hoa'] . '","giam":"' . $r_cart_don['giam'] . '","thanhtien":"' . $r_cart_don['thanhtien_gop'] . '"}';
									
								} else {
									$list .= ',"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart_don['tieu_de']) . '","soluong":"1","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart_don['gia_moi_don'] . '","can_nang":"'.str_replace(',', '.', $product_pl[$id_sp]['can_nang']).'","gia_ctv":"' . $r_cart_don['gia_ctv'] . '","minh_hoa":"' . $r_cart_don['minh_hoa'] . '","giam":"' . $r_cart_don['giam'] . '","thanhtien":"' . $r_cart_don['thanhtien_gop'] . '"}';
								}
							}else{
								$tamtinh += $product_pl[$id_sp]['gia_ctv'];
								$thanhtien=$product_pl[$id_sp]['gia_ctv'];
								$tong_giam+=($thanhtien/100)*$giam_sp;
								$r_cart_don['giam'] = number_format(($thanhtien/100)*$giam_sp);
								$thanhtien_gop += $thanhtien - ($thanhtien/100)*$giam_sp;
								$r_cart_don['thanhtien_gop'] = number_format($thanhtien - ($thanhtien/100)*$giam_sp);
								$r_cart_don['gia_ctv_moi'] = number_format($product_pl[$id_sp]['gia_ctv']);

								$r_cart_don['gia_moi_don'] = number_format(str_replace(',', '', $product_pl[$id_sp]['gia_moi']));
								$r_cart_don['quantity'] = 1;
								if ($k == 1) {
									$list .= '"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart_don['tieu_de']) . '","soluong":"1","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size']. '","gia_moi":"' . $r_cart_don['gia_moi'] . '","can_nang":"'.str_replace(',', '.', $product_pl[$id_sp]['can_nang']).'","gia_ctv":"' . $r_cart_don['gia_ctv_moi'] . '","minh_hoa":"' . $r_cart_don['minh_hoa'] . '","giam":"' . $r_cart_don['giam'] . '","thanhtien":"' . $r_cart_don['thanhtien_gop'] . '"}';
									
								} else {
									$list .= ',"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart_don['tieu_de']) . '","soluong":"1","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $_SESSION['drop_cart'][$id_sp]['size'] . '","gia_moi":"' . $r_cart_don['gia_moi_don'] . '","can_nang":"'.str_replace(',', '.', $r_cart_don['can_nang']).'","gia_ctv":"' . $r_cart_don['gia_ctv_moi'] . '","minh_hoa":"' . $r_cart_don['minh_hoa'] . '","giam":"' . $r_cart_don['giam'] . '","thanhtien":"' . $r_cart_don['thanhtien_gop'] . '"}';
								}
							}
						}
						$total_banle += $product_pl[$id_sp]['gia_moi'] * $so_luong[$id_sp];
						$can_nang+=str_replace(',', '.', $product_pl[$id_sp]['can_nang'])*$so_luong[$id_sp];
						$tong_soluong+=$so_luong[$id_sp];
					}
					$trongluong=$can_nang*1000;
					$can_nang=$can_nang*1000;
					$sanpham = '{' . $list . '}';
					//$phi_ship=intval($_REQUEST['phi_ship']);
					$tinh_gui=1;
					$huyen_gui=25;
					if($congty_ship=='ninja_van'){
						$thongtin_tinh=mysqli_query($conn,"SELECT * FROM tinh_ninja WHERE ma_tinh='$tinh'");
						$r_tinh=mysqli_fetch_assoc($thongtin_tinh);
						if($r_tinh['vung']=='noi_tinh'){
							if($trongluong<=5000){
								$phi_ship=26400;
							}else{
								$congthem=($trongluong - 5000)/1000;
								if($congthem<=45000){
									$phi_cong=round($congthem)*2130;
								}else{
									$phi_cong=round($congthem)*2020;
								}
								$phi_ship=26400 + $phi_cong;
							}
						}else if($r_tinh['vung']=='noi_vung'){
							if($trongluong<=5000){
								$phi_ship=34900;
							}else{
								$congthem=($trongluong - 5000)/1000;
								if($congthem<=45000){
									$phi_cong=round($congthem)*2902;
								}else{
									$phi_cong=round($congthem)*2770;
								}
								$phi_ship=34900 + $phi_cong;
							}
						}else if($r_tinh['vung']=='lienvung_gan'){
							if($trongluong<=5000){
								$phi_ship=37200;
							}else{
								$congthem=($trongluong - 5000)/1000;
								if($congthem<=45000){
									$phi_cong=round($congthem)*3870;
								}else{
									$phi_cong=round($congthem)*3680;
								}
								$phi_ship=37200 + $phi_cong;
							}
						}else if($r_tinh['vung']=='lienvung_xa'){
							if($trongluong<=5000){
								$phi_ship=51600;
							}else{
								$congthem=($trongluong - 5000)/1000;
								if($congthem<=45000){
									$phi_cong=round($congthem)*5450;
								}else{
									$phi_cong=round($congthem)*5170;
								}
								$phi_ship=51600 + $phi_cong;
							}
						}
						$phi_ship = $phi_ship + ($total_banle/100)*0.5 + ($phi_ship/100)*8;
						$tongtien = $thanhtien_gop + $phi_ship;
						if($chiu_ship=='shop'){
							$hoahong = $cod - $thanhtien_gop - $phi_ship;
						}else{
							$hoahong = $cod - $thanhtien_gop;
						}
					}else{
						$login_step_1=$class_viettel->login_step_1();
						$info_login=json_decode($login_step_1,true);
						$token=$info_login['data']['token'];
						$token_client=$class_viettel->get_token_client($token);
						$tinh_cuoc=$class_viettel->lay_dichvu($token_client,$can_nang,$cod,$cod,$dichvu_ship,$huyen_gui,$tinh_gui,$huyen,$tinh);
						$tach_cuoc=json_decode($tinh_cuoc,true);
						$phi_ship=$tach_cuoc['gia_cuoc'];
						$tongtien = $thanhtien_gop + $phi_ship;
						if($chiu_ship=='shop'){
							$hoahong = $cod - $thanhtien_gop - $phi_ship;
						}else{
							$hoahong = $cod - $thanhtien_gop;
						}
					}
					if($hoahong<=0){
						if($chiu_ship=='shop'){
							if($cod<($thanhtien_gop + $phi_ship)){
								$tru_tien = ($thanhtien_gop + $phi_ship) - $cod;
								if($tru_tien>($user_info['user_money'] + $user_info['user_money2'])){
									$ok=0;
									$thongbao='Thất bại! Số dư của bạn không đủ';
								}else{
									$ma_don = $class_index->creat_random($conn,'donhang_ctv');
									$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id_gop) ORDER BY FIELD(id,$list_id_gop)");
									while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
										$id_sp_kho = $r_kho['id'];
										$moi = $r_kho['kho'] - $so_luong[$id_sp_kho];
										mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
										if($moi<=3){
											$noti=1;
											if($moi==0){
												$noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
											}else{
												$noidung_notification='Thông báo tồn ít: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
											}
										}
									}
									$ok = 1;
									$thongbao = 'Gửi đơn hàng <span class="color_red">'.$don.'</span> thành công ';
									mysqli_query($conn, "INSERT INTO donhang_ctv(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$thanhtien_gop','','$tong_giam','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
									if($user_info['user_money']>=$tru_tien){
										$truoc = $user_info['user_money'] + $user_info['user_money2'];
										$moi=$user_info['user_money'] - $tru_tien;
										$sau = $truoc - $tru_tien;
										mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
										$noidung = 'Đặt đơn sóc đỏ, mã đơn hàng #'.$ma_don;
										mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tru_tien','$truoc','$sau','$noidung'," . time() . ")");
									}else{
										$truoc = $user_info['user_money'] + $user_info['user_money2'];
										$moi=$user_info['user_money2'] - ($tru_tien - $user_info['user_money']);
										$sau = $truoc - $tru_tien;
										mysqli_query($conn, "UPDATE user_info SET user_money='0',user_money2='$moi' WHERE user_id='$user_id'");
										$noidung = 'Đặt đơn sóc đỏ, mã đơn hàng #'.$ma_don;
										mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tru_tien','$truoc','$sau','$noidung'," . time() . ")");
									}
									$ngay_thang=date('d-m-Y');
									$hientai=time();
									mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$tamtinh','$tongtien','','$ngay_thang','$hientai')");
									$_SESSION['ma_don'] = $ma_don;
								}
							}
						}else{
							if($cod<=$thanhtien_gop){
								$tru_tien = $thanhtien_gop - $cod;
								if($tru_tien>($user_info['user_money'] + $user_info['user_money2'])){
									$ok=0;
									$thongbao='Thất bại! Số dư của bạn không đủ';
								}else{
									$ma_don = $class_index->creat_random($conn,'donhang_ctv');
									$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id_gop) ORDER BY FIELD(id,$list_id_gop)");
									while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
										$id_sp_kho = $r_kho['id'];
										$moi = $r_kho['kho'] - $so_luong[$id_sp_kho];
										mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
										if($moi<=3){
											$noti=1;
											if($moi==0){
												$noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
											}else{
												$noidung_notification='Thông báo tồn ít: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
												mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
											}
										}
									}
									$ok = 1;
									$thongbao = 'Gửi đơn hàng <span class="color_red">'.$don.'</span> thành công';
									mysqli_query($conn, "INSERT INTO donhang_ctv(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$thanhtien_gop','','$tong_giam','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
									if($user_info['user_money']>=$tru_tien){
										$truoc = $user_info['user_money'] + $user_info['user_money2'];
										$moi=$user_info['user_money'] - $tru_tien;
										$sau = $truoc - $tru_tien;
										mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
										$noidung = 'Đặt đơn sóc đỏ, mã đơn hàng #'.$ma_don;
										mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tru_tien','$truoc','$sau','$noidung'," . time() . ")");
									}else{
										$truoc = $user_info['user_money'] + $user_info['user_money2'];
										$moi=$user_info['user_money2'] - ($tru_tien - $user_info['user_money']);
										$sau = $truoc - $tru_tien;
										mysqli_query($conn, "UPDATE user_info SET user_money='0',user_money2='$moi' WHERE user_id='$user_id'");
										$noidung = 'Đặt đơn sóc đỏ, mã đơn hàng #'.$ma_don;
										mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tru_tien','$truoc','$sau','$noidung'," . time() . ")");
									}
									$ngay_thang=date('d-m-Y');
									$hientai=time();
									mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$tamtinh','$tongtien','','$ngay_thang','$hientai')");
									$_SESSION['ma_don'] = $ma_don;
								}
							}
						}

					}else{
						$ma_don = $class_index->creat_random($conn,'donhang_ctv');
						$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id_gop) ORDER BY FIELD(id,$list_id_gop)");
						while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
							$id_sp_kho = $r_kho['id'];
							$moi = $r_kho['kho'] - $so_luong[$id_sp_kho];
							mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
							if($moi<=3){
								$noti=1;
								if($moi==0){
									$noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
									mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
									mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
								}else{
									$noidung_notification='Thông báo tồn ít: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
									mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
									mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
								}
							}
						}
						$ok = 1;
						$thongbao = 'Gửi đơn hàng <span class="color_red">'.$don.'</span> thành công';
						mysqli_query($conn, "INSERT INTO donhang_ctv(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$thanhtien_gop','','$tong_giam','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
						$ngay_thang=date('d-m-Y');
						$hientai=time();
						mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$thanhtien_gop','$tongtien','','$ngay_thang','$hientai')");
						$_SESSION['ma_don'] = $ma_don;
						//////////
					}
				}
				echo json_encode(array('ok' => $ok,'noti'=>$noti, 'thongbao' => $thongbao));

			}else if($loai_don=='khach_san'){
				$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
				$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
				$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
				$ghi_chu = addslashes(strip_tags($_REQUEST['ghi_chu']));
				$tinh = intval($_REQUEST['tinh']);
				$huyen = intval($_REQUEST['huyen']);
				$total_sp_gop = 0;
				$noti=0;
				foreach ($_SESSION['don'][$don] as $key => $value) {
					if (intval($value) > 0) {
						$list_id_gop .= $value . ',';
						$so_luong[$value]++;
						$gg[$value][]=$key;
						$total_sp_gop++;
					}
				}
				$list_id_gop = substr($list_id_gop, 0, -1);
				$k=0;
				$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id_gop) ORDER BY FIELD(id,$list_id_gop)");
				while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
					$id_sp = $r_cart['id'];
					$kho = $_SESSION['drop_cart'][$id_sp]['kho'];
/*					if ($so_luong[$id_sp] > $r_cart[$kho]) {
						echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Kho hàng không đủ'));
						exit();
					} else {*/
						for ($i=0; $i <$so_luong[$id_sp] ; $i++) {
							$k++;
							if($gg[$id_sp][$i]==1){
								$giam_sp=0;
							}else if ($gg[$id_sp][$i]==2) {
								$giam_sp=0;
							}else if ($gg[$id_sp][$i]==3) {
								$giam_sp=2;
							}else if ($gg[$id_sp][$i]==4) {
								$giam_sp=3;
							}else if ($gg[$id_sp][$i]==5) {
								$giam_sp=5;
							}else{
								$giam_sp=0;
							}
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$tamtinh += $product_pl[$id_sp]['gia_drop'];
								$thanhtien=$product_pl[$id_sp]['gia_drop'];
								$thanhtien_gop+=$thanhtien - ($thanhtien/100)*$giam_sp;
								$r_cart['thanhtien_gop'] = number_format($thanhtien - ($thanhtien/100)*$giam_sp);
								$tong_giam+=($thanhtien/100)*$giam_sp;
								$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
								$r_cart['giam'] = number_format(($thanhtien/100)*$giam_sp);
							}else{
								$tamtinh += $product_pl[$id_sp]['gia_ctv'];
								$thanhtien=$product_pl[$id_sp]['gia_ctv'];
								$thanhtien_gop+=$thanhtien - ($thanhtien/100)*$giam_sp;
								$tong_giam+=($thanhtien/100)*$giam_sp;
								$r_cart['thanhtien_gop'] = number_format($thanhtien - ($thanhtien/100)*$giam_sp);
								$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ctv']);
								$r_cart['giam'] = number_format(($thanhtien/100)*$giam_sp);
							}
							$r_cart['gia_moi'] = number_format($product_pl[$id_sp]['gia_moi']);
							$r_cart['quantity'] = 1;
							if ($k == 1) {
								$list .= '"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"1","kho":"' . $_SESSION['drop_cart'][$id_sp]['kho'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","gia_nhap":"' . $r_cart['gia_nhap'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","giam":"' . $r_cart['giam'] . '","thanhtien":"' . $r_cart['thanhtien_gop'] . '"}';
							} else {
								$list .= ',"' . $id_sp . '_'.$i.'":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"1","kho":"' . $_SESSION['drop_cart'][$id_sp]['kho'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","gia_nhap":"' . $r_cart['gia_nhap'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","giam":"' . $r_cart['giam'] . '","thanhtien":"' . $r_cart['thanhtien_gop'] . '"}';
							}

						}
					//}
				}
				$sanpham = '{' . $list . '}';
				$phi_ship = 0;
				$tongtien = $thanhtien_gop + $phi_ship;
				//$ma_don = $shop . '' . $check->random_number(6);
				$ma_don = $class_index->creat_random($conn,'donhang');
				if (intval($total_sp_gop) < 1 OR $tongtien < 1000) {
					$ok = 0;
					$thongbao = 'Thất bại! Không có sản phẩm nào trong giỏ hàng';
				} else if ($tongtien > ($user_info['user_money'] + $user_info['user_money2'])) {
					$ok = 0;
					$thongbao = 'Số dư không đủ, vui lòng nạp thêm';
				} else {
					$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
					while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
						$id_sp_kho = $r_kho['id'];
						$chon_kho = $_SESSION['drop_cart'][$id_sp_kho]['kho'];
						$moi = $r_kho[$chon_kho] - $so_luong[$id_sp_kho];
						if ($chon_kho == 'kho_hcm') {
							mysqli_query($conn, "UPDATE sanpham SET kho_hcm='$moi' WHERE id='{$r_kho['id']}'");
						} else {
							mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
						}
						if($moi<=3){
							$noti=1;
							if($moi==0){
								$noidung_notification='Thông báo hết hàng: Sản phẩm '.$r_kho['tieu_de'];
								mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
								mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
							}else{
								$noidung_notification='Thông báo tồn ít: Sản phẩm '.$r_kho['tieu_de'];
								mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','don_hang','1'," . time() . ")");
								mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
							}
						}
					}
					$ok = 1;
					$thongbao = 'Gửi đơn hàng <span class="color_red">'.$don.'</span> thành công';
					$truoc = $user_info['user_money'] + $user_info['user_money2'];
					$sau = $truoc - $tongtien;
					if ($user_info['user_money'] >= $tongtien) {
						$conlai = $user_info['user_money'] - $tongtien;
						mysqli_query($conn, "UPDATE user_info SET user_money='$conlai' WHERE user_id='$user_id'");
					} else {
						$conlai = $user_info['user_money2'] - ($tongtien - $user_info['user_money']);
						mysqli_query($conn, "UPDATE user_info SET user_money='0',user_money2='$conlai' WHERE user_id='$user_id'");
					}
					$duoi = $check->duoi_file($_FILES['file']['name']);
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'pdf')) == true) {
						$minh_hoa = '/uploads/minh-hoa/donhang-' . $ma_don . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					}
					$duoi2 = $check->duoi_file($_FILES['file2']['name']);
					if (in_array($duoi2, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'pdf')) == true) {
						$minh_hoa2 = '/uploads/minh-hoa/donhang-' . $ma_don . '-2-' . time() . '.' . $duoi2;
						move_uploaded_file($_FILES['file2']['tmp_name'], '..' . $minh_hoa2);
					}
					if (isset($_COOKIE['drop_kho'])) {
						$drop_kho = addslashes(strip_tags($_COOKIE['drop_kho']));
					} else {
						$drop_kho = 'kho';
					}
					mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,dropship,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','$minh_hoa','$minh_hoa2','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','1','$sanpham','$thanhtien_gop','','0','$phi_ship','$tongtien','$drop_kho','0','online','$ghi_chu','',''," . time() . "," . time() . ")");
					$noidung = 'Đặt hàng drop, mã đơn hàng #' . $ma_don;
					mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tongtien','$truoc','$sau','$noidung'," . time() . ")");
					$ngay_thang=date('d-m-Y');
					$hientai=time();
					mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$thanhtien_gop','$tongtien','','$ngay_thang','$hientai')");
					$_SESSION['ma_don'] = $ma_don;
				}
				echo json_encode(array('ok' => $ok,'noti'=>$noti, 'thongbao' => $thongbao));

			}
?>