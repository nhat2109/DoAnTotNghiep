<?php
function token_login($user_id,$password){
    $pass_1=substr($password, 0,8);
    $pass_2=substr($password, 8,8);
    $pass_3=substr($password, 16,8);
    $pass_4=substr($password, 24,8);
    $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
    $token_login=base64_encode($string);
    return $token_login;
}
include('./includes/config.php');
$id_token=addslashes(strip_tags($_REQUEST['id_token']));
$id=addslashes(strip_tags($_REQUEST['id']));
$name=addslashes(strip_tags($_REQUEST['name']));
$avatar=addslashes(strip_tags($_REQUEST['avatar']));
$email=addslashes(strip_tags($_REQUEST['email']));
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$id_token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$hientai=time();
if ($err) {
    $ok=0;
    $thongbao='Gặp lỗi khi đăng nhập';
    $tiep=0;
} else {
    $data = json_decode($response, true);
    if (isset($data['error_description'])) {
        $ok=0;
        $thongbao='Gặp lỗi khi đăng nhập';
        $tiep=0;
        $html='';
    } else {
        if($id==$data['sub']){
            $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='0'");
            $r_tt=mysqli_fetch_assoc($thongtin);
            if($r_tt['total']>0){
                $hientai=time();
                setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
                $ok=1;
                $thongbao='Đang nhập thành công';
                $tiep=0;
                $html='';
                if($r_tt['dropship']==1){
                    $link='/dropship/';
                }else{
                    $link='/tai-khoan.html';

                }
            }else{
                //$ip_address = $_SERVER['REMOTE_ADDR'];
                //$pass=md5(rand(100000,999999));
                //mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,domain,ngaysinh,cmnd,ngaycap,noicap,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,dropship,ctv,leader,leader_start,code_active,active,chinh_thuc,created,date_update,ip_address,logined,end_online,aff,doitac,nhan_vien,about,nhom,gia_leader)VALUES('','0','0','0','$email','$pass','$name','$avatar','','','','','','','','','','','0','0','0','','','1','0','$hientai','$hientai','$ip_address','','','','','0','','','0')");
                //$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
                //$r_tt=mysqli_fetch_assoc($thongtin);
                //setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
                $tiep=1;
                $html='<div class="desc">Bổ sung thông tin để hoàn thành đăng ký</div>
                        <div class="li_input">
                            <input type="text" name="ho_ten" value="'.$name.'" placeholder="Họ và tên">
                        </div>
                        <div class="li_input">
                            <input type="text" name="email" value="'.$email.'" disable placeholder="Địa chỉ email">
                        </div>
                        <div class="li_input">
                            <input type="text" name="mobile" placeholder="Số điện thoại">
                        </div>
                        <div class="li_input">
                            <input type="password" name="password" placeholder="Mật khẩu đăng nhập">
                        </div>
                        <div class="li_input">
                            <input type="password" name="re_password" placeholder="Xác nhận mật khẩu đăng nhập">
                            <input type="hidden" value="'.$avatar.'" name="avatar">
                        </div>
                        <div class="li_input">
                            <button type="button" class="button_login" name="google_step_2">Đăng Ký</button>
                        </div>
                        <div class="li_input">
                            <div class="text-center">
                                <a href="/dang-nhap.html">Đăng nhập</a> | <a href="/quen-mat-khau.html">Quên mật khẩu?</a>
                            </div>
                        </div>';
                $ok=1;
                $thongbao='Đang nhập thành công';
            }
        }
    }
}
$info=array(
	'ok'=>$ok,
    'tiep'=>$tiep,
    'link'=>$link,
    'html'=>$html,
	'thongbao'=>$thongbao
);
echo json_encode($info);
?>