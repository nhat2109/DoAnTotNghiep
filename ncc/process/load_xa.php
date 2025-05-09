<?php
$huyen = isset($_REQUEST['huyen']) ? intval($_REQUEST['huyen']) : 0;
error_log("Loading xa for huyen: " . $huyen); // Debug

// Kiểm tra nếu $huyen rỗng hoặc không hợp lệ
if ($huyen <= 0) {
	error_log("Invalid huyen value: " . $huyen);
	echo json_encode(array('ok' => 0, 'list' => '<option value="">Chọn xã</option>', 'thongbao' => 'Vui lòng chọn huyện hợp lệ'));
	exit;
}

$list = '<option value="">Chọn Xã/Phường</option>';
$huyen = mysqli_real_escape_string($conn, $huyen); // Bảo mật đầu vào
$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY tieu_de ASC");

if (!$thongtin) {
	error_log("Query error for xa_moi: " . mysqli_error($conn));
	echo json_encode(array('ok' => 0, 'list' => $list, 'error' => 'Lỗi truy vấn: ' . mysqli_error($conn)));
	exit;
}

$num_rows = mysqli_num_rows($thongtin);
error_log("Number of xa records found: " . $num_rows); // Debug số bản ghi

if ($num_rows == 0) {
	error_log("No xa found for huyen: " . $huyen);
	echo json_encode(array('ok' => 0, 'list' => $list, 'thongbao' => 'Không tìm thấy xã cho huyện này'));
	exit;
}

while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$list .= '<option value="' . htmlspecialchars($r_tt['id']) . '">' . htmlspecialchars($r_tt['tieu_de']) . '</option>';
}

error_log("Generated xa list: " . $list); // Debug danh sách
echo json_encode(array('ok' => 1, 'list' => $list));
exit;
	// $tinh = intval($_REQUEST['tinh']);
	// $huyen = intval($_REQUEST['huyen']);
	// $congty_ship=addslashes($_REQUEST['congty_ship']);
	// if($congty_ship=='ninja_van'){
	// 	$list=$class_index->list_option_xa_ninja($conn,$tinh,$huyen,'');
	// }else{
	// 	$list=$class_viettel->option_xa($huyen,'');
	// }
	// echo json_encode(array('list' => $list));
?>