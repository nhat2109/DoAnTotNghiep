<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$thu_tu = intval($_REQUEST['thu_tu']);
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM kich_co WHERE id='$id' AND shop='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Dữ liệu không tồn tại';
			} else {
				$thongbao = 'Sửa kích cỡ thành công';
				$ok = 1;
				mysqli_query($conn, "UPDATE kich_co SET tieu_de='$tieu_de',thu_tu='$thu_tu' WHERE id='$id' AND shop='$user_id'");
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>