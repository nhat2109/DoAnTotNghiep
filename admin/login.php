<?php
include('../includes/tlca_world.php');
$check = $tlca_do->load('class_check');
$skin = $tlca_do->load('class_skin_cpanel');


if (isset($_COOKIE['admin_id'])) {
    $replace = [
        'title' => 'Bạn đã đăng nhập',
        'link_chuyen' => '/admin/'
    ];
    echo $skin->skin_replace('skin_admin/chuyenhuong', $replace);
    exit();
}


$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
$index_setting = [];
while ($r_s = mysqli_fetch_assoc($setting)) {
    $index_setting[$r_s['name']] = $r_s['value'];
}


$replace = [
    'title' => 'Đăng nhập tài khoản Admin',
    'description' => $index_setting['description'] ?? '',
    'site_name' => $index_setting['site_name'] ?? '',
    'h1' => $index_setting['h1'] ?? '',
    'box_script_footer' => $skin->skin_normal('skin_admin/box_script_footer'),
];
echo $skin->skin_replace('skin_admin/login', $replace);
?>