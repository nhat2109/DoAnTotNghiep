<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('brand', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $thu_tu = intval($_REQUEST['thu_tu']);
    $id=intval($_REQUEST['id']);
    $link_anh = addslashes(strip_tags($_REQUEST['link_anh']));
    $status = intval($_REQUEST['trang_thai']);
    // huyphuc14/04/2025
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM thuong_hieu WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if($r_tt['total']==0){
        $ok=0;
        $thongbao='Thất bại! thương hiệu không tồn tại';
    }else{
        if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
            $anh_thuong_hieu = '/uploads/thuong-hieu/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
            move_uploaded_file($_FILES['file']['tmp_name'], '..' . $anh_thuong_hieu);
            @unlink('..' . $r_tt['anh_thuong_hieu']);
            mysqli_query($conn, "UPDATE thuong_hieu SET tieu_de='$tieu_de',thu_tu='$thu_tu', anh_thuong_hieu='$anh_thuong_hieu', link_anh='$link_anh', status='$status' WHERE id='$id'");
            $ok = 1;
            $thongbao = 'Sửa thương hiệu thành công';
        } else {
            mysqli_query($conn, "UPDATE thuong_hieu SET tieu_de='$tieu_de',thu_tu='$thu_tu', link_anh='$link_anh', status='$status' WHERE id='$id'");
            $thongbao = 'Sửa thương hiệu thành công';
            $ok = 1;
        }
    }
    

}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>