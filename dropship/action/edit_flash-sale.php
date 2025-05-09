<?php
$thaythe['title'] = 'Sửa flash sale';
$thaythe['title_action'] = 'Sửa flash sale';
$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM deal WHERE id='$id' AND shop='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);

if ($r_tt['total'] == 0) {
    $thongbao = "Dữ liệu không tồn tại...";
    $replace = array(
        'title' => 'Dữ liệu không tồn tại...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/dropship/list-deal',
    );
    echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
    exit();
}

$r_tt['date_start'] = date('H:i d/m/Y', $r_tt['date_start']);
$r_tt['date_end'] = date('H:i d/m/Y', $r_tt['date_end']);
$list_id = $r_tt['main_product'];

// Kiểm tra xem $list_id có hợp lệ không (phải là danh sách ID, không phải JSON)
if (empty($list_id) || !preg_match('/^[0-9,]+$/', $list_id)) {
    $thongbao = "Dữ liệu không hợp lệ...";
    $replace = array(
        'title' => 'Dữ liệu không hợp lệ...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/dropship/list-deal',
    );
    echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
    exit();
}

// Lấy thông tin sản phẩm từ danh sách ID
$thongtin_sanpham = mysqli_query($conn, "SELECT ss.* FROM sanpham_shop ss WHERE ss.id IN ($list_id) AND ss.shop='$user_id' ORDER BY ss.id DESC");
$tach_sp_sub = json_decode($r_tt['sub_product'], true);
$list_sub = '';

while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
    $r_sp['gia_cu'] = number_format($r_sp['gia_cu']) . 'đ';
    $r_sp['gia_moi'] = number_format($r_sp['gia_moi']) . 'đ';
    $sp_id = $r_sp['id'];

    // Lấy thông tin biến thể từ sub_product và JOIN với phanloai_sanpham_shop
    $variants = [];
    if (isset($tach_sp_sub[$sp_id])) {
        foreach ($tach_sp_sub[$sp_id] as $variant) {
            $variant_id = $variant['variant_id'];
            // Lấy thông tin từ phanloai_sanpham_shop
            $variant_query = mysqli_query($conn, "SELECT pss.*, ss.tieu_de AS ten_sp, ss.minh_hoa 
                                                 FROM phanloai_sanpham_shop pss 
                                                 JOIN sanpham_shop ss ON pss.sp_id = ss.id 
                                                 WHERE pss.id='$variant_id' AND pss.sp_id='$sp_id' AND pss.user_id='$user_id'");
            $variant_data = mysqli_fetch_assoc($variant_query);
            $stock = $variant_data['kho_sanpham_shop'] ?? 0;

            $variants[] = [
                'variant_id' => $variant['variant_id'],
                'ten_color' => $variant['color'],
                'ten_size' => $variant_data['ten_size'] ?? '',
                'gia_cu' => $variant['gia_cu'],
                'gia_moi' => $variant['gia'], // Giá flash sale từ sub_product
                'stock' => $stock,
                'quantity' => $variant['so_luong'] ?? '', // Lấy so_luong từ sub_product
                'gia_deal' => $variant['gia'],
                'ten_sp' => $variant_data['ten_sp'] ?? $r_sp['tieu_de'],
                'minh_hoa' => $variant_data['minh_hoa'] ?? $r_sp['minh_hoa']
            ];
        }
        $r_sp['ten_sp'] = $variant_data['ten_sp'] ?? $r_sp['tieu_de'];
    }

    $r_sp['variants'] = json_encode($variants);
    $list_sub .= $skin->skin_replace('skin_dropship/box_action/li_product_flash_sale', $r_sp);
}

$r_tt['list_main'] = $list_id;
$r_tt['list_sub'] = $list_sub;
$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_flash_sale', $r_tt);
?>