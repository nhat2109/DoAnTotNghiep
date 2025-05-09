<?php
$user_id = $_COOKIE['user_id'];
$sql = "SELECT * FROM user_bank WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		echo '<div class="bank-item">';
		echo '<div class="bank-info">';
		echo '<h5>' . $row['ten_ngan_hang'] . '</h5>';
		echo '<p>Số tài khoản: ' . $row['so_tai_khoan'] . '</p>';
		echo '<p>Chủ tài khoản: ' . $row['chu_tai_khoan'] . '</p>';
		echo '</div>';
		echo '<div class="bank-actions">';
		echo '<button class="btn btn-sm btn-primary" onclick="editBank(' . $row['id'] . ')">Sửa</button>';
		echo '<button class="btn btn-sm btn-danger" onclick="deleteBank(' . $row['id'] . ')">Xóa</button>';
		echo '</div>';
		echo '</div>';
	}
} else {
	echo '<p class="text-muted">Chưa có tài khoản ngân hàng nào</p>';
}
exit;
?>