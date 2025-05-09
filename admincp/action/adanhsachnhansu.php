<?php
include './includes/tlca_world.php';
if (in_array('price', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    $thongbao = "Bạn không có quyền truy cập...";
    $replace = array(
        'title' => 'Bạn không có quyền truy cập...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/admincp/dashboard'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
    exit();
}
$thaythe['title'] = 'Danh sách giao việc';
$thaythe['title_action'] = 'Danh sách giao việc';
$limit = 10;
if ($user_info['bo_phan'] == 'chu_tich' or $user_info['bo_phan'] == 'giam_doc' or $user_info['bo_phan'] == 'admin' or $user_info['bo_phan'] == 'all') {

    $thongke = mysqli_query($conn, "SELECT count(*) AS total FROM giao_viec");
    $r_tk = mysqli_fetch_assoc($thongke);

    $list_nhansu = $class_index->danhsachnhansu($conn);

    $list_phongban_form = $class_index->list_phongban_form($conn);
    $dexuat_box= $class_index->box_dexuat($conn,$user_info['id']);
    $box_phongban = $class_index->box_phongban($conn);
    $phongbancha = $class_index->phongbancha($conn);
    $danhsachphongban = $class_index->danhsachphongban($conn);
    $list_giaoviec = $class_index->adanhsachnhansu($conn, '', $r_tk['total'], $page, $limit);
    $danhsachnhansuphongban =$class_index->danhsachnhansuphongban($conn);
    $query = mysqli_query($conn, "SELECT * FROM giao_viec");
    $total_giaoviec = 0;
    $dangtienhanh = 0;
    $chuanhan = 0;
    $miss_deadline = 0;
    $chamtiendo= 0;
    $hoanthanh =0;
    $chuatienhanh = 0;
    while($row_d = mysqli_fetch_assoc($query)){
        $total_giaoviec++;
        if ($row_d['status'] === '0') {
            $chuatienhanh++;
            if ($row_d['miss_deadline']) {
                $miss_deadline++;
            }
        }elseif($row_d['status']==='1'){
            $dangtienhanh++;
            if ($row_d['cham_tiendo']) {
                $chamtiendo++;
            }elseif($row_d['miss_deadline']){
                $miss_deadline++;
            }
        }elseif($row_d['status'] ==='2'){
            $hoanthanh++;
        }
    }

} else {
    $thongke = mysqli_query($conn, "SELECT count(*) AS total FROM giao_viec WHERE nguoi_giao='$user_id'");
    $r_tk = mysqli_fetch_assoc($thongke);
    $list_giaoviec = $class_index->adanhsachnhansu($conn, $user_id, $r_tk['total'], $page, $limit);

}

$total_page = ceil($r_tk['total'] / $limit);
$bien = array(
    'box_phongban' => $box_phongban,
    'list_phongban' => $list_phongban_form,
    'list_danhsachnhansu' => $list_nhansu,
    'list_giaoviec' => $list_giaoviec,
    'total_giaoviec' => $total_giaoviec,
    'dahoanthanh' => $hoanthanh,
    'quanhan' => $hoanthanh,
    'chamtiendo' => $chamtiendo,
    'list_phongbannhanvien'=>$danhsachphongban,
    'chuatienhanh' => $chuatienhanh,
    'dangtienhanh' => $dangtienhanh,
    'dexuat_box'=>$dexuat_box,
    'hoanthanh' => $hoanthanh,
    'quahan' => $miss_deadline,
    'danhsachnhansuphongban'=>$danhsachnhansuphongban,
    'phongbancha' => $phongbancha,
    'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/adanhsachnhansu'),
);
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/adanhsachnhansu', $bien);
