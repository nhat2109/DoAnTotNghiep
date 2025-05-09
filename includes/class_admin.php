<?php
class class_admin extends class_manage {
    public function token_login($user_id, $password) {
        $token = [
            'user_id' => $user_id,
            'hash' => md5($user_id . $password)
        ];
        return base64_encode(json_encode($token));
    }

    public function token_login_decode($token) {
        if (empty($token)) {
            return json_encode(['user_id' => '']);
        }
        try {
            $decoded = base64_decode($token);
            $data = json_decode($decoded, true);
            if (isset($data['user_id'])) {
                return json_encode(['user_id' => $data['user_id']]);
            }
        } catch (Exception $e) {}
        return json_encode(['user_id' => '']);
    }

    public function check_login($conn, $admin_id) {
        if (!isset($admin_id)) {
            return false;
        }
        
        try {
            $decoded = base64_decode($admin_id);
            $data = json_decode($decoded, true);
            
            if (!isset($data['user_id']) || !isset($data['hash'])) {
                return false;
            }
            
            $user_id = $data['user_id'];
            $hash = $data['hash'];
            
            $result = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id' AND active='1' AND role='admin'");
            if ($user = mysqli_fetch_assoc($result)) {
                return $hash === md5($user_id . $user['password']);
            }
        } catch (Exception $e) {}
        
        return false;
    }

    public function get_admin_info($conn, $admin_id) {
        $tach_token = json_decode($this->token_login_decode($admin_id), true);
        $user_id = $tach_token['user_id'];
        
        $result = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id' AND active='1' AND role='admin'");
        return mysqli_fetch_assoc($result);
    }

    public function load_admin_template($skin, $template, $data = []) {
        return $skin->skin_replace('skin_admin/' . $template, $data);
    }

    public function get_shop_stats($conn, $user_id) {
        $stats = [];
        
        // Total products
        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM sanpham_shop WHERE shop='$user_id'");
        $stats['total_products'] = mysqli_fetch_assoc($result)['total'];
        
        // Total orders
        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM donhang_shop WHERE shop='$user_id'");
        $stats['total_orders'] = mysqli_fetch_assoc($result)['total'];
        
        // Total customers
        $result = mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) as total FROM donhang_shop WHERE shop='$user_id'");
        $stats['total_customers'] = mysqli_fetch_assoc($result)['total'];
        
        return $stats;
    }
}
?>