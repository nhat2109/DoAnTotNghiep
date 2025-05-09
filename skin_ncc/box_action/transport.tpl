    

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->
<!-- #nhatthem54 -->
<style>
    .address_list {
        margin-bottom: 20px;
    }
    .address_item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
        position: relative;
        transition: all 0.3s;
    }
    .address_item.default {
        border-color: #ff4d4f;
        background: #fff5f5;
    }
    .address_actions {
        position: absolute;
        right: 15px;
        top: 15px;
    }
    .default_badge {
        background: #ff4d4f;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 14px;
        margin-left: 10px;
    }
    .pickup_badge {
        background: #52c41a;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 14px;
        margin-left: 10px;
    }
    .return_badge {
        background: #1890ff;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 14px;
        margin-left: 10px;
    }
    .list_group.group_3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }
    .modal {
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
    }
    
    .modal.fade {
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }
    
    .modal.fade.show {
        opacity: 1;
        display: block;
    }
    
    .modal-backdrop.fade {
        opacity: 0;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    
    /* Thêm animation cho modal-dialog */
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, -25%);
        -ms-transform: translate(0, -25%);
        -o-transform: translate(0, -25%);
        transform: translate(0, -25%);
        -webkit-transition: -webkit-transform .3s ease-out;
        -o-transition: -o-transform .3s ease-out;
        transition: transform .3s ease-out;
    }
    
    .modal.show .modal-dialog {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0);
    }
    
    .modal-content {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        padding: 1rem;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 500;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1rem;
    }
    
    .form_group {
        margin-bottom: 1rem;
    }
    
    .form_group label {
        font-size: 14px !important;
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .form_control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 14px !important;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out;
    }
    
    .form_control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .list_group.group_3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .checkbox {
        margin-top: 0.5rem;
    }
    
    .checkbox label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: normal;
    }
    
    .button_all {
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        cursor: pointer;
    }
    
    .button_all:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    
    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border: 1px solid #6c757d;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        cursor: pointer;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    
    .close {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        opacity: .5;
        padding: 0;
        background-color: transparent;
        border: 0;
        cursor: pointer;
    }
    
    .close:hover {
        color: #000;
        opacity: .75;
    }
    
    select.form_control {
        cursor: pointer;
    }
    
    textarea.form_control {
        min-height: 100px;
        resize: vertical;
    }
    
    .left i {
        font-size: 18px;
        
        transition: transform 0.3s ease;
    }
    
    .left:hover i {
        transform: scale(1.1);
    }
    body, .btn, .form-control {
        font-family: "Roboto", Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px !important;
        line-height: 1.42857143;
        color: #212529;
        background-color: #fff;
    }
    </style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Quản lý địa chỉ</h1>
                <div class="text_muted">Quản lý việc vận chuyển và địa chỉ giao hàng của bạn</div>
                <div class="line"></div>
                <hr>
            </div>

            <!-- Address List -->
            <div class="address_list" id="address_list">
                {address_list}
            </div>

            <!-- Add New Address Button -->
            <div class="add_address_btn">
                <button class="button_all" onclick="showAddAddressModal()">
                    <i class="fa fa-plus"></i> Thêm địa chỉ mới
                </button>
            </div>

            <!-- Add/Edit Address Modal -->
            <div class="modal fade" id="addressModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Thêm địa chỉ mới</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addressForm">
                                <input type="hidden" name="address_id" id="address_id">
                                <div class="form_group">
                                    <label>Họ và tên người nhận</label>
                                    <input type="text" class="form_control" name="fullname" id="fullname" required>
                                </div>
                                <div class="form_group">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form_control" name="mobile" id="mobile" required>
                                </div>
                                <div class="list_group group_3">
                                    <div class="form_group">
                                        <label>Tỉnh/TP</label>
                                        <select name="tinh" id="load_huyen" class="form_control" required>
                                            <option value="">Chọn tỉnh/TP</option>
                                            {option_tinh}
                                        </select>
                                    </div>
                                    <div class="form_group">
                                        <label>Quận/Huyện</label>
                                        <select name="huyen" id="load_xa" class="form_control" required>
                                            <option value="">Chọn quận/huyện</option>
                                        </select>
                                    </div>
                                    <div class="form_group">
                                        <label>Xã/Phường</label>
                                        <select name="xa" class="form_control" required>
                                            <option value="">Chọn xã/phường</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form_group">
                                    <label>Địa chỉ chi tiết</label>
                                    <textarea class="form_control" name="address_detail" id="address_detail" required></textarea>
                                </div>
                                <div class="form_group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_default" id="is_default"> Đặt làm địa chỉ mặc định
                                        </label>
                                    </div>
                                </div>
                                <div class="form_group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_pickup" id="is_pickup"> Địa chỉ lấy hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="form_group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_return" id="is_return"> Địa chỉ trả hàng
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" class="button_all" onclick="saveAddress()">Lưu địa chỉ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <a href="/ncc/transport"><span class="left"><i class="fa fa-truck"></i>Cài đặt vận chuyển</span></a> -->
        </div>
    </div>
