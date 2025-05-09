<?php
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$date_start = addslashes(strip_tags($_REQUEST['date_start']));
	$date_end = addslashes(strip_tags($_REQUEST['date_end']));
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	$main_product = addslashes(strip_tags($_REQUEST['main_product']));
	$main_product = substr($main_product, 0, -1);
	$sub_product = addslashes(strip_tags($_REQUEST['sub_product']));
	$sub_product = substr($sub_product, 0, -1);
	$list_product_sub = addslashes(strip_tags($_REQUEST['list_product_sub']));
	$id = intval($_REQUEST['id']);
	if ($tieu_de == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên chương trình';
	} else if ($date_start == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập thời gian bắt đầu';
	} else if ($date_end == '') {
		$ok = 0;
		$thongbao = 'Vui lòng chọn thời gian kết thúc';
	} else if ($main_product == '') {
		$ok = 0;
		$thongbao = 'Vui lòng chọn sản phẩm chính';
	} else if ($sub_product == '') {
		$ok = 0;
		$thongbao = 'Vui lòng chọn sản phẩm kèm theo';
	} else {
		$ok = 1;
		$thongbao = 'Sửa deal thành công';
		$tach_start = explode(' ', $date_start);
		$tach_time_start = explode(':', $tach_start[0]);
		$tach_date_start = explode('/', $tach_start[1]);
		$start = mktime($tach_time_start[0], $tach_time_start[1], 00, $tach_date_start[1], $tach_date_start[0], $tach_date_start[2]);
		$tach_end = explode(' ', $date_end);
		$tach_time_end = explode(':', $tach_end[0]);
		$tach_date_end = explode('/', $tach_end[1]);
		$end = mktime($tach_time_end[0], $tach_time_end[1], 00, $tach_date_end[1], $tach_date_end[0], $tach_date_end[2]);
		mysqli_query($conn, "UPDATE deal SET tieu_de='$tieu_de',main_product='$main_product',sub_product='$list_product_sub',sub_id='$sub_product',date_start='$start',date_end='$end',loai='$loai' WHERE id='$id' AND shop='$user_id'");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>