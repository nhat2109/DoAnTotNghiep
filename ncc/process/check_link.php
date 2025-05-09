<?php
			$link = $_REQUEST['link'];
			$loai = addslashes($_REQUEST['loai']);
			$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo_shop WHERE link='$link' AND loai='$loai' AND shop='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
			} else {
				$ok = 1;
			}
			$info = array(
				'ok' => $ok,
				'link' => $link,
			);
			echo json_encode($info);
?>