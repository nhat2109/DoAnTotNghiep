<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $title = addslashes(strip_tags($_REQUEST['title']));
    $description = addslashes(strip_tags($_REQUEST['description']));
    $noidung = addslashes($_REQUEST['noidung']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $loai = addslashes($_REQUEST['loai']);
    $cat = strip_tags(addslashes($_REQUEST['cat']));
    $link_video = strip_tags(addslashes($_REQUEST['link_video']));
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT * FROM video WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        $thongbao = 'Sửa video thành công';
        $ok = 1;
        mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',loai='$loai',cat='$cat',noi_dung='$noidung',link_video='$link_video',link='$link',title='$title',description='$description' WHERE id='$id'");
        @unlink('..' . $r_tt['minh_hoa']);
    } else {
        $param_video = parse_url($link_video);
        parse_str($param_video['query'], $video_query);
        $id_video=addslashes($video_query['v']);
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/default.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/mqdefault.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/sddefault.jpg';
        $minh_hoa='https://i.ytimg.com/vi/'.$id_video.'/sddefault.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/maxresdefault.jpg';
        if($link_video!=$r_tt['link_video']){
            mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',noi_dung='$noidung',loai='$loai',cat='$cat',link_video='$link_video',link='$link',title='$title',description='$description' WHERE id='$id'");
        }else{
            mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',noi_dung='$noidung',loai='$loai',cat='$cat',link_video='$link_video',link='$link',title='$title',description='$description' WHERE id='$id'");
        }
        $thongbao = 'Sửa video thành công';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>