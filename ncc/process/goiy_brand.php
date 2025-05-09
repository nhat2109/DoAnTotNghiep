<?php
$key = addslashes($_REQUEST['key']);
$list = '';

if (!empty($key)) {
    $thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE (tieu_de LIKE '%$key%') AND shop='0' ORDER BY tieu_de ASC LIMIT 10");
    $total = mysqli_num_rows($thongtin);

    if ($total > 0) {
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" data-source="socdo">' . htmlspecialchars($r_tt['tieu_de']) . '</div>';
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