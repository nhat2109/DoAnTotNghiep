<?
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('slide', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();	
    }
    $tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
    $link=addslashes(strip_tags($_REQUEST['link']));
    $target=addslashes(strip_tags($_REQUEST['target']));
    $thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $id=intval($_REQUEST['id']);
    $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM slide WHERE id='$id' AND shop='0'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if($r_tt['total']==0){
        $ok=0;
        $thongbao='Thất bại! Slide không tồn tại';
    }else{
        if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
            $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
            move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
            @unlink('..' . $r_tt['minh_hoa']);
            mysqli_query($conn, "UPDATE slide SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',link='$link',target='$target',thu_tu='$thu_tu' WHERE id='$id'");
            $ok = 1;
            $thongbao = 'Sửa slide thành công!';
        } else {
            mysqli_query($conn, "UPDATE slide SET tieu_de='$tieu_de',link='$link',target='$target',thu_tu='$thu_tu' WHERE id='$id'");
            $thongbao = 'Sửa slide thành công';
            $ok = 1;
        }

    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>