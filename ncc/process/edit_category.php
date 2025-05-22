<?php
$cat_id = (int)$_POST['cat_id'];
    $cat_tieude = addslashes(strip_tags($_POST['cat_tieude']));
    $cat_blank = addslashes(strip_tags($_POST['cat_blank']));
    $link_old = addslashes(strip_tags($_POST['link_old']));
    $cat_title = addslashes(strip_tags($_POST['cat_title']));
    $cat_description = addslashes(strip_tags($_POST['cat_description']));
    $cat_main = (int)$_POST['cat_main'];
    $cat_index = (int)$_POST['cat_index'];
    $cat_thutu = (int)$_POST['cat_thutu'];
    $cat_link = addslashes(strip_tags($_POST['cat_link']));

    $thongtin = mysqli_query($conn, "SELECT cat_img FROM category_sanpham_shop WHERE cat_id='$cat_id' AND shop='$user_id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if (!$r_tt) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Danh mục không tồn tại']);
        exit;
    }

    if (empty($cat_tieude)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng nhập tiêu đề']);
        exit;
    }

    if (empty($cat_thutu)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng nhập thứ tự']);
        exit;
    }

    if ($cat_blank !== $link_old) {
        $thongtin_seo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link='$cat_blank' AND loai='category' AND shop='$user_id'");
        $r_seo = mysqli_fetch_assoc($thongtin_seo);
        if ($r_seo['total'] > 0) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Link xem đã tồn tại']);
            exit;
        }
        mysqli_query($conn, "UPDATE seo_shop SET link='$cat_blank' WHERE link='$link_old' AND loai='category' AND shop='$user_id'");
    }

    $cat_img = $r_tt['cat_img'];
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_extensions)) {
            $cat_img = '/uploads/minh-hoa/' . preg_replace('/[^a-z0-9-]/', '-', strtolower($cat_tieude)) . '-' . time() . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], '..' . $cat_img)) {
        
                if ($r_tt['cat_img'] && file_exists('..' . $r_tt['cat_img'])) {
                    unlink('..' . $r_tt['cat_img']);
                }
            }
        }
    }

    $update_query = "UPDATE category_sanpham_shop SET 
        cat_tieude='$cat_tieude', 
        cat_main='$cat_main', 
        cat_blank='$cat_blank', 
        cat_img='$cat_img', 
        cat_link='$cat_link', 
        cat_title='$cat_title', 
        cat_description='$cat_description', 
        cat_thutu='$cat_thutu', 
        cat_index='$cat_index' 
    WHERE cat_id='$cat_id' AND shop='$user_id'";

    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['ok' => 1, 'thongbao' => 'Sửa danh mục thành công']);
    } else {
        echo json_encode(['ok' => 0, 'thongbao' => 'Sửa danh mục thất bại']);
    }
?>
