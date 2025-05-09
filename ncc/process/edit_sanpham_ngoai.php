<?php
    // Get basic product information
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
    // Parse product variants
    $list_phanloai = $_REQUEST['phan_loai'] ?? '';
    $tach_phanloai = json_decode($list_phanloai, true);

    // Check if product exists
    $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    
	$chieudai_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieudai_shop'] ?? 0);
	$chieurong_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieurong_shop'] ?? 0);
	$chieucao_shop = (float)preg_replace('/[^0-9.]/', '', $_REQUEST['chieucao_shop'] ?? 0);

	$kich_thuoc = "$chieudai_shop,$chieurong_shop,$chieucao_shop";
	$date_post = time();
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Sản phẩm không tồn tại';
    } else {
        // Handle file upload if exists
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $duoi = $check->duoi_file($_FILES['file']['name']);
            if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
                $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
                move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
                if ($r_tt['minh_hoa'] != $r_sp['minh_hoa']) {
                    @unlink('..' . $r_tt['minh_hoa']);
                }
            }
        }

        // Handle new brand if provided
        if ($thuong_hieu_2 != '') {
            $check_query = "SELECT id FROM thuong_hieu WHERE shop = '$user_id' AND tieu_de = '$thuong_hieu_2' AND thu_tu = '0'";
            $result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($result) == 0) {
                mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,goc)VALUES('$user_id','$thuong_hieu_2','0','0')");
                $thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$user_id' ORDER BY id DESC LIMIT 1");
                $r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
                $thuong_hieu = $r_th['id'];
            }
        }

        // Get first variant info for main product
        $first_phanloai = $tach_phanloai[0];
        $gia_cu_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_cu'] ?? 0);
        $gia_moi_first = (int)preg_replace('/[^0-9]/', '', $first_phanloai['gia_socdo'] ?? 0);
        $kho_first = (int)($first_phanloai['kho_sanpham_shop'] ?? 0);
        $color_first = (int)($first_phanloai['color'] ?? 0);
        $size_first = (int)($first_phanloai['size'] ?? 0);
        $can_nang_first = (float)($first_phanloai['can_nang'] ?? 0);

        if ($link == $link_old) {
            // Update product without changing link
            mysqli_query($conn, "UPDATE sanpham_shop SET 
                tieu_de='$tieu_de',
                kho_hang='$kho_first',
                cat='$category',
                kho_hang='$kho',
                gia_cu='$gia_cu_first',
                gia_moi='$gia_moi_first',
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
                WHERE id='$id' AND shop='$user_id'");
            $ok = 1;
        } else {
            // Check if new link exists
            $thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo_shop WHERE link='$link' AND loai='sanpham' AND shop='$user_id'");
            $r_seo = mysqli_fetch_assoc($thongtin_seo);
            
            if ($r_seo['total'] == 0) {
                // Update product with new link
                mysqli_query($conn, "UPDATE sanpham_shop SET 
                    tieu_de='$tieu_de',
                    kho_hang='$kho_first',
                    cat='$category',
                    kho_hang='$kho',
                    link='$link',
                    gia_cu='$gia_cu_first',
                    gia_moi='$gia_moi_first',
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
                    WHERE id='$id' AND shop='$user_id'");
                
                mysqli_query($conn, "UPDATE seo_shop SET link='$link' WHERE link='$link_old' AND loai='sanpham' AND shop='$user_id'");
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = "Thất bại! Link xem đã tồn tại";
            }
        }

        // Handle product variants if update was successful
        if ($ok == 1) {
            // Get existing variants
            $existing_variants = [];
            $query_existing = mysqli_query($conn, "SELECT ma_sp FROM phanloai_sanpham_shop WHERE sp_id='$id'");
            while($row = mysqli_fetch_assoc($query_existing)) {
                $existing_variants[] = $row['ma_sp'];
            }

            // Track processed variants
            $processed_variants = [];

            // Update or insert variants
            foreach ($tach_phanloai as $value) {
                $ma_sp = mysqli_real_escape_string($conn, $value['ma_sp'] ?? '');
                $processed_variants[] = $ma_sp;
                
                $variant_data = [
                    'color' => (int)($value['color'] ?? 0),
                    'ten_color' => mysqli_real_escape_string($conn, $value['ten_color'] ?? ''),
                    'ma_mau' => mysqli_real_escape_string($conn, $value['ma_mau'] ?? ''),
                    'color_socdo' => (int)($value['color'] ?? 0),
                    'ten_color_socdo' => mysqli_real_escape_string($conn, $value['ten_color'] ?? ''),
                    'ma_mau_socdo' => mysqli_real_escape_string($conn, $value['ma_mau'] ?? ''),
                    'size' => (int)($value['size'] ?? 0),
                    'ten_size' => mysqli_real_escape_string($conn, $value['ten_size'] ?? ''),
                    'size_socdo' => (int)($value['size'] ?? 0),
                    'ten_size_socdo' => mysqli_real_escape_string($conn, $value['ten_size'] ?? ''),
                    'can_nang' => (float)($value['can_nang'] ?? 0),
                    'gia_cu' => (int)preg_replace('/[^0-9]/', '', $value['gia_cu'] ?? 0),
                    'gia_moi' => (int)preg_replace('/[^0-9]/', '', $value['gia_moi'] ?? 0),
                    'gia_drop' => (int)preg_replace('/[^0-9]/', '', $value['gia_drop'] ?? 0),
                    'gia_ctv' => (int)preg_replace('/[^0-9]/', '', $value['gia_ctv'] ?? 0),
                    'gia_socdo' => (int)preg_replace('/[^0-9]/', '', $value['gia_socdo'] ?? 0),
                    'drop_min' => (int)preg_replace('/[^0-9]/', '', $value['drop_min'] ?? 0),
                    'kho_sanpham_shop' => (int)str_replace(',', '', $value['kho_sanpham_shop'] ?? 0),
                    'can_nang_tinhship' => (float)($value['trongluongtinhship'] ?? 0)
                ];

                if(in_array($ma_sp, $existing_variants)) {
                    // Update existing variant
                    $set_clauses = [];
                    foreach($variant_data as $key => $val) {
                        if(is_string($val)) {
                            $set_clauses[] = "$key='$val'";
                        } else {
                            $set_clauses[] = "$key=$val";
                        }
                    }
                    $set_clause = implode(',', $set_clauses);
                    
                    mysqli_query($conn, "UPDATE phanloai_sanpham_shop SET $set_clause 
                        WHERE sp_id='$id' AND ma_sp='$ma_sp'");
                } else {
                    // Insert new variant
                    $fields = array_merge(['user_id', 'sp_id', 'ma_sp', 'date_post'], array_keys($variant_data));
                    $values = array_merge([$user_id, $id, "'$ma_sp'", time()], 
                        array_map(function($val) { return is_string($val) ? "'$val'" : $val; }, array_values($variant_data)));
                    
                    mysqli_query($conn, "INSERT INTO phanloai_sanpham_shop 
                        (" . implode(',', $fields) . ") VALUES (" . implode(',', $values) . ")");
                }
            }

            // Delete unprocessed variants
            $variants_to_delete = array_diff($existing_variants, $processed_variants);
            if(!empty($variants_to_delete)) {
                $variants_to_delete_str = "'" . implode("','", $variants_to_delete) . "'";
                mysqli_query($conn, "DELETE FROM phanloai_sanpham_shop WHERE sp_id='$id' AND ma_sp IN ($variants_to_delete_str)");
            }

            $thongbao = 'Sửa sản phẩm thành công';
        }
    }

    echo json_encode([
        'ok' => $ok,
        'thongbao' => $thongbao
    ]);
?>