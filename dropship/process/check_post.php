<?php
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_shop WHERE sp_id='$id' AND shop='$user_id' ORDER BY id DESC LIMIT 1");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 1;
			} else {
				$ok = 0;
				$thongbao = 'Sản phẩm này đã có trên website của bạn';
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>