<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$list = $class_index->list_kq_timkiem_sanpham_tuan($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $key);
			$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
        <th style="text-align: left;width: 160px;">Thời gian</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
				<th style="text-align: center;width: 160px;" class="hide_mobile">Giá chương trình tuần</th>
			</tr>' . $list;
			$info = array(
				'ok' => 1,
				'list' => $list,
			);
			echo json_encode($info);
?>