<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_admin');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');


if (!isset($_COOKIE['admin_id'])) {
    header('Location: login.php');
    exit();
}

$tach_token = json_decode($check->token_login_decode($_COOKIE['admin_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['admin_id']);

$action = isset($_GET['action']) ? $_GET['action'] : 'profile';

switch ($action) {
    case 'profile':
        $thaythe = [
            'title' => 'Hồ sơ cá nhân',
            'box_right' => $skin->skin_replace('skin_admin/box_action/profile', $user_info),
        ];
        break;
    case 'settings':
        $thongtin_setting = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='$user_id'");
        $settings = [];
        while ($r_s = mysqli_fetch_assoc($thongtin_setting)) {
            $settings[$r_s['name']] = $r_s['value'];
        }
        $thaythe = [
            'title' => 'Cài đặt chung',
            'box_right' => $skin->skin_replace('skin_admin/box_action/settings', $settings),
        ];
        break;
    default:
        $thaythe = [
            'title' => 'Trang quản trị',
            'box_right' => '<p>Chào mừng đến với trang quản trị!</p>',
        ];
}

$replace = [
    'title' => $thaythe['title'],
    'menu' => $skin->skin_normal('skin_admin/box_menu'),
    'box_right' => $thaythe['box_right'],
    'footer' => $skin->skin_normal('skin_admin/footer'),
    'script_footer' => $skin->skin_normal('skin_admin/box_script_footer'),
];
echo $skin->skin_replace('skin_admin/index', $replace);
?>