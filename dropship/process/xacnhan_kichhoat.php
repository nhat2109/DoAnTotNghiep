<?php
			$sotien = preg_replace('/[^0-9]/', '', $_REQUEST['sotien']);
			if ($sotien >= 50000) {
				$ok = 1;
				$thongbao = 'Hệ thống đang chuyển hướng...';
				mysqli_query($conn, "INSERT INTO naptien(user_id,sotien,status,date_post,update_post)VALUES('$user_id','$sotien','0'," . time() . "," . time() . ")");
				$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
				$r_tt = mysqli_fetch_assoc($thongtin);
				$_SESSION['naptien'] = $r_tt['id'];
				$r_tt['username']=$user_info['username'];
				$so_tien=number_format($r_tt['sotien']);
				$r_tt['so_tien']=$so_tien;
				$step2=$skin->skin_replace('skin_dropship/box_action/step_kh_2', $r_tt);
			} else {
				$ok = 0;
				$thongbao = 'Vui lòng nhập số tiền từ 50,000 đ';
				$step2='';

			}
			$info = array(
				'ok' => $ok,
				'step2'=>$step2,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>