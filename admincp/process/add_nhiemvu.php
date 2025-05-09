<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('nhiemvu', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();	
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $ngay = addslashes(strip_tags($_REQUEST['ngay']));
    $noidung = addslashes($_REQUEST['noidung']);
    $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM nhiem_vu WHERE ngay='$ngay'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] == 0) {
        $thongbao = 'Thêm nhiệm vụ thành công';
        $ok = 1;
        mysqli_query($conn, "INSERT INTO nhiem_vu(tieu_de,ngay,mo_ta)VALUES('$tieu_de','$ngay','$noidung')");
    } else {
        $ok = 0;
        $thongbao = "Nhiệm vụ ngày ".$ngay.' đã tồn tại';
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>