<?php
$page = intval($_REQUEST['page']);
$sort = addslashes($_REQUEST['sort']);
$list_id = addslashes(strip_tags($_REQUEST['list_id']));
$key = addslashes(strip_tags($_REQUEST['key']));
$tach_key = explode(' ', $key);
$k = 0;
foreach ($tach_key as $key => $value) {
    $k++;
    if ($value != '') {
        if ($k == 1) {
            $where .= "tieu_de LIKE '%$value%'";
        } else {
            $where .= " AND tieu_de LIKE '%$value%'";
        }
    }
}
if ($sort == 'id-asc') {
    $order = "id ASC";
} else if ($sort == 'id-desc') {
    $order = "id DESC";
} else if ($sort == 'price-desc') {
    $order = "gia_moi DESC";
} else if ($sort == 'price-asc') {
    $order = "gia_moi ASC";
} else if ($sort == 'tieude-asc') {
    $order = "tieu_de ASC";
} else if ($sort == 'tieude-desc') {
    $order = "tieu_de DESC";
} else {
    $order = "id DESC";
}
$limit = 25;
$start = $page * $limit - $limit;
if ($list_id == '') {
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND kho>'0' ORDER BY $order");
} else {
    $list_id = substr($list_id, 0, -1);
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND id NOT IN ($list_id) AND kho>'0' ORDER BY $order");
}
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
    $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_deal', $r_tt);
}
$tiep = 0;
$page++;
$info = array(
    'page' => $page,
    'tiep' => $tiep,
    'list' => $list,
);
echo json_encode($info);
