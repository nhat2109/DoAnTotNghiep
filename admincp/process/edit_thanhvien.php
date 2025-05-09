<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $name = addslashes(strip_tags($_REQUEST['name']));
    $dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
    $active = intval($_REQUEST['active']);
    $nhan_vien = intval($_REQUEST['nhan_vien']);
    $dropship = intval($_REQUEST['dropship']);
    $leader = intval($_REQUEST['leader']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thành viên không tồn tại';
    } else {
        if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
            $minh_hoa = '/uploads/avatar/' . $check->blank($name) . '-' . time() . '.' . $duoi;
            move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
            $thongbao = 'Sửa thành viên thành công';
            $ok = 1;
            mysqli_query($conn, "UPDATE user_info SET name='$name',avatar='$minh_hoa',active='$active',mobile='$dien_thoai',leader='$leader',dropship='$dropship',nhan_vien='$nhan_vien' WHERE user_id='$id'");
            @unlink('..' . $r_tt['avatar']);
        } else {
            mysqli_query($conn, "UPDATE user_info SET name='$name',active='$active',mobile='$dien_thoai',leader='$leader',dropship='$dropship',nhan_vien='$nhan_vien' WHERE user_id='$id'");
            $thongbao = 'Sửa thành viên thành công';
            $ok = 1;
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>