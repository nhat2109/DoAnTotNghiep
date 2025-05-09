<?php
$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
$cat = strip_tags(addslashes($_REQUEST['cat']));
$cat = 'cat' . $cat;
$thongtin = mysqli_query($conn, "SELECT id,tieu_de FROM sanpham WHERE MATCH(tieu_de) AGAINST('$tieu_de') AND MATCH(category) AGAINST('$cat') ORDER BY gia ASC");
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $list .= '<li value="' . $r_tt['id'] . '"><span>' . $r_tt['tieu_de'] . '</span></li>';
}
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);

?>