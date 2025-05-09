<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$thu_tu = intval($_REQUEST['thu_tu']);
			$thongbao = 'Thêm thương hiệu thành công';
			$ok = 1;
			mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,id_thuonghieu_socdo,trang_thai_duyet)VALUES('$user_id','$tieu_de','$thu_tu',0,0)");
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>