<?php
	$cat_tieude = addslashes(strip_tags($_POST['cat_tieude']));
    $cat_blank = addslashes(strip_tags($_POST['cat_blank']));
    $cat_title = addslashes(strip_tags($_POST['cat_title']));
    $cat_description = addslashes(strip_tags($_POST['cat_description']));
    $cat_main = (int)$_POST['cat_main'];
    $cat_index = (int)$_POST['cat_index'];
    $cat_thutu = (int)$_POST['cat_thutu'];
    $cat_link = addslashes(strip_tags($_POST['cat_link']));

    if (empty($cat_tieude)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng nhập tiêu đề']);
        exit;
    }

    if (empty($cat_thutu)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng nhập thứ tự']);
        exit;
    }

    $thongtin_seo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link='$cat_blank' AND loai='category' AND shop='$user_id'");
    $r_seo = mysqli_fetch_assoc($thongtin_seo);
    if ($r_seo['total'] > 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Link xem đã tồn tại']);
        exit;
    }

    $cat_img = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_extensions)) {
            $cat_img = '/uploads/minh-hoa/' . preg_replace('/[^a-z0-9-]/', '-', strtolower($cat_tieude)) . '-' . time() . '.' . $ext;
            move_uploaded_file($file['tmp_name'], '..' . $cat_img);
        }
    }

    $sql_category = "INSERT INTO category_sanpham_shop (shop, cat_tieude, cat_main, cat_blank, cat_index, cat_link, cat_img, cat_title, cat_description, cat_thutu) 
                     VALUES ('$user_id', '$cat_tieude', '$cat_main', '$cat_blank', '$cat_index', '$cat_link', '$cat_img', '$cat_title', '$cat_description', '$cat_thutu')";
    
    $sql_seo = "INSERT INTO seo_shop (shop, loai, link) VALUES ('$user_id', 'category', '$cat_blank')";

    if (mysqli_query($conn, $sql_category) && mysqli_query($conn, $sql_seo)) {
        echo json_encode(['ok' => 1, 'thongbao' => 'Thêm danh mục thành công']);
    } else {
        echo json_encode(['ok' => 0, 'thongbao' => 'Thêm danh mục thất bại']);
    }
?>