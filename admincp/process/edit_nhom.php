<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('nhom', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $id=intval($_REQUEST['id']);
    $thongbao = 'Sửa nhóm thành công';
    $ok = 1;
    mysqli_query($conn, "UPDATE nhom SET tieu_de='$tieu_de' WHERE id='$id'");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>