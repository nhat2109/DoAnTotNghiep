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
    $thongbao = 'Thêm kích cỡ thành công';
    $ok = 1;
    mysqli_query($conn, "INSERT INTO kich_co(tieu_de,shop,thu_tu)VALUES('$tieu_de','0','$thu_tu')");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>