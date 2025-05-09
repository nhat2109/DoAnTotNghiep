<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('donhang', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $status = intval($_REQUEST['status']);
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang_ctv WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    $hientai = time();
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Đơn hàng không tồn tại';
    } else {
        if ($status == 0) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 1) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                $ma_don = $r_tt['ma_don'];
                $nguoi_ban = 'Sóc đỏ';
                $diachi_nguoiban = 'Số 22, Liền kề 25 - Khu đô thị Vân Canh - Hoài Đức - Hà Nội';
                $dienthoai_ban = '0943051818';
                $nguoi_mua = $r_tt['ho_ten'];
                $diachi_nguoimua = $r_tt['dia_chi'] . ',' . $r_tt['ten_xa'] . ',' . $r_tt['ten_huyen'] . ',' . $r_tt['ten_tinh'];
                $huyen_mua = $r_tt['ten_huyen'];
                $tinh_mua = $r_tt['ten_tinh'];
                $dienthoai_mua = $r_tt['dien_thoai'];
                $tong_soluong = $r_tt['so_luong'];
                $cod = $r_tt['cod'];
                $phi_ship = $r_tt['phi_ship'];
                $can_nang = $r_tt['can_nang'];
                if ($cod == 0) {
                    if ($r_tt['chiu_ship'] == 'khach') {
                        $loai_vanchuyen = 4;
                    } else {
                        $loai_vanchuyen = 1;
                    }
                } else {
                    if ($r_tt['chiu_ship'] == 'khach') {
                        $loai_vanchuyen = 2;
                    } else {
                        $loai_vanchuyen = 3;
                    }
                }
                $dichvu_ship = $r_tt['dichvu_ship'];
                $ghi_chu = $r_tt['ghi_chu'];
                $tach_sanpham = json_decode($r_tt['sanpham'], true);
                $k = 0;
                foreach ($tach_sanpham as $key => $value) {
                    $k++;
                    $nang = $value['can_nang'] * 1000;
                    if ($k == 1) {
                        $list_ten .= $value['tieu_de'] . ' x ' . $value['soluong'];
                        $list_item .= '{"PRODUCT_NAME": "' . $value['tieu_de'] . '","PRODUCT_QUANTITY": ' . $value['soluong'] . ',"PRODUCT_PRICE": ' . $value['gia_moi'] . ',"PRODUCT_WEIGHT": ' . $nang . '}';
                    } else {
                        $list_ten .= ' ,' . $value['tieu_de'] . ' x ' . $value['soluong'];
                        $list_item .= ',{"PRODUCT_NAME": "' . $value['tieu_de'] . '","PRODUCT_QUANTITY": ' . $value['soluong'] . ',"PRODUCT_PRICE": ' . $value['gia_moi'] . ',"PRODUCT_WEIGHT": ' . $nang . '}';
                    }
                    $total_banle += preg_replace('/[^0-9]/', '', $value['gia_moi']) * $value['soluong'];
                }
                $ten_sanpham = $list_ten;
                $mota_sanpham = 'Đơn hàng #' . $ma_don . ',' . $list_ten;
                if ($r_tt['congty_ship'] == 'ninja_van') {
                    $can = round($can_nang / 1000);
                    if ($r_tt['chiu_ship'] == 'shop') {
                        $cod = $cod;
                    } else {
                        $cod = $cod + $phi_ship;
                    }
                    $ketqua_tao = $class_ninja_van->tao_don($ma_don, $can, $cod, $total_banle, $ten_sanpham, $nguoi_ban, $dienthoai_ban, $email_ban, $nguoi_mua, $dienthoai_mua, $diachi_nguoimua, $huyen_mua, $tinh_mua, $ghi_chu);
                    $tach_ketqua = json_decode($ketqua_tao, true);
                } else {
                    $login_step_1 = $class_viettel->login_step_1();
                    $info_login = json_decode($login_step_1, true);
                    $token = $info_login['data']['token'];
                    $token_client = $class_viettel->get_token_client($token);
                    $ketqua_tao = $class_viettel->tao_don($token_client, $ma_don, $nguoi_ban, $diachi_nguoiban, $dienthoai_ban, $nguoi_mua, $diachi_nguoimua, $dienthoai_mua, $ten_sanpham, $mota_sanpham, $tong_soluong, $cod, $can_nang, 0, 0, 0, $loai_vanchuyen, $dichvu_ship, $ghi_chu, $cod, '');
                    $tach_ketqua = json_decode($ketqua_tao, true);
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 2) {
            if ($r_tt['status'] == 0 or $r_tt['status'] == 1) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 3) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu thay đổi';
            }
        } else if ($status == 4) {
            if ($r_tt['status'] != 5) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                if ($r_tt['congty_ship'] == 'ninja_van') {
                    $class_ninja_van->huy_don('SOCDO' . $r_tt['ma_don']);
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 5) {
            if ($r_tt['status'] != 3 and $r_tt['status'] != 4 and $r_tt['status'] != 6) {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                if ($r_tt['status'] != 5) {
                    $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
                    $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
                    $moi = $r_tt['hoahong'] + $r_tv['user_money'];
                    $truoc = $r_tv['user_money'] + $r_tv['user_money2'];
                    $sau = $truoc + $r_tt['hoahong'];
                    $noidung = 'Cộng tiền hoa hồng đơn hàng #' . $r_tt['ma_don'];
                    mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['hoahong']}','$truoc','$sau','$noidung'," . time() . ")");
                    mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 6) {
            if ($r_tt['status'] == 3) {
                $ok = 0;
                $thongbao = 'Thất bại! Đơn hàng này đang yêu cầu hủy';
            } else if ($r_tt['status'] == 4) {
                $ok = 0;
                $thongbao = 'Thất bại! Đơn hàng này đã bị hủy';
            } else {
                mysqli_query($conn, "UPDATE donhang_ctv SET status='$status',date_update='$hientai' WHERE id='$id'");
                /*					if($r_tt['status']!=6){
						$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
						$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
						$moi=$r_tt['tongtien']+$r_tv['user_money'];
						$truoc=$r_tv['user_money'] + $r_tv['user_money2'];
						$sau=$truoc + $r_tt['tongtien'];
						$noidung = 'Hoàn đơn hàng #'.$r_tt['ma_don'];
						mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['tongtien']}','$truoc','$sau','$noidung',".time().")");
						mysqli_query($conn,"UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
					}*/
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            }
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
