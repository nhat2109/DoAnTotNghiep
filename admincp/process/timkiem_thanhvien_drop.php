<?php

$key = addslashes(strip_tags($_REQUEST['key']));
$key = trim($key);
$list = $class_index->list_kq_timkiem_thanhvien_drop($conn, $key);
$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;" class="hide_mobile">Ngày</th>
				<th style="text-align: left;" class="hide_mobile">Người quản lý</th>
				<th style="text-align: left;width: 200px">Họ tên</th>
				<th style="text-align: left;" class="hide_mobile">Tài khoản</th>
				<th style="text-align: left;" class="hide_mobile">Chuyên nghiệp</th>
				<th style="text-align: center;" class="hide_mobile">Điện thoại</th>
				<th style="text-align: center;" class="hide_mobile">TK chính</th>
				<th style="text-align: center;" class="hide_mobile">TK Khuyến mại</th>
				<th style="text-align: center;width: 350px;">Tình trạng</th>
			</tr>' . $list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
