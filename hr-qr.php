<?php
require 'vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
$link=addslashes($_REQUEST['link']);
// Tạo đối tượng QrCode với nội dung là URL
$qrCode = new QrCode($link); // Thay 'https://example.com' bằng URL của bạn

// Đặt cấp độ sửa lỗi (error correction level)
$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));

// Thiết lập kích thước và margin
$qrCode->setSize(300);
$qrCode->setMargin(10);

// Đường dẫn đến logo
$logoPath = './images/loadx.png'; // Điều chỉnh đường dẫn tới thư mục images

// Kiểm tra xem logo có tồn tại hay không
if (file_exists($logoPath) && is_file($logoPath)) {
    // Thiết lập logo
    $qrCode->setLogoPath($logoPath);
    $qrCode->setLogoSize(100, null); // Thiết lập chiều rộng của logo là 50 và chiều cao là tự động
}

// Thiết lập header để trả về hình ảnh PNG
header('Content-Type: image/png');

// Hiển thị mã QR code trực tiếp trong trình duyệt
echo $qrCode->writeString();
?>
