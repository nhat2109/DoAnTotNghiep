<?php
// Kiểm tra đăng nhập và quyền truy cập
// if (!isset($_COOKIE['emin_id'])) {
//     echo json_encode(['ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập']);
//     exit();
// }

// Giả định $user_info và $conn đã được định nghĩa
if (!isset($user_info['user_id']) || empty($user_info['user_id'])) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi: Không tìm thấy user_id']);
    exit();
}

$user_id = (int)$user_info['user_id'];

// Lấy dữ liệu đầu vào
$tieu_de = mysqli_real_escape_string($conn, strip_tags($_REQUEST['tieu_de'] ?? ''));
$kho = (int)preg_replace('/[^0-9]/', '', $_REQUEST['kho'] ?? 0);
$anh = mysqli_real_escape_string($conn, strip_tags($_REQUEST['anh'] ?? ''));
$link = mysqli_real_escape_string($conn, strip_tags($_REQUEST['link'] ?? ''));
$link_aff = mysqli_real_escape_string($conn, strip_tags($_REQUEST['link_aff'] ?? ''));
$category = mysqli_real_escape_string($conn, strip_tags($_REQUEST['category'] ?? ''));
$category_ncc = mysqli_real_escape_string($conn, strip_tags($_REQUEST['category_ncc'] ?? ''));
$noiban = $_REQUEST['noiban'] ?? [];
$list_phanloai = $_REQUEST['phan_loai'] ?? '';
$tach_phanloai = json_decode($list_phanloai, true);
$thuong_hieu = mysqli_real_escape_string($conn, strip_tags($_REQUEST['thuong_hieu'] ?? ''));
$thuong_hieu_2 = mysqli_real_escape_string($conn, strip_tags($_REQUEST['thuong_hieu_2'] ?? ''));
$info = mysqli_real_escape_string($conn, strip_tags($_REQUEST['info'] ?? ''));
$info = substr($info, 0, -1);
$noibat = mysqli_real_escape_string($conn, $_REQUEST['noibat'] ?? '');
$noidung = mysqli_real_escape_string($conn, $_REQUEST['noidung'] ?? '');
$title = mysqli_real_escape_string($conn, strip_tags($_REQUEST['title'] ?? ''));
$description = mysqli_real_escape_string($conn, strip_tags($_REQUEST['description'] ?? ''));


//Lấy chiều dài, chiều rộng, chiều cao
$chieudai_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieudai_shop'] ?? 0);
$chieurong_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieurong_shop'] ?? 0);
$chieucao_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieucao_shop'] ?? 0);

$kich_thuoc = "$chieudai_shop,$chieurong_shop,$chieucao_shop";
// Kiểm tra file upload
$duoi = $check->duoi_file($_FILES['file']['name'] ?? '');
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Kiểm tra dữ liệu đầu vào
if (empty($tieu_de)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Chưa nhập tên sản phẩm']);
    exit();
}
//2-4
if (strlen($tieu_de) > 156) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Tiêu đề không được vượt quá 156 ký tự']);
    exit();
}
if (!in_array($duoi, $allowed_extensions)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Chưa chọn hình minh họa']);
    exit();
}
if (empty($list_phanloai) || !is_array($tach_phanloai) || empty($tach_phanloai)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Không có phân loại sản phẩm']);
    exit();
}

// Kiểm tra nơi bán
$noiban = is_array($noiban) ? $noiban : [$noiban];
//=========================7-5
// $insert_socdo = in_array('socdo', $noiban) || in_array('all', $noiban); 
$insert_shop = in_array('shop_ncc', $noiban) || in_array('all', $noiban) || in_array('socdo_ctv', $noiban);

if (!$insert_shop) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Chưa chọn nơi bán']);
    exit();
}

