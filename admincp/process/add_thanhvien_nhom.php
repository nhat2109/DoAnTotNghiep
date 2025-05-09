<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('nhom', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $thanhvien = addslashes(strip_tags($_REQUEST['thanhvien']));
    $id=intval($_REQUEST['id']);
    if(strlen($thanhvien)<4){
        $ok=0;
        $thongbao='Vui lòng nhập tài khoản thành viên';
    }else{
        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM nhom WHERE id='$id'");
        $r_tt=mysqli_fetch_assoc($thongtin);
        if($r_tt['total']>0){
            $tach_new=explode("\n", $thanhvien);
            foreach ($tach_new as $key => $value) {
                if(strlen($value)>2){
                    $list_tach.="'".$value."',";
                }
                
            }
            $list_tach=substr($list_tach, 0,-1);
            $thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE username IN ($list_tach) AND dropship='1' ORDER BY user_id ASC");
            $total_tv=mysqli_num_rows($thongtin_thanhvien);
            if($total_tv>0){
                $kk=0;
                $xx=0;
                while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
                    $thanhvien_id=$r_tv['user_id'];
                    $check_thanhvien=mysqli_query($conn,"SELECT count(*) AS total FROM nhom WHERE FIND_IN_SET($thanhvien_id,thanhvien)>0 ORDER BY id ASC");
                    $r_check=mysqli_fetch_assoc($check_thanhvien);
                    if($r_check['total']==0){
                        $list_id.=$r_tv['user_id'].',';
                        mysqli_query($conn,"UPDATE user_info SET nhom='$id' WHERE user_id='$thanhvien_id'");
                        $kk++;
                    }else{
                        $xx++;
                    }
                }
                if($kk>0){
                    $list_id=substr($list_id, 0,-1);
                    if(strlen($r_tt['thanhvien'])!=''){
                        $id_moi=$r_tt['thanhvien'].','.$list_id;
                    }else{
                        $id_moi=$list_id;
                    }
                    $tach_thanhvien_moi=explode(',', $id_moi);
                    $thanhvien_moi=array_unique($tach_thanhvien_moi);
                    $thanhvien_moi=implode(',', $thanhvien_moi);
                    mysqli_query($conn, "UPDATE nhom SET thanhvien='$thanhvien_moi' WHERE id='$id'");
                    $ok = 1;
                    if($xx==0){
                        $thongbao = 'Thêm thành viên nhóm thành công';
                    }else{
                        $thongbao = 'Thêm '.$kk.' thành viên thành công,'.$xx.' thất bại';
                    }
                }else{
                    $ok=0;
                    $thongbao='Thất bại! Các thành viên này đã tham gia các nhóm';

                }
            }else{
                $ok=0;
                $thongbao='Thất bại! Không có thành viên nào thỏa mãn';

            }
        }else{
            $ok=0;
            $thongbao='Thất bại! Nhóm không tồn tại';

        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>