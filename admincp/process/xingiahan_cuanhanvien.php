<?php
$id = intval($_REQUEST['id']);
$noidung_xingiahan = addslashes($_REQUEST['noidung']);
$thoihan = addslashes($_REQUEST['thoihan']);
$tgian_xingiahan = strtotime($thoihan);
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
    $file_name = '--';
}
$sql = "SELECT noidung_xacnhan_giahan FROM giao_viec WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$baoCaoHienTai = !empty($row['noidung_xacnhan_giahan']) ? json_decode($row['noidung_xacnhan_giahan'], true) : [];
$baoCaoHienTai[] = [
    "xingiahan" => $noidung_xingiahan,
    "ngayxin_giahan"=>$tgian_xingiahan,
    "acp"=>"Chờ xét duyệt",
    "noidung_xacnhan"=>"--",
    "tgian_xacnhan"=>"--",
    "file_name"=>$file_name
];
$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);
$sql = "UPDATE giao_viec SET xac_nhan_giahan='0', noidung_xacnhan_giahan='$baoCaoJson' WHERE id='$id'";
mysqli_query($conn, $sql);
$info = [
    'ok'=>1,
    'thongbao'=>'Đã gửi xin gia hạn',
];
echo json_encode($info);