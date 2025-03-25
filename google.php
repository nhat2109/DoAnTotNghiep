<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$page=intval($page);
if($page>1){
  $page=$page;
  $title_page=' - Page '.$page;
}else{
  $page=1;
  $title_page='';
}
$sort=addslashes($url_query['sort']);
function token_login($user_id,$password){
    $pass_1=substr($password, 0,8);
    $pass_2=substr($password, 8,8);
    $pass_3=substr($password, 16,8);
    $pass_4=substr($password, 24,8);
    $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
    $token_login=base64_encode($string);
    return $token_login;
}
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
  $index_setting[$r_s['name']]=$r_s['value'];
}
$limit=48;
if(isset($_COOKIE['user_id'])){
  $thongbao="Bạn hiện đã đăng nhập.";
  $replace=array(
    'title'=>'Bạn đã đăng nhập tài khoản',
    'thongbao'=>$thongbao,
    'link'=>'/tai-khoan.html'
  );
  echo $skin->skin_replace('skin/chuyenhuong',$replace);
  exit();
}else{
  require_once ('openid/libraries/Google/autoload.php');
  $client_id = '174528238670-pjvcs3qs0609ue8oirnbr85q6o52kq38.apps.googleusercontent.com'; 
  $client_secret = 'mDMp4QQyMH4TWVxy_hXgQO7K';
  $redirect_uri = 'https://socmoi.vn/google.php';
  if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
  }
  $client = new Google_Client();
  $client->setClientId($client_id);
  $client->setClientSecret($client_secret);
  $client->setRedirectUri($redirect_uri);
  $client->addScope("email");
  $client->addScope("profile");
  $service = new Google_Service_Oauth2($client);  
  if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $link_chuyen=filter_var($redirect_uri, FILTER_SANITIZE_URL);
    $thongbao="Bạn hiện đã đăng nhập.";
    $replace=array(
      'title'=>'Bạn đã đăng nhập tài khoản',
      'thongbao'=>$thongbao,
      'link'=>'/'
    );
    echo $skin->skin_replace('skin/chuyenhuong',$replace);
  }else{
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
    } else {
      $authUrl = $client->createAuthUrl();
    }
    if (isset($authUrl)){ 
      $thongbao="Hệ thống đang chuyển hướng.";
      $replace=array(
        'title'=>'Hệ thống đang chuyển hướng',
        'thongbao'=>$thongbao,
        'link'=>$authUrl
      );
      echo $skin->skin_replace('skin/chuyenhuong',$replace);
    } else {
      $info = $service->userinfo->get();
      $id= $info['id'];
      $ho_ten=$info['name'];
      $email=$info['email'];
      print_r($info);
      echo 'xxx';
      exit();
      $code_active=$check->random_string(10);
      $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
      $total=mysqli_num_rows($thongtin);
      $hientai=time();
      $ip_address = $_SERVER['REMOTE_ADDR'];
      if($total==0){
        $pass=md5(rand(100000,999999));
        mysqli_query($conn, "INSERT INTO user_info(username,shop,user_money,user_money2,email,password,name,avatar,mobile,domain,ngaysinh,cmnd,ngaycap,noicap,dia_chi,maso_thue,maso_thue_cap,maso_thue_noicap,dropship,ctv,leader,leader_start,code_active,active,chinh_thuc,created,date_update,ip_address,logined,end_online,aff,doitac,nhan_vien,about,nhom,gia_leader)VALUES('','0','0','0','$email','$pass','$ho_ten','','','$domain','$ngaysinh','$cmnd','$ngaycap','$noicap','$dia_chi','$maso_thue','$maso_thue_cap','$maso_thue_noicap','0','0','0','','','1','0','$hientai','$hientai','$ip_address','','','$aff','$doitac','0','','$nhom','0')");
        $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
        $r_tt=mysqli_fetch_assoc($thongtin);
        setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
      }else{
        $r_tt=mysqli_fetch_assoc($thongtin);
        setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
      }
    $thongbao="Đang chuyển hướng.";
    $replace=array(
      'title'=>'Đang chuyển hướng',
      'thongbao'=>$thongbao,
      'link'=>'/'
    );
    echo $skin->skin_replace('skin/chuyenhuong',$replace);
    }
  }
}
?>