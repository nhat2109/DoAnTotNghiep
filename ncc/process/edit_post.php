<?php
			$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
			$title = addslashes(strip_tags($_REQUEST['title']));
			$description = addslashes(strip_tags($_REQUEST['description']));
			$noidung = addslashes($_REQUEST['noidung']);
			$duoi = $check->duoi_file($_FILES['file']['name']);
			$category = addslashes($_REQUEST['category']);
			$link = strip_tags(addslashes($_REQUEST['link']));
			$link_old = strip_tags(addslashes($_REQUEST['link_old']));
			$id = intval($_REQUEST['id']);
			$thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE id='$id' AND shop='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($link == $link_old) {
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
					$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					$thongbao = 'Sửa bài viết thành công';
					$ok = 1;
					$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
					mysqli_query($conn, "UPDATE post_shop SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',cat='$category',noidung='$noidung',link='$link',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
					if (strpos($r_tt['minh_hoa'], $index_setting['link_img']) !== false) {
						@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
					} else {
						@unlink('..' . $r_tt['minh_hoa']);

					}
				} else {
					mysqli_query($conn, "UPDATE post_shop SET tieu_de='$tieu_de',noidung='$noidung',cat='$category',link='$link',title='$title',description='$description' WHERE id='$id'");
					$thongbao = 'Sửa bài viết thành công';
					$ok = 0;
				}
			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo_shop WHERE link='$link' AND shop='$user_id' AND loai='baiviet'");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] > 0) {
					$ok = 0;
					$thongbao = 'Link xem đã tồn tại';
				} else {
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
						$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
						$thongbao = 'Sửa bài viết thành công';
						$ok = 1;
						$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
						mysqli_query($conn, "UPDATE post_shop SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',cat='$category',noidung='$noidung',link='$link',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
						if (strpos($r_tt['minh_hoa'], $index_setting['link_img']) !== false) {
							@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
						} else {
							@unlink('..' . $r_tt['minh_hoa']);

						}
					} else {
						mysqli_query($conn, "UPDATE post_shop SET tieu_de='$tieu_de',noidung='$noidung',cat='$category',link='$link',title='$title',description='$description' WHERE id='$id' AND shop='$user_id'");
						$thongbao = 'Sửa bài viết thành công';
						$ok = 0;
					}
					mysqli_query($conn, "UPDATE seo_shop SET link='$link' WHERE link='$link_old' AND shop='$user_id' AND loai='baiviet'");
				}

			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
			);
			echo json_encode($info);
?>