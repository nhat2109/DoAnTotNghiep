<?php

$id= intval($_REQUEST['id']);
$tiendo = intval($_REQUEST['tiendo']);
$noi_dung = addslashes(strip_tags($_REQUEST['noidungbaocao']));
$thongtingiaoviec = mysqli_query($conn,"SELECT * FROM giao_viec WHERE id='$id'");
$update_line = time();
$r_thongtingiaoviec = mysqli_fetch_assoc($thongtingiaoviec);
if ($update_line >= strtotime('08:00') && $upstrtotime_line <= date('17:30')) {
    $status = "Đã báo cáo";
}else{
    $status = "Báo cáo muộn";
}
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
$baoCaoHienTai = !empty($r_thongtingiaoviec['bao_cao']) ? json_decode($r_thongtingiaoviec['bao_cao'], true) : [];
$baoCaoHienTai[] = [
    "b_cao" => $noi_dung,
    "xac_nhan" => false,
    "tien_do"   => $tiendo,
    "update_line"=>time(),
    "status"=> $status,
    "file_name"=>$file_name
];

$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);
if ($tiendo < $r_thongtingiaoviec['phantram']) {
    $thongbao = "Tiến độ không thể nhỏ hơn tiến độ hiện tại";
} elseif($tiendo > 100) {
    $thongbao = "Tiến độ không thể lớn hơn 100%";

}else {
    if ($tiendo == 100) {
        $filGiaoviec = ",status = '2'";
    }else{
        $filGiaoviec = "";
    }
    $sql = "UPDATE giao_viec SET phantram='$tiendo', bao_cao='$baoCaoJson',update_line = '{$update_line}', xac_nhan=NULL $filGiaoviec WHERE id='$id'";
    mysqli_query($conn, $sql);
    $thongbao = 'Update tiến độ thành công!';
}
$info = array(
    'ok' => 1,
    'thongbao' => $thongbao,
);
echo json_encode($info);