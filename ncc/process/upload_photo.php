<?php
//3-4
$total = count((array)$_FILES['file']['name']);
$truyen = intval($_REQUEST['truyen']);
$maxFiles = 8;
$maxSize = 1 * 1024 * 1024;
$k = 0;
$list = "";
// var_dump($total);
//     die();
if ($total > $maxFiles) {
    echo json_encode(array('ok' => 0, 'thongbao' => "Bạn chỉ được upload tối đa $maxFiles ảnh."));
    exit();
}

for ($i = 0; $i < $total; $i++) {
    $filename = $_FILES['file']['name'][$i];
    $duoi = $check->duoi_file($filename);
    $size = $_FILES['file']['size'][$i];
    if (!in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
        continue; 
    }

    // Kiểm tra dung lượng file
    if ($size > $maxSize) {
        echo json_encode(array('ok' => 0, 'thongbao' => "Ảnh $filename vượt quá dung lượng tối đa 1MB."));
        exit();
    }

    $folder_name = '/uploads/minh-hoa/' . $truyen . '/';

    if (!file_exists('..' . $folder_name)) {
        mkdir('..' . $folder_name, 0777, true);
    }

    $minh_hoa = $folder_name . $check->blank(str_replace('.' . $duoi, '', $filename)) . '-' . time() . '.' . $duoi;
    move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
    $pt['name'] = $filename; //huyphuc12/05/2025
    $pt['src'] = '/' . substr($minh_hoa, 1);
    $list .= $skin->skin_replace('skin_ncc/box_action/li_photo', $pt); //huyphuc12/05/2025
    $k++;
}

if ($k > 0) {
    echo json_encode(array('ok' => 1, 'thongbao' => 'Upload ảnh thành công!', 'list' => $list));
} else {
    echo json_encode(array('ok' => 0, 'thongbao' => 'Không có ảnh nào được upload.'));
}
?>
