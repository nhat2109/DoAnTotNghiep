<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $anh=addslashes($_REQUEST['anh']);
    $tach_anh=explode('/uploads/', $anh);
    @unlink('../uploads/'.$tach_anh[1]);
    $ok=1;
    $thongbao='Xóa ảnh thành công!';
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>