<?php
$user_id = $_COOKIE['user_id'];
$sql = "SELECT * FROM user_address WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
			
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		echo '<div class="address-item">';
		echo '<div class="address-info">';
		echo '<h5>' . $row['ten'] . '</h5>';
		echo '<p>' . $row['dien_thoai'] . '</p>';
		echo '<p>' . $row['dia_chi'] . '</p>';
		echo '</div>';
		echo '<div class="address-actions">';
		echo '<button class="btn btn-sm btn-primary" onclick="editAddress(' . $row['id'] . ')">Sửa</button>';
		echo '<button class="btn btn-sm btn-danger" onclick="deleteAddress(' . $row['id'] . ')">Xóa</button>';
		echo '</div>';
		echo '</div>';
	}
} else {
	echo '<p class="text-muted">Chưa có địa chỉ nào</p>';
}
exit;
?>