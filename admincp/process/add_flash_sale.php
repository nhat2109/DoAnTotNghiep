<?php
$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
$date_start = addslashes(strip_tags($_REQUEST['date_start']));
$date_end = addslashes(strip_tags($_REQUEST['date_end']));
$list_product = $_REQUEST['list_product'];
if ($tieu_de == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập tên chương trình';
} else if ($date_start == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập thời gian bắt đầu';
} else if ($date_end == '') {
    $ok = 0;
    $thongbao = 'Vui lòng chọn thời gian kết thúc';
} else if ($list_product == '') {
    $ok = 0;
    $thongbao = 'Vui lòng chọn sản phẩm';
} else {
    $ok = 1;
    $thongbao = 'Thêm flash sale thành công';
    $tach_start = explode(' ', $date_start);
    $tach_time_start = explode(':', $tach_start[0]);
    $tach_date_start = explode('/', $tach_start[1]);
    $start = mktime($tach_time_start[0], $tach_time_start[1], 00, $tach_date_start[1], $tach_date_start[0], $tach_date_start[2]);
    $tach_end = explode(' ', $date_end);
    $tach_time_end = explode(':', $tach_end[0]);
    $tach_date_end = explode('/', $tach_end[1]);
    $end = mktime($tach_time_end[0], $tach_time_end[1], 00, $tach_date_end[1], $tach_date_end[0], $tach_date_end[2]);
    $list_product = '[' . $list_product . ']';
    $tach_product = json_decode($list_product, true);
    $list_id = array();
    foreach ($tach_product as $key => $value) {
        $list_id[] = $value['sp_id'];
    }
    $list_id = implode(',', $list_id);
    mysqli_query($conn, "INSERT INTO deal(shop,tieu_de,main_product,sub_product,sub_id,date_start,date_end,loai,date_post)VALUES('0','$tieu_de','$list_id','$list_product','','$start','$end','flash_sale'," . time() . ")");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao
);
echo json_encode($info);
