<?php
$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
$cat_title = strip_tags($_REQUEST['cat_title']);
$cat_description = strip_tags($_REQUEST['cat_description']);
$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
$link_old = addslashes($_REQUEST['link_old']);
$cat_thutu = intval($_REQUEST['cat_thutu']);
$cat_blank = addslashes($_REQUEST['cat_blank']);
$cat_link = addslashes($_REQUEST['cat_link']);
$cat_id = intval($_REQUEST['cat_id']);
$cat_main = intval($_REQUEST['cat_main']);
$cat_icon = addslashes($_REQUEST['cat_icon']);
$cat_index = intval($_REQUEST['cat_index']);
$cat_id_socdo = addslashes($_REQUEST['cat_id_socdo']); // Giữ nguyên chuỗi "8,9,10"

if (empty($cat_tieude)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng nhập tiêu đề']);
    exit;
}

$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM category_sanpham_shop WHERE cat_id='$cat_id' AND shop='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['total'] == 0) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Danh mục không tồn tại']);
    exit;
}

$minh_hoa = $r_tt['cat_img']; 
if (!empty($_FILES['file']['name'])) {
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($cat_tieude) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        @unlink('..' . $r_tt['cat_img']);
    }
}
if ($cat_blank != $link_old) {
    $thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo_shop WHERE link='$cat_blank' AND loai='category' AND shop='$user_id' LIMIT 1");
    $r_seo = mysqli_fetch_assoc($thongtin_seo);
    if ($r_seo['total'] > 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Link xem đã tồn tại']);
        exit;
    }
    mysqli_query($conn, "UPDATE seo_shop SET link='$cat_blank' WHERE link='$link_old' AND loai='category' AND shop='$user_id'");
}
$update_query = "UPDATE category_sanpham_shop SET 
    cat_tieude='$cat_tieude', 
    cat_main='$cat_main', 
    cat_blank='$cat_blank', 
    cat_img='$minh_hoa', 
    cat_link='$cat_link', 
    cat_noidung='$cat_noidung', 
    cat_title='$cat_title', 
    cat_description='$cat_description', 
    cat_thutu='$cat_thutu', 
    cat_icon='$cat_icon', 
    cat_index='$cat_index', 
    cat_id_socdo='$cat_id_socdo' 
WHERE cat_id='$cat_id' AND shop='$user_id'";

mysqli_query($conn, $update_query);

echo json_encode(['ok' => 1, 'thongbao' => 'Sửa danh mục thành công']);
?>
