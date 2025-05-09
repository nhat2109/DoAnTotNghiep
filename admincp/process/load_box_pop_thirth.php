<?php
$loai = addslashes(strip_tags($_REQUEST['loai']));
if ($loai == 'add_lichsu_lienhe') {
    $khach_sale = intval($_REQUEST['khach_sale']);
    $bien = array(
        'name' => $user_info['name'],
        'mobile' => $user_info['mobile'],
        'email' => $user_info['email'],
        'khach_sale' => $khach_sale
    );
    $html = $skin->skin_replace('skin_cpanel/box_action/pop_add_lienhe', $bien);
} else if ($loai == 'add_yeucau_lienhe') {
    $thanh_vien = intval($_REQUEST['thanh_vien']);
    $bien = array(
        'thanh_vien' => $thanh_vien
    );
    $html = $skin->skin_replace('skin_cpanel/box_action/pop_add_yeucau', $bien);
}
$info = array(
    'html' => $html,
);
echo json_encode($info);
