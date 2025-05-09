<?php

$src = $_POST['src'] ?? '';

if (empty($src)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thiếu đường dẫn ảnh!']);
    exit;
}

$filePath = '..' . $src;
if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo json_encode(['ok' => 1, 'thongbao' => 'Ảnh đã được xóa.']);
    } else {
        echo json_encode(['ok' => 0, 'thongbao' => 'Không thể xóa ảnh.']);
    }
} else {
    echo json_encode(['ok' => 0, 'thongbao' => 'Ảnh không tồn tại.']);
}
