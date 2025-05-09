<?php
$user_id = $user_info['id'];
$list_nhansu = $class_index->lay_danh_sach_cong_viec_cua_nguoi_nhan($conn,$user_id);
$list_admin = $class_index->adanhsachnhansu($conn, $user_id, $total, $page, $limit);
$list_dexuat_admin = $class_index->box_dexuat($conn,$user_id);
$list_dexuat_nhanvien = $class_index->list_dexuat_nhanvien($conn,$user_id);
$arr = array(
    'list_nhansu'=>$list_nhansu,
    'list_admin'=>$list_admin,
    'list_dexuat_nhanvien'=>$list_dexuat_nhanvien,
    'list_dexuat_admin'=>$list_dexuat_admin
);
echo json_encode($arr);