</div>


<script>
    
// nhatthem94
// Show Add Address Modal
function showAddAddressModal() {
    $('#modalTitle').text('Thêm địa chỉ mới');
    $('#address_id').val('');
    $('#addressForm')[0].reset();
    $('#load_xa').html('<option value="">Chọn quận / huyện</option>');
    $('select[name="xa"]').html('<option value="">Chọn xã / phường</option>');
    $('#addressModal').modal('show');
}

// Show Edit Address Modal
function showEditAddressModal(id) {
    $.ajax({
        url: '/ncc/process.php',
        type: 'POST',
        data: {
            action: 'get_address',
            id: id
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                $('#address_id').val(data.data.id);
                $('#fullname').val(data.data.fullname);
                $('#mobile').val(data.data.mobile);
                
                $('#load_huyen').val(data.data.province);

                // Load quận/huyện
                $.ajax({
                    url: '/ncc/process.php',
                    type: 'POST',
                    data: {
                        action: 'get_huyen',
                        tinh: data.data.province
                    },
                    success: function(html) {
                        $('#load_xa').html(html);
                        $('#load_xa').val(data.data.district);

                        // Load xã/phường
                        $.ajax({
                            url: '/ncc/process.php',
                            type: 'POST',
                            data: {
                                action: 'get_xa',
                                huyen: data.data.district
                            },
                            success: function(html) {
                                $('select[name="xa"]').html(html);
                                $('select[name="xa"]').val(data.data.ward);
                            }
                        });
                    }
                });

                $('#address_detail').val(decodeURIComponent(data.data.address_detail));
                $('#is_default').prop('checked', data.data.is_default == 1);
                $('#is_pickup').prop('checked', data.data.is_pickup == 1);
                $('#is_return').prop('checked', data.data.is_return == 1);
                
                $('#modalTitle').text('Sửa địa chỉ');
                $('#addressModal').modal('show');
            } else {
                $('.load_note').html('Không thể tải thông tin địa chỉ');
            }
        },
        error: function() {
            $('.load_note').html('Có lỗi xảy ra khi tải thông tin địa chỉ');
        }
    });
}

function saveAddress() {
    // Lấy dữ liệu từ form
    var fullname = $('#fullname').val();
    var mobile = $('#mobile').val();
    var tinh = $('#load_huyen').val();
    var huyen = $('#load_xa').val();
    var xa = $('select[name="xa"]').val();
    var address_detail = $('#address_detail').val();

    // Kiểm tra các trường bắt buộc
    if (fullname.length < 1) {
        $('#fullname').focus();
        return;
    }
    if (mobile.length < 1) {
        $('#mobile').focus();
        return;
    }
    if (!tinh) {
        $('#load_huyen').focus();
        return;
    }
    if (!huyen) {
        $('#load_xa').focus();
        return;
    }
    if (!xa) {
        $('select[name="xa"]').focus();
        return;
    }
    if (address_detail.length < 1) {
        $('#address_detail').focus();
        return;
    }

    // Hiển thị overlay và trạng thái xử lý
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $('.load_note').html('Đang xử lý...');

    var formData = new FormData($('#addressForm')[0]);
    formData.append('action', 'save_address');
    $.ajax({
        url: '/ncc/process.php',
        type: 'POST',
        data: formData,

        processData: false,
        contentType: false,
        success: function(response) {
            try {
                var info = JSON.parse(response);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao); // Hiển thị thông báo từ server
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#addressModal').modal('hide'); // Đóng modal
                        window.location.reload(); // Tải lại trang nếu thành công
                    }
                }, 3000);
            } catch (e) {
                setTimeout(function() {
                    $('.load_note').html('Định dạng phản hồi không hợp lệ');
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        },
        error: function() {
            setTimeout(function() {
                $('.load_note').html('Có lỗi xảy ra khi lưu địa chỉ');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }
    });
}
// Update Address List without reloading
function updateAddressList() {
    $.ajax({
        url: '/ncc/action/transport.php', // Gọi lại file để lấy danh sách mới
        type: 'GET',
        success: function(response) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, 'text/html');
            var newAddressList = $(doc).find('#address_list').html();
            $('#address_list').html(newAddressList);
        },
        error: function() {
            alert('Lỗi khi cập nhật danh sách địa chỉ');
        }
    });
}
</script>