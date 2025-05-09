<?php
$key = addslashes(strip_tags($_REQUEST['key']));
	$list = $class_index->list_kq_timkiem_bom($conn, $key);
	$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;width: 150px">Người thêm</th>
				<th style="text-align: left; width: 150px;">Họ và tên</th>
				<th style="text-align: center;" class="hide_mobile">Điện thoại</th>
				<th style="text-align: left;" class="hide_mobile">Địa chỉ</th>
				<th style="text-align: left;width:250px;">Tình trạng bom</th>
				<th style="text-align: center;">Hành động</th>
			</tr>'.$list;
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
?>