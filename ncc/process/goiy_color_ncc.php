<?php
$key = addslashes($_REQUEST['key']);
$list = '';

if (!empty($key)) {
    $thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE (tieu_de LIKE '%$key%') AND shop='0' ORDER BY tieu_de ASC LIMIT 10");
    $total = mysqli_num_rows($thongtin);

    if ($total > 0) {
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" ma_mau="' . $r_tt['ma_mau'] . '" data-source="socdo"><span class="color-preview" style="background-color: ' . $r_tt['ma_mau'] . ';"></span><span class="color-name">' . htmlspecialchars($r_tt['tieu_de']) . '</span></div>';
        }
    } else {
        $list = '';
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