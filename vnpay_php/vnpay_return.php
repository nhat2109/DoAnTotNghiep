<?php
session_start();
require_once("./config.php");

// Lấy dữ liệu từ VNPay
$vnp_ResponseCode = $_GET['vnp_ResponseCode'];
$vnp_TxnRef = $_GET['vnp_TxnRef'];
$vnp_Amount = $_GET['vnp_Amount'];
$vnp_SecureHash = $_GET['vnp_SecureHash'];

// Debug GET parameters
file_put_contents('vnpay_debug.log', "GET Parameters: " . print_r($_GET, true) . "\n", FILE_APPEND);

// Xác thực chữ ký
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_" && $key != "vnp_SecureHash" && $key != "vnp_SecureHashType") {
        $inputData[$key] = $value;
    }
}
ksort($inputData);
$hashData = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
    } else {
        $hashData .= urlencode($key) . '=' . urlencode($value);
        $i = 1;
    }
}
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Debug hash data and signatures
file_put_contents('vnpay_debug.log', "Hash Data: $hashData\nSecure Hash: $secureHash\nVNP Secure Hash: $vnp_SecureHash\n", FILE_APPEND);

// Kết nối database
$conn = mysqli_connect("localhost", "root", "", "doantotnghiep");
if (!$conn) {
    file_put_contents('vnpay_debug.log', "Connection failed: " . mysqli_connect_error() . "\n", FILE_APPEND);
    die("Connection failed: " . mysqli_connect_error());
}

if ($secureHash == $vnp_SecureHash) {
    if ($vnp_ResponseCode == '00') {
        // Thanh toán thành công
        $order_id = $vnp_TxnRef;
        $payment_status = 'success';
        $amount = $vnp_Amount / 100;
        $transaction_id = $_GET['vnp_TransactionNo'];

        // Debug payment data
        file_put_contents('vnpay_debug.log', "Order ID: $order_id, Amount: $amount, Transaction ID: $transaction_id, Payment Status: $payment_status\n", FILE_APPEND);

        // Cập nhật trạng thái đơn hàng trong donhang_shop
        $stmt = mysqli_prepare($conn, "UPDATE donhang_shop SET status = '1', thanhtoan = 'vnpay' WHERE ma_don = ?");
        mysqli_stmt_bind_param($stmt, "s", $order_id);
        if (!mysqli_stmt_execute($stmt)) {
            file_put_contents('vnpay_debug.log', "Error updating donhang_shop: " . mysqli_error($conn) . "\n", FILE_APPEND);
            header('Location: https://giaodiennhat.vn/checkout.html?error=update_failed');
            exit();
        }
        mysqli_stmt_close($stmt);

        // Lưu thông tin thanh toán
        $stmt = mysqli_prepare($conn, "
            INSERT INTO order_payments (
                order_id,
                payment_method,
                amount,
                transaction_id,
                payment_status,
                created_at
            ) VALUES (?, 'vnpay', ?, ?, ?, NOW())
        ");
        mysqli_stmt_bind_param($stmt, "sdss", $order_id, $amount, $transaction_id, $payment_status);
        if (!mysqli_stmt_execute($stmt)) {
            file_put_contents('vnpay_debug.log', "Error inserting into order_payments: " . mysqli_error($conn) . "\n", FILE_APPEND);
            header('Location: https://giaodiennhat.vn/checkout.html?error=insert_payment_failed');
            exit();
        }
        mysqli_stmt_close($stmt);

        // Lưu mã đơn vào session
        $_SESSION['ma_don'] = $order_id;
        file_put_contents('vnpay_debug.log', "Session ma_don set to: " . $_SESSION['ma_don'] . "\n", FILE_APPEND);

        header('Location: https://giaodiennhat.vn/checkout.html?step=3');
        exit();
    } else {
        // Thanh toán thất bại
        file_put_contents('vnpay_debug.log', "Payment failed with response code: $vnp_ResponseCode\n", FILE_APPEND);
        header('Location: https://giaodiennhat.vn/checkout.html?error=payment_failed');
        exit();
    }
} else {
    // Chữ ký không hợp lệ
    file_put_contents('vnpay_debug.log', "Invalid signature. Calculated: $secureHash, Received: $vnp_SecureHash\n", FILE_APPEND);
    header('Location: https://giaodiennhat.vn/checkout.html?error=invalid_signature');
    exit();
}
?>