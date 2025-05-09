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
    $id=intval($_REQUEST['id']);
    if(strlen($tieu_de)<3){
        $thongbao = 'Vui lòng nhập tiêu đề';
        $ok = 0;
    }else if(strlen($noidung)<15){
        $thongbao = 'Vui lòng nhập nội dung';
        $ok = 0;
    }else{
        $thongtin=mysqli_query($conn,"SELECT * FROM banner_qc WHERE id='$id'");
        $r_tt=mysqli_fetch_assoc($thongtin);
        if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
            $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
            move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
            @unlink('..'.$r_tt['minh_hoa']);
        }else{
            $minh_hoa=$r_tt['minh_hoa'];
        }
        if(in_array($duoi_cover, array('jpg', 'jpeg', 'png', 'gif','webp')) == true){
            $cover = '/uploads/minh-hoa/cover-' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi_cover;
            move_uploaded_file($_FILES['cover']['tmp_name'], '..' . $cover);
            @unlink('..'.$r_tt['cover']);
        }else{
            $cover=$r_tt['cover'];

        }
        $thongbao = 'Sửa marketing thương hiệu thành công';
        $ok = 1;
        mysqli_query($conn, "UPDATE banner_qc SET thuong_hieu='$thuong_hieu',tieu_de='$tieu_de',minh_hoa='$minh_hoa',cover='$cover',noi_dung='$noidung',thu_tu='$thu_tu',active='$active' WHERE id='$id'");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>