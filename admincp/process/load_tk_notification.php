<?php
$bo_phan = $user_info['bo_phan'];
$user_id = $user_info['id'];
$giaoviec = $_REQUEST['giaoviec'];
if ($bo_phan == 'all') {
    $thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND FIND_IN_SET($user_id,doc)<1");
} elseif($giaoviec == 'giaoviec'){
    $thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' or giaoviec = 'giaoviec' AND FIND_IN_SET($user_id,doc)<1");
}else {
    $thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND FIND_IN_SET($user_id,doc)<1");
}
$total = mysqli_num_rows($thongtin);
$info = array(
    'ok' => 1,
    'total_notification' => $total,
);
echo json_encode($info);
