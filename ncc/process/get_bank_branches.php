<?php
try {
	$bank_id = isset($_GET['bank_id']) ? intval($_GET['bank_id']) : 0;
	$province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;
	
	if (!$bank_id || !$province_id) {
		throw new Exception('Thiếu thông tin ngân hàng hoặc tỉnh/thành phố');
	}

	// Validate bank exists and active
	$check_bank = mysqli_query($conn, "SELECT id FROM banks WHERE id = $bank_id AND status = 1");
	if (mysqli_num_rows($check_bank) == 0) {
		throw new Exception('Ngân hàng không hợp lệ');
	}

	// Get branches
	$sql = "SELECT id, code, name, address 
			FROM bank_branches 
			WHERE bank_id = ? AND province_id = ? AND status = 1 
			ORDER BY name ASC";
			
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
	}

	mysqli_stmt_bind_param($stmt, "ii", $bank_id, $province_id);
	if (!mysqli_stmt_execute($stmt)) {
		throw new Exception("Lỗi thực thi truy vấn: " . mysqli_stmt_error($stmt));
	}

	$result = mysqli_stmt_get_result($stmt);
	$branches = [];
	
	while ($row = mysqli_fetch_assoc($result)) {
		$branches[] = [
			'id' => $row['id'],
			'code' => $row['code'],
			'name' => $row['name'],
			'address' => $row['address']
		];
	}

	echo json_encode([
		'status' => 'success',
		'data' => $branches
	]);

} catch (Exception $e) {
	error_log("Error in get_bank_branches: " . $e->getMessage());
	echo json_encode([
		'status' => 'error',
		'message' => $e->getMessage()
	]);
}
?>