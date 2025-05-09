<?php
$user_id = $_COOKIE['user_id'];
$email = addslashes($_POST['email']);
$maso_thue = addslashes($_POST['maso_thue']);
$maso_thue_cap = addslashes($_POST['maso_thue_cap']);
$maso_thue_noicap = addslashes($_POST['maso_thue_noicap']);
$tinh = addslashes($_POST['tinh']);
$huyen = addslashes($_POST['huyen']);
$xa = addslashes($_POST['xa']);
$dia_chi = addslashes($_POST['dia_chi']);

// Check if profile already exists
$check = mysqli_query($conn, "SELECT id FROM user_profile WHERE user_id = '$user_id'");
if(mysqli_num_rows($check) > 0) {
	echo json_encode(['success' => false, 'message' => 'Thông tin đã tồn tại']);
	exit;
}

// Insert new profile
$sql = "INSERT INTO user_profile (user_id, email, maso_thue, maso_thue_cap, maso_thue_noicap, tinh, huyen, xa, dia_chi) 
		VALUES ('$user_id', '$email', '$maso_thue', '$maso_thue_cap', '$maso_thue_noicap', '$tinh', '$huyen', '$xa', '$dia_chi')";

if(mysqli_query($conn, $sql)) {
	echo json_encode(['success' => true]);
} else {
	echo json_encode(['success' => false, 'message' => 'Lỗi khi lưu thông tin']);
}
exit;
?>