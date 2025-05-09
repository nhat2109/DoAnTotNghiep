<?php  
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('banner', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();	
    }
    $tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
    $link=addslashes(strip_tags($_REQUEST['link']));
    $target=addslashes(strip_tags($_REQUEST['target']));
    $vi_tri=addslashes(strip_tags($_REQUEST['vi_tri']));
    $thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
    $bg_banner=addslashes(strip_tags($_REQUEST['bg_banner']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        @unlink('..' . $index_setting[$name]);
        mysqli_query($conn, "INSERT INTO banner(tieu_de,minh_hoa,bg_banner,link,target,thu_tu,vi_tri)VALUES('$tieu_de','$minh_hoa','$bg_banner','$link','$target','$thu_tu','$vi_tri')");
        $ok = 1;
        $thongbao = 'Thêm banner thành công!';
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