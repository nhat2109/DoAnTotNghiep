<?php
$page = intval($_REQUEST['page']);
if ($page < 1) {
    $page = 1;
}
$bo_phan = $user_info['bo_phan'];
$loai = addslashes($_REQUEST['loai']);
$limit = 10;
$tach_list = json_decode($class_index->list_notification($conn, $user_info['id'], $bo_phan, $loai, $page, $limit), true);
if ($tach_list['total'] < $limit) {
    $tiep = 0;
} else {
    $tiep = 1;
}
$list = $tach_list['list'];
if ($tach_list['total'] == 0) {
    if ($page == 1) {
        $list = '<div class="empty">Không có dữ liệu nào</div>';
    } else {
        $list = '<div class="li_empty">Không còn dữ liệu nào</div>';
    }
    $page = 1;
} else {
    $page++;
}
$info = array(
    'ok' => 1,
    'page' => $page,
    'tiep' => $tiep,
    'list' => $list,
);
echo json_encode($info);
