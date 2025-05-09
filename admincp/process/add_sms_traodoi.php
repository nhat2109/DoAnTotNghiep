<?php
$phien = addslashes(strip_tags($_REQUEST['phien']));
$noi_dung = addslashes(strip_tags($_REQUEST['noi_dung']));
$sms_id = intval($_REQUEST['sms_id']);
if (strlen($noi_dung) == '') {
    $ok = 0;
    $thongbao = 'Chưa nhập nội dung';
} else {
    $thongtin = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['active'] != 1) {
        $ok = 0;
        $thongbao = 'Thất bại! Phiên yêu cầu đã đóng';
    } else {
        $hientai = time();
        mysqli_query($conn, "INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','{$r_tt['thanh_vien']}','{$r_tt['thanh_vien']}','{$user_info['id']}','$noi_dung','0','1','$hientai')");
        $ok = 1;
        $thongbao = 'Gửi thành công';
        $thongtin_moi = mysqli_query($conn, "SELECT chat.*,emin_info.name,emin_info.avatar FROM chat LEFT JOIN emin_info ON emin_info.id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='{$user_info['id']}' ORDER BY chat.id DESC LIMIT 1");
        $r_m = mysqli_fetch_assoc($thongtin_moi);
        $thongtin_cuoi = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
        $r_c = mysqli_fetch_assoc($thongtin_cuoi);
        $r_m['noi_dung'] = $check->smile($r_m['noi_dung']);
        if ($r_c['thanh_vien'] == $r_c['user_out']) {
            $list = $skin->skin_replace('skin_dropship/box_action/li_chat_right_avatar', $r_m);
            $list_out = $skin->skin_replace('skin_dropship/box_action/li_chat_left_avatar', $r_m);
        } else if ($r_c['user_out'] != $user_info['id']) {
            $list = $skin->skin_replace('skin_dropship/box_action/li_chat_right_avatar', $r_m);
            $list_out = $skin->skin_replace('skin_dropship/box_action/li_chat_left_avatar', $r_m);
        } else {
            $list = $skin->skin_replace('skin_dropship/box_action/li_chat_right', $r_m);
            $list_out = $skin->skin_replace('skin_dropship/box_action/li_chat_left', $r_m);
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
    'list' => $list,
    'user_out' => $user_info['id'],
    'list_out' => $list_out,
    'phien' => $phien,
    'bo_phan' => $r_tt['bo_phan'],
    'thanh_vien' => $r_tt['thanh_vien']
);
echo json_encode($info);
