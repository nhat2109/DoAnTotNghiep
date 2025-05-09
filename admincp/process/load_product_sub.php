<?php
$page = intval($_REQUEST['page']);
$sort = addslashes($_REQUEST['sort']);
$limit = 25;
$start = $page * $limit - $limit;
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
$list_id = addslashes(strip_tags($_REQUEST['list_id']));
if ($list_id == '') {
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>'0' ORDER BY $order LIMIT $start,$limit");
} else {
    $list_id = substr($list_id, 0, -1);
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id NOT IN ($list_id) AND kho>'0' ORDER BY $order LIMIT $start,$limit");
}
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}' ORDER BY id ASC");
    $r_pl = mysqli_fetch_assoc($thongtin_phanloai);
    $i++;
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
    $r_tt['pl'] = $r_pl['id'];
    $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_deal', $r_tt);
}
if ($i < $limit) {
    $tiep = 0;
} else {
    $tiep = 1;
}
$page++;
$info = array(
    'page' => $page,
    'tiep' => $tiep,
    'list' => $list,
);
echo json_encode($info);
