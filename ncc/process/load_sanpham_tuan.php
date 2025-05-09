<?php
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$page = intval($_REQUEST['page']);
			$page++;
			$limit = 25;
			$list = $class_index->list_sanpham_tuan($conn,$user_info['leader'],$user_info['gia_leader'],$kho, $user_id, $page, $limit);
			$info = array(
				'list' => $list,
				'page' => $page,
			);
			echo json_encode($info);
?>