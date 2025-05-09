<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('live_stream', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
    $nam_sinh = addslashes(strip_tags($_REQUEST['nam_sinh']));
    $chieu_cao = addslashes(strip_tags($_REQUEST['chieu_cao']));
    $can_nang = addslashes(strip_tags($_REQUEST['can_nang']));
    $kinh_nghiem = addslashes(strip_tags($_REQUEST['kinh_nghiem']));
    $time_start = addslashes(strip_tags($_REQUEST['time_start']));
    $time_end = addslashes(strip_tags($_REQUEST['time_end']));
    $ngan_sach = addslashes(strip_tags($_REQUEST['ngan_sach']));
    $video = addslashes(strip_tags($_REQUEST['video']));
    $thu_tu = intval(strip_tags($_REQUEST['thu_tu']));
    $an = intval(strip_tags($_REQUEST['an']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (strlen($ho_ten) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập tên idol';
    } else if (strlen($nam_sinh) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập năm sinh';
    } else if (strlen($chieu_cao) < 2) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập chiều cao';
    } else if (strlen($can_nang) < 2) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập cân nặng';
    } else if (strlen($kinh_nghiem) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập kinh nghiệm';
    } else if (strlen($time_start) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập khung giờ bắt đầu';
    } else if (strlen($time_end) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập khung giờ kết thúc';
    } else if (strlen($ngan_sach) < 4) {
        $ok = 0;
        $thongbao = 'Vui lòng nhập ngân sách';
    } else if ($thu_tu == '') {
        $ok = 0;
        $thongbao = 'Vui lòng nhập thứ tự hiển thị';
    } else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == false) {
        $ok = 0;
        $thongbao = 'Vui lòng chọn ảnh đại diện';
    } else {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($ho_ten) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        mysqli_query($conn, "INSERT INTO idol(ho_ten,avatar,nam_sinh,chieu_cao,can_nang,kinh_nghiem,video,time_start,time_end,ngan_sach,thu_tu,an)VALUES('$ho_ten','$minh_hoa','$nam_sinh','$chieu_cao','$can_nang','$kinh_nghiem','$video','$time_start','$time_end','$ngan_sach','$thu_tu','$an')");
        $ok = 1;
        $thongbao = 'Thêm idol thành công!';
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
