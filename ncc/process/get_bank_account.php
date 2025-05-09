<?php
try {
    $id = intval($_POST['id']);
    $user_id = $tach_token['user_id'];
    
    $sql = "SELECT ba.*, b.code as bank_code, b.name as bank_name, b.logo as bank_logo,
            bb.code as branch_code, bb.name as branch_name, bb.address as branch_address,
            bb.province_id, t.tieu_de as province_name
            FROM bank_accounts ba
            LEFT JOIN banks b ON ba.bank_id = b.id
            LEFT JOIN bank_branches bb ON ba.branch_id = bb.id
            LEFT JOIN tinh_moi t ON bb.province_id = t.id
            WHERE ba.id = ? AND ba.user_id = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Lỗi thực thi truy vấn: " . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        // Ensure all necessary fields are included
        $data = array(
            'id' => $row['id'],
            'account_name' => $row['account_name'],
            'id_number' => $row['id_number'],
            'bank_id' => $row['bank_id'],
            'bank_code' => $row['bank_code'],
            'bank_name' => $row['bank_name'],
            'bank_logo' => $row['bank_logo'],
            'province_id' => $row['province_id'],
            'province_name' => $row['province_name'],
            'branch_id' => $row['branch_id'],
            'branch_code' => $row['branch_code'],
            'branch_name' => $row['branch_name'],
            'branch_address' => $row['branch_address'],
            'account_number' => $row['account_number'],
            'account_holder' => $row['account_holder'],
            'is_default' => $row['is_default']
        );
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    } else {
        throw new Exception("Không tìm thấy thông tin tài khoản");
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 