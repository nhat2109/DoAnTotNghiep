<?php
$bo_phan = $user_info['bo_phan'];
$user_id = $user_info['id'];
if ($bo_phan == 'all') {
    $thongtin_noti = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND FIND_IN_SET($user_id,doc)='0'");
} else {
    $thongtin_noti = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND bo_phan='$bo_phan' AND FIND_IN_SET($user_id,doc)='0'");
}
$total_noti = mysqli_num_rows($thongtin_noti);
if ($total_noti > 9) {
    $total_noti = '9+';
}
$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE status='0'");
$total_drop = 0;
$total_ctv = 0;
$total_socdo = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    if ($r_tt['dropship'] == 1) {
        $total_drop++;
    } else if ($r_tt['dropship'] == 2) {
        $total_ctv++;
    } else {
        $total_socdo++;
    }
}
if ($total_drop > 9) {
    $total_drop = '9+';
}
if ($total_socdo > 9) {
    $total_socdo = '9+';
}
$thongtin_donhang_ctv = mysqli_query($conn, "SELECT count(*) AS total FROM donhang_ctv WHERE status='0'");
$r_d_ctv = mysqli_fetch_assoc($thongtin_donhang_ctv);
$total_ctv = $r_d_ctv['total'];
if ($total_ctv > 9) {
    $total_ctv = '9+';
}
$thongtin_nap = mysqli_query($conn, "SELECT count(*) AS total FROM naptien WHERE status='0'");
$r_np = mysqli_fetch_assoc($thongtin_nap);
$total_nap = $r_np['total'];
if ($total_nap > 9) {
    $total_nap = '9+';
}
$thongtin_rut = mysqli_query($conn, "SELECT count(*) AS total FROM rut_tien WHERE status='0'");
$r_rut = mysqli_fetch_assoc($thongtin_rut);
$total_rut = $r_rut['total'];
if ($total_rut > 9) {
    $total_rut = '9+';
}
$thongtin_mua_seeding = mysqli_query($conn, "SELECT count(*) AS total FROM mua_seeding_shopee WHERE status='0'");
$r_mua_seeding = mysqli_fetch_assoc($thongtin_mua_seeding);
$total_mua_seeding = $r_mua_seeding['total'];
if ($total_mua_seeding > 9) {
    $total_mua_seeding = '9+';
}
$thongtin_mua_seeding_ncc = mysqli_query($conn, "SELECT count(*) AS total FROM mua_seeding_shopee_ncc WHERE status='0'");
$r_mua_seeding_ncc = mysqli_fetch_assoc($thongtin_mua_seeding_ncc);
$total_mua_seeding_ncc = $r_mua_seeding_ncc['total'];
if ($total_mua_seeding_ncc > 9) {
    $total_mua_seeding_ncc = '9+';
}
$thongtin_mua_domain = mysqli_query($conn, "SELECT count(*) AS total FROM mua_domain WHERE status='0'");
$r_mua_domain = mysqli_fetch_assoc($thongtin_mua_domain);
$total_mua_domain = $r_mua_domain['total'];
if ($total_mua_domain > 9) {
    $total_mua_domain = '9+';
}
$thongtin_hotro_domain = mysqli_query($conn, "SELECT count(*) AS total FROM hotro_domain WHERE status='0'");
$r_hotro_domain = mysqli_fetch_assoc($thongtin_hotro_domain);
$total_hotro_domain = $r_hotro_domain['total'];
if ($total_hotro_domain > 9) {
    $total_hotro_domain = '9+';
}
$thongtin_dat_live = mysqli_query($conn, "SELECT count(*) AS total FROM dat_live WHERE status='0'");
$r_dat_live = mysqli_fetch_assoc($thongtin_dat_live);
$total_dat_live = $r_dat_live['total'];
if ($total_dat_live > 9) {
    $total_dat_live = '9+';
}
$thongtin_dk_drop = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE dropship='2'");
$r_dk_drop = mysqli_fetch_assoc($thongtin_dk_drop);
$total_dk_drop = $r_dk_drop['total'];
if ($total_dk_drop > 9) {
    $total_dk_drop = '9+';
}
$thongtin_dk_ctv = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE ctv='2'");
$r_dk_ctv = mysqli_fetch_assoc($thongtin_dk_ctv);
$total_dk_ctv = $r_dk_ctv['total'];
if ($total_dk_ctv > 9) {
    $total_dk_ctv = '9+';
}
$thongtin_hethang = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10'");
$total_hethang = mysqli_num_rows($thongtin_hethang);
if ($total_hethang > 9) {
    $total_hethang = '9+';
}
$thongke_tamkhoa = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE dropship='4'");
$r_tamkhoa = mysqli_fetch_assoc($thongke_tamkhoa);
$total_tamkhoa = intval($r_tamkhoa['total']);
if ($total_tamkhoa > 9) {
    $total_tamkhoa = '9+';
}
$thongke_chat = mysqli_query($conn, "SELECT count(*) AS total FROM chat WHERE bo_phan='{$user_info['bo_phan']}' AND active='1' AND doc='0' AND tieu_de='' GROUP BY thanh_vien");
$r_chat = mysqli_fetch_assoc($thongke_chat);
$total_chat = intval($r_chat['total']);
if ($total_chat > 9) {
    $total_chat = '9+';
}
echo json_encode(array('total_noti' => $total_noti, 'total_chat' => $total_chat, 'total_cart_drop' => $total_drop, 'total_cart_ctv' => $total_ctv, 'total_cart_socdo' => $total_socdo, 'total_nap' => $total_nap, 'total_rut' => $total_rut, 'total_mua_seeding' => $total_mua_seeding, 'total_mua_seeding_ncc' => $total_mua_seeding_ncc, 'total_mua_domain' => $total_mua_domain, 'total_hotro_domain' => $total_hotro_domain, 'total_dk_ctv' => $total_dk_ctv, 'total_dk_drop' => $total_dk_drop, 'total_hethang' => $total_hethang, 'total_dat_live' => $total_dat_live, 'total_tamkhoa' => $total_tamkhoa));
