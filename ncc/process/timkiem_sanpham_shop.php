<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			$list = $class_index->list_kq_timkiem_sanpham_shop($conn,$user_info['leader'],$user_info['gia_leader'], $user_id, $key);
			$list = '
			<thead style="z-index: 1;">
				<tr>
					<th style="text-align: center;"><input type="checkbox" id="select-all"></th>
					<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
					<th style="text-align: center;width: 120px;" class="hide_mobile">Mã</th>
					<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
					<th style="text-align: left;">Tên sản phẩm</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán lẻ</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Kho</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Đã bán</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">View</th>
					<th style="text-align: center;width: 160px;">Hành động</th>
				</tr>
			</thead>
			' . $list;
			$info = array(
				'ok' => 1,
				'list' => $list,
			);
			echo json_encode($info);
?>