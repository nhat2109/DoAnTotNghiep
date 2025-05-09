<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_info WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$show_modal = false;
if (empty($user['email']) || empty($user['maso_thue']) || empty($user['dia_chi'])) {
	$show_modal = true;
}

echo json_encode(['show_modal' => $show_modal]);
?>