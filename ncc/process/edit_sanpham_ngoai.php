<?php


$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
$anh = addslashes(strip_tags($_REQUEST['anh']));
$minh_hoa = addslashes(strip_tags($_REQUEST['minh_hoa']));
$link = addslashes(strip_tags($_REQUEST['link']));
$link_old = addslashes(strip_tags($_REQUEST['link_old']));
$category = addslashes(strip_tags($_REQUEST['category']));
$thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
$thuong_hieu_2 = addslashes(strip_tags($_REQUEST['thuong_hieu_2']));
$info = addslashes(strip_tags($_REQUEST['info']));
$info = substr($info, 0, -1);
$noibat = addslashes($_REQUEST['noibat']);
$noidung = addslashes($_REQUEST['noidung']);
$title = addslashes(strip_tags($_REQUEST['title']));
$description = addslashes(strip_tags($_REQUEST['description']));
$id = intval($_REQUEST['id']);
$kho = (int)preg_replace('/[^0-9]/', '', $_REQUEST['kho'] ?? 0);

$list_phanloai = $_REQUEST['phan_loai'] ?? '';
$tach_phanloai = json_decode($list_phanloai, true);

$chieudai_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieudai_shop'] ?? 0);
$chieurong_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieurong_shop'] ?? 0);
$chieucao_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieucao_shop'] ?? 0);
$kich_thuoc = "$chieudai_shop,$chieurong_shop,$chieucao_shop";

$date_post = time();
$ok = 0;

// Lấy thông tin sản phẩm
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);

if (!$r_tt) {
    $thongbao = 'Thất bại! Sản phẩm không tồn tại';
    echo json_encode(['ok' => 0, 'thongbao' => $thongbao]);
    exit;
}

// Nếu có ảnh mới
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
        if ($r_tt['minh_hoa']) @unlink('..' . $r_tt['minh_hoa']);
    }
}

// Nếu có thương hiệu mới
if ($thuong_hieu_2 != '') {
    $result = mysqli_query($conn, "SELECT id FROM thuong_hieu WHERE shop = '$user_id' AND tieu_de = '$thuong_hieu_2' AND thu_tu = '0'");
    if (mysqli_num_rows($result) == 0) {
        mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
        $r_th = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1"));
        $thuong_hieu = $r_th['id'];
    }
}

// Tính giá cao nhất và thấp nhất
$gia_cu_max = 0;
$gia_moi_min = PHP_INT_MAX;

foreach ($tach_phanloai as $pl) {
    $gia_cu = (int)preg_replace('/[^0-9]/', '', $pl['gia_cu'] ?? 0);
    $gia_moi = (int)preg_replace('/[^0-9]/', '', $pl['gia_moi'] ?? 0);

    if ($gia_cu > $gia_cu_max) $gia_cu_max = $gia_cu;
    if ($gia_moi > 0 && $gia_moi < $gia_moi_min) $gia_moi_min = $gia_moi;
}
if ($gia_moi_min === PHP_INT_MAX) $gia_moi_min = 0;

// Lấy thông tin phân loại đầu tiên
$first = $tach_phanloai[0];
$kho_first = (int)($first['kho_sanpham_shop'] ?? 0);
$color_first = (int)($first['color'] ?? 0);
$size_first = (int)($first['size'] ?? 0);
$can_nang_first = (float)($first['can_nang'] ?? 0);

// Cập nhật sản phẩm
if ($link == $link_old) {
    $sql = "UPDATE sanpham_shop SET 
        tieu_de='$tieu_de',
        cat='$category',
        kho_hang='$kho',
        gia_cu='$gia_cu_max',
        gia_moi='$gia_moi_min',
        noi_bat='$noibat',
        noi_dung='$noidung',
        mau='$color_first',
        thuong_hieu='$thuong_hieu',
        thongtin='$info',
        can_nang='$can_nang_first',
        size='$size_first',
        minh_hoa='$minh_hoa',
        anh='$anh',
        title='$title',
        description='$description',
        date_post='$date_post',
        kich_thuoc='$kich_thuoc'
        WHERE id='$id' AND shop='$user_id'";
    $ok = mysqli_query($conn, $sql);
} else {
    $check_link = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'"));
    if ($check_link['total'] == 0) {
        $sql = "UPDATE sanpham_shop SET 
            tieu_de='$tieu_de',
            cat='$category',
            kho_hang='$kho',
            link='$link',
            gia_cu='$gia_cu_max',
            gia_moi='$gia_moi_min',
            noi_bat='$noibat',
            noi_dung='$noidung',
            mau='$color_first',
            thuong_hieu='$thuong_hieu',
            thongtin='$info',
            can_nang='$can_nang_first',
            size='$size_first',
            minh_hoa='$minh_hoa',
            anh='$anh',
            title='$title',
            description='$description',
            date_post='$date_post',
            kich_thuoc='$kich_thuoc'
            WHERE id='$id' AND shop='$user_id'";
        $ok = mysqli_query($conn, $sql);
        if ($ok) {
            mysqli_query($conn, "UPDATE seo_shop SET link='$link' WHERE link='$link_old' AND loai='sanpham' AND shop='$user_id'");
        }
    } else {
        $ok = 0;
        $thongbao = "Thất bại! Link xem đã tồn tại";
    }
}

echo json_encode([
    'ok' => $ok ? 1 : 0,
    'thongbao' => $ok ? 'Cập nhật thành công' : ($thongbao ?? 'Đã có lỗi xảy ra')
]);
?>
