<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $title = addslashes(strip_tags($_REQUEST['title']));
    $description = addslashes(strip_tags($_REQUEST['description']));
    $link_video = strip_tags(addslashes($_REQUEST['link_video']));
    $loai = strip_tags(addslashes($_REQUEST['loai']));
    $cat = strip_tags(addslashes($_REQUEST['cat']));
    $noidung = addslashes($_REQUEST['noidung']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        $thongbao = 'Thêm video thành công';
        $ok = 1;
        mysqli_query($conn, "INSERT INTO video(tieu_de,minh_hoa,link,link_video,loai,cat,noi_dung,view,title,description,date_post)VALUES('$tieu_de','$minh_hoa','$link','$link_video','$loai','$cat','$noidung','0','$title','$description',".time().")");
    } else {
        $param_video = parse_url($link_video);
        parse_str($param_video['query'], $video_query);
        $id_video=addslashes($video_query['v']);
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/default.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/mqdefault.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/sddefault.jpg';
        $minh_hoa='https://i.ytimg.com/vi/'.$id_video.'/sddefault.jpg';
        //$minh_hoa='http://img.youtube.com/vi/'.$id_video.'/maxresdefault.jpg';
        mysqli_query($conn, "INSERT INTO video(tieu_de,minh_hoa,link,link_video,loai,cat,noi_dung,view,title,description,date_post)VALUES('$tieu_de','$minh_hoa','$link','$link_video','$loai','$cat','$noidung','0','$title','$description',".time().")");
        mysqli_query($conn, "INSERT INTO seo (loai,link)VALUES('video','$link')");
        $thongbao = 'Thêm video thành công';
        $ok = 1;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>