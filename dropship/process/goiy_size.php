


<?php
$key = addslashes($_REQUEST['key']);
$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE tieu_de LIKE '%$key%' AND shop='$user_id' ORDER BY tieu_de ASC LIMIT 100");
$total = mysqli_num_rows($thongtin);
if ($total > 0) {
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $list .= '<div class="li_goiy" value="' . $r_tt['id'] . '" data-source="socdo">' . $r_tt['tieu_de'] . '</div>';
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