// Xử lý kích cỡ và thương hiệu (nếu có) //3-4
if (!empty($thuong_hieu_2)) {
    $check_query = "SELECT id FROM thuong_hieu WHERE shop = '$user_id' AND tieu_de = '$thuong_hieu_2' AND thu_tu = '0'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) == 0) { 
        $query = "INSERT INTO thuong_hieu (shop, tieu_de, thu_tu, id_thuonghieu_socdo) 
                  VALUES ('$user_id', '$thuong_hieu_2', '0', '0')";
        
        if (!mysqli_query($conn, $query)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm thương hiệu: ' . mysqli_error($conn)]);
            exit();
        }
        $thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
        $r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
        $thuong_hieu = $r_th['id'];
    } else {
        $r_th = mysqli_fetch_assoc($result);
        $thuong_hieu = $r_th['id'];
    }
}
// Xử lý hình ảnh trước khi thêm dữ liệu
$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
if (!move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Lỗi khi upload hình minh họa']);
    exit();
}

// Lấy thông tin phân loại đầu tiên
$first_phanloai = $tach_phanloai[0];
$gia_cu_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_cu'] ?? 0);
$gia_moi_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_moi'] ?? 0);
$gia_drop_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_drop'] ?? 0);
$gia_ctv_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_ctv'] ?? 0);
$drop_min_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['drop_min'] ?? 0);
$ma_sp_first = mysqli_real_escape_string($conn, $first_phanloai['ma_sp'] ?? '');
$can_nang_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['can_nang'] ?? 0);
//2-4
$gia_socdo_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_socdo'] ?? 0);


//5-4
// lấy giá lớn nhất của tất cả các phân loại để làm giá cũ của 
$max_phanloai = array_reduce($tach_phanloai, function ($carry, $item) {
    $gia_cu_item = (int)preg_replace('/[^0-9]/', '', $item['gia_cu'] ?? 0);
    $gia_cu_carry = (int)preg_replace('/[^0-9]/', '', $carry['gia_cu'] ?? 0);
    return ($gia_cu_item > $gia_cu_carry) ? $item : $carry;
}, ['gia_cu' => 0]);

$gia_cu_max = (int)preg_replace('/[^0-9]/', '', $max_phanloai['gia_cu']);

// lấy giá trị lớn nhất của sóc đỏ làm giá mới
$min_phanloai_socdo = array_reduce($tach_phanloai, function ($carry, $item) {
    $gia_item = (int)preg_replace('/[^0-9]/', '', $item['gia_socdo'] ?? 0);
    $gia_carry = (int)preg_replace('/[^0-9]/', '', $carry['gia_socdo'] ?? PHP_INT_MAX);
    return ($gia_item < $gia_carry) ? $item : $carry;
}, ['gia_socdo' => PHP_INT_MAX]);

$gia_socdo_min = (int)preg_replace('/[^0-9]/', '', $min_phanloai_socdo['gia_moi']);


// Tính trọng lượng tính ship cho phân loại đầu tiên
// $thetich_sp = $chieudai_shop * $chieurong_shop * $chieucao_shop;
// $trongluong_kichthuoc = $thetich_sp / 6000;
// $can_nang_tinhship_first = max($can_nang_first, $trongluong_kichthuoc);

// Thông tin cho website shop
// $color_first_shop = (int)($first_phanloai['color_shop'] ?? 0);
// $size_first_shop = (int)($first_phanloai['size_shop'] ?? 0);
// $ten_color_first_shop = mysqli_real_escape_string($conn, $first_phanloai['ten_color_shop'] ?? '');
// $ten_size_first_shop = mysqli_real_escape_string($conn, $first_phanloai['ten_size_shop'] ?? '');
// $ma_mau_first_shop = mysqli_real_escape_string($conn, $first_phanloai['ma_mau_shop'] ?? '');

// Thông tin cho Sóc Đỏ
$color_first_socdo = (int)($first_phanloai['color'] ?? 0);
$size_first_socdo = (int)($first_phanloai['size'] ?? 0);
$ten_color_first_socdo = mysqli_real_escape_string($conn, $first_phanloai['ten_color'] ?? '');
$ten_size_first_socdo = mysqli_real_escape_string($conn, $first_phanloai['ten_size'] ?? '');
$ma_mau_first_socdo = mysqli_real_escape_string($conn, $first_phanloai['ma_mau'] ?? '');

$date_post = time();

// Kiểm tra trùng link
$ok = 1;
$thongbao = 'Thêm sản phẩm thành công';

