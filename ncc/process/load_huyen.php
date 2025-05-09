<?php
$tinh = isset($_REQUEST['tinh']) ? intval($_REQUEST['tinh']) : 0;
error_log("Loading huyen for tinh: " . $tinh); // Debug

// Kiểm tra nếu $tinh rỗng hoặc không hợp lệ
if ($tinh <= 0) {
	error_log("Invalid tinh value: " . $tinh);
	echo json_encode(array('ok' => 0, 'list' => '<option value="">Chọn huyện</option>', 'thongbao' => 'Vui lòng chọn tỉnh hợp lệ'));
	exit;
}

$list = '<option value="">Chọn Quận/Huyện</option>';
$tinh = mysqli_real_escape_string($conn, $tinh); // Bảo mật đầu vào
$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC");

if (!$thongtin) {
	error_log("Query error for huyen_moi: " . mysqli_error($conn));
	echo json_encode(array('ok' => 0, 'list' => $list, 'error' => 'Lỗi truy vấn: ' . mysqli_error($conn)));
	exit;
}

$num_rows = mysqli_num_rows($thongtin);
error_log("Number of huyen records found: " . $num_rows); // Debug số bản ghi

if ($num_rows == 0) {
	error_log("No huyen found for tinh: " . $tinh);
	echo json_encode(array('ok' => 0, 'list' => $list, 'thongbao' => 'Không tìm thấy huyện cho tỉnh này'));
	exit;
}

while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$list .= '<option value="' . htmlspecialchars($r_tt['id']) . '">' . htmlspecialchars($r_tt['tieu_de']) . '</option>';
}

error_log("Generated huyen list: " . $list); // Debug danh sách
echo json_encode(array('ok' => 1, 'list' => $list));
exit;
			// $tinh = intval($_REQUEST['tinh']);
			// $congty_ship=addslashes($_REQUEST['congty_ship']);
			// if($congty_ship=='ninja_van'){
			// 	$list=$class_index->list_option_huyen_ninja($conn,$tinh,'');
			// }else{
			// 	$list=$class_viettel->option_huyen($tinh,'');
			// }
			// echo json_encode(array('list' => $list));
?>