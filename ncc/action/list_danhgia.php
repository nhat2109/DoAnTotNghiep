<?php
$thaythe['title'] = 'Danh sách đánh giá sản phẩm';
$thaythe['title_action'] = 'Danh sách đánh giá sản phẩm';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20;
$start = ($page-1)*$limit;

$list = '';
$sql = "SELECT r.*, s.tieu_de as ten_sanpham, s.minh_hoa, u.username, u.avatar FROM product_reviews r 
        LEFT JOIN sanpham_shop s ON r.sp_id = s.id 
        LEFT JOIN user_info u ON r.user_id = u.user_id 
        ORDER BY r.date_post DESC LIMIT $start, $limit";
$res = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($res)) {
    $row['ngay'] = date('d/m/Y H:i', $row['date_post']);
    $row['status_text'] = $row['status']==1 ? 'Hiện' : 'Ẩn';
    $row['status_class'] = $row['status']==1 ? 'success' : 'secondary';
    $row['duyet_disabled'] = $row['status']==1 ? 'disabled' : '';
    $row['an_disabled'] = $row['status']==0 ? 'disabled' : '';
    $list .= $skin->skin_replace('skin_ncc/box_action/tr_danhgia', $row);
}
// Đếm tổng
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product_reviews"))['total'];
$phantrang = $class_index->phantrang($page, ceil($total/$limit), '/ncc/list-danhgia?page=' );

$replace = array(
    'list_danhgia' => $list,
    'phantrang' => $phantrang
);
$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_danhgia', $replace); 