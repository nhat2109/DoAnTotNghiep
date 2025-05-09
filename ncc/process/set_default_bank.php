<?php
try {
    $id = intval($_POST['id']);
    $user_id = $tach_token['user_id'];
    //$current_time = date('Y-m-d H:i:s');
    $current_time = strtotime("now");
    
    // Check if account exists
    $check_sql = "SELECT id FROM bank_accounts WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Lỗi thực thi truy vấn: " . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 0) {
        throw new Exception("Không tìm thấy tài khoản");
    }
    
    mysqli_begin_transaction($conn);
    
    try {
        // Unset all default accounts
        $sql1 = "UPDATE bank_accounts SET is_default = 0 WHERE user_id = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        if (!$stmt1) {
            throw new Exception("Lỗi chuẩn bị truy vấn 1: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt1, "i", $user_id);
        if (!mysqli_stmt_execute($stmt1)) {
            throw new Exception("Lỗi thực thi truy vấn 1: " . mysqli_stmt_error($stmt1));
        }
        
        // Set new default
        $sql2 = "UPDATE bank_accounts SET is_default = 1 WHERE id = ? AND user_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        if (!$stmt2) {
            throw new Exception("Lỗi chuẩn bị truy vấn 2: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt2, "ii", $id, $user_id);
        if (!mysqli_stmt_execute($stmt2)) {
            throw new Exception("Lỗi thực thi truy vấn 2: " . mysqli_stmt_error($stmt2));
        }
        
        mysqli_commit($conn);
        echo json_encode(['status' => 'success', 'message' => 'Đã đặt làm tài khoản mặc định']);
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
    
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 