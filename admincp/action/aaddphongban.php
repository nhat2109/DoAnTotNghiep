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
$thaythe['title'] = 'Danh sách giao việc';
$thaythe['title_action'] = 'Thêm phòng ban';	$thaythe['title'] = 'Thêm giao việc mới';
$thaythe['title_action'] = 'Thêm giao việc mới';
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/aaddphongban', $bien);
