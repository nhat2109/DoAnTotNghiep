<?php
$thaythe['title'] = 'Quản lý tài khoản ngân hàng';
$thaythe['title_action'] = 'Quản lý tài khoản ngân hàng';

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Get user's bank accounts with full details
$user_id = $tach_token['user_id'];
$sql = "SELECT ba.*, b.code as bank_code, b.name as bank_name, b.logo as bank_logo,
        bb.code as branch_code, bb.name as branch_name, bb.address as branch_address,
        t.tieu_de as province_name
        FROM bank_accounts ba
        LEFT JOIN banks b ON ba.bank_id = b.id
        LEFT JOIN bank_branches bb ON ba.branch_id = bb.id
        LEFT JOIN tinh_moi t ON bb.province_id = t.id
        WHERE ba.user_id = ? 
        ORDER BY ba.is_default DESC, ba.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$bank_account_list = '';
while ($row = mysqli_fetch_assoc($result)) {
    $default_badge = $row['is_default'] ? '<span class="default_badge">Mặc định</span>' : '';
    $default_class = $row['is_default'] ? ' default' : '';
    $bank_logo = $row['bank_logo'] ? '<img src="' . htmlspecialchars($row['bank_logo']) . '" alt="' . htmlspecialchars($row['bank_name']) . '" class="bank_logo">' : '';
    
    $bank_account_list .= '
    <div class="bank_item' . $default_class . '" id="bank_' . $row['id'] . '">
        <div class="bank_info">
            <div class="bank_header">
                ' . $bank_logo . '
                <div class="bank_details">
                    <div class="bank_name">
                        <strong>' . htmlspecialchars($row['bank_name']) . '</strong>
                        <span class="bank_code">(' . htmlspecialchars($row['bank_code']) . ')</span>
                        ' . $default_badge . '
                    </div>
                    <div class="branch_info">
                        Chi nhánh: <span class="branch_name">' . htmlspecialchars($row['branch_name']) . '</span>
                        ' . ($row['province_name'] ? ' - <span class="province_name">' . htmlspecialchars($row['province_name']) . '</span>' : '') . '
                        <div class="branch_address">' . htmlspecialchars($row['branch_address']) . '</div>
                    </div>
                </div>
            </div>
            <div class="account_info">
                <div class="account_holder">
                    <span class="label">Chủ tài khoản:</span>
                    <span class="value">' . htmlspecialchars($row['account_holder']) . '</span>
                </div>
                <div class="account_number">
                    <span class="label">Số tài khoản:</span>
                    <span class="value">' . htmlspecialchars($row['account_number']) . '</span>
                </div>
                <div class="id_number">
                    <span class="label">CMND/CCCD:</span>
                    <span class="value">' . htmlspecialchars($row['id_number']) . '</span>
                </div>
            </div>
        </div>
        <div class="bank_actions">
            <button class="btn btn-edit" onclick="editBank(' . $row['id'] . ')">
                <i class="fa fa-edit"></i> Sửa
            </button>
            ' . (!$row['is_default'] ? '
            <button  href="javascript:;"  class="btn btn-delete f" onclick="confirm_del(\'del\', \'bank_accounts\', \'Xác nhận xóa tài khoản ngân hàng\', ' . $row['id'] . ');">
                <i class="fa fa-trash-alt"></i> Xóa
            </button>
            <button class="btn btn-default" onclick="setDefaultBank(' . $row['id'] . ')">
                <i class="fa fa-star"></i> Đặt mặc định
            </button>' : '') . '
        </div>
    </div>';
}

// <div class="address_actions">
// <button class="button_all" onclick="showEditAddressModal(' . $row['id'] . ')">Sửa</button>
// ' . (!$row['is_default'] ? '<button href="javascript:;"  class="button_all" class="del" onclick="confirm_del(\'del\', \'transport\', \'Xác nhận địa chỉ giao nhận\', ' . $row['id'] . ');;" >Xóa</button>' : '') . '
// </div>
$thaythe['bank_account_list'] = $bank_account_list;

// Get bank options with logos
$sql = "SELECT id, code, name, logo FROM banks WHERE status = 1 ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

$bank_options = '<option value="">Chọn ngân hàng</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $bank_options .= '<option value="' . $row['id'] . '" 
                      data-logo="' . htmlspecialchars($row['logo']) . '"
                      data-code="' . htmlspecialchars($row['code']) . '">' 
                   . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['code']) . ')</option>';
}
$thaythe['bank_options'] = $bank_options;

// Get province options
$sql = "SELECT id, id_tinh, tieu_de FROM tinh_moi ORDER BY thu_tu ASC, tieu_de ASC";
$result = mysqli_query($conn, $sql);

$province_options = '<option value="">Chọn tỉnh/thành phố</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $province_options .= '<option value="' . $row['id'] . '" data-id-tinh="' . $row['id_tinh'] . '">' 
                      . htmlspecialchars($row['tieu_de']) . '</option>';
}
$thaythe['province_options'] = $province_options;

// Add custom CSS
$thaythe['custom_css'] = '
<style>
.bank_item {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    padding: 20px;
    position: relative;
    transition: all 0.3s ease;
}

.bank_item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.bank_item.default {
    border: 2px solid #ff4d4f;
}

.bank_header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.bank_logo {
    width: 48px;
    height: 48px;
    object-fit: contain;
    margin-right: 15px;
}

.bank_details {
    flex: 1;
}

.bank_name {
    font-size: 16px;
    margin-bottom: 5px;
}

.bank_code {
    color: #666;
    margin-left: 5px;
}

.branch_info {
    color: #666;
    font-size: 14px;
}

.branch_address {
    margin-top: 5px;
    font-style: italic;
    color: #888;
}

.account_info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.account_info .label {
    color: #666;
    display: block;
    margin-bottom: 5px;
    font-size: 13px;
}

.account_info .value {
    font-weight: 500;
    color: #333;
    font-size: 15px;
}

.bank_actions {
    position: absolute;
    right: 20px;
    top: 20px;
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 15px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: none;
    color: white;
    transition: all 0.2s ease;
}

.btn i {
    font-size: 14px;
}

.btn-edit {
    background: #4CAF50;
}

.btn-edit:hover {
    background: #45a049;
}

.btn-delete {
    background: #f44336;
}

.btn-delete:hover {
    background: #da190b;
}

.btn-default {
    background: #2196F3;
}

.btn-default:hover {
    background: #1976D2;
}

.default_badge {
    background: #ff4d4f;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    margin-left: 10px;
}

.add_bank_btn {
    margin-top: 20px;
}

.btn-add {
    background: #1890ff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.btn-add:hover {
    background: #096dd9;
}

.modal-content {
    border-radius: 8px;
}

.modal-header {
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.char-count {
    float: right;
    color: #666;
}
</style>';

// Load template
$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/payment', $thaythe);
?>