// Đăng lên website con (sanpham_shop)
if ($insert_shop) {
    // Kiểm tra trùng link trong seo_shop
    $thongtin = mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
    if (!$thongtin) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi kiểm tra link: ' . mysqli_error($conn)]);
        exit();
    }
    $r_tt = mysqli_fetch_assoc($thongtin);

    if ($r_tt['total'] > 0) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Link xem đã tồn tại trên website con']);
        exit();
    }

    // Xác định status dựa trên nơi bán
    //$status = $insert_socdo ? 0 : 2; // Nếu có đăng lên Sóc Đỏ hoặc tất cả, status = 0, nếu chỉ đăng lên website shop thì status = 2
    //Nếu nơi bán là All thì status = 0, 
    //Nếu nơi bán là shop_ncc thì status = 2, 
    //Nếu nơi bán là socdo_ctv thì status = 1 => đăng lên công đồng ctv
    if($noiban[0]=='all')
    {
        $status =0;
    } 
    else if($noiban[0]=='shop_ncc')
    {
        $status = 2;
    }
    else if($noiban[0]=='socdo_ctv')
    {
        $status = 1;
    }
    $sp_id_temp = 0;
    $ban = 0;
    $view = 0;

    // truy vấn categories lấy category của sóc đỏ
    $list_category=getcategorysocdo($conn, $category);
    $query = "INSERT INTO sanpham_shop (shop, sp_id, tieu_de, minh_hoa, link, link_aff, cat, cat_shop, status, kho_hang, gia_cu, gia_moi, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, ban, title, description, view, date_post ,kich_thuoc ) 
              VALUES ('$user_id', '$sp_id_temp', '$tieu_de', '$minh_hoa', '$link', '$link_aff', '$list_category', '', '$status', '$kho', '$gia_cu_max', '$gia_socdo_min', '$noibat', '$noidung', '$color_first_socdo', '$thuong_hieu', '$size_first_socdo', '$info', '$can_nang_first', '$anh', '$ban', '$title', '$description', '$view', '$date_post' ,'$kich_thuoc')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm vào sanpham_shop: ' . mysqli_error($conn)]);
        exit();
    }

    $sanpham_shop_id = mysqli_insert_id($conn);

    // Thêm phân loại vào phanloai_sanpham_shop
    foreach ($tach_phanloai as $value) {
        $gia_cu = (int)preg_replace('/[^0-9]/', '', $value['gia_cu'] ?? 0);
        $gia_moi = (int)preg_replace('/[^0-9]/', '', $value['gia_moi'] ?? 0);
        $gia_drop = (int)preg_replace('/[^0-9]/', '', $value['gia_drop'] ?? 0);
        $gia_ctv = (int)preg_replace('/[^0-9]/', '', $value['gia_ctv'] ?? 0);
        $gia_socdo = (int)preg_replace('/[^0-9]/', '', $value['gia_socdo'] ?? 0);
        $drop_min = (int)preg_replace('/[^0-9]/', '', $value['drop_min'] ?? 0);
        $ma_sp = mysqli_real_escape_string($conn, $value['ma_sp'] ?? '');
        $can_nang = (int)preg_replace('/[^0-9]/', '', $value['can_nang'] ?? 0);
        $kho_sanpham_shop = (int)preg_replace('/[^0-9]/', '', $value['kho_sanpham_shop'] ?? 0);
        $color_shop_val = (int)($value['color_shop'] ?? 0); // cẩn bỏ
        $size_shop_val = (int)($value['size_shop'] ?? 0); // cần bỏ
        $color_socdo_val = (int)($value['color'] ?? 0);
        $size_socdo_val = (int)($value['size'] ?? 0);
        $ten_color_shop = mysqli_real_escape_string($conn, $value['ten_color_shop'] ?? '');
        $ten_size_shop = mysqli_real_escape_string($conn, $value['ten_size_shop'] ?? '');
        $ten_color_socdo = mysqli_real_escape_string($conn, $value['ten_color'] ?? '');
        $ten_size_socdo = mysqli_real_escape_string($conn, $value['ten_size'] ?? '');
        $ma_mau_shop = mysqli_real_escape_string($conn, $value['ma_mau_shop'] ?? '');
        $ma_mau_socdo = mysqli_real_escape_string($conn, $value['ma_mau'] ?? '');

        // Tính trọng lượng tính ship
        $thetich_sp = $chieudai_shop * $chieurong_shop * $chieucao_shop;
        $trongluong_kichthuoc = $thetich_sp / 6000;
        $can_nang_tinhship = max($can_nang, $trongluong_kichthuoc);

        $query = "INSERT INTO phanloai_sanpham_shop 
                (user_id, sp_id, ma_sp, color, ten_color, ma_mau, color_socdo, ten_color_socdo, ma_mau_socdo, size, ten_size, size_socdo, ten_size_socdo, can_nang, gia_cu, gia_moi, gia_drop, gia_ctv, gia_socdo, drop_min, kho_sanpham_shop, can_nang_tinhship, date_post) 
                VALUES 
                ($user_id, $sanpham_shop_id, '$ma_sp', $color_socdo_val, '$ten_color_socdo', '$ma_mau_socdo', $color_socdo_val, '$ten_color_socdo', '$ma_mau_socdo', $size_socdo_val, '$ten_size_socdo', $size_socdo_val, '$ten_size_socdo', $can_nang, $gia_cu, $gia_moi, $gia_drop, $gia_ctv, $gia_socdo, $drop_min, $kho_sanpham_shop, $can_nang_tinhship, $date_post)";
        if (!mysqli_query($conn, $query)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm phân loại sanpham_shop: ' . mysqli_error($conn)]);
            exit();
        }
    }

   // Thêm SEO cho website con
    $query = "INSERT INTO seo_shop (loai, link, shop) VALUES ('sanpham', '$link', '$user_id')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm SEO sanpham_shop: ' . mysqli_error($conn)]);
        exit();
    }

   // Nếu có đăng lên Sóc Đỏ hoặc tất cả, status = 0

