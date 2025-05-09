<?php
			$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
			$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
			$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
			$ghi_chu = addslashes(strip_tags($_REQUEST['ghi_chu']));
			$tinh = intval($_REQUEST['tinh']);
			$huyen = intval($_REQUEST['huyen']);
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
			$total_sp=0;
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
			while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
				$total_sp++;
				$id_sp = $r_cart['id'];
				$kho = $_SESSION['drop_cart'][$id_sp]['kho'];
				if($kho==''){
					$kho='kho';
				}
				if ($_SESSION['drop_cart'][$id_sp]['quantity'] > $r_cart[$kho]) {
					echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Kho hàng không đủ'));
					exit();
				} else {
					$k++;
					if($user_info['leader']==1 OR $user_info['gia_leader']==1){
						$tamtinh += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
					}else{
						$tamtinh += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
						$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ncc']);
					}
					$r_cart['gia_moi'] = number_format($product_pl[$id_sp]['gia_moi']);
					$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
					if ($k == 1) {
						$list .= '"' . $id_sp . '":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"' . $_SESSION['drop_cart'][$id_sp]['quantity'] . '","kho":"' . $_SESSION['drop_cart'][$id_sp]['kho'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $product_pl[$id_sp]['ma_sp'] . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","gia_nhap":"' . $r_cart['gia_nhap'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
					} else {
						$list .= ',"' . $id_sp . '":{"tieu_de":"' . addslashes($r_cart['tieu_de']) . '","soluong":"' . $_SESSION['drop_cart'][$id_sp]['quantity'] . '","kho":"' . $_SESSION['drop_cart'][$id_sp]['kho'] . '","color":"' . $product_pl[$id_sp]['ten_color'] . '","ma_sanpham":"' . $ma_sanpham . '","size":"' . $product_pl[$id_sp]['ten_size'] . '","gia_moi":"' . $r_cart['gia_moi'] . '","gia_nhap":"' . $r_cart['gia_nhap'] . '","minh_hoa":"' . $r_cart['minh_hoa'] . '","thanhtien":"' . $r_cart['thanhtien'] . '"}';
					}
				}
			}
			$sanpham = '{' . $list . '}';
			$phi_ship = 0;
			$tongtien = $tamtinh + $phi_ship;
			//$ma_don = $shop . '' . $check->random_number(6);
			$ma_don = $class_index->creat_random($conn,'donhang');
			$noti=0;
			if (intval($total_sp) < 1 OR $tongtien < 1000) {
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
					$moi = $r_kho[$chon_kho] - $_SESSION['drop_cart'][$id_sp_kho]['quantity'];
					if ($chon_kho == 'kho_hcm') {
						mysqli_query($conn, "UPDATE sanpham SET kho_hcm='$moi' WHERE id='{$r_kho['id']}'");
					} else {
						mysqli_query($conn, "UPDATE sanpham SET kho='$moi' WHERE id='{$r_kho['id']}'");
					}
					if($moi<3){
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
				mysqli_query($conn, "INSERT INTO donhang(ma_don,minh_hoa,minh_hoa2,user_id,ho_ten,email,dien_thoai,dia_chi,tinh,huyen,xa,ncc,sanpham,tamtinh,coupon,giam,phi_ship,tongtien,kho,status,thanhtoan,ghi_chu,utm_source,utm_campaign,date_update,date_post)VALUES('$ma_don','$minh_hoa','$minh_hoa2','$user_id','$ho_ten','$email','$dien_thoai','$dia_chi','$tinh','$huyen','0','1','$sanpham','$tamtinh','','0','$phi_ship','$tongtien','$drop_kho','0','online','$ghi_chu','',''," . time() . "," . time() . ")");
				$noidung = 'Đặt hàng drop, mã đơn hàng #' . $ma_don;
				mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$tongtien','$truoc','$sau','$noidung'," . time() . ")");
				$ngay_thang=date('d-m-Y');
				$hientai=time();
				mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('$user_id','{$user_info['name']}','{$user_info['mobile']}','$tamtinh','$tongtien','','$ngay_thang','$hientai')");
				$_SESSION['ma_don'] = $ma_don;
				unset($_SESSION['drop_cart']);
			}
			echo json_encode(array('ok' => $ok,'noti'=>$noti, 'thongbao' => $thongbao));
?>