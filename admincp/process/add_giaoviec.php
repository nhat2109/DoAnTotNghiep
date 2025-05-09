<?php
$nguoi_nhan = addslashes($_REQUEST['id_nhanvien']);
$phongban_nhan = addslashes($_REQUEST['phongban_nhan']);
$nguoigiamsat = addslashes($_REQUEST['nguoigiamsat']);
$ten_congviec = addslashes($_REQUEST['ten_congviec']);
$chitiet_congviec = addslashes($_REQUEST['chitiet_congviec']);
$thoigian = addslashes($_REQUEST['thoi_han']);
$uu_tien = addslashes($_REQUEST['uu_tien']);
$thoigian_phainhanviec = addslashes($_REQUEST['thoigian_phainhanviec']);

$thoi_han = strtotime($thoigian);
if ($_FILES['file'] != null) {
    if ($_FILES['file']['error'] !== 0) {
        die("Lỗi khi tải tệp lên! Mã lỗi: " . $_FILES['file']['error']);
    }
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/anh-cong-viec-duoc-giao/";

    // Tạo thư mục nếu chưa tồn tại
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = $_FILES['file']['name'];
    $filetmp = $_FILES['file']['tmp_name'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Đặt tên file theo ngày giờ để tránh trùng lặp
    $newFileName = date("d-m-Y-H-i-s") . "." . $extension;
    $filePath = $uploadDir . $newFileName;
    $file_name = '/uploads/anh-cong-viec-duoc-giao/' . $newFileName;
    // Kiểm tra quyền ghi của thư mục
    if (!is_writable($uploadDir)) {
        die("Thư mục không có quyền ghi: " . $uploadDir);
    }

    // Di chuyển file
    if (move_uploaded_file($filetmp, $filePath)) {
    }

    if (preg_match_all('/<img src="data:image\/(.*?);base64,(.*?)"/', $chitiet_congviec, $matches)) {
        foreach ($matches[2] as $index => $base64) {
            $imageData = base64_decode($base64);
            $fileType = $matches[1][$index];
            $fileName = "/uploads/anh-cong-viec-duoc-giao/" . time() . "_$index.$fileType";

            file_put_contents($fileName, $imageData);
        }
    }
}else{
    $file_name = '';
}
$created_at = time();

if (preg_match_all('/<img src=[\'\"]?data:image\/(.*?);base64,(.*?)[\'\"]?/', $chitiet_congviec, $matches)) {
    foreach ($matches[2] as $index => $base64) {
        $imageData = base64_decode($base64);
        $fileType = $matches[1][$index];

        // Kiểm tra phần mở rộng hợp lệ
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        if (!in_array($fileType, $allowedExtensions)) {
            die("Lỗi: Định dạng ảnh không hợp lệ ($fileType)");
        }

        $newImageName = time() . "_$index." . $fileType;
        $imagePath = $uploadDir . $newImageName;

        // Kiểm tra dữ liệu ảnh hợp lệ
        if ($imageData === false) {
            die("Lỗi: Không thể giải mã base64.");
        }

        // Lưu file ảnh
        if (file_put_contents($imagePath, $imageData) === false) {
            die("Lỗi: Không thể lưu ảnh vào $imagePath");
        }

        // Thay thế base64 bằng đường dẫn ảnh
        $chitiet_congviec = str_replace($matches[0][$index], '<img src="/uploads/anh-cong-viec-duoc-giao/' . $newImageName . '">', $chitiet_congviec);
    }
}

$phantram = '0';
$thongbao = "Giao việc thành công";
$status = 0;
// Sử dụng prepared statement
$stmt = mysqli_prepare($conn, 'INSERT INTO giao_viec (nguoi_giao,nguoi_nhan,phongban_nhan,nguoigiamsat,tieu_de,noi_dung,date_line,dinh_kem,status,phantram,uu_tien,created_at,thoigian_phainhanviec) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
mysqli_stmt_bind_param($stmt, 'isssssssiiiss', $user_info['id'], $nguoi_nhan, $phongban_nhan, $nguoigiamsat, $ten_congviec, $chitiet_congviec, $thoi_han, $file_name, $status, $phantram, $uu_tien, $created_at, $thoigian_phainhanviec);
mysqli_stmt_execute($stmt);
$phong_ban_id = mysqli_insert_id($conn); // Lấy id của phòng ban vừa thêm
mysqli_stmt_close($stmt);
$noidung_notification='Giao việc mới: '.$ten_congviec;
$query = "INSERT INTO notification(user_id, sp_id, noi_dung, doc, bo_phan, admin, date_post,giaoviec)
VALUES ('{$user_info['id']}', '0', '$noidung_notification', '', '', '1', " . time() . ",'giaoviec')";

mysqli_query($conn, $query);

$info = array(
    'ok' => 1,
    'noti'=>1,
    'thongbao' => $thongbao,
);
echo json_encode($info);
