<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
    $minh_hoa = '';
} else {
    $filename = $_FILES['file']['name'];
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
        $minh_hoa = '/uploads/hinh-anh/' . $check->blank(str_replace('.'.$duoi,'', $filename)) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        $thongbao = 'Upload ảnh thành công';
        $ok = 1;
        $minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
    } else {
        $thongbao = 'Vui lòng chọn ảnh minh họa';
        $ok = 0;
        $minh_hoa = '';
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'minh_hoa' => $minh_hoa,
);
echo json_encode($info);?>