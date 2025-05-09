

<?php
// $key = addslashes($_REQUEST['key']);
// $list = '';

// // Nếu không có từ khóa, lấy danh sách màu phổ biến (mặc định)
// if (empty($key)) {
//     $thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE shop='$user_id' ORDER BY thu_tu ASC, tieu_de ASC LIMIT 10");
// } else {
//     // Tìm kiếm dựa trên tieu_de và keywords
//     //$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE (tieu_de LIKE '%$key%' OR keywords LIKE '%$key%') AND shop='$user_id' ORDER BY tieu_de ASC LIMIT 10");
// }

// $total = mysqli_num_rows($thongtin);

// if ($total > 0) {
//     while ($r_tt = mysqli_fetch_assoc($thongtin)) {
//         $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" ma_mau="' . $r_tt['ma_mau'] . '" data-source="socdo"><span class="color-preview" style="background-color: ' . $r_tt['ma_mau'] . ';"></span>' . $r_tt['tieu_de'] . '</div>';
//     }
// } else {
//     $list = '';
// }

// $info = array(
//     'ok' => 1,
//     'list' => $list,
// );
// echo json_encode($info);
// $key = addslashes($_REQUEST['key']);
// $list = '';

// // Tìm kiếm dựa trên tieu_de và keywords
// $thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE (tieu_de LIKE '%$key%' OR keywords LIKE '%$key%') AND shop='0' ORDER BY tieu_de ASC LIMIT 10");
// $total = mysqli_num_rows($thongtin);

// if ($total > 0) {
//     while ($r_tt = mysqli_fetch_assoc($thongtin)) {
//         $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" ma_mau="' . $r_tt['ma_mau'] . '" data-source="socdo"><span class="color-preview" style="background-color: ' . $r_tt['ma_mau'] . ';"></span>' . $r_tt['tieu_de'] . '</div>';
//     }
// } else {
//     $list = '';
// }

// $info = array(
//     'ok' => 1,
//     'list' => $list,
// );
// echo json_encode($info);

$key = addslashes($_REQUEST['key']);
$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE tieu_de LIKE '%$key%' AND shop='$user_id' ORDER BY tieu_de ASC LIMIT 10");
$total = mysqli_num_rows($thongtin);
if ($total > 0) {
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" ma_mau="' . $r_tt['ma_mau'] . '" data-source="socdo">' . $r_tt['tieu_de'] . '</div>';
    }
} else {
    $list = '';
}
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
?>