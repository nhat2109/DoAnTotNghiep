<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('price', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này' . $user_info['emin_group']));
        exit();
    }
    $kieu = addslashes(strip_tags($_REQUEST['kieu']));
    $price = preg_replace('/[^0-9]/', '', $_REQUEST['price']);
    $min_price = preg_replace('/[^0-9]/', '', $_REQUEST['min_price']);
    $max_price = preg_replace('/[^0-9]/', '', $_REQUEST['max_price']);
    $thu_tu = intval($_REQUEST['thu_tu']);
    $thongbao = 'Thêm khoảng giá thành công';
    $ok = 1;
    if ($kieu == 'nho') {
        mysqli_query($conn, "INSERT INTO khoang_gia(min_price,max_price,kieu,thu_tu)VALUES('0','$price','$kieu','$thu_tu')");
    } else if ($kieu == 'lon') {
        mysqli_query($conn, "INSERT INTO khoang_gia(min_price,max_price,kieu,thu_tu)VALUES('$price','0','$kieu','$thu_tu')");
    } else {
        mysqli_query($conn, "INSERT INTO khoang_gia(min_price,max_price,kieu,thu_tu)VALUES('$min_price','$max_price','$kieu','$thu_tu')");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
