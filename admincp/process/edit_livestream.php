<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('live_stream', explode(',', $user_info['emin_group']))==false AND in_array('quanly_live', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $status = addslashes(strip_tags($_REQUEST['status']));
    $id=intval($_REQUEST['id']);
    $thongtin_mua=mysqli_query($conn,"SELECT *,count(*) AS total FROM dat_live WHERE id='$id'");
    $r_m=mysqli_fetch_assoc($thongtin_mua);
    if($r_m['total']==0){
        $ok=0;
        $thongbao='Dữ liệu không tồn tại';
    }else{
        if($r_m['status']==0){
            if($status==2){
                $thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_m['user_id']}'");
                $r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
                $truoc=$r_tv['user_money'] + $r_tv['user_money2'];
                $sau=$truoc + preg_replace('/[^0-9]/', '', $r_m['ngan_sach']);
                $moi=$r_tv['user_money'] + preg_replace('/[^0-9]/', '', $r_m['ngan_sach']);
                $noidung='Hoàn tiền đặt lịch live stream';
                mysqli_query($conn,"UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_m['user_id']}'");
                mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_m['user_id']}','{$r_m['ngan_sach']}','$truoc','$sau','$noidung',".time().")");
                mysqli_query($conn,"UPDATE dat_live SET status='$status' WHERE id='$id'");
                $ok=1;
                $thongbao='Lưu thay đổi thành công';
            }else{
                mysqli_query($conn,"UPDATE dat_live SET status='$status' WHERE id='$id'");
                $ok=1;
                $thongbao='Lưu thay đổi thành công';
            }

        }else if($r_m['status']==1){
                $ok=0;
                $thongbao='Thất bại! Đơn hàng này đã hoàn thành';
        }else if($r_m['status']==2){
            $ok=0;
            $thongbao='Thất bại! Đơn hàng đã hủy';
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>