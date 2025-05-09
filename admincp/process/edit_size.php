<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('size', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $thu_tu = intval($_REQUEST['thu_tu']);
    $id=intval($_REQUEST['id']);
    $thongbao = 'Sửa kích cỡ thành công';
    $ok = 1;
    mysqli_query($conn, "UPDATE kich_co SET tieu_de='$tieu_de',thu_tu='$thu_tu' WHERE id='$id'");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>