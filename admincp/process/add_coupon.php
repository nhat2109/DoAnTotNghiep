<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('coupon', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $ma = addslashes(strip_tags($_REQUEST['ma']));
    $loai = addslashes(strip_tags($_REQUEST['loai']));
    $kieu = addslashes(strip_tags($_REQUEST['kieu']));
    $sanpham = addslashes(strip_tags($_REQUEST['sanpham']));
    if ($kieu == 'sanpham') {
        $sanpham = substr($sanpham, 0, -1);
    } else {
        $sanpham = '';
    }
    $giam = addslashes(strip_tags($_REQUEST['giam']));
    $giam = preg_replace('/[^0-9]/', '', $giam);
    $dieu_kien = intval(preg_replace('/[^0-9]/', '', $_REQUEST['dieu_kien']));
    $time_start = addslashes(strip_tags($_REQUEST['time_start']));
    $date_start = addslashes(strip_tags($_REQUEST['date_start']));
    $time_expired = addslashes(strip_tags($_REQUEST['time_expired']));
    $date_expired = addslashes(strip_tags($_REQUEST['date_expired']));
    $tach_time_start = explode(':', $time_start);
    $tach_date_start = explode('/', $date_start);
    $start = mktime($tach_time_start[0], $tach_time_start[1], $tach_time_start[2], $tach_date_start[1], $tach_date_start[0], $tach_date_start[2]);
    $tach_time_expired = explode(':', $time_expired);
    $tach_date_expired = explode('/', $date_expired);
    $expired = mktime($tach_time_expired[0], $tach_time_expired[1], $tach_time_expired[2], $tach_date_expired[1], $tach_date_expired[0], $tach_date_expired[2]);
    if (strlen($ma) < 4) {
        $ok = 0;
        $thongbao = 'Mã coupon quá ngắn';
    } else if ($giam == '') {
        $ok = 0;
        $thongbao = 'Bạn chưa nhập giá trị khuyến mại';
    } else if ($start > $expired) {
        $ok = 0;
        $thongbao = 'Thời gian bắt đầu và hết hạn không hợp lệ';
    } else if ($kieu == 'sanpham' and strlen($sanpham) < 1) {
        $ok = 0;
        $thongbao = 'Vui lòng chọn sản phẩm áp dụng';
    } else {
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='$ma' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] > 0) {
            $ok = 0;
            $thongbao = 'Thất bại! Mã giảm giá đã tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Đã thêm coupon mới thành công';
            mysqli_query($conn, "INSERT INTO coupon(shop,ma,loai,kieu,sanpham,giam,dieu_kien,start,expired,status)VALUES('0','$ma','$loai','$kieu','$sanpham','$giam','$dieu_kien','$start','$expired','0')");
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
