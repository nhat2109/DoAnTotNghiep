<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			$list = $class_index->list_kq_timkiem_donhang($conn,$user_id, $key);
			$info = array(
				'ok' => 1,
				'list' => $list,
			);
			echo json_encode($info);
?>