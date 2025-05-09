<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$thu_tu = intval($_REQUEST['thu_tu']);
			$thongbao = 'Thêm kích cỡ thành công';
			$ok = 1;
			mysqli_query($conn, "INSERT INTO kich_co(shop,tieu_de,thu_tu)VALUES('$user_id','$tieu_de','$thu_tu')");
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>