<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Phương thức request không hợp lệ!'
    ]);
    exit;
}
$id = isset($_POST['id']) ? $_POST['id'] : '';
$shop = isset($_POST['shop']) ? $_POST['shop'] : '';
$tieu_de = isset($_POST['tieu_de']) ? $_POST['tieu_de'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$loai = isset($_POST['loai']) ? $_POST['loai'] : '';
$giao_dien = isset($_POST['giao_dien']) ? $_POST['giao_dien'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';

if (empty($id) || empty($shop) || empty($name)) {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Thiếu thông tin bắt buộc!'
    ]);
    exit;
}

$feedback_data = [];

if (isset($_POST['user_name']) && is_array($_POST['user_name'])) {
    foreach ($_POST['user_name'] as $index => $user_name) {
        $danh_gia = isset($_POST['danh_gia'][$index]) ? $_POST['danh_gia'][$index] : '';
        $noidung = isset($_POST['noidung'][$index]) ? $_POST['noidung'][$index] : '';

        $feedback_item = [
            'user_name' => $user_name,
            'danh_gia' => $danh_gia,
            'noidung' => $noidung,
        ];

        if (isset($_FILES['avatar']) && isset($_FILES['avatar']['name'][$index]) && $_FILES['avatar']['error'][$index] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['avatar']['error'][$index] !== UPLOAD_ERR_OK) {
                echo json_encode([
                    'ok' => 0,
                    'thongbao' => 'Lỗi khi tải ảnh lên: ' . $_FILES['avatar']['error'][$index]
                ]);
                exit;
            }

            $file_name = $_FILES['avatar']['name'][$index];
            $file_tmp = $_FILES['avatar']['tmp_name'][$index];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_ext, $allowed)) {
                echo json_encode([
                    'ok' => 0,
                    'thongbao' => 'Định dạng ảnh không hợp lệ! Chỉ chấp nhận jpg, jpeg, png, gif.'
                ]);
                exit;
            }

            if ($_FILES['avatar']['size'][$index] > 5 * 1024 * 1024) {
                echo json_encode([
                    'ok' => 0,
                    'thongbao' => 'Kích thước ảnh vượt quá 5MB!'
                ]);
                exit;
            }

            $upload_dir = '../uploads/minh-hoa/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name_new = uniqid('avatar_', true) . '.' . $file_ext;
            $file_destination = $upload_dir . $file_name_new;

            if (!move_uploaded_file($file_tmp, $file_destination)) {
                echo json_encode([
                    'ok' => 0,
                    'thongbao' => 'Không thể lưu ảnh vào thư mục!'
                ]);
                exit;
            }

            $feedback_item['avatar'] = '/uploads/minh-hoa/' . $file_name_new;
        }

        $feedback_data[] = $feedback_item;
    }
}

if (empty($feedback_data)) {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Không có dữ liệu feedback để lưu!'
    ]);
    exit;
}
$feedback_json = json_encode($feedback_data);

if ($feedback_json === false) {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Lỗi JSON: '
    ]);
    exit;
}

$tieu_de = mysqli_real_escape_string($conn, $tieu_de);
$name = mysqli_real_escape_string($conn, $name);
$loai = mysqli_real_escape_string($conn, $loai);
$giao_dien = mysqli_real_escape_string($conn, $giao_dien);
$description = mysqli_real_escape_string($conn, $description);
$feedback_json = mysqli_real_escape_string($conn, $feedback_json);
$id = mysqli_real_escape_string($conn, $id);
$shop = mysqli_real_escape_string($conn, $shop);

// Cập nhật dữ liệu vào database
$sql = "UPDATE shop_setting SET 
        tieu_de = '$tieu_de', 
        name = '$name', 
        loai = '$loai', 
        giao_dien = '$giao_dien', 
        description = '$description',
        value = '$feedback_json'
        WHERE id = '$id' AND shop = '$shop'";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode([
        'ok' => 1,
        'thongbao' => 'Cập nhật đánh giá thành công!'
    ]);
} else {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Có lỗi xảy ra khi cập nhật đánh giá: ' . mysqli_error($conn)
    ]);
}