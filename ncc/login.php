<?php
include('../includes/tlca_world.php');
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_ncc');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page = addslashes($url_query['page']);
$skin = $tlca_do->load('class_skin_cpanel');


if (isset($_COOKIE['user_id'])) {
    if (isset($_COOKIE['show_welcome_setup'])) {
        $thongbao = "Bạn cần hoàn thiện thông tin nhà cung cấp.<br>Đang chuyển hướng tới trang thiết lập...";
        $replace = array(
            'title' => 'Hoàn thiện thông tin nhà cung cấp...',
            'description' => $index_setting['description'],
            'thongbao' => $thongbao,
            'link_chuyen' => '/ncc/welcome_setup.php'
        );
        echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
        exit();
    } else {
        $thongbao = "Bạn đã đăng nhập tài khoản.<br>Đang chuyển hướng tới trang chủ...";
        $replace = array(
            'title' => 'Bạn đã đăng nhập...',
            'description' => $index_setting['description'],
            'thongbao' => $thongbao,
            'link_chuyen' => '/ncc/'
        );
        echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
        exit();
    }
}

$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
    $index_setting[$r_s['name']] = $r_s['value'];
}
$limit = 30;
$replace = array(
    'header' => $skin->skin_normal('skin_ncc/header'),
    'top_menu' => $skin->skin_normal('skin_ncc/top_menu'),
    'footer' => $skin->skin_normal('skin_ncc/footer'),
    'box_script_footer' => $skin->skin_normal('skin_ncc/box_script_footer'),
    'title' => 'Đăng nhập tài khoản',
    'description' => $index_setting['description'],
    'site_name' => $index_setting['site_name'],
    'h1' => $index_setting['h1']
);
echo $skin->skin_replace('skin_ncc/login', $replace);
?>