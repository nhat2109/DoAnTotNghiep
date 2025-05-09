<?php
$ten_khach = addslashes(strip_tags($_REQUEST['ten_khach']));
$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE (name LIKE '%$ten_khach%' OR mobile LIKE '%$ten_khach%' OR username LIKE '%$ten_khach%') AND shop='0' ORDER BY name ASC LIMIT 25");
$total = mysqli_num_rows($thongtin);
if ($total > 0) {
    $ok = 1;
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $list .= '<div class="li_goi_y" thanhvien="' . $r_tt['user_id'] . '"><div class="name">' . $r_tt['name'] . '</div><div class="dien_thoai">ĐT: ' . $r_tt['mobile'] . '</div><div class="dien_thoai">Email: ' . $r_tt['email'] . '</div></div>';
    }
} else {
    $ok = 0;
    $list = '';
}
$info = array(
    'ok' => $ok,
    'list' => $list,
);
echo json_encode($info);
