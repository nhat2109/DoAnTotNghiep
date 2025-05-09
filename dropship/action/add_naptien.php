<?php
	$thaythe['title'] = 'Nạp tiền vào tài khoản';
	$thaythe['title_action'] = 'Nạp tiền vào tài khoản';
	$step = addslashes(strip_tags($url_query['step']));
	if ($step == 2) {
		if (isset($_SESSION['naptien'])) {
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' AND id='{$_SESSION['naptien']}' ORDER BY id DESC LIMIT 1");
			$r_tt = mysqli_fetch_assoc($thongtin);
			$r_tt['sotien_2']=$r_tt['sotien'];
			$r_tt['sotien'] = number_format($r_tt['sotien']);
			$r_tt['bank_name'] = $index_setting['bank_name'];
			$r_tt['bank_account'] = $index_setting['bank_account'];
			$r_tt['bank_holder'] = $index_setting['bank_holder'];
			$r_tt['username'] = $user_info['username'];
			$r_tt['id_nap'] = $r_tt['id'];
			if ($r_tt['status'] == 1) {
				$thongbao = "Giao dịch này đã hoàn thành...";
				$replace = array(
					'title' => 'Giao dịch đã này hoàn thành...',
					'description' => $index_setting['description'],
					'thongbao' => $thongbao,
					'link_chuyen' => '/dropship/list-naptien',
				);
				echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
				exit();
			} else if ($r_tt['status'] == 2) {
				$thongbao = "Giao dịch này đã bị hủy...";
				$replace = array(
					'title' => 'Giao dịch này đã bị hủy...',
					'description' => $index_setting['description'],
					'thongbao' => $thongbao,
					'link_chuyen' => '/dropship/list-naptien',
				);
				echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
				exit();
			}
			$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_naptien_step2', $r_tt);
		} else {
			$thongbao = "Không có giao dịch nạp mới...";
			$replace = array(
				'title' => 'Không có giao dịch nạp mới...',
				'description' => $index_setting['description'],
				'thongbao' => $thongbao,
				'link_chuyen' => '/dropship/list-naptien',
			);
			echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
			exit();
		}

	} else {
		$r_tt['user_money'] = number_format($user_info['user_money']);
		$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_naptien_step1', $r_tt);
	}
?>