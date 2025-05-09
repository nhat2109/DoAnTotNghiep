<?php
    $id = (int)$_REQUEST['id'];

    // Lấy thông tin sản phẩm từ sanpham_shop
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$id'");
    if (mysqli_num_rows($thongtin) == 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không tồn tại!']);
        exit();
    }

    $r_sp = mysqli_fetch_assoc($thongtin);

    // Kiểm tra trạng thái
    if ($r_sp['status'] != 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không ở trạng thái chờ duyệt (status phải là 0)!']);
        exit();
    }

    // Kiểm tra trùng link trong seo
    $thongtin_seo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo WHERE link='{$r_sp['link']}' AND loai='sanpham'");
    $r_seo = mysqli_fetch_assoc($thongtin_seo);
    if ($r_seo['total'] > 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Link xem đã tồn tại trên Sóc Đỏ!']);
        exit();
    }

    // Lấy thông tin phân loại từ phanloai_sanpham_shop
    $thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham_shop WHERE sp_id='$id' LIMIT 1");
    if (mysqli_num_rows($thongtin_phanloai) == 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Không tìm thấy phân loại sản phẩm!']);
        exit();
    }
    $r_pl = mysqli_fetch_assoc($thongtin_phanloai);

    // Chuẩn bị dữ liệu để thêm vào sanpham
    $ma_sanpham = $r_pl['ma_sp'];
    $tieu_de = mysqli_real_escape_string($conn, $r_sp['tieu_de']);
    $minh_hoa = $r_sp['minh_hoa'];
    $link = $r_sp['link'];
    $cat = $r_sp['cat'];// 3-4 lấy tất cả 
    $gia_cu = $r_pl['gia_cu'];
    $gia_moi = $r_pl['gia_moi'];
    $gia_drop = $r_pl['gia_drop'];
    $drop_min = $r_pl['drop_min'];
    $gia_ctv = $r_pl['gia_ctv'];
    $gia_socdo = $r_pl['gia_socdo'];
    $ctv_min = $r_pl['drop_min'];
    $noi_ban = 'socdo';
    $noi_bat = mysqli_real_escape_string($conn, $r_sp['noi_bat']);
    $noi_dung = mysqli_real_escape_string($conn, $r_sp['noi_dung']);
    $mau = $r_pl['color_socdo'];
    $thuong_hieu = $r_sp['thuong_hieu'];
    $size = $r_pl['size_socdo'];
    $thongtin = mysqli_real_escape_string($conn, $r_sp['thongtin']);
    $can_nang = $r_pl['can_nang'];
    $anh = $r_sp['anh'];
    $sale = 0;
    $kho = $r_sp['kho_hang'];
    $kho_hcm = $r_sp['kho_hang'];
    $ban = 0;
    $box_banchay = 0;
    $box_noibat = 0;
    $cat_ma = 0;
    $box_flash = 0;
    $title = mysqli_real_escape_string($conn, $r_sp['title']);
    $description = mysqli_real_escape_string($conn, $r_sp['description']);
    $view = 0;
    $date_post = time();
    $shop = $r_sp['shop'];
    $status = 1; // Đã duyệt

    // Thêm vào bảng sanpham
    $query = "INSERT INTO sanpham (ma_sanpham, tieu_de, minh_hoa, link, cat, gia_cu, gia_moi, gia_drop, drop_min, gia_ctv, ctv_min, noi_ban, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, sale, kho, kho_hcm, ban, box_banchay, box_noibat, cat_ma, box_flash, title, description, view, date_post, shop, status) 
              VALUES ('$ma_sanpham', '$tieu_de', '$minh_hoa', '$link', '$cat', '$gia_cu', '$gia_socdo', '$gia_drop', '$drop_min', '$gia_ctv', '$ctv_min', '$noi_ban', '$noi_bat', '$noi_dung', '$mau', '$thuong_hieu', '$size', '$thongtin', '$can_nang', '$anh', '$sale', '$kho', '$kho_hcm', '$ban', '$box_banchay', '$box_noibat', '$cat_ma', '$box_flash', '$title', '$description', '$view', '$date_post', '$shop', '$status')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm vào sanpham: ' . mysqli_error($conn)]);
        exit();
    }

    $sanpham_id = mysqli_insert_id($conn);

    // Cập nhật sp_id và status trong sanpham_shop (status từ 0 thành 1)
    $query_update = "UPDATE sanpham_shop SET sp_id='$sanpham_id', status=1 WHERE id='$id'";
    if (!mysqli_query($conn, $query_update)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi cập nhật sp_id và status: ' . mysqli_error($conn)]);
        exit();
    }

    // Thêm phân loại vào phanloai_sanpham
    $thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham_shop WHERE sp_id='$id'");
    while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
        $ma_sp = $r_pl['ma_sp'];
        $color = $r_pl['color_socdo'];
        $size = $r_pl['size_socdo'];
        $ten_color = $r_pl['ten_color_socdo'];
        $ma_mau = $r_pl['ma_mau_socdo'];
        $ten_size = $r_pl['ten_size_socdo'];
        $can_nang = $r_pl['can_nang'];
        $gia_cu = $r_pl['gia_cu'];
        $gia_moi = $r_pl['gia_moi'];
        $gia_drop = $r_pl['gia_drop'];
        $gia_ctv = $r_pl['gia_ctv'];
        $gia_socdo = $r_pl['gia_socdo'];//3-4 cập nhật bảng soc đỏ
        $drop_min = $r_pl['drop_min'];
        $kho_sanpham_socdo = $r_pl['kho_sanpham_shop'];
        $can_nang_tinhship = $r_pl['can_nang_tinhship'];
        $date_post = time();

        $query_pl = "INSERT INTO phanloai_sanpham (user_id, sp_id, ma_sp, color, size, ten_color, ma_mau, ten_size, can_nang, gia_cu, gia_moi, gia_drop, gia_ctv, drop_min, kho_sanpham_socdo, can_nang_tinhship, date_post) 
                     VALUES ('$shop', '$sanpham_id', '$ma_sp', '$color', '$size', '$ten_color', '$ma_mau', '$ten_size', '$can_nang', '$gia_cu', '$gia_socdo', '$gia_drop', '$gia_ctv', '$drop_min', '$kho_sanpham_socdo', '$can_nang_tinhship', '$date_post')";
        if (!mysqli_query($conn, $query_pl)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm phân loại: ' . mysqli_error($conn)]);
            exit();
        }
    }

    // Thêm SEO cho Sóc Đỏ
    $query_seo = "INSERT INTO seo (loai, link) VALUES ('sanpham', '$link')";
    if (!mysqli_query($conn, $query_seo)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm SEO: ' . mysqli_error($conn)]);
        exit();
    }

    echo json_encode(['ok' => 1, 'thongbao' => 'Duyệt sản phẩm thành công!']);
    exit();

?>