<?php
if (!isset($user_info['user_id']) || empty($user_info['user_id'])) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi: Không tìm thấy user_id']);
    exit();
}

$user_id = (int)$user_info['user_id'];

// Hàm làm sạch dữ liệu, giữ lại các ký tự tiếng Việt và thẻ HTML an toàn (nếu cần)
function stripHtmlForPhp($text, $allowTags = '') {
    $text = strip_tags($text, $allowTags);
    $text = preg_replace('/[\r\n\t]+/', ' ', $text);
    $text = preg_replace('/\s+/', ' ', $text);
    return trim($text);
}

// Hàm làm sạch HTML để tránh XSS
function sanitizeHtml($text) {
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="UTF-8">' . $text);
    $images = $doc->getElementsByTagName('img');
    foreach ($images as $img) {
        $src = $img->getAttribute('src');
        if (!preg_match('/^(https?:\/\/|\/)/', $src)) {
            $img->setAttribute('src', '');
        }
    }
    $body = '';
    foreach ($doc->getElementsByTagName('body')->item(0)->childNodes as $child) {
        $body .= $doc->saveHTML($child);
    }
    return $body;
}

// Nhận dữ liệu từ request và làm sạch
$tieu_de        = stripHtmlForPhp($_REQUEST['tieu_de']);
$link           = stripHtmlForPhp($_REQUEST['link']);
$chieudai_shop  = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieudai_shop'] ?? 0);
$chieurong_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieurong_shop'] ?? 0);
$chieucao_shop  = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieucao_shop'] ?? 0);
$kich_thuoc     = "$chieudai_shop,$chieurong_shop,$chieucao_shop";
$anh            = stripHtmlForPhp($_REQUEST['anh']);
$category       = stripHtmlForPhp($_REQUEST['category']);
$thuong_hieu    = stripHtmlForPhp($_REQUEST['thuong_hieu']);
$thuong_hieu_2  = stripHtmlForPhp($_REQUEST['thuong_hieu_2']);
$info           = stripHtmlForPhp($_REQUEST['info']);
$info           = substr($info, 0, -1);

file_put_contents('debug.log', "noibat trước khi làm sạch: " . $_REQUEST['noibat'] . "\n", FILE_APPEND);
$noibat         = stripHtmlForPhp($_REQUEST['noibat'], '');
file_put_contents('debug.log', "noibat sau khi làm sạch: $noibat\n", FILE_APPEND);

$noidung        = sanitizeHtml($_REQUEST['noidung']);
$noidung        = stripHtmlForPhp($noidung, '<p><b><i><img><br><ul><li>');
$title          = stripHtmlForPhp($_REQUEST['title']);
$description    = stripHtmlForPhp($_REQUEST['description']);
$list_phanloai  = $_REQUEST['phan_loai'];
$tach_phanloai  = json_decode('[' . $list_phanloai . ']', true);

// Kiểm tra độ dài dữ liệu trước khi chèn
if (mb_strlen($title, 'UTF-8') > 150) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Tiêu đề SEO không được vượt quá 150 ký tự']);
    exit();
}
if (mb_strlen($description, 'UTF-8') > 150) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Mô tả SEO không được vượt quá 150 ký tự']);
    exit();
}
if (mb_strlen($noibat, 'UTF-8') > 200) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Nội dung nổi bật không được vượt quá 200 ký tự']);
    exit();
}
if (mb_strlen(strip_tags($noidung), 'UTF-8') > 3000) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Nội dung chi tiết không được vượt quá 3000 ký tự']);
    exit();
}

