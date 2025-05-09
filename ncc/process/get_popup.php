<?php
			$thongtin = mysqli_query($conn, "SELECT * FROM thongbao WHERE FIND_IN_SET($user_id,poped)<1 AND pop='1' AND (noi_dang LIKE '%all%' OR noi_dang LIKE '%drop%') AND date_post>='{$user_info['created']}' AND FIND_IN_SET($user_id,doc)<1 ORDER BY id ASC LIMIT 1");
			$total = mysqli_num_rows($thongtin);
			if ($total == 0) {
				$ok = 0;
			} else {
				$ok = 1;
				$r_tt = mysqli_fetch_assoc($thongtin);
				$tach_doc = explode(',', $r_tt['poped']);
				if (in_array($user_id, $tach_doc) == true) {

				} else {
					if ($r_tt['poped'] == '') {
						mysqli_query($conn, "UPDATE thongbao SET poped='$user_id' WHERE id='{$r_tt['id']}'");
					} else {
						$poped = $r_tt['poped'] . ',' . $user_id;
						mysqli_query($conn, "UPDATE thongbao SET poped='$poped' WHERE id='{$r_tt['id']}'");
					}
				}
				$content = '<a href="/ncc/view-thongbao?id=' . $r_tt['id'] . '"><img src="' . $r_tt['img_pop'] . '" alt="' . $r_tt['tieu_de'] . '"></a>';
				//$content='';
			}
			$thongtin_doc = mysqli_query($conn, "SELECT * FROM thongbao WHERE FIND_IN_SET($user_id,doc)<1 AND (noi_dang LIKE '%all%' OR noi_dang LIKE '%drop%') AND date_post>='{$user_info['created']}' ");
			$total_doc = mysqli_num_rows($thongtin_doc);
			if ($total_doc > 9) {
				$total_doc = '9+';
			}
			$info = array(
				'ok' => $ok,
				'content' => $content,
				'total' => $total_doc,
			);
			echo json_encode($info);
?>