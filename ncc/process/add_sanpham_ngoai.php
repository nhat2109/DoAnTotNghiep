<?php


$tieu_de = mysqli_real_escape_string($conn, strip_tags($_REQUEST['tieu_de'] ?? ''));
$kho = (int)preg_replace('/[^0-9]/', '', $_REQUEST['kho'] ?? 0);
$anh = mysqli_real_escape_string($conn, strip_tags($_REQUEST['anh'] ?? ''));
$link = mysqli_real_escape_string($conn, strip_tags($_REQUEST['link'] ?? ''));
$category = mysqli_real_escape_string($conn, strip_tags($_REQUEST['category'] ?? ''));
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

// Lấy kích thước đóng hộp
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
if (strlen($tieu_de) > 120) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Tiêu đề không được vượt quá 120 ký tự']);
    exit();
}
if (empty($link)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Chưa nhập link xem']);
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

// Xử lý thương hiệu
if (!empty($thuong_hieu_2)) {
    $check_query = "SELECT id FROM thuong_hieu WHERE shop = '$user_id' AND tieu_de = '$thuong_hieu_2'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO thuong_hieu (shop, tieu_de) VALUES ('$user_id', '$thuong_hieu_2')";
        if (!mysqli_query($conn, $query)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm thương hiệu: ' . mysqli_error($conn)]);
            exit();
        }
        $thongtin_thuonghieu = mysqli_query($conn, "SELECT id FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
        $r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
        $thuong_hieu = $r_th['id'];
    } else {
        $r_th = mysqli_fetch_assoc($result);
        $thuong_hieu = $r_th['id'];
    }
}

// Xử lý hình ảnh
$minh_hoa = '/Uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
if (!move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Lỗi khi upload hình minh họa']);
    exit();
}

// Lấy thông tin phân loại đầu tiên
$first_phanloai = $tach_phanloai[0];
$gia_cu_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_cu'] ?? 0);
$gia_moi_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_moi'] ?? 0);
$ma_sp_first = mysqli_real_escape_string($conn, $first_phanloai['ma_sp'] ?? '');
$can_nang_first = (float)preg_replace('/[^0-9.]/', '', $first_phanloai['can_nang'] ?? 0);
$color_first = mysqli_real_escape_string($conn, $first_phanloai['color'] ?? '');
$size_first = mysqli_real_escape_string($conn, $first_phanloai['size'] ?? '');
$ten_color_first = mysqli_real_escape_string($conn, $first_phanloai['ten_color'] ?? '');
$ten_size_first = mysqli_real_escape_string($conn, $first_phanloai['ten_size'] ?? '');
$ma_mau_first = mysqli_real_escape_string($conn, $first_phanloai['ma_mau'] ?? '');

// Lấy giá lớn nhất và nhỏ nhất từ phân loại
$max_phanloai = array_reduce($tach_phanloai, function ($carry, $item) {
    $gia_cu_item = (int)preg_replace('/[^0-9]/', '', $item['gia_cu'] ?? 0);
    $gia_cu_carry = (int)preg_replace('/[^0-9]/', '', $carry['gia_cu'] ?? 0);
    return ($gia_cu_item > $gia_cu_carry) ? $item : $carry;
}, ['gia_cu' => 0]);
$gia_cu_max = (int)preg_replace('/[^0-9]/', '', $max_phanloai['gia_cu']);

$min_phanloai = array_reduce($tach_phanloai, function ($carry, $item) {
    $gia_moi_item = (int)preg_replace('/[^0-9]/', '', $item['gia_moi'] ?? 0);
    $gia_moi_carry = (int)preg_replace('/[^0-9]/', '', $carry['gia_moi'] ?? PHP_INT_MAX);
    return ($gia_moi_item < $gia_moi_carry && $gia_moi_item > 0) ? $item : $carry;
}, ['gia_moi' => PHP_INT_MAX]);
$gia_moi_min = (int)preg_replace('/[^0-9]/', '', $min_phanloai['gia_moi'] ?? 0);

$date_post = time();

// Kiểm tra trùng link
$thongtin = mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
if (!$thongtin) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi kiểm tra link: ' . mysqli_error($conn)]);
    exit();
}
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['total'] > 0) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Link xem đã tồn tại trên website']);
    exit();
}

// Thêm sản phẩm vào sanpham_shop
$sp_id_temp = 0;
$ban = 0;
$view = 0;

$query = "INSERT INTO sanpham_shop (shop, tieu_de, minh_hoa, link, cat, kho_hang, gia_cu, gia_moi, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, ban, title, description, view, date_post, kich_thuoc) 
          VALUES ('$user_id', '$tieu_de', '$minh_hoa', '$link', '$category', '$kho', '$gia_cu_max', '$gia_moi_min', '$noibat', '$noidung', '$color_first', '$thuong_hieu', '$size_first', '$info', '$can_nang_first', '$anh', '$ban', '$title', '$description', '$view', '$date_post', '$kich_thuoc')";
if (!mysqli_query($conn, $query)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm vào sanpham_shop: ' . mysqli_error($conn)]);
    exit();
}

$sanpham_shop_id = mysqli_insert_id($conn);

// Thêm phân loại vào phanloai_sanpham_shop
foreach ($tach_phanloai as $value) {
    $gia_cu = (int)preg_replace('/[^0-9]/', '', $value['gia_cu'] ?? 0);
    $gia_moi = (int)preg_replace('/[^0-9]/', '', $value['gia_moi'] ?? 0);
    $ma_sp = mysqli_real_escape_string($conn, $value['ma_sp'] ?? '');
    $can_nang = (float)preg_replace('/[^0-9.]/', '', $value['can_nang'] ?? 0);
    $kho_sanpham_shop = (int)preg_replace('/[^0-9]/', '', $value['kho_sanpham_shop'] ?? 0);
    $color = mysqli_real_escape_string($conn, $value['color'] ?? '');
    $size = mysqli_real_escape_string($conn, $value['size'] ?? '');
    $ten_color = mysqli_real_escape_string($conn, $value['ten_color'] ?? '');
    $ten_size = mysqli_real_escape_string($conn, $value['ten_size'] ?? '');
    $ma_mau = mysqli_real_escape_string($conn, $value['ma_mau'] ?? '');

    // Tính trọng lượng tính ship
    $thetich_sp = $chieudai_shop * $chieurong_shop * $chieucao_shop;
    $trongluong_kichthuoc = $thetich_sp / 6000;
    $can_nang_tinhship = max($can_nang, $trongluong_kichthuoc);

    $query = "INSERT INTO phanloai_sanpham_shop 
              (user_id, sp_id, ma_sp, color, size, ten_size, ten_color, ma_mau, can_nang, gia_cu, gia_moi, kho_sanpham_shop, can_nang_tinhship, date_post) 
              VALUES 
              ('$user_id', '$sanpham_shop_id', '$ma_sp', '$color', '$size', '$ten_size', '$ten_color', '$ma_mau', '$can_nang', '$gia_cu', '$gia_moi', '$kho_sanpham_shop', '$can_nang_tinhship', '$date_post')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm phân loại sanpham_shop: ' . mysqli_error($conn)]);
        exit();
    }
}

// Thêm SEO cho website
$query = "INSERT INTO seo_shop (loai, link, shop) VALUES ('sanpham', '$link', '$user_id')";
if (!mysqli_query($conn, $query)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi thêm SEO sanpham_shop: ' . mysqli_error($conn)]);
    exit();
}

// Trả về kết quả
echo json_encode([
    'ok' => 1,
    'thongbao' => 'Thêm sản phẩm thành công',
]);
?>