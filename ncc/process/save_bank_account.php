<?php
try {
    // Validate required fields
    $required_fields = ['account_name', 'id_number', 'bank_id', 'account_number', 'account_holder'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
        }
    }

    // Get and sanitize input
    $user_id = $tach_token['user_id'];
    $account_name = mysqli_real_escape_string($conn, trim($_POST['account_name']));
    $id_number = mysqli_real_escape_string($conn, trim($_POST['id_number']));
    $bank_id = intval($_POST['bank_id']);
    $branch_id = !empty($_POST['branch_id']) ? intval($_POST['branch_id']) : null;
    $account_number = mysqli_real_escape_string($conn, trim($_POST['account_number']));
    $account_holder = mysqli_real_escape_string($conn, strtoupper(trim($_POST['account_holder'])));
    $is_default = isset($_POST['is_default']) && $_POST['is_default'] == 1 ? 1 : 0;
    //$current_time = date('Y-m-d H:i:s');
    $current_time = strtotime("now");

    // Check if this is an edit operation
    $bank_account_id = isset($_POST['bank_account_id']) ? intval($_POST['bank_account_id']) : 0;

    // Validate bank exists
    $check_bank = mysqli_query($conn, "SELECT id FROM banks WHERE id = $bank_id AND status = 1");
    if (mysqli_num_rows($check_bank) == 0) {
        throw new Exception("Ngân hàng không hợp lệ");
    }

    // Validate branch if provided
    if ($branch_id) {
        $check_branch = mysqli_query($conn, "SELECT id FROM bank_branches WHERE id = $branch_id AND bank_id = $bank_id AND status = 1");
        if (mysqli_num_rows($check_branch) == 0) {
            throw new Exception("Chi nhánh không hợp lệ");
        }
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // If setting as default, unset all other default accounts
        if ($is_default) {
            $sql_unset_default = "UPDATE bank_accounts SET is_default = 0, updated_at = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $sql_unset_default);
            mysqli_stmt_bind_param($stmt, "si", $current_time, $user_id);
            mysqli_stmt_execute($stmt);
        }

        if ($bank_account_id > 0) {
            // Verify account ownership
            $check_ownership = mysqli_query($conn, "SELECT id FROM bank_accounts WHERE id = $bank_account_id AND user_id = $user_id");
            if (mysqli_num_rows($check_ownership) == 0) {
                throw new Exception("Không tìm thấy tài khoản hoặc bạn không có quyền chỉnh sửa");
            }

            // Update existing account
            $sql = "UPDATE bank_accounts SET 
                    account_name = ?,
                    id_number = ?,
                    bank_id = ?,
                    branch_id = ?,
                    account_number = ?,
                    account_holder = ?,
                    is_default = ?,
                    updated_at = ?
                    WHERE id = ? AND user_id = ?";
            
            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "ssiissisii",
                $account_name,
                $id_number,
                $bank_id,
                $branch_id,
                $account_number,
                $account_holder,
                $is_default,
                $current_time,
                $bank_account_id,
                $user_id
            );
        } else {
            // Insert new account
            $sql = "INSERT INTO bank_accounts 
                    (user_id, account_name, id_number, bank_id, branch_id, 
                    account_number, account_holder, is_default, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "issiississ",
                $user_id,
                $account_name,
                $id_number,
                $bank_id,
                $branch_id,
                $account_number,
                $account_holder,
                $is_default,
                $current_time,
                $current_time
            );
        }

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Lỗi thực thi câu lệnh: " . mysqli_stmt_error($stmt));
        }

        mysqli_commit($conn);
        echo json_encode([
            'status' => 'success',
            'message' => $bank_account_id > 0 ? 'Cập nhật tài khoản thành công' : 'Thêm tài khoản mới thành công'
        ]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 