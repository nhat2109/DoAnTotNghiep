<?php
  session_start();
  include('../includes/tlca_world.php');
  $check=$tlca_do->load('class_check');
  $class_index=$tlca_do->load('class_mem_panel');
  $param_url = parse_url($_SERVER['REQUEST_URI']);
  parse_str($param_url['query'], $url_query);
  $page=addslashes($url_query['page']);
  $skin=$tlca_do->load('class_skin_cpanel');
  if(intval($page)<1){
    $page=1;
  }else{
    $page=intval($page);
  }
  $user_id=$_COOKIE['user_id'];
  $class_member=$tlca_do->load('class_member');
  $user_info=$class_member->user_info($conn,$user_id);
  require_once ('libraries/Google/autoload.php');
  if(isset($_COOKIE['user_id'])){
    $thongbao="Bạn đã đăng nhập.<br>Đang chuyển hướng tới trang chủ...";
    $replace=array(
      'title'=>'Bạn đã đăng nhập...',
      'description'=>$index_setting['description'],
      'thongbao'=>$thongbao,
      'link_chuyen'=>'/'
    );
    echo $skin->skin_replace('skin_members/chuyenhuong',$replace);
  }else{
    $client_id = '657949797109-r8ai20v5175hmm5co1ga027piapneud6.apps.googleusercontent.com'; 
    $client_secret = 'BfC0ESQ-uhZMzaqKEDuBAFVa';
    $redirect_uri = 'https://yesmart.vn/openid/google.php';
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
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
      exit;
    }
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
    } else {
      $authUrl = $client->createAuthUrl();
    }
    if (isset($authUrl)){ 
      //show login url
        header('Location: ' . $authUrl);
        exit;
    } else {
      
      $info = $service->userinfo->get(); //get user info
      //$id= $info['id'];
      $ho_ten=$info['name'];
      $email=$info['email'];
      $avatar=$info['picture'];
      $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE email='$email'");
      $r_tt=mysqli_fetch_assoc($thongtin);
      if($r_tt['total']>0){
        setcookie("user_id",$r_tt['user_id'],time() + 31536000,'/');
        $thongbao="Đăng nhập thành công.<br>Đang chuyển hướng tới trang chủ...";
        $replace=array(
          'title'=>'Đăng nhập thành công...',
          'description'=>$index_setting['description'],
          'thongbao'=>$thongbao,
          'link_chuyen'=>'/'
        );
        echo $skin->skin_replace('skin_members/chuyenhuong',$replace);
      }else{
        $pass=md5($check->random_string(6));
        $code_active=$check->random_string(10);
        mysqli_query($conn,"INSERT INTO user_info (ho_ten,password,dien_thoai,avatar,email,id_fb,date_reg,user_money,code_active,kich_hoat)VALUES('$ho_ten','$pass','','$avatar','$email','',".time().",'0','$code_active','1')");
        $thongtin_moi=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
        $r_m=mysqli_fetch_assoc($thongtin_moi);
        setcookie("user_id",$r_m['user_id'],time() + 31536000,'/');
        $thongbao="Đăng nhập thành công.<br>Đang chuyển hướng tới trang chủ...";
        $replace=array(
          'title'=>'Đăng nhập thành công...',
          'description'=>$index_setting['description'],
          'thongbao'=>$thongbao,
          'link_chuyen'=>'/'
        );
        echo $skin->skin_replace('skin_members/chuyenhuong',$replace);

      }
    }

  }
?>