//    if ($status == 0) { 
//         $kho_hcm = 0;
//         $box_flash = 0;
//         $box_banchay =0;
//         $box_noibat = 0;
//         $query_sanpham = "INSERT INTO sanpham (ma_sanpham, tieu_de, minh_hoa, link, cat, gia_cu, gia_moi, gia_drop, drop_min, gia_ctv, ctv_min, noi_ban, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, sale, kho, kho_hcm, box_flash, box_banchay, box_noibat, ban, title, description, view, cat_ma, date_post ,shop) VALUES ('$ma_sp', '$tieu_de', '$minh_hoa', '$link', '$list_category', '$gia_cu', '$gia_socdo_first', '$gia_drop', '$drop_min', '$gia_ctv', '$drop_min', '$noiban', '$noibat', '$noidung', '$color_first_socdo', '$thuong_hieu', '$size_first_socdo', '$info', '$can_nang', '$anh', 0, '$kho', '$kho_hcm', '$box_flash', '$box_banchay', '$box_noibat', 0, '$title', '$description', 0, 0, " . time() . ",'$sanpham_shop_id')"; 
//         if (!mysqli_query($conn, $query_sanpham)) { echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm vào bảng sanpham: ' . mysqli_error($conn)]); exit(); } 
//     }


}

// if (!empty($size_2)) {
//     $query = "INSERT INTO kich_co (shop, tieu_de, thu_tu) VALUES ('$user_id', '$size_2', '0')";
//     if (!mysqli_query($conn, $query)) {
//         echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm kích cỡ: ' . mysqli_error($conn)]);
//         exit();
//     }
//     $thongtin_kichco = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
//     $r_kc = mysqli_fetch_assoc($thongtin_kichco);
//     $size = $r_kc['id'];
// }

// Trả về kết quả
echo json_encode([
    'ok' => $ok,
    'thongbao' => $thongbao,
    'tach_phanloai'=>$tach_phanloai,
]);

function getcategorysocdo($conn, $category)
{
    $categoryArray = explode(',', $category);
    $categoryList = implode("','", $categoryArray);
    $sql = "
    SELECT cat_id_socdo 
    FROM category_sanpham_shop 
    WHERE cat_id IN ('$categoryList') 
    AND cat_id_socdo != 0
    ";
    $result = mysqli_query($conn, $sql);
    $categories = explode(',', $category); 
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['cat_id_socdo']; 
    }

    return implode(',', array_unique($categories));
}


?>