// Kiểm tra link trùng
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link=? AND loai='sanpham' AND shop=?");
mysqli_stmt_bind_param($stmt, "si", $link, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$r_tt = mysqli_fetch_assoc($result);

if ($r_tt['total'] == 0) {
    if ($tieu_de == '') {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa nhập tiêu đề';
    } elseif (empty($tach_phanloai)) {
        $ok = 0;
        $thongbao = 'Thất bại! Chưa có phân loại sản phẩm';
    } else {
        // Kiểm tra file ảnh minh họa
        if (!isset($_FILES['file']) || empty($_FILES['file']['name'])) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Chưa chọn hình minh họa']);
            exit;
        }
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Lỗi khi upload file: ' . $_FILES['file']['error']]);
            exit;
        }
        $file_name = $_FILES['file']['name'];
        $duoi = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        if (!in_array($duoi, $allowed_extensions)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Vui lòng chọn ảnh có định dạng: jpg, jpeg, png, gif, webp']);
            exit;
        }
        $minh_hoa = '/uploads/minh-hoa/' . preg_replace('/\s+/', '-', $tieu_de) . '-' . time() . '.' . $duoi;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa)) {
            echo json_encode(['ok' => 0, 'thongbao' => 'Thất bại! Lỗi khi upload hình minh họa']);
            exit;
        }

        // Xử lý phân loại sản phẩm (lấy phân loại đầu tiên cho giá và kho hàng)
        $first_phanloai = $tach_phanloai[0];
        $gia_cu    = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_cu']);
        $gia_moi   = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_moi']);
        $kho_hang  = (int)preg_replace('/[^0-9]/', '', $first_phanloai['kho_sanpham_shop']);
        $can_nang  = $first_phanloai['can_nang']; // lưu dưới dạng chuỗi
        $color     = addslashes($first_phanloai['color']);
        $size      = addslashes($first_phanloai['size']);

        // Nếu có thương hiệu thứ 2 thì chèn vào bảng thuong_hieu và lấy id mới
        if ($thuong_hieu_2 != '') {
            $stmt_th = mysqli_prepare($conn, "INSERT INTO thuong_hieu(shop, tieu_de, thu_tu, id_thuonghieu_socdo) VALUES(?, ?, '0', '0')");
            mysqli_stmt_bind_param($stmt_th, "is", $user_id, $thuong_hieu_2);
            mysqli_stmt_execute($stmt_th);

            $stmt_th = mysqli_prepare($conn, "SELECT * FROM thuong_hieu WHERE shop=? ORDER BY id DESC LIMIT 1");
            mysqli_stmt_bind_param($stmt_th, "i", $user_id);
            mysqli_stmt_execute($stmt_th);
            $result_th = mysqli_stmt_get_result($stmt_th);
            $r_th = mysqli_fetch_assoc($result_th);
            $thuong_hieu = $r_th['id'];
        }
        // Nếu cột thuong_hieu là dạng varchar, ta vẫn bind dưới dạng chuỗi:
        $thuong_hieu = stripHtmlForPhp($thuong_hieu);

        // Giá trị mặc định cho các cột
        $sp_id_temp = 0;
        $link_aff   = '';
        $cat_shop   = '';  // mặc định rỗng
        $status     = 0;
        $ban        = 0;
        $view       = 0;
        $date_post  = time();
        file_put_contents('debug.log', "noibat trước khi lưu: $noibat\n", FILE_APPEND);

        // Chuẩn bị câu truy vấn INSERT cho bảng sanpham_shop
        $query = "INSERT INTO sanpham_shop(
            shop, sp_id, tieu_de, minh_hoa, link, link_aff, cat, cat_shop, status, kho_hang, 
            gia_cu, gia_moi, noi_bat, noi_dung, mau, thuong_hieu, size, thongtin, can_nang, anh, 
            ban, title, description, view, date_post, kich_thuoc
        ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            echo json_encode(['ok' => 0, 'thongbao' => "Lỗi chuẩn bị câu truy vấn: " . mysqli_error($conn)]);
            exit();
        }

        // Chuỗi bind type phải có 26 ký tự:
        $bindTypes = "iissssssiiiissssssssississ";
        mysqli_stmt_bind_param($stmt, $bindTypes,
            $user_id,         // shop: i
            $sp_id_temp,      // sp_id: i
            $tieu_de,         // tieu_de: s
            $minh_hoa,        // minh_hoa: s
            $link,            // link: s
            $link_aff,        // link_aff: s
            $category,        // cat: s
            $cat_shop,        // cat_shop: s
            $status,          // status: i
            $kho_hang,        // kho_hang: i
            $gia_cu,          // gia_cu: i
            $gia_moi,         // gia_moi: i
            $noibat,          // noi_bat: s
            $noidung,         // noi_dung: s
            $color,           // mau: s
            $thuong_hieu,     // thuong_hieu: s
            $size,            // size: s
            $info,            // thongtin: s
            $can_nang,        // can_nang: s
            $anh,             // anh: s
            $ban,             // ban: i
            $title,           // title: s
            $description,     // description: s
            $view,            // view: i
            $date_post,       // date_post: s (varchar(11))
            $kich_thuoc       // kich_thuoc: s
        );
        
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            $error = mysqli_error($conn);
            echo json_encode(['ok' => 0, 'thongbao' => "Thất bại! Lỗi khi thêm sản phẩm: $error"]);
            exit;
        }
        
        // Lấy id insert được và cập nhật cột sp_id (theo logic của bạn)
        $sp_id = mysqli_insert_id($conn);
        $stmt_update = mysqli_prepare($conn, "UPDATE sanpham_shop SET sp_id = ? WHERE id = ? AND shop = ?");
        mysqli_stmt_bind_param($stmt_update, "iii", $sp_id, $sp_id, $user_id);
        $update_result = mysqli_stmt_execute($stmt_update);
        if (!$update_result) {
            $error = mysqli_error($conn);
            echo json_encode(['ok' => 0, 'thongbao' => "Thất bại! Lỗi khi cập nhật sp_id: $error"]);
            exit;
        }

        // Xử lý phân loại sản phẩm cho từng phần tử trong mảng $tach_phanloai
        $thetich_sp = $chieudai_shop * $chieurong_shop * $chieucao_shop;
        $trongluong_kichthuoc = $thetich_sp / 6000;
        foreach ($tach_phanloai as $phanloai) {
            $ma_sp = addslashes($phanloai['ma_sp']);
            $color_pl = addslashes($phanloai['color']);
            $size_pl  = addslashes($phanloai['size']);
            $ten_color = addslashes($phanloai['ten_color']);
            $ma_mau  = addslashes($phanloai['ma_mau']);
            $ten_size = addslashes($phanloai['ten_size']);
            $can_nang_pl = $phanloai['can_nang'];
            $gia_cu_pl  = (int)preg_replace('/[^0-9]/', '', $phanloai['gia_cu']);
            $gia_moi_pl = (int)preg_replace('/[^0-9]/', '', $phanloai['gia_moi']);
            $kho_sanpham_shop = (int)preg_replace('/[^0-9]/', '', $phanloai['kho_sanpham_shop']);
            $can_nang_tinhship = max($can_nang_pl, $trongluong_kichthuoc);
            $gia_drop = 0;
            $gia_ctv = 0;
            $gia_socdo = 0;
            $drop_min = 0;

            $stmt_pl = mysqli_prepare($conn, "INSERT INTO phanloai_sanpham_shop(user_id, sp_id, ma_sp, color, size, ten_color, ma_mau, ten_size, can_nang, gia_cu, gia_moi, gia_drop, gia_ctv, gia_socdo, drop_min, kho_sanpham_shop, can_nang_tinhship, date_post) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)");
            $date_post_pl = time();
            mysqli_stmt_bind_param($stmt_pl, "iissssssiiiiiiiidi",
                $user_id,
                $sp_id,
                $ma_sp,
                $color_pl,
                $size_pl,
                $ten_color,
                $ma_mau,
                $ten_size,
                $can_nang_pl,
                $gia_cu_pl,
                $gia_moi_pl,
                $gia_drop,
                $gia_ctv,
                $gia_socdo,
                $drop_min,
                $kho_sanpham_shop,
                $can_nang_tinhship,
                $date_post_pl
            );
            $result_pl = mysqli_stmt_execute($stmt_pl);
            if (!$result_pl) {
                $error = mysqli_error($conn);
                echo json_encode(['ok' => 0, 'thongbao' => "Thất bại! Lỗi khi thêm phân loại: $error"]);
                exit;
            }
        }

        // Thêm dữ liệu SEO cho sản phẩm
        $stmt_seo = mysqli_prepare($conn, "INSERT INTO seo_shop(loai, link, shop) VALUES('sanpham', ?, ?)");
        mysqli_stmt_bind_param($stmt_seo, "si", $link, $user_id);
        $seo_result = mysqli_stmt_execute($stmt_seo);
        if (!$seo_result) {
            $error = mysqli_error($conn);
            echo json_encode(['ok' => 0, 'thongbao' => "Thất bại! Lỗi khi thêm SEO: $error"]);
            exit;
        }

        $ok = 1;
        $thongbao = 'Thêm sản phẩm thành công';
    }
} else {
    $ok = 0;
    $thongbao = 'Link xem đã tồn tại';
}

ob_clean();
echo json_encode(['ok' => $ok, 'thongbao' => $thongbao]);
exit();
?>
