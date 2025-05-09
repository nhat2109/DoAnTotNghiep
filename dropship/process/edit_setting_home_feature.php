<?php
	// Lấy name từ id được gửi lên
	$name = $_POST['id'];
	
	// Kiểm tra dữ liệu đầu vào
	if (!isset($_POST['icons']) || !isset($_POST['titles']) || !isset($_POST['descs'])) {
		$info = array(
			'ok' => 0,
			'thongbao' => 'Dữ liệu không hợp lệ!'
		);
		echo json_encode($info);
		exit;
	}

	$icons = $_POST['icons'];
	$titles = $_POST['titles'];
	$descs = $_POST['descs'];
	$description = $_POST['description'];

	// Tạo mảng dữ liệu
	$features = array();
	for($i = 0; $i < count($icons); $i++) {
		$features[] = array(
			'icon' => $icons[$i],
			'title' => $titles[$i],
			'desc' => $descs[$i]
		);
	}

	$noidung = array(
		'features' => $features,
		'description' => $description
	);

	// Chuyển đổi thành JSON
	$noidung = json_encode($noidung, JSON_UNESCAPED_UNICODE);

	// Thực hiện UPDATE trực tiếp
	$sql = "UPDATE shop_setting SET value='".mysqli_real_escape_string($conn, $noidung)."' WHERE name='".mysqli_real_escape_string($conn, $name)."' AND shop='".$user_id."'";
	$result = mysqli_query($conn, $sql);

	// Debug info
	$debug = array(
		'sql' => $sql,
		'data' => array(
			'noidung' => $noidung,
			'name' => $name,
			'user_id' => $user_id
		),
		'mysql_error' => mysqli_error($conn),
		'mysql_affected_rows' => mysqli_affected_rows($conn)
	);

	if($result && mysqli_affected_rows($conn) > 0) {
		$ok = 1;
		$thongbao = 'Sửa cài đặt thành công!';
	} else {
		$ok = 0;
		$thongbao = 'Có lỗi xảy ra: ' . mysqli_error($conn);
	}

	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'debug' => $debug
	);
	echo json_encode($info);
?>