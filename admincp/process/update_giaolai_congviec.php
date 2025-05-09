<?php
$id = addslashes($_REQUEST['id']);
$list = $class_index->update_giaolaicongviec($conn,$id);
$tt_giaoviec = mysqli_query($conn,"SELECT * FROM giao_viec WHERE id = '{$id}'");
$r = mysqli_fetch_assoc($tt_giaoviec);
$id_nn = $r['nguoi_nhan'];
$id_gs = $r['nguoigiamsat'];
$id_pb = $r['phongban_nhan'];
echo json_encode([
    'list'=>$list,
    'id_nguoinhan'=>$id_nn,
    'id_nguoigiamsat'=>$id_gs,
    'id_phongban'=>$id_pb
]);