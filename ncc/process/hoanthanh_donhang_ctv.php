<?php
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
				$list_pl = substr($list_pl, 0, -1);
				$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
				$product_pl=array();
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$sp_pl=$r_pl['sp_id'];
					$product_pl[$sp_pl]['ma_sp']=$r_pl['ma_sp'];
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
					$total_banle += $product_pl[$id_sp]['gia_moi'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
					$can_nang+=str_replace(',', '.', $product_pl[$id_sp]['can_nang'])*$_SESSION['drop_cart'][$id_sp]['quantity'];
					$tong_soluong+=$_SESSION['drop_cart'][$id_sp]['quantity'];
					$k++;
					if($user_info['leader']==1 OR $user_info['gia_leader']==1){
						$tamtinh += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_ncc'] = number_format($product_pl[$id_sp]['gia_drop']);
					}else{
						$tamtinh += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_ncc'] = number_format($product_pl[$id_sp]['gia_ncc']);
					}
					$r_cart['gia_moi'] = number_format($product_pl[$id_sp]['gia_moi']);
					$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
					if ($k == 1) {
						$list .= '"' . $id_sp . '":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"' . $_SESSION['drop_cart'][$id_sp]['quantity'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","can_nang":"'.str_replace(',', '.', $product_pl[$id_sp]['can_nang'])*$_SESSION['drop_cart'][$id_sp]['quantity'].'","gia_ncc":"' . $r_cart['gia_ncc'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
						
					} else {
						$list .= ',"' . $id_sp . '":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"' . $_SESSION['drop_cart'][$id_sp]['quantity'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","can_nang":"'.str_replace(',', '.', $product_pl[$id_sp]['can_nang'])*$_SESSION['drop_cart'][$id_sp]['quantity'].'","gia_ncc":"' . $r_cart['gia_ncc'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
					}
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
					$tongtien = $tamtinh + $phi_ship;
					if($chiu_ship=='shop'){
						$hoahong = $cod - $tamtinh - $phi_ship;
					}else{
						$hoahong = $cod - $tamtinh;
					}
				}else{
					$login_step_1=$class_viettel->login_step_1();
					$info_login=json_decode($login_step_1,true);
					$token=$info_login['data']['token'];
					$token_client=$class_viettel->get_token_client($token);
					$tinh_cuoc=$class_viettel->lay_dichvu($token_client,$can_nang,$cod,$cod,$dichvu_ship,$huyen_gui,$tinh_gui,$huyen,$tinh);
					$tach_cuoc=json_decode($tinh_cuoc,true);
					$phi_ship=$tach_cuoc['gia_cuoc'];
					$tongtien = $tamtinh + $phi_ship;
					if($chiu_ship=='shop'){
						$hoahong = $cod - $tamtinh - $phi_ship;
					}else{
						$hoahong = $cod - $tamtinh;
					}
				}
				if($hoahong<=0){
					if($chiu_ship=='shop'){
						if($cod<($tamtinh + $phi_ship)){
							$tru_tien = ($tamtinh + $phi_ship) - $cod;
							if($tru_tien>($user_info['user_money'] + $user_info['user_money2'])){
								$ok=0;
								$thongbao='Thất bại! Số dư của bạn không đủ';
							}else{
								$ma_don = $class_index->creat_random($conn,'donhang_ncc');
								$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
								while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
									$id_sp_kho = $r_kho['id'];
									$moi = $r_kho['kho'] - $_SESSION['drop_cart'][$id_sp_kho]['quantity'];
									mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
									if($moi<=3){
										$noti=1;
										if($moi==0){
											$noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
											mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','1'," . time() . ")");
											mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
										}else{
											$noidung_notification='Thông báo tồn ít: Sản phẩm <b>'.$r_kho['tieu_de'].'</b>';
											mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','1'," . time() . ")");
											mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('$user_id','$id_sp_kho','$noidung_notification','','san_pham','0'," . time() . ")");
										}
									}
								}
								$ok = 1;
								$thongbao = 'Gửi đơn hàng thành công';
								mysqli_query($conn, "INSERT INTO donhang_ncc(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$tamtinh','','0','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
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
								unset($_SESSION['drop_cart']);
							}
						}
					}else{
						if($cod<=$tamtinh){
							$tru_tien = $tamtinh - $cod;
							if($tru_tien>($user_info['user_money'] + $user_info['user_money2'])){
								$ok=0;
								$thongbao='Thất bại! Số dư của bạn không đủ';
							}else{
								$ma_don = $class_index->creat_random($conn,'donhang_ncc');
								$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
								while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
									$id_sp_kho = $r_kho['id'];
									$moi = $r_kho['kho'] - $_SESSION['drop_cart'][$id_sp_kho]['quantity'];
									mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
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
								$thongbao = 'Gửi đơn hàng thành công';
								mysqli_query($conn, "INSERT INTO donhang_ncc(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$tamtinh','','0','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
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
								unset($_SESSION['drop_cart']);
							}
						}
					}

				}else{
					$ma_don = $class_index->creat_random($conn,'donhang_ncc');
					$thongtin_kho = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
					while ($r_kho = mysqli_fetch_assoc($thongtin_kho)) {
						$id_sp_kho = $r_kho['id'];
						$moi = $r_kho['kho'] - $_SESSION['drop_cart'][$id_sp_kho]['quantity'];
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
					$thongbao = 'Gửi đơn hàng thành công';
					mysqli_query($conn, "INSERT INTO donhang_ncc(ma_don,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,sanpham,so_luong,can_nang,tamtinh,coupon,giam,congty_ship,dichvu_ship,phi_ship,chiu_ship,tongtien,cod,hoahong,status,thanhtoan,ghi_chu,date_update,date_post)VALUES('$ma_don','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$sanpham','$tong_soluong','$can_nang','$tamtinh','','0','$congty_ship','$dichvu_ship','$phi_ship','$chiu_ship','$tongtien','$cod','$hoahong','0','online','$ghi_chu',".time()."," . time() . ")");
					$ngay_thang=date('d-m-Y');
					$hientai=time();
					mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$tamtinh','$tongtien','','$ngay_thang','$hientai')");
					$_SESSION['ma_don'] = $ma_don;
					//////////
					unset($_SESSION['drop_cart']);
				}
			}
			echo json_encode(array('ok' => $ok,'noti'=>$noti, 'thongbao' => $thongbao));
?>