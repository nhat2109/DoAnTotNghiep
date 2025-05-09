<?php
class class_supership extends class_manage {
  function getLongestSubstring($input, $maxLength = 255) {
      // Tách chuỗi đầu vào thành mảng dựa trên dấu phẩy
      $parts = explode(',', $input);
      
      // Biến chứa kết quả
      $result = '';
      $length = 0;
      
      // Duyệt qua từng phần của chuỗi
      foreach ($parts as $part) {
          $part = trim($part); // Loại bỏ khoảng trắng thừa
          $partLength = strlen($part); // Độ dài của phần hiện tại
          
          // Kiểm tra nếu thêm phần hiện tại vào chuỗi kết quả mà vượt quá maxLength ký tự
          if ($length + $partLength + 1 > $maxLength) {
              break;
          }
          
          // Thêm phần hiện tại vào chuỗi kết quả
          if ($length > 0) {
              $result .= ',';
              $length++;
          }
          $result .= $part;
          $length += $partLength;
      }
      
      return $result;
  }
  function user_supership($conn,$user_id){
    $check=$this->load('class_check');
    $thongtin=mysqli_query($conn,"SELECT * FROM user_supership WHERE user_id='$user_id'");
    $total_row=mysqli_num_rows($thongtin);
    if($total_row>0){
      $row=mysqli_fetch_assoc($thongtin);
      $thongtin_decode=$check->cookie_decode($row['thongtin']);
      $row['thongtin']=$thongtin_decode;
      return $row;
    }else{
      return array('ok'=>0,'thongbao'=>'Tài khoản không tồn tại');
    }
  }
  function register_supership($conn,$user_id,$project, $name, $phone, $email, $password) {
    $check=$this->load('class_check');
    $thongtin=mysqli_query($conn,"SELECT * FROM user_supership WHERE user_id='$user_id'");
    $total_row=mysqli_num_rows($thongtin);
    if($total_row>0){
      $ok=0;
      $thongbao='Tài khoản đã được đăng ký';
    }else{
      $partner="WOsRymNkoU8tRsJwFdNZQd73M8urrlxm4NvAtIvA";
      $url = "https://api.mysupership.vn/v1/partner/auth/register";
      $headers = [
          "Accept: application/json",
          "Content-Type: application/json"
      ];
      $data = [
          "project" => $project,
          "name" => $name,
          "phone" => $phone,
          "email" => $email,
          "password" => $password,
          "partner" => $partner
      ];
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $response = curl_exec($ch);
      if (curl_errno($ch)) {
        $ok=0;
        $thongbao='Lỗi khi đăng ký tài khoản';
      }else{
        $tach_response=json_decode($response,true);
        if($tach_response['status']=='Success'){
          $ok=1;
          $thongbao='Đăng ký tài khoản thành công';
          $token=$tach_response['results']['access_token'];
          $password=$check->cookie_encode($password);
          $results_token=$check->cookie_encode($response);
          mysqli_query($conn,"INSERT INTO user_supership (user_id,email,password,thongtin,date_post) VALUES ('$user_id','$email','$password','$results_token','".time()."')");
        }else{
          $ok=0;
          print_r($tach_response);
          $thongbao='Lỗi khi đăng ký tài khoản';
        }
      }
      curl_close($ch);
      $info=array('ok'=>$ok,'thongbao'=>$thongbao);
      return json_encode($info);
    }
  }
	function connect_api($user_id,$username,$password) {
    $client_id="34";
    $client_secret="HEBbW7mYhqipZqbwnsE6XSgj624dL9BkcnZuhRHu";
    $partner="WOsRymNkoU8tRsJwFdNZQd73M8urrlxm4NvAtIvA";
    $log_token = './log_supership/'.$user_id.'.txt';
    if(file_exists($log_token)){
      $log_token_text = file_get_contents($log_token);
      $tach_token=json_decode($log_token_text,true);
      $expires_in=$tach_token['results']['expires_in'];
      $file_time=filemtime($log_token);
      if($expires_in>time() - $file_time){
        $access_token=$tach_token['results']['access_token'];
        return $access_token;
      }else{
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.mysupership.vn/v1/partner/auth/login');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        $headers = array(
            'Content-Type: application/json'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = array(
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "username" => $username,
            "password" => $password,
            "partner" => $partner
  
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          return false;
        } else {
          $fh = fopen($log_token, "w");
          fwrite($fh, $response);
          fclose($fh);
          $tach_response=json_decode($response,true);
          return $tach_response['results']['access_token'];
        }
      }
    }else{
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://api.mysupership.vn/v1/partner/auth/login');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_ENCODING, '');
      curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
      curl_setopt($curl, CURLOPT_TIMEOUT, 0);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
      $headers = array(
          'Content-Type: application/json'
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      $data = array(
          "client_id" => $client_id,
          "client_secret" => $client_secret,
          "username" => $username,
          "password" => $password,
          "partner" => $partner

      );
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return false;
      } else {
        $fh = fopen($log_token, "w");
        fwrite($fh, $response);
        fclose($fh);
        $tach_response=json_decode($response,true);
        return $tach_response['results']['access_token'];
      }
    }
	}
  function get_tinh(){
    $link='https://api.mysupership.vn/v1/partner/areas/province'; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array(
      'Content-Type: application/json'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
  function get_huyen($tinh){
    $link='https://api.mysupership.vn/v1/partner/areas/district?province='.$tinh; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array(
      'Content-Type: application/json'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
  function get_xa($huyen){
    $link='https://api.mysupership.vn/v1/partner/areas/commune?district='.$huyen; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array(
      'Content-Type: application/json'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
  function get_tax($sender_province,$sender_district,$receiver_province,$receiver_district,$weight,$amount,$accessToken){
    if($accessToken!=''){

    }else{
      $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUxNjY5YzJiNTVlMzA0MWVhNTdiNmI1YzQ2ODVlZGM5ZTM0YTcwYmM1OWMyMWRmZTk3NGE2NTdlYTNlMDk1YWM5MzM2ZDc0NGMyZGY2YWY0In0.eyJhdWQiOiIxIiwianRpIjoiNTE2NjljMmI1NWUzMDQxZWE1N2I2YjVjNDY4NWVkYzllMzRhNzBiYzU5YzIxZGZlOTc0YTY1N2VhM2UwOTVhYzkzMzZkNzQ0YzJkZjZhZjQiLCJpYXQiOjE3MjY2MzE4NTksIm5iZiI6MTcyNjYzMTg1OSwiZXhwIjoxNzU4MTY3ODU5LCJzdWIiOiIxMjc1MyIsInNjb3BlcyI6W119.eCRdByLdEXpz8XyhCOl2Mv50OV1f6PKWz_hCkrbOPXcjES7voj_wl3vZUoW5pH3AnT_oQn3HuMlm1Ifx1fldpsrT3qW9m3pTDDjNKBd0jSR1OWREeGqX8HtA8rfILOTe1EjmvynkgtOJVfq5_3H4qqyadKC6dmNjenU-ljfhGpXAsQd2FsW7SNmSoCRvtGvHQS80oB0ZFx-5VtBNFygvDq-9yXjPYVxmNPGC9mJZeyFRtpCX5j4nAaeeMm5QlPWBzdfRSy_hogD03HraEPw9MWMo5A0JpZjijtzrxfiTQ03Xemp3X_aVsvCeN82NfCkVzAiQPkrBFhL4dJlVn3-wbZCy9FUF83eOSroEGjKTm1nIV3hLm1cfgxg_EC-1YihrTrDFbCgfYJAgYSt1fZWNiu-5Tk0BsMqH7_TsSY_X66KZII-HKFlMV_GajxSqL8gVd9fJhViRDRuln354dtK0ky6X0TixiE0ks2Qu9IimE5ZYYart2KLYU6BrNeYj_qzJsiJMyZMpD1uMg5xNp2R3eL41BFqLLVcxaVnbx_MzwiCEtcSQR-Cpxo3tFlCC_k7P-JNp4pCbjEjdjSeyve73zK5AK6uWyqhzgZpJtBeNXKT4Kcm4rX0AtN3o8e32TQSBwXqWxlCh5KcY2ejjwUgqM_sOjbZdM2ldeaPjoSTIMjw';
    }
    $url = "https://api.mysupership.vn/v1/partner/orders/price?" . http_build_query([
      'sender_province'   => $sender_province,
      'sender_district'   => $sender_district,
      'receiver_province' => $receiver_province,
      'receiver_district' => $receiver_district,
      'weight'            => $weight,
      'value'             => $amount,
    ]);
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Authorization: Bearer " . $accessToken,
        ],
    ]);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return ['error' => true, 'message' => $error];
    }
    curl_close($curl);
    return json_decode($response, true); // Trả về mảng kết quả 
  }
  function tao_don($orderData,$accessToken) {
    $headers = [
        'Accept: application/json',
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];
    // Sử dụng tham số $orderData đã được truyền vào hàm thay vì ghi đè
    // Nếu $orderData không có sẵn, sử dụng giá trị mặc định
    if (empty($orderData)) {
      $orderData = [
        "pickup_phone" => "0989999999",
        "pickup_address" => "45 Nguyễn Chí Thanh",
        "pickup_commune" => "Phường Ngọc Khánh",
        "pickup_district" => "Quận Ba Đình",
        "pickup_province" => "Thành phố Hà Nội",
        "name" => "Trương Thế Ngọc",
        "phone" => "0945900350",
        "email" => null,
        "address" => "35 Trương Định",
        "province" => "Thành phố Hồ Chí Minh",
        "district" => "Quận 3",
        "commune" => "Phường 6",
        "amount" => "220000",
        "value" => null,
        "weight" => "200",
        "payer" => "1",
        "service" => "1",
        "config" => "1",
        "soc" => "KAN7453535",
        "note" => "Giao giờ hành chính",
        "product_type" => "2",
        "products" => [
          [
            "sku" => "P899234",
            "name" => "Tên Sản Phẩm 1",
            "price" => 200000,
            "weight" => 200,
            "quantity" => 1,
          ],
          [
            "sku" => "P899789",
            "name" => "Tên Sản Phẩm 2",
            "price" => 250000,
            "weight" => 300,
            "quantity" => 2,
          ]
        ]
      ];
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return [
            'success' => false,
            'error' => curl_error($ch),
        ];
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'success' => $httpCode === 200,
        'status_code' => $httpCode,
        'response' => json_decode($response, true),
    ];
  }
  function huy_don($orderCode,$accessToken) {

    // Initialize cURL session
    // $accessToken là token của bạn
    // $orderCode là mã đơn hàng
    $ch = curl_init();
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, "https://api.mysupership.vn/v1/partner/orders/cancel");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    // Set headers
    $headers = [
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // Set POST data
    $data = json_encode([
        "code" => $orderCode
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    // Execute the cURL request
    $response = curl_exec($ch);
    // Check if the request was successful
    if(curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        // Return the response from the server
        return $response;
    }
    // Close the cURL session
    curl_close($ch);
  }
  function list_status() {
    $url = 'https://api.mysupership.vn/v1/partner/orders/status';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Trả về nội dung thay vì xuất ra
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");   // Phương thức GET (mặc định là GET nhưng để rõ ràng)
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
  }
  function order_info($code, $type, $accessToken) {
    // $code là mã đơn hàng
    // $type là loại đơn hàng: 1 là mã đơn trên supership, 2 là mã đơn trên sóc đỏ
    // $accessToken là token của bạn
    $url = 'https://api.mysupership.vn/v1/partner/orders/info';
    $query = http_build_query([
        'code' => $code,
        'type' => $type
    ]);
    $fullUrl = $url . '?' . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
  }
  function token_print($codes,$accessToken) {
    // $codes là mã đơn hàng trên supership
    // $accessToken là token của bạn
    $url = 'https://api.mysupership.vn/v1/partner/orders/token';
    $payload = json_encode([
        'code' => $codes
    ]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
  }
  function create_print($size = 'A5',$token_print) {
    // $token là token của bạn  
    // $size là khổ giấy:
    // - Khổ giấy A5: A5
    // - Khổ giấy K46: K46
    // - Khổ giấy T2: T2
    // - Khổ giấy K50: K50
    // - Khổ giấy K75: K75
    // - Khổ giấy K80: K80
    $url = 'https://api.mysupership.vn/v1/partner/orders/label';
    $query = http_build_query([
        'token' => $token_print,
        'size' => $size
    ]);
    $fullUrl = $url . '?' . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
  }  
}
?>
