<?php 
$loai = addslashes($_REQUEST['loai']);
$tieu_de = addslashes($_REQUEST['tieu_de']);
$link = addslashes($_REQUEST['link']);
$target = addslashes($_REQUEST['target']);
$thu_tu = intval($_REQUEST['thu_tu']);
$category = addslashes($_REQUEST['category']);
$theloai = addslashes($_REQUEST['theloai']);
$page = addslashes($_REQUEST['page']);
$vi_tri=addslashes($_REQUEST['vi_tri']);
if ($loai == 'page') {
    if (strlen($tieu_de) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Hãy nhập tiêu đề';
    } else {
        $ok = 1;
        $thongbao = 'Thêm menu thành công';
        mysqli_query($conn, "INSERT INTO menu (menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$tieu_de','','$page','$target','$thu_tu','$loai','$vi_tri')");
    }
}else if ($loai == 'theloai') {
    if (strlen($tieu_de) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Hãy nhập tiêu đề';
    } else {
        $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category WHERE cat_id='$theloai' ORDER BY cat_id DESC LIMIT 1");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] > 0) {
            $ok = 1;
            $thongbao = 'Thêm menu thành công';
            mysqli_query($conn, "INSERT INTO menu (menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$tieu_de','$category','/bai-viet/{$r_tt['cat_blank']}.html','$target','$thu_tu','$loai','$vi_tri')");
        } else {
            $ok = 0;
            $thongbao = 'Thất bại! Danh mục không tồn tại';

        }
    }
}else if ($loai == 'category') {
    if (strlen($tieu_de) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Hãy nhập tiêu đề';
    } else {
        $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category_sanpham WHERE cat_id='$category' ORDER BY cat_id DESC LIMIT 1");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] > 0) {
            $ok = 1;
            $thongbao = 'Thêm menu thành công';
            mysqli_query($conn, "INSERT INTO menu (menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$tieu_de','$category','/san-pham/{$r_tt['cat_blank']}.html','$target','$thu_tu','$loai','$vi_tri')");
        } else {
            $ok = 0;
            $thongbao = 'Thất bại! Danh mục không tồn tại';

        }
    }
}  else {
    if (strlen($tieu_de) < 2) {
        $ok = 0;
        $thongbao = 'Thất bại! Hãy nhập tiêu đề';
    } else {
        $ok = 1;
        $thongbao = 'Thêm menu thành công';
        mysqli_query($conn, "INSERT INTO menu (menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$tieu_de','','$link','$target','$thu_tu','$loai','$vi_tri')");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>