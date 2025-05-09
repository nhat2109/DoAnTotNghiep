<?php
if (in_array('thongke', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    $thongbao = "Bạn không có quyền truy cập...";
    $ok = 0;
} else {
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT * FROM nhom WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
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
    $thongke = json_decode($class_index->thongke_doanhthu_nhom($conn, $r_tt['thanhvien'], $begin_time, $end_time), true);
    $ok = 1;
    $thongbao = 'Lấy dữ liệu thành công';
    $list_thanhvien = '            <tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
            <th style="text-align: left;">Tài khoản</th>
            <th style="text-align: left;">Họ và tên</th>
            <th style="text-align: center;">Vai trò</th>
            <th style="text-align: center;">Tổng đơn hàng</th>
            <th style="text-align: center;">Tổng doanh số</th>
        </tr>' . $class_index->list_doanhthu_thanhvien_nhom($conn, $r_tt['thanhvien'], $r_tt['nhomtruong'], $begin_time, $end_time);
}
$bien = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'doanhthu_hoanthanh' => number_format($thongke['doanhthu_hoanthanh']) . ' đ',
    'doanhthu_giao' => number_format($thongke['doanhthu_vanchuyen']) . ' đ',
    'doanhthu_huy' => number_format($thongke['doanhthu_huy']) . ' đ',
    'doanhthu_hoan' => number_format($thongke['doanhthu_hoan']) . ' đ',
    'doanhthu_cho' => number_format($thongke['doanhthu_cho']) . ' đ',
    'doanhthu_tiepnhan' => number_format($thongke['doanhthu_tiepnhan']) . ' đ',
    'donhang_hoanthanh' => 'với ' . number_format($thongke['donhang_hoanthanh']) . ' đơn hàng',
    'donhang_giao' => 'với ' . number_format($thongke['donhang_vanchuyen']) . ' đơn hàng',
    'donhang_huy' => 'với ' . number_format($thongke['donhang_huy']) . ' đơn hàng',
    'donhang_hoan' => 'với ' . number_format($thongke['donhang_hoan']) . ' đơn hàng',
    'donhang_cho' => 'với ' . number_format($thongke['donhang_cho']) . ' đơn hàng',
    'donhang_tiepnhan' => 'với ' . number_format($thongke['donhang_tiepnhan']) . ' đơn hàng',
    'list_thanhvien' => $list_thanhvien,
);
echo json_encode($bien);
