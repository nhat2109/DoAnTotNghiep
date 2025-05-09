<?php

$loai = addslashes($_REQUEST['loai']);
$id = preg_replace('/[^0-9a-z-]/', '', $_REQUEST['id']);
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if ($loai == 'color') {
        if (in_array('color', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM mau_sanpham WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Màu sản phẩm không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa màu sản phẩm thành công';
            mysqli_query($conn, "DELETE FROM mau_sanpham WHERE id='$id'");
        }
    } else if ($loai == 'size') {
        if (in_array('size', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM kich_co WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Kích cỡ sản phẩm không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa kích cỡ sản phẩm thành công';
            mysqli_query($conn, "DELETE FROM kich_co WHERE id='$id'");
        }
    } else if ($loai == 'brand') {
        if (in_array('brand', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thuong_hieu WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa thương hiệu thành công';
            @unlink('..' . $r_tt['anh_thuong_hieu']);
            mysqli_query($conn, "DELETE FROM thuong_hieu WHERE id='$id'");
        }
    } else if ($loai == 'bom') {
        if (in_array('donhang', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM bom_hang WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa khách bom hàng thành công';
            mysqli_query($conn, "DELETE FROM bom_hang WHERE id='$id'");
        }
    } else if ($loai == 'price') {
        if (in_array('price', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM khoang_gia WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Khoảng giá không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa khoảng giá thành công';
            mysqli_query($conn, "DELETE FROM khoang_gia WHERE id='$id'");
        }
    } else if ($loai == 'donhang') {
        if (in_array('donhang', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa đơn hàng thành công';
            mysqli_query($conn, "DELETE FROM donhang WHERE id='$id'");
        }
    } else if ($loai == 'donhang_ctv') {
        if (in_array('donhang', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang_ctv WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa đơn hàng thành công';
            mysqli_query($conn, "DELETE FROM donhang_ctv WHERE id='$id'");
        }
    } else if ($loai == 'domain') {
        if (in_array('domain', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain_price WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Tên miền không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa tên miền thành công';
            mysqli_query($conn, "DELETE FROM domain_price WHERE id='$id'");
        }
    } else if ($loai == 'goi_seeding') {
        if (in_array('seeding', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM seeding_shopee WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa gói dịch vụ thành công';
            mysqli_query($conn, "DELETE FROM seeding_shopee WHERE id='$id'");
        }
    } else if ($loai == 'goi_seeding_ncc') {
        if (in_array('seeding', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM seeding_shopee_ncc WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa gói dịch vụ thành công';
            mysqli_query($conn, "DELETE FROM seeding_shopee_ncc WHERE id='$id'");
        }
    } else if ($loai == 'category') {
        if (in_array('category', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category WHERE cat_id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Danh mục không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa danh mục bài viết thành công';
            mysqli_query($conn, "DELETE FROM category WHERE cat_id='$id'");
            mysqli_query($conn, "DELETE FROM seo WHERE link='{$r_tt['cat_blank']}'");
        }
    } else if ($loai == 'category_video') {
        if (in_array('category', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category_video WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Danh mục không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa danh mục video thành công';
            mysqli_query($conn, "DELETE FROM category_video WHERE id='$id'");
        }
    } else if ($loai == 'category_sanpham') {
        if (in_array('category', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category_sanpham WHERE cat_id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Danh mục không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa danh mục thành công';
            mysqli_query($conn, "DELETE FROM category_sanpham WHERE cat_id='$id'");
            mysqli_query($conn, "DELETE FROM seo WHERE link='{$r_tt['cat_blank']}'");
        }
    } else if ($loai == 'menu') {
        if (in_array('menu', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM menu WHERE menu_id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Menu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa menu thành công';
            mysqli_query($conn, "DELETE FROM menu WHERE menu_id='$id'");
        }
    } else if ($loai == 'thanhvien') {
        if (in_array('thanhvien', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Thành viên này không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa thành viên thành công';
            @unlink('..' . $r_tt['avatar']);
            mysqli_query($conn, "DELETE FROM user_info WHERE user_id='$id'");
        }
    } else if ($loai == 'nhacungcap') {
        if (in_array('nhacungcap', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Thành viên này không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa thành viên thành công';
            @unlink('..' . $r_tt['avatar']);
            mysqli_query($conn, "DELETE FROM user_info WHERE user_id='$id'");
        }
    } else if ($loai == 'thanhvien_nhom') {
        if (in_array('nhom', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $tach_id = explode('-', $id);
        $thongtin_nhom = mysqli_query($conn, "SELECT * FROM nhom WHERE id='$tach_id[0]'");
        $r_nhom = mysqli_fetch_assoc($thongtin_nhom);
        $tach_thanhvien = explode(',', $r_nhom['thanhvien']);
        foreach ($tach_thanhvien as $key => $value) {
            if (intval($value) > 0 and $value != $tach_id[1]) {
                $list_id .= $value . ',';
            }
        }
        $list_id = substr($list_id, 0, -1);
        if ($tach_id[1] == $r_nhom['nhomtruong']) {
            mysqli_query($conn, "UPDATE nhom SET thanhvien='$list_id',nhomtruong='' WHERE id='$tach_id[0]'");
        } else {
            mysqli_query($conn, "UPDATE nhom SET thanhvien='$list_id' WHERE id='$tach_id[0]'");
        }
        if (in_array($tach_id[1], $tach_thanhvien) == true) {
            $id_tv = $tach_id[1];
            mysqli_query($conn, "UPDATE user_info SET nhom='' WHERE user_id='$id_tv'");
        }
        $ok = 1;
        $thongbao = 'Xóa thành viên thành công';
    } else if ($loai == 'nhom') {
        if (in_array('nhom', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin_nhom = mysqli_query($conn, "SELECT * FROM nhom WHERE id='$id'");
        $r_nhom = mysqli_fetch_assoc($thongtin_nhom);
        $tach_thanhvien = explode(',', $r_nhom['thanhvien']);
        foreach ($tach_thanhvien as $key => $value) {
            mysqli_query($conn, "UPDATE user_info SET nhom='' WHERE user_id='$value'");
        }
        mysqli_query($conn, "DELETE FROM nhom WHERE id='$id'");
        $ok = 1;
        $thongbao = 'Xóa nhóm thành công';
    } else if ($loai == 'baiviet') {
        if (in_array('baiviet', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM post WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Bài viết không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa bài viết thành công';
            mysqli_query($conn, "DELETE FROM post WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'video') {
        if (in_array('video', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM video WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Video không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa video thành công';
            mysqli_query($conn, "DELETE FROM video WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'sanpham') {
        if (in_array('sanpham', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Sản phẩm không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa sản phẩm thành công';
            mysqli_query($conn, "DELETE FROM sanpham WHERE id='$id'");
            mysqli_query($conn, "DELETE FROM sanpham_shop WHERE sp_id='$id'");
            mysqli_query($conn, "DELETE FROM phanloai_sanpham WHERE sp_id='$id'");
            mysqli_query($conn, "DELETE FROM seo WHERE loai='sanpham' AND link='{$r_tt['link']}'");
            $tach_anh = explode(',', $r_tt['anh']);
            foreach ($tach_anh as $key => $value) {
                $tach_value = explode('/uploads/', $value);
                @unlink('../uploads/' . $tach_value[1]);
            }
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'giaodien') {
        if (in_array('giaodien', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM giaodien WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Giao diện không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa giao diện thành công';
            mysqli_query($conn, "DELETE FROM giaodien WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'slide') {
        if (in_array('slide', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM slide WHERE id='$id' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Slide không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa slide thành công';
            mysqli_query($conn, "DELETE FROM slide WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'banner') {
        if (in_array('banner', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM banner WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Banner không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa banner thành công';
            mysqli_query($conn, "DELETE FROM banner WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
        }
    } else if ($loai == 'quantri') {
        if (in_array('quantri', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM emin_info WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Quản trị không tồn tại';
        } else {
            if ($r_tt['emin_group'] == 1) {
                $ok = 0;
                $thongbao = 'Thất bại! Đây là tài khoản quản trị cấp cao';
            } else {
                $ok = 1;
                $thongbao = 'Xóa quản trị viên thành công';
                mysqli_query($conn, "DELETE FROM emin_info WHERE id='$id'");
            }
        }
    } else if ($loai == 'nhiemvu') {
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM nhiem_vu WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Nhiệm vụ không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa nhiệm vụ thành công';
            $thongtin_noidung = mysqli_query($conn, "SELECT * FROM noidung_nhiemvu WHERE nhiem_vu='$id'");
            while ($r_nv = mysqli_fetch_assoc($thongtin_noidung)) {
                $tach_hinhanh = explode(',', $r_nv['hinh_anh']);
                foreach ($tach_hinhanh as $key => $value) {
                    if (strlen($value) > 5) {
                        @unlink('..' . $value);
                    }
                }
                mysqli_query($conn, "DELETE FROM noidung_nhiemvu WHERE id='{$r_nv['id']}'");
            }
            mysqli_query($conn, "DELETE FROM nhiem_vu WHERE id='$id'");
        }
    } else if ($loai == 'noidung_nhiemvu') {
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM noidung_nhiemvu WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Nội dung không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa nội dung nhiệm vụ thành công';
            $tach_hinhanh = explode(',', $r_tt['hinh_anh']);
            foreach ($tach_hinhanh as $key => $value) {
                if (strlen($value) > 5) {
                    @unlink('..' . $value);
                }
            }
            mysqli_query($conn, "DELETE FROM noidung_nhiemvu WHERE id='$id'");
        }
    } else if ($loai == 'share_sanpham') {
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM list_share_sanpham WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Nội dung không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa nội dung thành công';
            $tach_hinhanh = explode(',', $r_tt['minh_hoa']);
            foreach ($tach_hinhanh as $key => $value) {
                if (strlen($value) > 5) {
                    @unlink('..' . $value);
                }
            }
            mysqli_query($conn, "DELETE FROM list_share_sanpham WHERE id='$id'");
        }
    } else if ($loai == 'contact') {
        if (in_array('lienhe', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM contact WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Liên hệ không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa liên hệ thành công';
            mysqli_query($conn, "DELETE FROM contact WHERE id='$id'");
        }
    } else if ($loai == 'coupon') {
        if (in_array('coupon', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE id='$id' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Mã coupon không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa coupon thành công';
            mysqli_query($conn, "DELETE FROM coupon WHERE id='$id'");
        }
    } else if ($loai == 'thongbao') {
        if (in_array('thongbao', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thongbao WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Thông báo không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa thông báo thành công';
            mysqli_query($conn, "DELETE FROM thongbao WHERE id='$id'");
            @unlink('..' . $r_tt['minh_hoa']);
            @unlink('..' . $r_tt['img_pop']);
        }
    } else if ($loai == 'remarketing') {
        if (in_array('remarketing', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thongbao_shop WHERE id='$id' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa Remarketing thành công';
            mysqli_query($conn, "DELETE FROM thongbao_shop WHERE id='$id' AND shop='0'");
            @unlink('..' . $r_tt['minh_hoa']);
            @unlink('..' . $r_tt['img_pop']);
        }
    } else if ($loai == 'idol') {
        if (in_array('live_stream', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM idol WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa idol thành công';
            mysqli_query($conn, "DELETE FROM idol WHERE id='$id'");
        }
    } else if ($loai == 'sanpham_trend') {
        if (in_array('sanpham_trend', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham_trend WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa sản phẩm gợi ý thành công';
            mysqli_query($conn, "DELETE FROM sanpham_trend WHERE id='$id'");
        }
    } else if ($loai == 'sanpham_tuan') {
        if (in_array('sanpham_tuan', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM sanpham_tuan WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa sản phẩm tuần thành công';
            mysqli_query($conn, "DELETE FROM sanpham_tuan WHERE id='$id'");
        }
    } else if ($loai == 'deal') {
        if (in_array('coupon', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE id='$id' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa deal sốc thành công';
            mysqli_query($conn, "DELETE FROM deal WHERE id='$id'");
        }
    } else if ($loai == 'flash_sale') {
        if (in_array('coupon', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM deal WHERE id='$id' AND shop='0'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $ok = 0;
            $thongbao = 'Dữ liệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Xóa flash sale thành công';
            mysqli_query($conn, "DELETE FROM deal WHERE id='$id'");
        }
    } else if ($loai == 'pheduyet_brand') {///huyphuc16/04/2025
        if (in_array('brand', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
            echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
            exit();
        }
        $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM thuong_hieu WHERE id='$id'");
        $thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);

        if (!$r_tt) {
            $ok = 0;
            $thongbao = 'Thương hiệu không tồn tại';
        } else {
            $ok = 1;
            $thongbao = 'Thương hiệu đã thêm vào sóc đỏ';
            $reload = 1;
            $tieu_de = $r_tt['tieu_de'];
            $thu_tu = $r_tt['thu_tu'];
            mysqli_query($conn, "INSERT INTO thuong_hieu (shop, tieu_de, thu_tu, id_thuonghieu_socdo,status) 
                                        VALUES (0, '$tieu_de', '$thu_tu', 0,0)");
            $new_id = mysqli_insert_id($conn);

            if ($new_id) {
                mysqli_query($conn, "UPDATE thuong_hieu SET id_thuonghieu_socdo = '$new_id' WHERE id = '$id'");
            }
        }
        
    }////
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'reload' => $reload,///huyphuc16/04/2025
);
echo json_encode($info);
