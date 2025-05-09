<?php
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$kieu=addslashes($_REQUEST['kieu']);
			$page = intval($_REQUEST['page']);
			$page++;
			$limit = 100;
			if($kieu=='mobile'){
				$list = $class_index->list_sanpham_trend($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $user_id, $page, $limit);
			}else{
				$list = $class_index->list_sanpham_trend($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $user_id, $page, $limit);

			}
			$info = array(
				'list' => $list,
				'page' => $page,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>