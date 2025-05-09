<?php 
if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
    echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
    exit();
}
$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
$noidung = addslashes($_REQUEST['noidung']);
mysqli_query($conn, "UPDATE index_setting SET value='$noidung' WHERE name='$name'");
$ok = 1;
$thongbao = 'Sửa cài đặt thành công!';
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>