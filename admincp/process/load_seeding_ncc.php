<?php
if (in_array('thongke', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    $thongbao = "Bạn không có quyền truy cập...";
    $ok = 0;
} else {
    $end = addslashes(strip_tags($_REQUEST['time_end']));
    $tach_end = explode('/', $end);
    $date_end = $tach_end[0];
    $month_end = $tach_end[1];
    $year_end = $tach_end[2];
    $end_time = mktime(23, 59, 59, $month_end, $date_end, $year_end);
    $begin = addslashes(strip_tags($_REQUEST['time_begin']));
    $tach_begin = explode('/', $begin);
    $date_begin = $tach_begin[0];
    $month_begin = $tach_begin[1];
    $year_begin = $tach_begin[2];
    $begin_time = mktime(0, 0, 0, $month_begin, $date_begin, $year_begin);
    $thongke = json_decode($class_index->thongke_seeding_ncc($conn, $begin_time, $end_time), true);
    $ok = 1;
    $thongbao = 'Lấy dữ liệu thành công';
}
$bien = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'doanhthu_finish' => number_format($thongke['doanhthu_finish']) . ' đ',
    'doanhthu_wait' => number_format($thongke['doanhthu_wait']) . ' đ',
    'doanhthu_run' => number_format($thongke['doanhthu_run']) . ' đ',
    'donhang_finish' => 'với ' . number_format($thongke['donhang_finish']) . ' đơn hàng',
    'donhang_wait' => 'với ' . number_format($thongke['donhang_wait']) . ' đơn hàng',
    'donhang_run' => 'với ' . number_format($thongke['donhang_run']) . ' đơn hàng',
);
echo json_encode($bien);
