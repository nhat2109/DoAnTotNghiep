<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $user_id = str_replace('ctv_', '', addslashes($_REQUEST['user_id']));
    $status = intval($_REQUEST['status']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM shop_setting WHERE shop='$user_id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] > 0) {
    } else {
        if ($status == 1) {
            $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
            $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
            $domain = $r_tv['username'] . '.socdo.vn';
            $logo = '/uploads/minh-hoa/logo-' . time() . '.png';
            copy('../skin_shop/css/images/logo.png', '..' . $logo);
            $favicon = '/uploads/minh-hoa/favicon-' . time() . '.png';
            copy('../images/favicon.png', '..' . $favicon);
            $lienhe = addslashes($index_setting['lienhe']);
            $gioithieu = addslashes($index_setting['gioithieu']);
            $description = addslashes($index_setting['description']);
            $ban_do = addslashes($index_setting['ban_do']);
            $google_analytics = addslashes($index_setting['google_analytics']);
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','ban_do','$ban_do','html')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','description','$description','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','gioithieu','$gioithieu','html')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','hotline','{$index_setting['hotline']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','lienhe','$lienhe','html')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','link_facebook','{$index_setting['link_facebook']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','link_instagram','{$index_setting['link_instagram']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','link_twitter','{$index_setting['link_twitter']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','link_youtube','{$index_setting['link_youtube']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','logo','$logo','img')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','favicon','$favicon','img')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','text_contact_footer','','html')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','text_footer','','html')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','text_hotline','{$index_setting['text_hotline']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','title','{$index_setting['title']}','')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','giaodien','','css')");
            mysqli_query($conn, "INSERT INTO shop_setting(shop,name,value,loai)VALUES('$user_id','google_analytics','$google_analytics','html')");
            mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");

            /*				mysqli_query($conn,"INSERT INTO menu_shop(shop,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$user_id','Sản phẩm','0','/san-pham.html','','1','link','top')");
            mysqli_query($conn,"INSERT INTO menu_shop(shop,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$user_id','Giới thiệu','0','/gioi-thieu.html','','2','link','top')");
            mysqli_query($conn,"INSERT INTO menu_shop(shop,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$user_id','Liên hệ','0','/lien-he.html','','3','link','top')");*/
        }
    }
    mysqli_query($conn, "UPDATE user_info SET ctv='$status' WHERE user_id='$user_id'");
    $ok = 1;
    $thongbao = 'Cập nhật thành công';
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
