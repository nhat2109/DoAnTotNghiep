<?php
$page = intval($_REQUEST['page']);
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
if (isset($_COOKIE['admin_kho'])) {
    $kho = $_COOKIE['admin_kho'];
} else {
    $kho = 'kho';
}
$limit = 25;
$start = $page * $limit - $limit;
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE $where AND (SELECT count(*) FROM sanpham_trend st WHERE st.sp_id=sp.id)='0' ORDER BY id DESC");
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
    if ($kho == 'kho_hcm') {
        $r_tt['kho'] = $r_tt['kho_hcm'];
    } else {
        $r_tt['kho'] = $r_tt['kho'];
    }
    $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_trend', $r_tt);
}
$tiep = 0;
$page++;
$info = array(
    'page' => $page,
    'tiep' => $tiep,
    'list' => $list,
);
echo json_encode($info);
