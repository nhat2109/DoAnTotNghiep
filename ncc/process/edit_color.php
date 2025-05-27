<?php
			 $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			 $ma_mau = addslashes($_REQUEST['ma_mau']);
			 $thu_tu = intval($_REQUEST['thu_tu']);
			 $id=intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM mau_sanpham WHERE id='$id' AND shop='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Dữ liệu không tồn tại';
			} else {
				$thongbao = 'Sửa màu sản phẩm thành công';
				$ok = 1;
				mysqli_query($conn, "UPDATE mau_sanpham SET tieu_de='$tieu_de',ma_mau='$ma_mau', thu_tu='$thu_tu' WHERE id='$id' AND shop='$user_id'");
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>