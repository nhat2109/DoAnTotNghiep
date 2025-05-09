<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $pop = addslashes(strip_tags($_REQUEST['pop']));
    $noi_dang = addslashes(strip_tags($_REQUEST['noi_dang']));
    $noidung = addslashes($_REQUEST['noidung']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        $thongbao = 'Thêm thông báo thành công';
        $ok = 1;
        $duoi_pop = $check->duoi_file($_FILES['file_popup']['name']);
        if (in_array($duoi_pop, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
            $img_pop = '/uploads/minh-hoa/popup-' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi_pop;
            move_uploaded_file($_FILES['file_popup']['tmp_name'], '..' . $img_pop);
        } else {
            $img_pop = '';
        }
        mysqli_query($conn, "INSERT INTO thongbao(tieu_de,minh_hoa,img_pop,noi_dung,nhan,noi_dang,doc,pop,poped,date_post)VALUES('$tieu_de','$minh_hoa','$img_pop','$noidung','','$noi_dang','','$pop',''," . time() . ")");
    } else {
        $thongbao = 'Vui lòng chọn ảnh minh họa';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
