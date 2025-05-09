<?php
			$name = strip_tags(addslashes($_REQUEST['name']));
			$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
			$tinh=intval($_REQUEST['tinh']);
			$huyen=intval($_REQUEST['huyen']);
			$xa=intval($_REQUEST['xa']);
			$maso_thue=addslashes($_REQUEST['maso_thue']);
			$maso_thue_cap=addslashes($_REQUEST['maso_thue_cap']);
			$maso_thue_noicap=addslashes($_REQUEST['maso_thue_noicap']);
			$dia_chi=addslashes($_REQUEST['dia_chi']);
			$email=addslashes($_REQUEST['email']);
			if (strlen($name) < 2) {
				$thongbao = "Vui lòng nhập họ và tên";
				$ok = 0;
			} else {
				mysqli_query($conn, "UPDATE user_info SET name='$name',mobile='$mobile',tinh='$tinh',huyen='$huyen',xa='$xa',dia_chi='$dia_chi',maso_thue='$maso_thue',maso_thue_cap='$maso_thue_cap',maso_thue_noicap='$maso_thue_noicap',email='$email' WHERE user_id='$user_id'");
				$ok = 1;
				$thongbao = 'Sửa thông tin thành công!';
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>