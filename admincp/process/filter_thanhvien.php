<?php
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$fixed_date = strtotime('2025-03-15'); // Thời gian cố định 10/3/2025
$current_date = strtotime(date('Y-m-d')); // Ngày hiện tại
$where = [];
if ($status != '') {
    if ($status == 'active') {
        $where[] = "dropship IN (1, 2, 4)"; // Lọc các giá trị 1, 2, 4
    } else if ($status == 'inactive') {
        $where[] = "dropship = 0"; // Lọc giá trị 0
    }
}

if ($start_date && $end_date) {
    $start_timestamp = DateTime::createFromFormat('d/m/Y', $start_date)->getTimestamp();
    $end_timestamp = DateTime::createFromFormat('d/m/Y', $end_date)->getTimestamp();
    $where[] = "created BETWEEN $start_timestamp AND $end_timestamp";
}
$where_sql = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";

$thongtin = mysqli_query($conn, "SELECT * FROM user_info $where_sql ORDER BY user_id DESC");
$list = '';
$i = 0;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $i++;
    $r_tt['i'] = $i;
// Xử lý thông tin quản lý
        if ($r_tt['aff'] > 0) {
            $thongtin_quanly = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['aff']}'");
            $r_ql = mysqli_fetch_assoc($thongtin_quanly);
            $r_tt['nguoi_quanly'] = $r_ql['name'];
        } else {
            $r_tt['nguoi_quanly'] = '<button class="show_quanly" user_id="' . $r_tt['user_id'] . '">Thêm quản lý</button>';
        }

        // Xử lý các trường khác
        $r_tt['leader'] = ($r_tt['leader'] == 1) ? 'Có' : 'Không';
        $r_tt['user_money'] = number_format($r_tt['user_money']);
        $r_tt['user_donate'] = number_format($r_tt['user_donate']);
        $r_tt['sodu'] = number_format($r_tt['user_money'] + $r_tt['user_money2']);
        $r_tt['user_money2'] = number_format($r_tt['user_money2']);
        $r_tt['created'] = date('d/m/Y', $r_tt['created']);

        // Xử lý nút "Thêm HOT"
        if ($r_tt['dropship'] == 0) {
            $r_tt['add_hot'] = $r_tt['status_cre'] == 0 ? '' : '';
        } else {
            $r_tt['add_hot'] = $r_tt['status_cre'] == 1 
                ? '<button class="btn btn-danger da_themhot">Đã thêm HOT</button>' 
                : '<button class="btn btn-success add_hot">Thêm HOT</button>';
        }

        // Xử lý trạng thái tài khoản
        if ($r_tt['active'] == 2) {
            $r_tt['tinh_trang'] = 'Tạm khóa';
        } else if ($r_tt['active'] == 3) {
            $r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
        }

        // Xử lý trạng thái dropship
        if ($r_tt['dropship'] == 0) {
            $r_tt['tinh_trang'] = 'Mua hàng';
        } else {
            // Chuyển đổi created từ d/m/Y sang timestamp
            $created_date_str = str_replace('/', '-', $r_tt['created']); // Đổi sang định dạng Y-m-d
            $created_date = strtotime($created_date_str); // Chuyển thành timestamp

            $thongtin_userkh = mysqli_query($conn, "SELECT COUNT(*) as count FROM user_kh WHERE user_id='{$r_tt['user_id']}'");
            $r_ttkh = mysqli_fetch_assoc($thongtin_userkh);

            // Kiểm tra điều kiện "Đã duyệt" (dropship = 1)
            if ($r_ttkh['count'] > 0 || $r_tt['leader'] == "Có" || $r_tt['nhan_vien'] == 1) {
                $r_tt['dropship'] = 1; // Đã duyệt
            } else {
                // Trường hợp 1: Nếu created_date < fixed_date
                if ($created_date < $fixed_date) {
                    $expiration_date = strtotime("+15 days", $fixed_date); // 15 ngày từ fixed_date
                } else {
                    // Trường hợp 2: Nếu created_date >= fixed_date
                    $expiration_date = strtotime("+15 days", $created_date); // 15 ngày từ created_date
                }

                // Kiểm tra trạng thái dùng thử hoặc tạm khóa
                if ($current_date <= $expiration_date) {
                    $r_tt['dropship'] = 2; // Dùng thử
                } else {
                    $r_tt['dropship'] = 4; // Tạm khóa
                    mysqli_query($conn, "UPDATE user_info SET dropship = 4 WHERE user_id='{$r_tt['user_id']}'");
                }
            }

            // Hiển thị radio button theo trạng thái
            $r_tt['tinh_trang'] = '
                <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2" ' . ($r_tt['dropship'] == 2 ? 'checked' : '') . '> Dùng thử 
                <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="1" ' . ($r_tt['dropship'] == 1 ? 'checked' : '') . '> Kích hoạt
                <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="4" ' . ($r_tt['dropship'] == 4 ? 'checked' : '') . '> Tạm khóa';
        }
    $list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
}
mysqli_free_result($thongtin);
if ($i == 0) {
    $list = '<center>Không có kết quả</center>';
}
$list = '<tr>
           <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
<!--                     <th style="text-align: left;">ID</th> -->
                <th style="text-align: left;">Họ tên</th>
                <th style="text-align: left;" class="hide_mobile">Tài khoản</th>
                <th style="text-align: left;" class="hide_mobile">Chuyên nghiệp</th>
                <th style="text-align: left;" class="hide_mobile">Người quản lý</th>
                <th style="text-align: center;" class="hide_mobile">THÊM HOT</th>
                <th style="text-align: center;" class="hide_mobile">Ngày đăng ký</th>
                <th style="text-align: center;" class="hide_mobile">Điện thoại</th>
                <th style="text-align: center;" class="hide_mobile">Email</th>
                <th style="text-align: center;" class="hide_mobile">TK chính</th>
            <th style="text-align: center;" class="hide_mobile">TK Khuyến mại</th>
                <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
        </tr>' . $list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
?>