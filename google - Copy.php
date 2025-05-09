<?php
require_once ('openid/libraries/Google/autoload.php');
if(isset($_COOKIE['user_id'])){
    $thongbao="Bạn đã đăng nhập.";
    $replace=array(
      'header'=>$skin->skin_normal($s.'/tpl/header'),
      'box_header'=>$skin->skin_normal($s.'/tpl/box_header'),
      'box_slide'=>$skin->skin_normal($s.'/tpl/box_slide'),
      'box_login_right'=>$box_login_right,
      'dieuhuong'=>$skin->skin_normal($s.'/tpl/dieuhuong'),
      'home-block-other'=>$skin->skin_normal($s.'/tpl/home-block-other'),
      'footer'=>$skin->skin_normal($s.'/tpl/footer'),
      'script_footer'=>$skin->skin_normal($s.'/tpl/script_footer'),
      'title'=>'Đang chuyển hướng',
      'thongbao'=>$thongbao,
      'link_chuyen'=>'/'
    );
    echo $skin->skin_replace($s.'/tpl/chuyenhuong',$replace);
}else{
  $client_id = '174528238670-pjvcs3qs0609ue8oirnbr85q6o52kq38.apps.googleusercontent.com'; 
  $client_secret = 'mDMp4QQyMH4TWVxy_hXgQO7K';
  $redirect_uri = 'http://shop.vn/google.php';
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
    $thongbao="Bạn đã đăng nhập.";
    $replace=array(
      'header'=>$skin->skin_normal($s.'/tpl/header'),
      'box_header'=>$skin->skin_normal($s.'/tpl/box_header'),
      'box_slide'=>$skin->skin_normal($s.'/tpl/box_slide'),
      'box_login_right'=>$box_login_right,
      'dieuhuong'=>$skin->skin_normal($s.'/tpl/dieuhuong'),
      'home-block-other'=>$skin->skin_normal($s.'/tpl/home-block-other'),
      'footer'=>$skin->skin_normal($s.'/tpl/footer'),
      'script_footer'=>$skin->skin_normal($s.'/tpl/script_footer'),
      'title'=>'Đang chuyển hướng',
      'thongbao'=>$thongbao,
      'link_chuyen'=>$link_chuyens
    );
    echo $skin->skin_replace($s.'/tpl/chuyenhuong',$replace);
  }else{
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
    } else {
      $authUrl = $client->createAuthUrl();
    }
    if (isset($authUrl)){ 
        $thongbao="Đang chuyển hướng.";
        $replace=array(
          'header'=>$skin->skin_normal($s.'/tpl/header'),
          'box_header'=>$skin->skin_normal($s.'/tpl/box_header'),
          'box_slide'=>$skin->skin_normal($s.'/tpl/box_slide'),
          'box_login_right'=>$box_login_right,
          'dieuhuong'=>$skin->skin_normal($s.'/tpl/dieuhuong'),
          'home-block-other'=>$skin->skin_normal($s.'/tpl/home-block-other'),
          'footer'=>$skin->skin_normal($s.'/tpl/footer'),
          'script_footer'=>$skin->skin_normal($s.'/tpl/script_footer'),
          'title'=>'Đang chuyển hướng',
          'thongbao'=>$thongbao,
          'link_chuyen'=>$authUrl
        );
        echo $skin->skin_replace($s.'/tpl/chuyenhuong',$replace);
    } else {
      
      $info = $service->userinfo->get();
      $id= $info['id'];
      $ho_ten=$info['name'];
      $email=$info['email'];
      $code_active=$check->random_string(10);
      $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
      $total=mysqli_num_rows($thongtin);
      if($total==0){
          mysqli_query($conn,"INSERT INTO user_info (ho_ten,password,avatar,dien_thoai,email,date_reg,user_money,code_active,kich_hoat)VALUES('$ho_ten','$pass','','','$email',".time().",'0','$code_active','1')");
          $class_member->openid_login($conn,$email,'on');
      }else{
          $class_member->openid_login($conn,$email,'on');
      }
      $thongbao="Đang chuyển hướng.";
      $replace=array(
        'header'=>$skin->skin_normal($s.'/tpl/header'),
        'box_header'=>$skin->skin_normal($s.'/tpl/box_header'),
        'box_slide'=>$skin->skin_normal($s.'/tpl/box_slide'),
        'box_login_right'=>$box_login_right,
        'dieuhuong'=>$skin->skin_normal($s.'/tpl/dieuhuong'),
        'home-block-other'=>$skin->skin_normal($s.'/tpl/home-block-other'),
        'footer'=>$skin->skin_normal($s.'/tpl/footer'),
        'script_footer'=>$skin->skin_normal($s.'/tpl/script_footer'),
        'title'=>'Đang chuyển hướng',
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/'
      );
      echo $skin->skin_replace($s.'/tpl/chuyenhuong',$replace);
    }

  }
}
?>

