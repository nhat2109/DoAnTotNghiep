<?php
$tieu_de = addslashes($_REQUEST['tieu_de']);
$noi_dung = addslashes($_REQUEST['noi_dung']);
$datetime = addslashes($_REQUEST['datetime_local']);
$nguoinhan = addslashes($_REQUEST['nguoinhan']);
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
$baoCaoHienTai[] = [
    "tieu_de" => $tieu_de,
    "noi_dung"=>$noi_dung,
    "acp"=>"Chờ xét duyệt",
    "noidung_xacnhan"=>"--",
    "created_at"=>"--",
    "file_name"=>$file_name
];
$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);
$created_at = time();
$datetime = strtotime(str_replace("T", " ", $datetime));

mysqli_query($conn,"INSERT INTO dexuat (tieu_de,noi_dung,file,created_at,baocao,trangthai,thoigian,nguoigui,nguoinhan) VALUES('$tieu_de','$noi_dung','$file_name','$created_at','$baoCaoJson','0','$datetime','{$user_info['id']}','$nguoinhan')");


$info = array(
    'ok'=>1,
    'noti'=>1,
    'thongbao'=>'Đã gửi đề xuất'
);
echo json_encode($info);