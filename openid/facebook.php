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
        $app_id = "715707815532165";
        $app_secret = "8584240179b6181b31577d7b4a3867fa";
        $redirect_uri = urlencode("https://yesmart.vn/openid/facebook.php");  
        $code = $_GET['code'];  
        // Get code value
        if($code==''){
            $link='https://www.facebook.com/dialog/oauth?client_id=715707815532165&redirect_uri=https://yesmart.vn/openid/facebook.php&scope=public_profile,email';
            header('Location: ' . $link);
        }else{
            // Get access token info
            $facebook_access_token_uri = "https://graph.facebook.com/v2.8/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";    
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $facebook_access_token_uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            $response = curl_exec($ch); 
            curl_close($ch);
            // Get access token
            $aResponse = json_decode($response);
            $access_token = $aResponse->access_token;
            // Get user infomation
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?fields=id,name,email&access_token=$access_token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            $response = curl_exec($ch); 
            curl_close($ch);
            $info=json_decode($response,true);
            $id= $info['id'];
            $ho_ten=$info['name'];
            $email=$info['email'];
            $avatar='https://graph.facebook.com/'.$id.'/picture?type=large';
            $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE id_fb='$id'");
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
                if(strlen($email)>5){
                    $thongtin_email=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE email='$email'");
                    $r_e=mysqli_fetch_assoc($thongtin_email);
                    if($r_e['total']>0){
                        setcookie("user_id",$r_e['user_id'],time() + 31536000,'/');
                        mysqli_query($conn,"UPDATE user_info SET id_fb='$id' WHERE email='$email'");
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
                        mysqli_query($conn,"INSERT INTO user_info (ho_ten,password,dien_thoai,avatar,email,id_fb,date_reg,user_money,code_active,kich_hoat)VALUES('$ho_ten','$pass','','$avatar','$email','$id',".time().",'0','$code_active','1')");
                        $thongtin_moi=mysqli_query($conn,"SELECT * FROM user_info WHERE id_fb='$id'");
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
                }else{
                    $pass=md5($check->random_string(6));
                    $code_active=$check->random_string(10);
                    mysqli_query($conn,"INSERT INTO user_info (ho_ten,password,dien_thoai,avatar,email,id_fb,date_reg,user_money,code_active,kich_hoat)VALUES('$ho_ten','$pass','','$avatar','$email','$id',".time().",'0','$code_active','1')");
                    $thongtin_moi=mysqli_query($conn,"SELECT * FROM user_info WHERE id_fb='$id'");
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

    }

?>