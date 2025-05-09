<?php
// if (in_array('sanpham', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
//     $thongbao = "Bạn không có quyền truy cập...";
//     $ok = 0;
// } 
// else {
    $cat_id = intval($_REQUEST['cat_id']);
    $tach_list = json_decode($class_index->list_div_sub_category_sanpham_ncc($conn, $cat_id, ''), true);
    if ($tach_list['total'] > 0) {
        $ok = 1;
        $thongbao = 'Lấy dữ liệu thành công';
    } else {
        $ok = 0;
        $thongbao = 'Danh mục này không có danh mục con';
    }
// }
$bien = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'list' => $tach_list['list']
);
echo json_encode($bien);
