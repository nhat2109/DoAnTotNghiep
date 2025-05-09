<?php
$user_id = $_SESSION['user_id'];
$email = addslashes(strip_tags($_REQUEST['email']));
$maso_thue = addslashes(strip_tags($_REQUEST['maso_thue']));
$maso_thue_cap = addslashes(strip_tags($_REQUEST['maso_thue_cap']));
$maso_thue_noicap = addslashes(strip_tags($_REQUEST['maso_thue_noicap']));
$tinh = addslashes(strip_tags($_REQUEST['tinh']));
$huyen = addslashes(strip_tags($_REQUEST['huyen']));
$xa = addslashes(strip_tags($_REQUEST['xa']));
$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));

$sql = "UPDATE user_info SET 
		email = '$email',
		maso_thue = '$maso_thue',
		maso_thue_cap = '$maso_thue_cap',
		maso_thue_noicap = '$maso_thue_noicap',
		tinh = '$tinh',
		huyen = '$huyen',
		xa = '$xa',
		dia_chi = '$dia_chi'
		WHERE id = '$user_id'";

if (mysqli_query($conn, $sql)) {
	echo json_encode(['status' => 'success', 'message' => 'Cập nhật thông tin thành công']);
} else {
	echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi cập nhật thông tin']);
}
?>