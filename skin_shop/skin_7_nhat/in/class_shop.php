<?php

class class_shop extends class_manage
{
    function list_menu($conn, $s, $shop)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM menu_shop WHERE shop='$shop' ORDER BY menu_thutu ASC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $vitri = $r_tt['menu_vitri'];
            $list[$vitri] .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_menu_' . $vitri, $r_tt);
            if ($vitri == 'top') {
                $list['menu_mobile'] .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_menu_mobile', $r_tt);
            }
        }
        return json_encode($list);
    }
    //////////////////////////////
    function list_category($conn, $shop)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC LIMIT 4");
        // $list = '';
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC LIMIT 4");

            while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
                // thêm thông tin lấy ảnh và số lượng
                // $cat_img = $r_tt['cat_img'] ? '<img src="'.$r_tt['cat_img'].'" alt="'.$r_tt['cat_tieude'].'">' : '';
                // $cat_quantity = isset($r_tt['cat_quantity']) ? $r_tt['cat_quantity'] : 'Không xác định';
                // $list .= $skin->box('tpl/box_li/box_category', array(
                //     'cat_img' => $cat_img,
                //     'cat_tieude' => $r_tt['cat_tieude'],
                //     'cat_quantity' => $cat_quantity,
                // ));
                $list_sub .= '<li><a class="sub-a" href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a></li>';
                $list_sub_left .= '<li class="nav-item">
                                    <a class="nav-link" href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a>
                                </li>';
            }
            if (strlen($list_sub) > 10) {
                $duoi = $check->duoi_file($r_tt['cat_icon']);
                if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {
                    $cat_icon = '<img src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '">';
                } else {
                    $cat_icon = $r_tt['cat_icon'];
                }
                $list .= '<li class="dropdown menu-item-count clearfix">
                            <h3><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</a></h3>
                            <div class="subcate gd-menu">
                                <div class="sub-flex clearfix">
                                    <ul>' . $list_sub . '</ul>
                                </div>
                            </div>
                        </li>';
                $list_left .= '<li class="nav-item ">
                            <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="nav-link" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a>
                            <i class="fa fa-angle-down"></i>
                            <ul class="dropdown-menu">' . $list_sub_left . '</ul>
                        </li>';
                unset($list_sub);
                unset($list_sub_left);
            } else {
                $duoi = $check->duoi_file($r_tt['cat_icon']);
                if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {
                    $cat_icon = '<img src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '">';
                } else {
                    $cat_icon = $r_tt['cat_icon'];
                }
                $list .= '<li class="menu-item-count clearfix">
                            <h3><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</a></h3>
                        </li>';
                $list_left .= '<li class="nav-item "><a class="nav-link" href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a></li>';
            }
            $list_main .= '<li class=""><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="nav-link" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a></li>';
        }
        return json_encode(array('list' => $list, 'list_left' => $list_left, 'list_main' => $list_main));
    }
    // function list_category($conn, $shop)  
    // {  
    //     $skin = $this->load('class_skin');  
    //     $check = $this->load('class_check');  
    //     $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC");  
    //     $list = '';  
    //     $list_left = '';  
    //     $list_main = '';  
    //     while ($r_tt = mysqli_fetch_assoc($thongtin)) {  
    //         $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");  
    //         $list_sub = '';  
    //         $list_sub_left = '';  
    //         $list_product = '';  
    //         while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {  
    //             $list_sub .= '<li><a class="sub-a" href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a></li>';  
    //             $list_sub_left .= '<li class="nav-item">  
    //                                 <a class="nav-link" href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a>  
    //                             </li>';  

    //             // Query danh sách sản phẩm con  
    //             $thongtin_product = mysqli_query($conn, "SELECT * FROM san_pham_shop WHERE cat_id='{$r_s['cat_id']}' AND shop='$shop' ORDER BY id DESC LIMIT 4");  
    //             while ($r_p = mysqli_fetch_assoc($thongtin_product)) {  
    //                 $list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham', $r_p);  
    //             }  
    //         }  
    //         if (strlen($list_sub) > 10) {  
    //             $duoi = $check->duoi_file($r_tt['cat_icon']);  
    //             if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {  
    //                 $cat_icon = '<img src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '">';  
    //             } else {  
    //                 $cat_icon = $r_tt['cat_icon'];  
    //             }  
    //             $list .= '<li class="dropdown menu-item-count clearfix">  
    //                         <h3><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</a></h3>  
    //                         <div class="subcate gd-menu">  
    //                             <div class="sub-flex clearfix">  
    //                                 <ul>' . $list_sub . '</ul>  
    //                             </div>  
    //                             <div class="product-list">' . $list_product . '</div>  
    //                         </div>  
    //                     </li>';  
    //             $list_left .= '<li class="nav-item ">  
    //                         <a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="nav-link" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a>  
    //                         <i class="fa fa-angle-down"></i>  
    //                         <ul class="dropdown-menu">' . $list_sub_left . '</ul>  
    //                     </li>';  
    //             unset($list_sub);  
    //             unset($list_sub_left);  
    //             unset($list_product);  
    //         } else {  
    //             $duoi = $check->duoi_file($r_tt['cat_icon']);  
    //             if (in_array($duoi, array('jpg', 'png', 'gif', 'jpeg', 'webp')) == true) {  
    //                 $cat_icon = '<img src="' . $r_tt['cat_icon'] . '" alt="' . $r_tt['cat_tieude'] . '">';  
    //             } else {  
    //                 $cat_icon = $r_tt['cat_icon'];  
    //             }  
    //             $list .= '<li class="menu-item-count clearfix">  
    //                         <h3><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $cat_icon . ' ' . $r_tt['cat_tieude'] . '</a></h3>  
    //                         <div class="product-list">' . $list_product . '</div>  
    //                     </li>';  
    //             $list_left .= '<li class="nav-item "><a class="nav-link" href="/san-pham/' . $r_tt['cat_blank'] . '.html" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a></li>';  
    //         }  
    //         $list_main .= '<li class=""><a href="/san-pham/' . $r_tt['cat_blank'] . '.html" class="nav-link" title="' . $r_tt['cat_tieude'] . '">' . $r_tt['cat_tieude'] . '</a></li>';  
    //     }  
    //     return json_encode(array('list' => $list, 'list_left' => $list_left, 'list_main' => $list_main));  
    // }

    function list_box_index($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC LIMIT 5 ");
        // SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC LIMIT 4
        // $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_index='1' ORDER BY cat_thutu ASC LIMIT 5");

        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $cat_id = $r_tt['cat_id'];
            // Lấy số lượng sản phẩm trong danh mục
            $query_count = "SELECT COUNT(*) as total 
            FROM sanpham_shop 
            LEFT JOIN sanpham ON sanpham_shop.sp_id = sanpham.id 
            WHERE sanpham_shop.shop = '$shop' 
            AND FIND_IN_SET($cat_id, sanpham_shop.cat) > 0";
            $result_count = mysqli_query($conn, $query_count);
            $total_products = 0;

            if ($result_count && $row = mysqli_fetch_assoc($result_count)) {
                $total_products = $row['total'];
            }

            $thongtin_sanpham = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' AND FIND_IN_SET($cat_id,sanpham_shop.cat)>0 ORDER BY sanpham_shop.id DESC LIMIT 8");
            while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
                $id_sp = $r_sp['id'];
                $r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
                if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
                    $giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
                    $r_sp['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
                } else {
                    $r_sp['label_sale'] = '';
                }
                if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                        $r_sp['loai'] = 'flash_sale';
                    } else {
                        $r_sp['loai'] = 'muakem';
                    }
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
                } else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
                    $r_sp['loai'] = 'tang';
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà tặng</div>';
                } else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    }
                    $r_sp['loai'] = 'flash_sale';
                    $r_sp['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
                } else {
                    $r_sp['loai'] = '';
                    $r_sp['icon_label'] = '<div class="icon_label"></div>';
                }

                $r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
                $r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
                $r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
                if ($r_sp['link_aff'] != '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_aff', $r_sp);
                } else if (strpos($r_sp['mau'], ',') !== false) {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_tuychon', $r_sp);
                } else if ($r_sp['kho'] < 1 and $r_sp['kho_hang'] < 1 and $r_sp['link_aff'] == '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_hethang', $r_sp);
                } else {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index', $r_sp);
                }
            }
            $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC LIMIT 6");
            while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
                // Truy vấn số lượng sản phẩm thuộc danh mục này
                $query_count = "SELECT COUNT(*) as total 
                FROM sanpham_shop 
                LEFT JOIN sanpham ON sanpham_shop.sp_id = sanpham.id 
                WHERE sanpham_shop.shop = '$shop' 
                AND FIND_IN_SET($cat_id, sanpham_shop.cat) > 0";
                $result_count = mysqli_query($conn, $query_count);
                $total_products = 0;

                if ($result_count && $row = mysqli_fetch_assoc($result_count)) {
                    $total_products = $row['total'];
                }
                $list_sub .= '<li><a href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a></li>';
            }
            $r_tt['list_sub'] = $list_sub;
            $r_tt['list_sanpham'] = $list_sp;
            unset($list_sp);
            unset($list_sub);
            if ($i % 2 == 0) {
                $r_tt['img_left'] = '';
                $r_tt['img_right'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
            } else {
                $r_tt['img_left'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
                $r_tt['img_right'] = '';
            }
            $r_tt['total_products'] = $total_products;
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_index', $r_tt);
        }
        return $list;
    }
    function list_box_index_1($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        // $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop  LIMIT 5");
        $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_index='1' ORDER BY cat_thutu ASC LIMIT 5");
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $cat_id = $r_tt['cat_id'];
            $thongtin_sanpham = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' AND FIND_IN_SET($cat_id,sanpham_shop.cat)>0 ORDER BY sanpham_shop.id DESC LIMIT 10");
            while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
                $id_sp = $r_sp['id'];
                $r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
                if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
                    $giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
                    $r_sp['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
                } else {
                    $r_sp['label_sale'] = '';
                }
                if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                        $r_sp['loai'] = 'flash_sale';
                    } else {
                        $r_sp['loai'] = 'muakem';
                    }
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
                } else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
                    $r_sp['loai'] = 'tang';
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà tặng</div>';
                } else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    }
                    $r_sp['loai'] = 'flash_sale';
                    $r_sp['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
                } else {
                    $r_sp['loai'] = '';
                    $r_sp['icon_label'] = '<div class="icon_label"></div>';
                }
                $r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
                $r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
                $r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
                // Lấy thông tin màu sắc
                if ($r_sp['mau'] != '') { // Thay vì $r_tt['mau'], dùng $r_sp['mau']
                    $mau = $r_sp['mau']; // Lấy thông tin màu từ sản phẩm
                    $thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
                    $list_mau = '';
                    $m = 0;
                    while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
                        $checked = ($m === 0) ? 'checked' : '';
                        $list_mau .= '
                            <div class="n-sd swatch-element">
                                <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" ' . $checked . ' />
                                <label for="mau-' . $r_m['id'] . '">
                                    ' . $r_m['tieu_de'] . '
                                    <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                    <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                </label>
                            </div>';
                        $m++;
                    }
                    $r_sp['option_mau'] = '
                        <div class="swatch-div">
                            <div id="variant-swatch-0" class="swatch clearfix swatch-color">
                                <div class="select-swap">' . $list_mau . '</div>
                            </div>
                        </div>';
                } else {
                    $r_sp['option_mau'] = ''; // Nếu không có màu sắc
                }

                if ($r_sp['link_aff'] != '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_aff', $r_sp);
                } else if (strpos($r_sp['mau'], ',') !== false) {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_tuychon', $r_sp);
                } else if ($r_sp['kho'] < 1 and $r_sp['kho_hang'] < 1 and $r_sp['link_aff'] == '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_hethang', $r_sp);
                } else {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index', $r_sp);
                }
            }
            $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC LIMIT 6");
            while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
                $list_sub .= '<li><a href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a></li>';
            }
            $r_tt['list_sub'] = $list_sub;
            $r_tt['list_sanpham'] = $list_sp;
            unset($list_sp);
            unset($list_sub);
            if ($i % 2 == 0) {
                $r_tt['img_left'] = '';
                $r_tt['img_right'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
            } else {
                $r_tt['img_left'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
                $r_tt['img_right'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_index_1', $r_tt);
        }
        return $list;
    }
    function list_box_index_2($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        // $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop  LIMIT 5");
        $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_index='1' ORDER BY cat_thutu ASC LIMIT 5");
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $cat_id = $r_tt['cat_id'];
            $thongtin_sanpham = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' AND FIND_IN_SET($cat_id,sanpham_shop.cat)>0 ORDER BY sanpham_shop.id DESC LIMIT 8");
            while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
                $id_sp = $r_sp['id'];
                $r_sp['date_post'] = date('d/m/Y', $r_sp['date_post']);
                if ($r_sp['gia_cu'] > $r_sp['gia_moi']) {
                    $giam = ceil((($r_sp['gia_cu'] - $r_sp['gia_moi']) / $r_sp['gia_cu']) * 100);
                    $r_sp['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
                } else {
                    $r_sp['label_sale'] = '';
                }
                if (in_array($r_sp['id'], $tach_list_muakem_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                        $r_sp['loai'] = 'flash_sale';
                    } else {
                        $r_sp['loai'] = 'muakem';
                    }
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
                } else if (in_array($r_sp['id'], $tach_list_tang_id) == true) {
                    $r_sp['loai'] = 'tang';
                    $r_sp['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà tặng</div>';
                } else if (in_array($r_sp['id'], $tach_list_flashsale_id) == true) {
                    if (isset($list_c[$id_sp])) {
                        $r_sp['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    }
                    $r_sp['loai'] = 'flash_sale';
                    $r_sp['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
                } else {
                    $r_sp['loai'] = '';
                    $r_sp['icon_label'] = '<div class="icon_label"></div>';
                }

                $r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
                $r_sp['gia_moi'] = number_format($r_sp['gia_moi']);
                $r_sp['gia_drop'] = number_format($r_sp['gia_drop']);
                if ($r_sp['link_aff'] != '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_aff', $r_sp);
                } else if (strpos($r_sp['mau'], ',') !== false) {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_tuychon', $r_sp);
                } else if ($r_sp['kho'] < 1 and $r_sp['kho_hang'] < 1 and $r_sp['link_aff'] == '') {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index_hethang', $r_sp);
                } else {
                    $list_sp .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_index', $r_sp);
                }
            }
            $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC LIMIT 6");
            while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
                $list_sub .= '<li><a href="/san-pham/' . $r_s['cat_blank'] . '.html" title="' . $r_s['cat_tieude'] . '">' . $r_s['cat_tieude'] . '</a></li>';
            }
            $r_tt['list_sub'] = $list_sub;
            $r_tt['list_sanpham'] = $list_sp;
            unset($list_sp);
            unset($list_sub);
            if ($i % 2 == 0) {
                $r_tt['img_left'] = '';
                $r_tt['img_right'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
            } else {
                $r_tt['img_left'] = '<div class="img_category"><a href="' . $r_tt['cat_link'] . '" title="' . $r_tt['cat_tieude'] . '"><img src="' . $r_tt['cat_img'] . '" data-src="' . $r_tt['cat_img'] . '" alt="' . $r_tt['cat_tieude'] . '" /></a></div>';
                $r_tt['img_right'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_index_1', $r_tt);
        }
        return $list;
    }
    ///////////////////////
    //////////////////////////////////////////////////////////////////
    function list_option_danhmuc($conn, $category)
    {
        $tach_category = explode(',', $category);
        $thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            if (in_array($r_tt['cat_id'], $tach_category) == true) {
                $list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
            } else {
                $list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
            }
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ///////////////////
    function list_option_tinh($conn, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            if ($r_tt['id'] == $id) {
                $list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
            } else {
                $list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_huyen($conn, $tinh, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY thu_tu ASC");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            if ($r_tt['id'] == $id) {
                $list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
            } else {
                $list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_sanpham($conn, $s, $shop, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' ORDER BY sanpham_shop.id DESC LIMIT $start,$limit");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
                $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
                $r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
            } else {
                $r_tt['label_sale'] = '';
            }
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            //$list.=$skin->skin_replace('skin_shop/box_li/li_sanpham',$r_tt);
            if (strpos($r_tt['mau'], ',') !== false) {
                $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_tuychon', $r_tt);
            } else if ($r_tt['kho'] < 1 and $r_tt['kho_hang'] < 1) {
                $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_hethang', $r_tt);
            } else {
                $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham', $r_tt);
            }
        }
        return $list;
    }
    //////////////////////////////
    function list_sanpham_daxem($conn, $s, $shop, $list_id, $id, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        if (!empty($list_id)) {
            $list_id = implode(',', array_filter(explode(',', $list_id)));
        } else {
            $list_id = '0'; // Default value to avoid SQL syntax error
        }
        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY rand() DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
                $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
                $r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
            } else {
                $r_tt['label_sale'] = '';
            }
            if (in_array($r_tt['id'], $tach_list_muakem_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai'] = 'flash_sale';
                } else {
                    $r_tt['loai'] = 'muakem';
                }
                $r_tt['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
            } else if (in_array($r_tt['id'], $tach_list_tang_id) == true) {
                $r_tt['loai'] = 'tang';
                $r_tt['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà</div>';
            } else if (in_array($r_tt['id'], $tach_list_flashsale_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai'] = 'flash_sale';
                $r_tt['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
            } else {
                $r_tt['loai'] = '';
                $r_tt['icon_label'] = '<div class="icon_label"></div>';
            }
            // Lấy thông tin màu sắc
            if ($r_tt['mau'] != '') {
                $mau = $r_tt['mau'];
                $thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
                $m = 0;
                $list_mau = '';
                while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
                    $m++;
                    if ($m == 1) {
                        $list_mau .= '<div class="n-sd swatch-element">
                                    <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" checked />
                                    <label for="mau-' . $r_m['id'] . '">
                                        ' . $r_m['tieu_de'] . '
                                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                    </label>
                                </div>';
                    } else {
                        $list_mau .= '<div class="n-sd swatch-element">
                                    <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '"/>
                                    <label for="mau-' . $r_m['id'] . '">
                                        ' . $r_m['tieu_de'] . '
                                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                    </label>
                                </div>';
                    }
                }
                $option_mau = '<div class="swatch-div">
                            <div id="variant-swatch-0 " class="swatch clearfix swatch-color">
                                
                                <div class="select-swap">' . $list_mau . '</div>
                            </div>
                        </div>';
                $r_tt['option_mau'] = $option_mau;  // Gán vào dữ liệu sản phẩm
            } else {
                $r_tt['option_mau'] = '';  // Nếu không có màu sắc
            }

            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_lienquan', $r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ///////////////////
    function list_slide($conn, $s, $shop)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='$shop' ORDER BY thu_tu DESC LIMIT 3");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_slide', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_category_sanpham_mobile($conn, $shop)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub = mysqli_num_rows($thongtin_sub);
            if ($total_sub > 0) {
                while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
                    $list_sub .= '<li class="ng-scope"><a href="/san-pham/' . $r_s['cat_blank'] . '.html">' . $r_s['cat_tieude'] . '</a></li>';
                }
                $list .= '<li class="ng-scope ng-has-child1"><a href="/san-pham/' . $r_tt['cat_blank'] . '.html">' . $r_tt['cat_tieude'] . ' <i class="fa fa-plus fa1" aria-hidden="true"></i></a><ul class="ul-has-child1">' . $list_sub . '</ul></li>';
                unset($list_sub);
            } else {
                $list .= ' <li class="ng-scope"><a href="san-pham/' . $r_tt['cat_blank'] . '.html">' . $r_tt['cat_tieude'] . '</a></li>';
            }
        }
        return $list;
    }
    ///////////////////
    // function list_tintuc($conn,$s,$shop,$page,$limit){
    //     $skin=$this->load('class_skin');
    //     $check=$this->load('class_check');
    //     $start=$page*$limit - $limit;
    //     $thongtin=mysqli_query($conn,"SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
    //     $i=$start;
    //     while($r_tt=mysqli_fetch_assoc($thongtin)){
    //         $i++;
    //         $r_tt['i']=$i;
    //         $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
    //         $r_tt['trich']=$check->words($r_tt['noidung'],20);
    //         if($i==1){
    //             $list['left'].=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_tintuc_index',$r_tt);
    //         }else{
    //             $list['right'].=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_tintuc_index',$r_tt);
    //         }
    //     }
    //     return json_encode($list);
    // }
    function list_tintuc($conn, $s, $shop, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");

        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
            $r_tt['trich'] = $check->words($r_tt['noidung'], 20);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_tintuc_index', $r_tt);
        }

        return $list;
    }
    ///////////////////
    function list_tintuc_moi($conn, $s, $shop, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $limit");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['trich'] = $check->words($r_tt['noidung'], 20);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_baiviet_moi', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_color($conn, $s, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham ORDER BY thu_tu ASC");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            if (in_array($r_tt['id'], $tach_id) == true) {
                $r_tt['checked'] = 'checked="checked"';
            } else {
                $r_tt['checked'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_color', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_brand($conn, $s, $shop, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$shop' ORDER BY thu_tu ASC");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            if (in_array($r_tt['id'], $tach_id) == true) {
                $r_tt['checked'] = 'checked="checked"';
            } else {
                $r_tt['checked'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_thuonghieu', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_size($conn, $s, $shop, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$shop' ORDER BY thu_tu ASC");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['tieu_de'] = strtoupper($r_tt['tieu_de']);
            if (in_array($r_tt['id'], $tach_id) == true) {
                $r_tt['checked'] = 'checked="checked"';
            } else {
                $r_tt['checked'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_size', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_donhang($conn, $s, $shop, $user_id, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE shop='$shop' AND user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            if ($r_tt['status'] == 0) {
                $r_tt['status'] = 'Chờ xử lý';
            } else if ($r_tt['status'] == 1) {
                $r_tt['status'] = 'Đã tiếp nhận';
            } else if ($r_tt['status'] == 2) {
                $r_tt['status'] = 'Đang vận chuyển';
            } else if ($r_tt['status'] == 3) {
                $r_tt['status'] = 'Yêu cầu hủy đơn';
            } else if ($r_tt['status'] == 4) {
                $r_tt['status'] = 'Đã hủy đơn';
            } else if ($r_tt['status'] == 5) {
                $r_tt['status'] = 'Đã nhận hàng';
            } else if ($r_tt['status'] == 6) {
                $r_tt['status'] = 'Đã hoàn đơn';
            } else {
            }
            $tach_sanpham = json_decode($r_tt['sanpham'], true);
            foreach ($tach_sanpham as $key => $value) {
                $s++;
                // $list_sanpham = ''; // Reset biến
                $list_sanpham .= '+' . $value['tieu_de'] . '<br>';
            }
            $r_tt['list_sanpham'] = $list_sanpham;
            unset($list_sanpham);
            //print_r($r_tt);
            //$list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_tichdiem', $r_tt);

            $list .= $skin->skin_replace('skin_shop/skin_7_nhat/tpl/box_li/li_donhang', $r_tt);
        }
        //echo $list;
        return $list;
    }
    ///////////////////
    function list_tichdiem($conn, $s, $shop, $user_id, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM tich_diem_shop WHERE shop='$shop' AND user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            if ($r_tt['status'] == 1) {
                $r_tt['status'] = 'Đã cộng';
            } else {
                $r_tt['status'] = 'Tạm giữ';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_tichdiem', $r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_thongbao($conn, $s, $shop, $user_id, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE shop='$shop' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') ORDER BY date_post DESC LIMIT $start,$limit");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            if ((time() - $r_tt['date_post']) < 3 * 24 * 3600) {
                $r_tt['new'] = '<span>new</span>';
            } else {
                $r_tt['new'] = '';
            }
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $tach_doc = explode(',', $r_tt['doc']);
            if (in_array($user_id, $tach_doc) == true) {
                $r_tt['status'] = '<i class="fa fa-eye"></i> đã đọc';
                $r_tt['new'] = '';
            } else {
                $r_tt['status'] = '<i class="fa fa-eye-slash"></i> chưa đọc';
                $r_tt['new'] = '<span>new</span>';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_thongbao', $r_tt);
        }
        return $list;
    }

    // list brand tự làm 
    function list_chung_nhan($conn, $s, $shop,$user_id, $brand)
    {
        // Khởi tạo biến chứa HTML
        $list = '';

        // Truy vấn lấy dữ liệu từ bảng chung_nhan
        $thongtin = mysqli_query($conn, "SELECT 
            id,
            tieu_de,
            minh_hoa,
            cat_link,
            noi_dung,
            title,
            description 
        FROM chung_nhan 
        WHERE shop='$shop'
        ORDER BY id ASC");
    
        // Duyệt qua kết quả trả về
        while ($rtt = mysqli_fetch_assoc($thongtin)) {
            // Chuẩn bị dữ liệu cho template
            $data = array(
                'brand_id' => $rtt['id'],
                'brand_link' => '/' . $rtt['cat_link'], // Thêm dấu / trước cat_link
                'brand_title' => $rtt['title'],
                'brand_image' => $rtt['minh_hoa'],
                'brand_description' => $rtt['description']
            );

            // Load template item và thêm vào list
            $list .= $this->skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_chungnhan', $data);
        }

        // Chuẩn bị dữ liệu cho template chính
        $main_data = array(
            'list_chung_nhan' => $list
        );

        // var_dump($main_data);
        // exit();
        
        // Load template chính và trả về
        return $this->skin->skin_replace('skin_shop/' . $s . '/tpl/box_brand', $main_data);
    }

    ///////////////////
    function list_khoang_gia($conn, $s, $id)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM khoang_gia ORDER BY thu_tu ASC");
        $i = $start;
        $tach_id = explode('*', $id);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            if ($r_tt['kieu'] == 'nho') {
                $r_tt['khoang'] = '<span>Dưới</span> ' . number_format($r_tt['max_price']) . '₫';
                $r_tt['price'] = '0-' . $r_tt['max_price'];
            } else if ($r_tt['kieu'] == 'lon') {
                $r_tt['khoang'] = '<span>Trên</span> ' . number_format($r_tt['min_price']) . '₫';
                $r_tt['price'] = $r_tt['min_price'] . '-999999999999';
            } else {
                $r_tt['khoang'] = number_format($r_tt['min_price']) . '₫ - ' . number_format($r_tt['max_price']) . '₫';
                $r_tt['price'] = $r_tt['min_price'] . '-' . $r_tt['max_price'];
            }
            if (in_array($r_tt['price'], $tach_id) == true) {
                $r_tt['checked'] = 'checked="checked"';
            } else {
                $r_tt['checked'] = '';
            }
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_price', $r_tt);
        }
        return $list;
    }
    //////////////////////////////
    function list_baiviet_category($conn, $s, $shop, $id, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $cat = 'cat' . $id;
        $start = $page * $limit - $limit;
        $thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE FIND_IN_SET($id,cat)>0 AND shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['trich'] = $check->words($r_tt['noidung'], 80);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_tintuc', $r_tt);
        }
        mysqli_free_result($thongtin);
        $info = array(
            'total' => $i,
            'list' => $list,
        );
        return json_encode($info);
    }
    //////////////////////////////
    function list_baiviet_lienquan($conn, $s, $shop, $id, $cat, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        if (strpos($cat, ',') !== false) {
            $tach_cat = explode(',', $cat);
            $total_cat = count($tach_cat);
            for ($i = 0; $i < $total_cat; $i++) {
                if ($i == 0) {
                    $where .= "(FIND_IN_SET($tach_cat[$i],cat)>0 ";
                } else {
                    if ($tach_cat[$i] == '') {
                    } else {
                        $where .= "OR FIND_IN_SET($tach_cat[$i],cat)>0 ";
                    }
                }
            }
            $where = $where . ")";
        } else {
            $where = "FIND_IN_SET($cat,cat)>0";
        }
        if ($cat == '') {
            $thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE id!='$id' AND shop='$shop' ORDER BY id DESC LIMIT $limit");
        } else {
            $thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE $where AND id!='$id' AND shop='$shop' ORDER BY id DESC LIMIT $limit");
        }
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['trich'] = $check->words($r_tt['noidung'], 80);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_baiviet_lienquan', $r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ////////////////////////////// gốc

    function list_flashsale($conn, $s, $shop, $list_flashsale_id, $list_c)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_flashsale_id) AND shop='$shop' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $id_sp = $r_tt['id'];
            // Xử lý giá từ flash sale nếu có
        if (isset($list_c[$id_sp])) {
            $expiredTimestamp = intval($list_c[$id_sp]['expired']);
            $remainingTime = $expiredTimestamp - time();
            $r_tt['expired'] = $remainingTime > 0 ? $remainingTime : 0;

            // Xử lý giá có dấu phẩy
            $price = $list_c[$id_sp]['gia'];
            if (strpos($price, ',') !== false) {
                // Nếu có dấu phẩy, chỉ xóa các ký tự không phải số và dấu phẩy
                $price = preg_replace('/[^0-9,]/', '', $price);
                // Đảm bảo format số đúng
                $price = str_replace(',', '', $price); // Xóa dấu phẩy để xử lý số
                $r_tt['gia_moi'] = number_format((float)$price, 0, '.', ',');
            } else {
                // Nếu không có dấu phẩy, xử lý như bình thường
                $price = preg_replace('/[^0-9]/', '', $price);
                $r_tt['gia_moi'] = number_format((float)$price, 0, '.', ',');
            }
        } else {
            $r_tt['expired'] = 0;
        }

        // Xử lý các giá khác
        if (!empty($r_tt['gia_cu'])) {
            $gia_cu = strpos($r_tt['gia_cu'], ',') !== false ? 
                      str_replace(',', '', $r_tt['gia_cu']) : 
                      preg_replace('/[^0-9]/', '', $r_tt['gia_cu']);
            $r_tt['gia_cu'] = number_format((float)$gia_cu, 0, '.', ',');
        }

        if (!empty($r_tt['gia_drop'])) {
            $gia_drop = strpos($r_tt['gia_drop'], ',') !== false ? 
                       str_replace(',', '', $r_tt['gia_drop']) : 
                       preg_replace('/[^0-9]/', '', $r_tt['gia_drop']);
            $r_tt['gia_drop'] = number_format((float)$gia_drop, 0, '.', ',');
        }

        // Xử lý giảm giá nếu có
        if (!empty($r_tt['gia_cu']) && !empty($r_tt['gia_moi'])) {
            $gia_cu = (float)str_replace(',', '', $r_tt['gia_cu']);
            $gia_moi = (float)str_replace(',', '', $r_tt['gia_moi']);
            
            if ($gia_cu > $gia_moi) {
                $giam = ceil((($gia_cu - $gia_moi) / $gia_cu) * 100);
                $r_tt['label_sale'] = $giam . '%';
            }
        }

            //$r_tt['gia_moi'] = number_format($list_c[$id_sp]['gia']) . 'đ';
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_flash_sale', $r_tt);

        }
        // exit();
        $flashsale_expired = $list_c[$id_sp]['expired'] - time(); // Tính thời gian còn lại
        mysqli_free_result($thongtin);
        return $list;
    }
    // function list_flashsale($conn, $s, $shop, $list_flashsale_id, $list_c)
    // {
    //     $skin = $this->load('class_skin');
    //     $list = '';

    //     // Tìm thời gian expired nhỏ nhất
    //     $minExpired = PHP_INT_MAX;
    //     foreach ($list_c as $item) {
    //         if (isset($item['expired'])) {
    //             $remainingTime = intval($item['expired']) - time();
    //             if ($remainingTime > 0 && $remainingTime < $minExpired) {
    //                 $minExpired = $remainingTime;
    //             }
    //         }
    //     }
    //     if ($minExpired === PHP_INT_MAX) {
    //         $minExpired = 0; // Không có giá trị hợp lệ
    //     }

    //     $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_flashsale_id) AND shop='$shop' ORDER BY id DESC");
    //     while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    //         $id_sp = $r_tt['id'];
    //         $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);

    //         // Xử lý giảm giá
    //         if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
    //             $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
    //             $r_tt['label_sale'] = $giam . '%';
    //         }

    //         // Xử lý giá từ flash sale nếu có
    //         if (isset($list_c[$id_sp])) {
    //             $expiredTimestamp = intval($list_c[$id_sp]['expired']);
    //             $remainingTime = $expiredTimestamp - time();
    //             $r_tt['expired'] = $remainingTime > 0 ? $remainingTime : 0;
    //             $r_tt['gia_moi'] = number_format($list_c[$id_sp]['gia']) . 'đ';
    //         } else {
    //             $r_tt['expired'] = 0;
    //         }

    //         $r_tt['gia_cu'] = ($r_tt['gia_cu']) . 'đ';
    //         $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_flash_sale', $r_tt);
    //     }
    //     mysqli_free_result($thongtin);

    //     // Thêm thẻ countdown với thời gian nhỏ nhất
    //     $minExpired_that = $minExpired  + time();
    //     // $list .= '<div class="count_down" data-expired="' . $minExpired_that . '"></div>';
    //     // echo $minExpired_that;
    //     // echo time(); // In ra timestamp hiện tại

    //     // exit();
    //     $template = $skin->skin_replace('your_template_path', [
    //         'list_flash_sale' => $list,
    //         'minExpired_that' => $minExpired_that
    //     ]);
        
    //     return $template;
    // }

    // public function list_flashsale($conn, $s, $shop, $list_flashsale_id, $list_c) 
    // {
    //     $skin = $this->load('class_skin');
    //     $list = '';
        
    //     // Tìm thời gian expired nhỏ nhất
    //     $minExpired = PHP_INT_MAX;
    //     foreach ($list_c as $item) {
    //         if (isset($item['expired'])) {
    //             $remainingTime = intval($item['expired']) - time();
    //             if ($remainingTime > 0 && $remainingTime < $minExpired) {
    //                 $minExpired = $remainingTime;
    //             }
    //         }
    //     }
        
    //     if ($minExpired === PHP_INT_MAX) {
    //         $minExpired = 0;
    //     }

    //     // Lấy thông tin sản phẩm
    //     $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_flashsale_id) AND shop='$shop' ORDER BY id DESC");
        
    //     while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    //         $id_sp = $r_tt['id'];
    //         $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            
    //         // Xử lý giảm giá
    //         if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
    //             $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
    //             $r_tt['label_sale'] = $giam . '%';
    //         }
            
    //         // Xử lý giá từ flash sale
    //         if (isset($list_c[$id_sp])) {
    //             $expiredTimestamp = intval($list_c[$id_sp]['expired']);
    //             $remainingTime = $expiredTimestamp - time();
    //             $r_tt['expired'] = $remainingTime > 0 ? $remainingTime : 0;
    //             $r_tt['gia_moi'] = number_format($list_c[$id_sp]['gia']) . 'đ';
    //         } else {
    //             $r_tt['expired'] = 0;
    //         }
            
    //         $r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
    //         $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_flash_sale', $r_tt);
    //     }
        
    //     mysqli_free_result($thongtin);
        
    //     // Chuẩn bị data cho template
    //     $template_data = array(
    //         'list_flash_sale' => $list,
    //         'minExpired_that' => $minExpired + time()
    //     );
        
    //     // Render template chính
    //     // var_dump($template_data);
    //     // print_r($template_data);
    //     // exit();
    //     return $skin->skin_replace('skin_shop/' . $s . '/tpl/box_flash_sale_index', $template_data);
    // }



    //////////////////////////////

    function list_sanpham_lienquan($conn, $s, $shop, $id, $cat, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        if (strpos($cat, ',') !== false) {
            $tach_cat = explode(',', $cat);
            $total_cat = count($tach_cat);
            for ($i = 0; $i < $total_cat; $i++) {
                if ($i == 0) {
                    $where .= "(FIND_IN_SET('" . $tach_cat[$i] . "', cat) > 0 ";
                } else {
                    if ($tach_cat[$i] != '') {
                        $where .= "OR FIND_IN_SET('" . $tach_cat[$i] . "', cat) > 0 ";
                    }
                }
            }
            $where .= ")";
        } else {
            $where = "FIND_IN_SET('$cat', cat) > 0";
        }

        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE $where /*AND id!='$id'*/ AND shop='$shop' ORDER BY id DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $id_sp = $r_tt['id'];
            if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
                $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
                $r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
            } else {
                $r_tt['label_sale'] = '';
            }
            if (in_array($r_tt['id'], $tach_list_muakem_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai'] = 'flash_sale';
                } else {
                    $r_tt['loai'] = 'muakem';
                }
                $r_tt['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
            } else if (in_array($r_tt['id'], $tach_list_tang_id) == true) {
                $r_tt['loai'] = 'tang';
                $r_tt['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà</div>';
            } else if (in_array($r_tt['id'], $tach_list_flashsale_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai'] = 'flash_sale';
                $r_tt['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
            } else {
                $r_tt['loai'] = '';
                $r_tt['icon_label'] = '<div class="icon_label"></div>';
            }
            // Lấy thông tin màu sắc
            if ($r_tt['mau'] != '') {
                $mau = $r_tt['mau'];
                $thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
                $m = 0;
                $list_mau = '';
                while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
                    $m++;
                    if ($m == 1) {
                        $list_mau .= '<div class="n-sd swatch-element">
                                    <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" checked />
                                    <label for="mau-' . $r_m['id'] . '">
                                        ' . $r_m['tieu_de'] . '
                                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                    </label>
                                </div>';
                    } else {
                        $list_mau .= '<div class="n-sd swatch-element">
                                    <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '"/>
                                    <label for="mau-' . $r_m['id'] . '">
                                        ' . $r_m['tieu_de'] . '
                                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                                    </label>
                                </div>';
                    }
                }
                $option_mau = '<div class="swatch-div">
                            <div id="variant-swatch-0 " class="swatch clearfix swatch-color">
                                
                                <div class="select-swap">' . $list_mau . '</div>
                            </div>
                        </div>';
                $r_tt['option_mau'] = $option_mau;  // Gán vào dữ liệu sản phẩm
            } else {
                $r_tt['option_mau'] = '';  // Nếu không có màu sắc
            }

            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_lienquan', $r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_sanpham_giamgia($conn, $s, $shop, $id, $cat, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit)
    {
        $skin = $this->load('class_skin');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);

        // Xử lý danh mục
        if (!empty($cat)) {
            if (strpos($cat, ',') !== false) {
                $tach_cat = explode(',', $cat);
                $total_cat = count($tach_cat);
                for ($i = 0; $i < $total_cat; $i++) {
                    if ($i == 0) {
                        $where .= "(FIND_IN_SET($tach_cat[$i], cat) > 0 ";
                    } else {
                        if ($tach_cat[$i] != '') {
                            $where .= "OR FIND_IN_SET($tach_cat[$i], cat) > 0 ";
                        }
                    }
                }
                $where .= ")";
            } else {
                $where = "FIND_IN_SET($cat, cat) > 0";
            }
        } else {
            $where = "1"; // Điều kiện mặc định nếu không có danh mục
        }

        // Tạo câu lệnh SQL
        $sql = "SELECT * FROM sanpham_shop WHERE $where AND shop='$shop' ORDER BY id DESC LIMIT $limit";

        // Debug SQL nếu cần
        // echo $sql;

        $thongtin = mysqli_query($conn, $sql);
        $list = '';

        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $id_sp = $r_tt['id'];
            // Lấy thông tin màu sắc
            if ($r_tt['mau'] != '') {
                $mau = $r_tt['mau'];
                $thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
                $m = 0;
                $list_mau = '';
                while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
                    $m++;
                    if ($m == 1) {
                        $list_mau .= '<div class="n-sd swatch-element">
                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" checked />
                        <label for="mau-' . $r_m['id'] . '">
                            ' . $r_m['tieu_de'] . '
                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                        </label>
                    </div>';
                    } else {
                        $list_mau .= '<div class="n-sd swatch-element">
                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '"/>
                        <label for="mau-' . $r_m['id'] . '">
                            ' . $r_m['tieu_de'] . '
                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
                        </label>
                    </div>';
                    }
                }
                $option_mau = '<div class="swatch-div">
                <div id="variant-swatch-0 " class="swatch clearfix swatch-color">
                    
                    <div class="select-swap">' . $list_mau . '</div>
                </div>
            </div>';
                $r_tt['option_mau'] = $option_mau;  // Gán vào dữ liệu sản phẩm
            } else {
                $r_tt['option_mau'] = '';  // Nếu không có màu sắc
            }
            // Xử lý giảm giá
            if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
                $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
                if ($giam >= 40) {


                    $r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
                    $r_tt['icon_label'] = '<div class="icon_label"></div>';
                    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
                    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_lienquan', $r_tt);
                }
            }
        }

        mysqli_free_result($thongtin);
        return $list;
    }


    //////////////////////////
    function list_sanpham_timkiem($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $where, $order, $page, $limit)
    {
        $skin = $this->load('class_skin');
        $check = $this->load('class_check');
        $tach_list_muakem_id = explode(',', $list_muakem_id);
        $tach_list_tang_id = explode(',', $list_tang_id);
        $tach_list_flashsale_id = explode(',', $list_flashsale_id);
        $start = $page * $limit - $limit;
        if (strlen($where) < 5) {
            $thongtin_sanpham = mysqli_query($conn, "SELECT *,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE shop='$shop' ORDER BY $order LIMIT $start,$limit");
        } else {
            $thongtin_sanpham = mysqli_query($conn, "SELECT *,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE " . $where . " AND shop='$shop' ORDER BY $order LIMIT $start,$limit");
        }
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin_sanpham)) {
            $i++;
            $id_sp = $r_tt['id'];
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
                $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
                $r_tt['label_sale'] = '<span class="label-product label-sale">-' . $giam . '%</span>';
            } else {
                $r_tt['label_sale'] = '';
            }
            if (in_array($r_tt['id'], $tach_list_muakem_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai'] = 'flash_sale';
                } else {
                    $r_tt['loai'] = 'muakem';
                }
                $r_tt['icon_label'] = '<div class="icon_label text">Mua kèm deal sốc</div>';
            } else if (in_array($r_tt['id'], $tach_list_tang_id) == true) {
                $r_tt['loai'] = 'tang';
                $r_tt['icon_label'] = '<div class="icon_label text">Mua hàng nhận quà</div>';
            } else if (in_array($r_tt['id'], $tach_list_flashsale_id) == true) {
                if (isset($list_c[$id_sp])) {
                    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai'] = 'flash_sale';
                $r_tt['icon_label'] = '<div class="icon_label text">Sản phẩm flash sale</div>';
            } else {
                $r_tt['loai'] = '';
                $r_tt['icon_label'] = '<div class="icon_label"></div>';
            }
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            if (strpos($where, 'tieu_de') !== false) {
                if ($r_tt['link_aff'] != '') {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_timkiem_aff', $r_tt);
                } else if (strpos($r_tt['mau'], ',') !== false) {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_timkiem_tuychon', $r_tt);
                } else if ($r_tt['kho'] < 1 and $r_tt['kho_hang'] < 1) {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_timkiem_hethang', $r_tt);
                } else {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_timkiem', $r_tt);
                }
            } else {
                if ($r_tt['link_aff'] != '') {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_aff', $r_tt);
                } else if (strpos($r_tt['mau'], ',') !== false) {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_tuychon', $r_tt);
                } else if ($r_tt['kho'] < 1 and $r_tt['kho_hang'] < 1) {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham_hethang', $r_tt);
                } else {
                    $list .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_sanpham', $r_tt);
                }
            }
        }
        return $list;
    }
    ///////////////////////
    function phantrang_sanpham($page, $total, $link)
    {
        $list = '';
        if ($total <= 1) {
            return '';
        } else {
            if ($total <= 5) {
                for ($i = 1; $i <= $total; $i++) {
                    if ($page == $i) {
                        $list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
                    } else {
                        $list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
                    }
                }
                return $list;
            } else {
                if ($page <= 3) {
                    for ($i = 1; $i <= 5; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else if ($page > 3 and $page <= ($total - 2)) {
                    $start = $page - 2;
                    $end = $page + 2;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else {
                    $start = $total - 4;
                    $end = $total;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                }
            }
        }
    }
    ///////////////////////
    function phantrang($page, $total, $link)
    {
        if ($total <= 1) {
            return '';
        } else {
            if ($total <= 5) {
                for ($i = 1; $i <= $total; $i++) {
                    if ($page == $i) {
                        $list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
                    } else {
                        $list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
                    }
                }
                return $list;
            } else {
                if ($page <= 3) {
                    for ($i = 1; $i <= 5; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else if ($page > 3 and $page <= ($total - 2)) {
                    $start = $page - 2;
                    $end = $page + 2;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else {
                    $start = $total - 4;
                    $end = $total;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                }
            }
        }
    }
    ///////////////////////
    function phantrang_timkiem($page, $total, $link)
    {
        if ($total <= 1) {
            return '';
        } else {
            if ($total <= 5) {
                for ($i = 1; $i <= $total; $i++) {
                    if ($page == $i) {
                        $list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
                    } else {
                        $list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
                    }
                }
                return $list;
            } else {
                if ($page <= 3) {
                    for ($i = 1; $i <= 5; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else if ($page > 3 and $page <= ($total - 2)) {
                    $start = $page - 2;
                    $end = $page + 2;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                } else {
                    $start = $total - 4;
                    $end = $total;
                    for ($i = $start; $i <= $end; $i++) {
                        if ($page == $i) {
                            $list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
                        } else {
                            $list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    return $list;
                }
            }
        }
    }
}
