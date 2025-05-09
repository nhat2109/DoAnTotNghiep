<?php
$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
$link = $check->blank($tieu_de);
$thu_tu = intval(strip_tags($_REQUEST['thu_tu']));
$id = intval($_REQUEST['id']);
if ($tieu_de == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập tiêu đề danh mục';
} else if ($thu_tu == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập thứ tự';
} else {
    mysqli_query($conn, "UPDATE category_video SET tieu_de='$tieu_de',link='$link',thu_tu='$thu_tu' WHERE id='$id'");
    $ok = 1;
    $thongbao = 'Lưu danh mục video thành công';
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
