<?php
$id = intval($_REQUEST['id']);
$gia = preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_trend WHERE sp_id='$id'");
$r_tk = mysqli_fetch_assoc($thongke);
$noti = 0;
if ($r_tk['total'] == 0) {
    $ok = 1;
    mysqli_query($conn, "INSERT INTO sanpham_trend(sp_id,gia)VALUES('$id','$gia')");
    $thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_trend.id AS id,sanpham_trend.gia FROM sanpham_trend INNER JOIN sanpham ON sanpham_trend.sp_id=sanpham.id ORDER BY sanpham_trend.id DESC LIMIT 100");
    $i = 0;
    $noti = 1;
    $noidung_notification = 'Hệ thống thêm mới sản phẩm trend';
    mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $i++;
        $r_tt['i'] = $i;
        $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
        $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
        $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
        $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
        $r_tt['drop_min'] = number_format($r_tt['drop_min']);
        $r_tt['drop_max'] = number_format($r_tt['drop_max']);
        $r_tt['gia'] = number_format($r_tt['gia']);
        if ($r_tt['ma_sanpham'] != '') {
            if (strpos($r_tt['ma_sanpham'], '|') !== false) {
                $tach_ma_sanpham = explode('|', $r_tt['ma_sanpham']);
                foreach ($tach_ma_sanpham as $key => $value) {
                    $tach_value = explode('&&', $value);
                    $list_ma .= $tach_value[2] . ':' . $tach_value[1] . '<br>';
                }
            } else {
                $tach_ma_sanpham = explode('&&', $r_tt['ma_sanpham']);
                $list_ma = $tach_ma_sanpham[2] . ':' . $tach_ma_sanpham[1];
            }
        } else {
            $list_ma = '';
        }
        $r_tt['list_ma'] = $list_ma;
        unset($list_ma);
        $list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_trend', $r_tt);
    }
    $list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
            <th style="text-align: left;width: 150px;" class="hide_mobile">Mã Sản Phẩm</th>
            <th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
            <th style="text-align: left;">Tên sản phẩm</th>
            <th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá drop</th>
            <th style="text-align: center;width: 140px;" class="hide_mobile">Giá bán tối thiểu</th>
            <th style="text-align: center;width: 80px;" class="hide_mobile">Giá gợi ý</th>
            <th style="text-align: center;width: 160px;">Hành động</th>
        </tr>' . $list;
} else {
    $ok = 0;
}
$info = array(
    'ok' => $ok,
    'noti' => $noti,
    'list' => $list
);
echo json_encode($info);
