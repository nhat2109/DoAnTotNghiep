<?php
	$tinh_nhan=intval($_REQUEST['tinh']);
	$huyen_nhan=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$congty_ship=addslashes($_REQUEST['congty_ship']);
	$tien_thu=preg_replace('/[^0-9]/', '', $_REQUEST['cod']);
	$tinh_gui=1;
	$huyen_gui=25;
	$list_id='';
	foreach ($_SESSION['drop_cart'] as $key => $value) {
		if (intval($key) > 0) {
			$list_id .= $key . ',';
		}
		if (intval($value['pl']) > 0) {
			$list_pl .= $value['pl'] . ',';
		}
	}
	if($list_id==''){
		$ok=0;
	}else{
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
	}
	while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
		$id_sp = $r_cart['id'];
		if($user_info['leader']==1 OR $user_info['gia_leader']==1){
			$total_price += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
		}else{
			$total_price += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];				
		}
		$total_banle += $product_pl[$id_sp]['gia_moi'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
		$can_nang+=str_replace(',', '.', $product_pl[$id_sp]['can_nang'])*$_SESSION['drop_cart'][$id_sp]['quantity'];
	}
	$trongluong=$can_nang*1000;
	if($congty_ship=='ninja_van'){
		$thongtin_tinh=mysqli_query($conn,"SELECT * FROM tinh_ninja WHERE ma_tinh='$tinh_nhan'");
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
			$tong_ship = $phi_ship + ($total_banle/100)*0.5 + ($phi_ship/100)*8;
			$list='<option value="NEXTDAY" phi_ship="'.$tong_ship.'" phi_ship_text="'.number_format($tong_ship).' đ">Tiêu chuẩn - Phí: '.number_format($tong_ship).'đ</option>';
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
			$phi_ship = $phi_ship + ($total_banle/100)*0.5 + ($phi_ship/100)*8;
			$list='<option value="NEXTDAY" phi_ship="'.$phi_ship.'" phi_ship_text="'.number_format($phi_ship).' đ">Tiêu chuẩn - Phí: '.number_format($phi_ship).'đ</option>';
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
			$phi_ship = $phi_ship + ($total_banle/100)*0.5 + ($phi_ship/100)*8;
			$list='<option value="NEXTDAY" phi_ship="'.$phi_ship.'" phi_ship_text="'.number_format($phi_ship).' đ">Tiêu chuẩn - Phí: '.number_format($phi_ship).'đ</option>';
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
			$phi_ship = $phi_ship + ($total_banle/100)*0.5 + ($phi_ship/100)*8;
			$list='<option value="NEXTDAY" phi_ship="'.$phi_ship.'" phi_ship_text="'.number_format($phi_ship).' đ">Tiêu chuẩn - Phí: '.number_format($phi_ship).'đ</option>';
		}else{
			$list='';
		}
	}else{
		$login_step_1=$class_viettel->login_step_1();
		$info_login=json_decode($login_step_1,true);
		$token=$info_login['data']['token'];
		$token_client=$class_viettel->get_token_client($token);
		$list=$class_viettel->option_dichvu($token_client,$trongluong,$total_price,$tien_thu,$huyen_gui,$tinh_gui,$huyen_nhan,$tinh_nhan);
	}
	echo json_encode(array('list' => $list));
?>