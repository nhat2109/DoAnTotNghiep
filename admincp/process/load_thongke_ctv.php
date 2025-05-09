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
    $list = $class_index->thongke_ctv($conn, $begin_time, $end_time);
    $ok = 1;
    $thongbao = 'Lấy dữ liệu thành công';
    $list = '<tr>
                <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
                <th style="text-align: left;">Tài khoản</th>
                <th style="text-align: left;">Điện thoại</th>
                <th style="text-align: left;">Họ và tên</th>
                <th style="text-align: center;width: 100px;">Tổng đơn</th>
                <th style="text-align: center;">Doanh số</th>
                <th style="text-align: center;width: 150px;">Hành động</th>
            </tr>
            ' . $list;
}
$bien = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'list' => $list,
);
echo json_encode($bien);
