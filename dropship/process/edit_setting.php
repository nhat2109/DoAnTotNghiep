<?php
			$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
			$noidung = addslashes($_REQUEST['noidung']);
			mysqli_query($conn, "UPDATE shop_setting SET value='$noidung' WHERE name='$name' AND shop='$user_id'");
			$ok = 1;
			$thongbao = 'Sửa cài đặt thành công!';
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>