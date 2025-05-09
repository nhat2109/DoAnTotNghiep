<?php  

if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('giaodien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();	
    }
    $tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
    $demo=addslashes(strip_tags($_REQUEST['demo']));
    $gia_cu=preg_replace('/[^0-9]/', '', $_REQUEST['gia_cu']);
    $gia_moi=preg_replace('/[^0-9]/', '', $_REQUEST['gia_moi']);
    $thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $duoi_socdo = $check->duoi_file($_FILES['file_socdo']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        if (in_array($duoi_socdo, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
            $minhhoa_socdo = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-socdo-' . time() . '.' . $duoi_socdo;
            move_uploaded_file($_FILES['file_socdo']['tmp_name'], '..' . $minhhoa_socdo);
        }else{
            $minhhoa_socdo='';
        }
        mysqli_query($conn, "INSERT INTO giaodien(tieu_de,minh_hoa,minhhoa_socdo,demo,gia_cu,gia_moi,thu_tu)VALUES('$tieu_de','$minh_hoa','$minhhoa_socdo','$demo','$gia_cu','$gia_moi','$thu_tu')");
        $ok = 1;
        $thongbao = 'Thêm giao diện thành công!';
    } else {
        $thongbao = 'Thất bại! Bạn chưa chọn hình ảnh';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>