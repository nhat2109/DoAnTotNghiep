<?php
$page = intval($_REQUEST['page']);
$limit = 100;
$start = $page * $limit - $limit;
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE (SELECT count(*) FROM sanpham_tuan st WHERE st.sp_id=sp.id)='0' ORDER BY id DESC LIMIT $start,$limit");
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    $r_tt['gia_drop'] = number_format($r_tt['gia_drop']) . 'đ';
    $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_tuan', $r_tt);
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
