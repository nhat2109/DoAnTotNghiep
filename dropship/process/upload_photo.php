<?php
			$total = count((array)$_FILES['file']['name']);
			$truyen = intval($_REQUEST['truyen']);
			$k = 0;
			for ($i = 0; $i < $total; $i++) {
				$filename = $_FILES['file']['name'][$i];
				$duoi = $check->duoi_file($_FILES['file']['name'][$i]);
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
					$folder_name = '/uploads/minh-hoa/' . $truyen . '/';

					if (!file_exists('..' . $folder_name)) {
						mkdir('..' . $folder_name, 0777);
					} else {
					}
					$minh_hoa = $folder_name . '' . $check->blank(str_replace('.' . $duoi, '', $filename)) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
					//$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
					//$list .= $index_setting['link_domain'] . '' . substr($minh_hoa, 1) . "\n";
					$pt['src'] = '/' . substr($minh_hoa, 1);
					$list .= $skin->skin_replace('skin_cpanel/box_action/li_photo', $pt);
					$k++;
				}
			}
			if ($k > 0) {
				$ok = 1;
				$thongbao = 'Upload ảnh thành công!';
			} else {
				$thongbao = 'Không có ảnh nào được upload' . $total;
				$ok = 0;
			}
			echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao, 'list' => $list));
?>