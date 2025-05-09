<?php
if (in_array('quantri', explode(',', $user_info['emin_group'])) == false && $user_info['emin_group'] != 1) {
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

$thaythe['title'] = 'Danh sách thành viên nhà cung cấp';
$thaythe['title_action'] = 'Danh sách thành viên nhà cung cấp';
$limit = 50;
$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE ctv = '1'");
$r_tk = mysqli_fetch_assoc($thongke);
$total_page = ceil($r_tk['total'] / $limit);
$bien = array(
    'list_quantri' => $class_index->list_thanhvien_ncc($conn, $page, $limit),
    'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/list-thanhvien-ncc')
);
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_thanhvien_ncc', $bien);
?>