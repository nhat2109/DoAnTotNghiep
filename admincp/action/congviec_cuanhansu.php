<?php
include './includes/tlca_world.php';
if (in_array('price', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    $thongbao = "Bạn không có quyền truy cập...";
    $replace = array(
        'title' => 'Bạn không có quyền truy cập...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/admincp/dashboard'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
    exit();
}
$thaythe['title'] = 'Danh sách công việc';
$thaythe['title_action'] = 'Danh sách công việc';
$limit = 10;
$user_id = mysqli_real_escape_string($conn, $user_info['id']);
$list_danhsach_congviec = $class_index->lay_danh_sach_cong_viec_cua_nguoi_nhan($conn,$user_id);
$danhsachsep = $class_index->danhsach_cacsep($conn);
$total_page = ceil($r_tk['total'] / $limit);
$dexuat_lichsu = $class_index->list_dexuat_nhanvien($conn,$user_info['id']);
$bien = array(
    'title'=>$thaythe['title'],
    'danhsachsep'=>$danhsachsep,
    'list_dexuat_nhanvien'=>$dexuat_lichsu,
    'congviec_nhansu_dcgiao' => $list_danhsach_congviec,
    'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/adanhsachnhansu'),
);
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/congviec_cuanhansu', $bien);
