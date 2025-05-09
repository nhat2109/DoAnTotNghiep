<?php
$thaythe['title'] = 'Quản lý địa chỉ';
$thaythe['title_action'] = 'Quản lý địa chỉ';

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Get user's addresses
$user_id = $tach_token['user_id'];
$sql = "SELECT t.*, p.tieu_de as province_name, d.tieu_de as district_name, w.tieu_de as ward_name 
        FROM transport t
        LEFT JOIN tinh_moi p ON t.province = p.id 
        LEFT JOIN huyen_moi d ON t.district = d.id
        LEFT JOIN xa_moi w ON t.ward = w.id
        WHERE t.user_id = ? 
        ORDER BY t.is_default DESC, t.id DESC";

// Sử dụng prepared statement để bảo mật
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$address_list = '';
while ($row = mysqli_fetch_assoc($result)) {
    $default_badge = $row['is_default'] ? '<span class="default_badge">Mặc định</span>' : '';
    $pickup_badge = $row['is_pickup'] ? '<span class="pickup_badge">Lấy hàng</span>' : '';
    $return_badge = $row['is_return'] ? '<span class="return_badge">Trả hàng</span>' : '';
    $default_class = $row['is_default'] ? ' default' : '';

    $address_list .= '
    <div class="address_item' . $default_class . '" id="address_' . $row['id'] . '">
        <div class="address_info">
            <div class="name_phone">
                <strong>' . htmlspecialchars($row['fullname']) . '</strong>' . $default_badge . $pickup_badge . $return_badge . '
                <span class="phone">' . htmlspecialchars($row['mobile']) . '</span>
            </div>
            <div class="address">
                ' . htmlspecialchars($row['address_detail']) . '<br>
                ' . htmlspecialchars($row['ward_name']) . ', ' . htmlspecialchars($row['district_name']) . ', ' . htmlspecialchars($row['province_name']) . '
            </div>
        </div>
        <div class="address_actions">
            <button class="button_all" onclick="showEditAddressModal(' . $row['id'] . ')">Sửa</button>
            ' . (!$row['is_default'] ? '<button href="javascript:;"  class="button_all" class="del" onclick="confirm_del(\'del\', \'transport\', \'Xác nhận địa chỉ giao nhận\', ' . $row['id'] . ');;" >Xóa</button>' : '') . '
        </div>
    </div>';
}
// <a href="/ncc/edit-brand?id={id}" class="edit">Sửa</a><a href="javascript:;" onclick="confirm_del('del','brand', 'Xác nhận xóa thương hiệu', '{id}');;" class="del">xóa</a>

//onclick="deleteAddress(' . $row['id'] . ')"
$thaythe['address_list'] = $address_list;

// Get province options
$thaythe['option_tinh'] = $class_index->list_option_tinh($conn, $user_info['tinh']);
$thaythe['option_huyen'] = $class_index->list_option_huyen($conn, $user_info['tinh'], $user_info['huyen']);
$thaythe['option_xa'] = $class_index->list_option_xa($conn, $user_info['huyen'], $user_info['xa']);

$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/transport', $thaythe);

// Add Google Maps API if needed
$thaythe['header_js'] = '
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>';
?>