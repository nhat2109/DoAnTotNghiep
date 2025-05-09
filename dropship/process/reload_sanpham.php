<?php
			$kieu=addslashes($_REQUEST['kieu']);
			$limit = 25;
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			if($kieu=='mobile'){
				$list = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $user_id, 1, $limit);
			}else{
				$list = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $user_id, 1, $limit);

			}
			$info = array(
				'list' => $list,
				'page' => 2,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>