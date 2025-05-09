<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$ma_mau = addslashes($_REQUEST['ma_mau']);
			$thu_tu = intval($_REQUEST['thu_tu']);
			$thongbao = 'Thêm màu sản phẩm thành công';
			$ok = 1;
			mysqli_query($conn, "INSERT INTO mau_sanpham(shop,tieu_de, ma_mau,thu_tu)VALUES('$user_id','$tieu_de','$ma_mau','$thu_tu')");
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>