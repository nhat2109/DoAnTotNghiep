<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $active=intval($_REQUEST['active']);
    $thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
    $noidung = addslashes($_REQUEST['noidung']);
    $thu_tu = intval($_REQUEST['thu_tu']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $duoi_cover = $check->duoi_file($_FILES['cover']['name']);
    if(strlen($tieu_de)<3){
        $thongbao = 'Vui lòng nhập tiêu đề';
        $ok = 0;
    }else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == false) {
        $thongbao = 'Vui lòng chọn ảnh minh họa';
        $ok = 0;
    }else if(in_array($duoi_cover, array('jpg', 'jpeg', 'png', 'gif','webp')) == false){
        $thongbao = 'Vui lòng chọn ảnh giới thiệu';
        $ok = 0;
    }else{
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        $cover = '/uploads/minh-hoa/cover-' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi_cover;
        move_uploaded_file($_FILES['cover']['tmp_name'], '..' . $cover);
        $thongbao = 'Thêm marketing thương hiệu thành công';
        $ok = 1;
        mysqli_query($conn, "INSERT INTO banner_qc(thuong_hieu,tieu_de,minh_hoa,cover,noi_dung,thu_tu,active)VALUES('$thuong_hieu','$tieu_de','$minh_hoa','$cover','$noidung','$thu_tu','$active')");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>