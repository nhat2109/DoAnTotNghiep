<?php
$thaythe['title'] = 'Danh sách sản phẩm NCC';
$thaythe['title_action'] = 'Danh sách sản phẩm NCC';
$limit = 25;

$status_filter = isset($_GET['status']) ? (int)$_GET['status'] : '';

$conditions = [];
$conditions[] = "user_info.ctv = 1";
if ($status_filter !== '') {
    $conditions[] = "sanpham_shop.status = '$status_filter'";
} else {
    $conditions[] = "sanpham_shop.status = 0";
}
$where_clause = "WHERE " . implode(" AND ", $conditions);

$thongke = mysqli_query($conn, "SELECT count(*) AS total 
                               FROM sanpham_shop 
                               INNER JOIN user_info ON sanpham_shop.shop = user_info.user_id 
                               $where_clause");
$r_tk = mysqli_fetch_assoc($thongke);
$total_page = ceil($r_tk['total'] / $limit);

if (isset($_COOKIE['admin_kho'])) {
    $kho = $_COOKIE['admin_kho'];
} else {
    $kho = 'kho';
}

$bien = array(
    'option_ncc' => $class_index->get_list_ncc($conn),
    'list_sanpham_ncc' => $class_index->list_sanpham_ncc($conn, $kho, $page, $limit, $status_filter),
    'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/list-sanpham-ncc' . ($status_filter !== '' ? '?status=' . $status_filter : '')),
);
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_sanpham_ncc', $bien);
?>