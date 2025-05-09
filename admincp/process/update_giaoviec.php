<?php
$id = addslashes($_REQUEST['id']);
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
$thongbao = "Giao lại thành công!";
$status = 0;
$sql = "UPDATE giao_viec SET 
    nguoi_giao = '{$user_info['id']}',
    nguoi_nhan = '{$nguoi_nhan}',
    phongban_nhan = '{$phongban_nhan}',
    nguoigiamsat = '{$nguoigiamsat}',
    tieu_de = '{$ten_congviec}',
    noi_dung = '{$chitiet_congviec}',
    date_line = '{$thoi_han}',
    dinh_kem = '{$file_name}',
    status = '0',
    uu_tien = '{$uu_tien}',
    update_at = '$created_at',
    thoigian_phainhanviec = '{$thoigian_phainhanviec}',
    miss_deadline = null,
    cham_tiendo = null,
    created_at = '{$created_at}'
WHERE id = '{$id}'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi SQL: " . mysqli_error($conn));
}
$info = array(
    'ok' => $ok,
    'noti'=>1,
    'thongbao' => $thongbao,
);
echo json_encode($info);
