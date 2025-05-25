<?php

$thaythe['title'] = 'Link tuyển dụng thành viên';
$thaythe['title_action'] = 'Link tuyển dụng thành viên';
$limit = 10;
$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);

$tien_kh = 200000; // Số tiền nhận được khi tuyển dụng thành viên
$date_post = time();
$truoc = 0;
$sau = 0;
$noidung = "Tuyển dụng thành viên thành công";

// 1️⃣ **Lấy danh sách user hợp lệ trong user_kh có aff = $user_id và chưa được cộng tiền**
$thongtin_tuyendung = $conn->query("
    SELECT DISTINCT u.user_id 
    FROM user_info u
    JOIN user_kh kh ON u.user_id = kh.user_id
    WHERE u.aff = '$user_id'
    AND kh.da_cong_tien = 0 -- Kiểm tra xem đã cộng tiền chưa
");

$activated_users = [];
while ($row = $thongtin_tuyendung->fetch_assoc()) {
    $activated_users[] = $row['user_id'];
}

// 2️⃣ **Cộng tiền nếu có user hợp lệ**
$total_bonus = count($activated_users) * $tien_kh;

if ($total_bonus > 0) {
    // 3️⃣ **Cập nhật tiền vào tài khoản của $user_id**
    $conn->query("UPDATE user_info SET user_money = user_money + $total_bonus WHERE user_id = '$user_id'");

    // 4️⃣ **Đánh dấu đã cộng tiền và lưu lịch sử giao dịch**
    foreach ($activated_users as $tuyendung_id) {
        // Đánh dấu đã cộng tiền trong user_kh
        $conn->query("UPDATE user_kh SET da_cong_tien = 1 WHERE user_id = '$tuyendung_id'");

        // Lưu lịch sử giao dịch
        $conn->query("INSERT INTO lichsu_chitieu (user_id, sotien, truoc, sau, noidung, date_post)
                      VALUES ('$user_id', '$tien_kh', '$truoc', '$sau', '$noidung', '$date_post')");
    }
}

// **Lấy lại thông tin người dùng sau khi cập nhật tiền**
$user_info = $conn->query("SELECT user_money FROM user_info WHERE user_id = '$user_id'")->fetch_assoc();

// **Tính tổng số tiền đã cộng từ trước đến nay**
$thongtin_tuyendung_bonus = $conn->query("
    SELECT COUNT(DISTINCT u.user_id) AS total 
    FROM user_info u
    JOIN user_kh kh ON u.user_id = kh.user_id
    WHERE u.aff = '$user_id'
");
$total_bonus_fix = $thongtin_tuyendung_bonus->fetch_assoc()['total'] * $tien_kh;

// **Tính tổng số thành viên**
$thongke = $conn->query("SELECT count(*) AS total FROM user_info WHERE aff='$user_id'");
$r_tk = $thongke->fetch_assoc();
$total_page = ceil($r_tk['total'] / $limit);

// **Gán dữ liệu để hiển thị**
$bien = array(
    'tong_tien' => number_format($total_bonus_fix),
    'user_money' => number_format($user_info['user_money']),
    'user_id' => $user_id,
    'link_tuyendung' => 'https://socdo.vn/dangky-banhang.html?affgroup=' . $user_id,
    'list_thanhvien' => $class_index->list_thanhvien_nhom($conn, $user_id, $page, $limit),
    'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-tuyendung-nhom'),
);

$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_tuyendung_nhom', $bien);
?>