
<?php
$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
$thu_tu = intval($_REQUEST['thu_tu']);
$id_thuonghieu_socdo = intval($_REQUEST['id_thuonghieu_socdo']);
$thongbao = 'Thêm thương hiệu thành công';
$ok = 1;
if (strlen($tieu_de) < 2) {
    $ok = 0;
    $thongbao = 'Tên thương hiệu phải có ít nhất 2 ký tự';
} else {
    if ($id_thuonghieu_socdo == 0) {
        $tieu_de_normalized = strtoupper(preg_replace('/\s+/', '', $tieu_de));
        $thongtin = mysqli_query($conn, "SELECT id FROM thuong_hieu WHERE shop='0'");
        $closest_id = 0;

        while ($r = mysqli_fetch_assoc($thongtin)) {
            $socdo_tieu_de_normalized = strtoupper(preg_replace('/\s+/', '', $r['tieu_de']));
            if ($tieu_de_normalized === $socdo_tieu_de_normalized) {
                $closest_id = $r['id'];
                break;
            }
        }
        if ($closest_id > 0) {
            $id_thuonghieu_socdo = $closest_id;
        }
    }
    mysqli_query($conn, "INSERT INTO thuong_hieu(shop, tieu_de, thu_tu, id_thuonghieu_socdo) VALUES('$user_id', '$tieu_de', '$thu_tu', '$id_thuonghieu_socdo')");
}

$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>