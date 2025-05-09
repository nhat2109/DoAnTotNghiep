<?php
header('Content-Type: application/json; charset=utf-8');
try {
    if (!isset($_COOKIE['emin_id'])) {
        throw new Exception('Bạn chưa đăng nhập');
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    if (!$user_id || !in_array($status, [1,2,3])) {
        throw new Exception('Dữ liệu không hợp lệ');
    }

    // Update status
    $update = mysqli_query($conn, 
        "UPDATE user_info 
         SET status_cre = '$status'
         WHERE user_id = '$user_id'"
    );

    if (!$update) {
        throw new Exception(mysqli_error($conn));
    }

    // Get fresh statistics
    $stats_query = mysqli_query($conn, 
        "SELECT COALESCE(u.status_cre, '3') as status_cre, COUNT(*) as count
         FROM khach_hang k
         LEFT JOIN user_info u ON u.user_id = k.user_socdo 
         WHERE u.status_cre IN (1,2,3) OR u.status_cre IS NULL
         GROUP BY COALESCE(u.status_cre, '3')"
    );

    // Initialize counters
    $stats = ['1' => 0, '2' => 0, '3' => 0];
    
    // Update with actual counts
    while ($row = mysqli_fetch_assoc($stats_query)) {
        $stats[$row['status_cre']] = (int)$row['count'];
    }

    echo json_encode([
        'ok' => true,
        'stats' => $stats
    ]);

} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
exit;
?>