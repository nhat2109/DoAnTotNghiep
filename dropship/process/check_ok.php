<?php
			$phi_ship=intval($_REQUEST['phi_ship']);
			$tong_hoahong=intval($_REQUEST['tong_hoahong']);
			$tong_tiensan=intval($_REQUEST['tong_tiensan']);
			$total_cod=intval($_REQUEST['total_cod']);
			$total_sp = 0;
			foreach ($_SESSION['drop_cart'] as $key => $value) {
				if (intval($key) > 0) {
					$list_id .= $key . ',';
					$total_sp++;
				}
			}
			$list_id = substr($list_id, 0, -1);
			if($total_sp==0){
				$ok=0;
				$thongbao='Thất bại! Không có sản phẩm trong giỏ hàng';
			}else{
				if($tong_hoahong<0){
					$total_tien = $tong_tiensan + $phi_ship + ($tong_hoahong*-1);
				}else{
					$total_tien = $tong_tiensan;
				}
				$tien_tk=$user_info['user_money'] + $user_info['user_money2'];
				if($total_tien<=$tien_tk){
					$ok=1;
					$thongbao='Hệ thống đang xử lý';
				}else{
					$ok=0;
					$thongbao='Thất bại! Số tiền trong tài khoản không đủ';
				}
			}
			echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
?>