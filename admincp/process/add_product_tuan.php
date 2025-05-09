<?php
$id = intval($_REQUEST['id']);
$gia = preg_replace('/[^0-9]/', '', addslashes($_REQUEST['gia']));
$gia_tuan = preg_replace('/[^0-9]/', '', addslashes($_REQUEST['gia_tuan']));
$gia_ctv = preg_replace('/[^0-9]/', '', addslashes($_REQUEST['gia_ctv']));
$gia_ctv_tuan = preg_replace('/[^0-9]/', '', addslashes($_REQUEST['gia_ctv_tuan']));
$time_start = strip_tags(addslashes($_REQUEST['time_start']));
$time_end = strip_tags(addslashes($_REQUEST['time_end']));
$note_text = strip_tags(addslashes($_REQUEST['note_text']));
$noti = 0;
/*	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham_tuan WHERE sp_id='$id'");
$r_tk=mysqli_fetch_assoc($thongke);
if($r_tk['total']==0){*/
$ok = 1;
$tach_start = explode(' ', $time_start);
$tach_time_start = explode(':', $tach_start[0]);
$tach_date_start = explode('/', $tach_start[1]);
$start = mktime($tach_time_start[0], $tach_time_start[1], 00, $tach_date_start[1], $tach_date_start[0], $tach_date_start[2]);
$tach_end = explode(' ', $time_end);
$tach_time_end = explode(':', $tach_end[0]);
$tach_date_end = explode('/', $tach_end[1]);
$end = mktime($tach_time_end[0], $tach_time_end[1], 00, $tach_date_end[1], $tach_date_end[0], $tach_date_end[2]);
mysqli_query($conn, "INSERT INTO sanpham_tuan(sp_id,gia_truoc,gia_tuan,gia_ctv_truoc,gia_ctv_tuan,time_start,time_end,note_text,update_price)VALUES('$id','$gia','$gia_tuan','$gia_ctv','$gia_ctv_tuan','$start','$end','$note_text','0')");
$noti = 1;
$noidung_notification = 'Hệ thống cập nhật chương trình tuần mới';
mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
$thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_tuan.id AS id,sanpham_tuan.gia_truoc,sanpham_tuan.gia_tuan,sanpham_tuan.time_start,sanpham_tuan.time_end FROM sanpham_tuan INNER JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id ORDER BY sanpham_tuan.id DESC LIMIT 100");
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['i'] = $i;
    $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
    if ($r_tt['gia_ctv_tuan'] == 0) {
        $gia_ctv = $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan']) * 0.3);
    } else {
        $gia_ctv = $r_tt['gia_ctv_tuan'];
    }
    if ($r_tt['gia_ctv_truoc'] == 0) {
        $gia_ctv_truoc = $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc']) * 0.3);
    } else {
        $gia_ctv_truoc = $r_tt['gia_ctv_truoc'];
    }
    $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
    $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
    $r_tt['drop_min'] = number_format($r_tt['drop_min']);
    $r_tt['drop_max'] = number_format($r_tt['drop_max']);
    $r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
    $r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
    $r_tt['gia_ctv_truoc'] = number_format($gia_ctv_truoc);
    $r_tt['gia_ctv_tuan'] = number_format($gia_ctv);
    if ($r_tt['time_start'] > time()) {
        $r_tt['text_time'] = 'Bắt đầu sau:';
        $r_tt['conlai'] = $r_tt['time_start'] - time();
        $r_tt['status'] = 0;
        $r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
    } else {
        $r_tt['text_time'] = 'Kết thúc sau:';
        $r_tt['conlai'] = $r_tt['time_end'] - time();
        $r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
        $r_tt['status'] = 1;
    }
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
    $list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_tuan', $r_tt);
}
$list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
            <th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
            <th style="text-align: left;">Tên sản phẩm</th>
            <th style="text-align: left;width: 160px;">Thời gian</th>
            <th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá Drop</th>
            <th style="text-align: center;width: 160px;" class="hide_mobile">Giá chương trình tuần</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
            <th style="text-align: center;width: 160px;" class="hide_mobile">Giá CTV tuần</th>
            <th style="text-align: center;width: 160px;">Hành động</th>
        </tr>' . $list;
/*	}else{
    $ok=0;
}*/
$info = array(
    'ok' => $ok,
    'noti' => $noti,
    'list' => $list
);
echo json_encode($info);
