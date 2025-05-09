<?php 
$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
$cat_title = strip_tags($_REQUEST['cat_title']);
$cat_description = strip_tags($_REQUEST['cat_description']);
$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
$link_old = addslashes($_REQUEST['link_old']);
$cat_thutu = intval($_REQUEST['cat_thutu']);
$cat_blank = addslashes($_REQUEST['cat_blank']);
$cat_id = intval($_REQUEST['cat_id']);
$cat_main = intval($_REQUEST['cat_main']);
$cat_icon = addslashes($_REQUEST['cat_icon']);
$cat_index = intval($_REQUEST['cat_index']);
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('theloai', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    if ($cat_tieude == '') {
        $ok = 0;
        $thongbao = 'Vui lòng nhập tiêu đề';
    } else {
        if ($cat_blank == $link_old) {
            $ok = 1;
            $thongbao = "Sửa thể loại thành công";
            mysqli_query($conn, "UPDATE category SET cat_tieude='$cat_tieude',cat_main='$cat_main',cat_blank='$cat_blank',cat_noidung='$cat_noidung',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',cat_index='$cat_index' WHERE cat_id='$cat_id'");

        } else {
            $thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' AND loai='theloai' ORDER BY id DESC LIMIT 1");
            $r_seo = mysqli_fetch_assoc($thongtin_seo);
            if ($r_seo['total'] > 0) {
                $ok = 0;
                $thongbao = 'Thất bại! Link xem đã tồn tại';

            } else {
                $ok = 1;
                $thongbao = "Sửa thể loại thành công";
                mysqli_query($conn, "UPDATE category SET cat_tieude='$cat_tieude',cat_blank='$cat_blank',cat_noidung='$cat_noidung',cat_main='$cat_main',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
                mysqli_query($conn, "UPDATE seo SET link='$cat_blank' WHERE link='$link_old' AND loai='theloai'");
            }

        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>