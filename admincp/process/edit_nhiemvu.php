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
    $id=intval($_REQUEST['id']);
    $thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM nhiem_vu WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if($r_tt['total']==0){
        $ok=0;
        $thongbao='Thất bại! Nhiệm vụ không tồn tại';
    }else{
        mysqli_query($conn, "UPDATE nhiem_vu SET tieu_de='$tieu_de',mo_ta='$noidung' WHERE id='$id'");
        $thongbao = 'Sửa nhiệm vụ thành công';
        $ok = 1;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>