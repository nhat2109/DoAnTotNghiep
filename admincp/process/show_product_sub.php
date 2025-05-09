<?php
$page = intval($_REQUEST['page']);
$list_sub = $_REQUEST['list_sub'];
$tach_sub = json_decode('[' . $list_sub . ']', true);
$limit = 25;
$start = $page * $limit - $limit;
if ($list_sub == '') {
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY id DESC");
} else {
    $list_id = array();
    foreach ($tach_sub as $key => $value) {
        $list_id[] .= $value['sp_id'];
    }
    $list_id = implode(',', $list_id);
    $kieu = addslashes(strip_tags($_REQUEST['kieu']));
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY id DESC");
}
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
    $sp_id = $r_tt['id'];
    $thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id'");
    while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
        $r_pl['gia_cu'] = number_format($r_pl['gia_cu']);
        $r_pl['gia_moi'] = number_format($r_pl['gia_moi']);
        $r_pl['pl'] = $r_pl['id'];
        if ($kieu == 'tang') {
            $r_pl['gia_deal'] = 0;
            $list_pl .= $skin->skin_replace('skin_cpanel/box_action/li_pl_deal', $r_pl);
        } else if ($kieu == 'muakem') {
            $r_pl['gia_deal'] = '';
            $list_pl .= $skin->skin_replace('skin_cpanel/box_action/li_pl_deal', $r_pl);
        } else {
            $r_pl['gia_deal'] = '';
            $r_pl['so_luong'] = '';
            $list_pl .= $skin->skin_replace('skin_cpanel/box_action/li_pl', $r_pl);
        }
    }
    $r_tt['list_pl'] = $list_pl;
    unset($list_pl);
    if ($kieu == 'tang') {
        $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_sub_deal', $r_tt);
    } else if ($kieu == 'muakem') {

        $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_sub_deal', $r_tt);
    } else {
        $list .= $skin->skin_replace('skin_cpanel/box_action/li_product_flash_sale', $r_tt);
    }
}
$tiep = 0;
$page++;
$info = array(
    'page' => $page,
    'tiep' => $tiep,
    'list' => $list,
);
echo json_encode($info);
