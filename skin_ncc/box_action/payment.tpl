<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
<style>
    .bank_account_list {
        margin-bottom: 20px;
    }
    
    .bank_item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
        position: relative;
        transition: all 0.3s;
    }
    
    .bank_item.default {
        border-color: #ff4d4f;
        background: #fff5f5;
    }
    
    .bank_actions {
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
    
    .form_group {
        margin-bottom: 1rem;
    }
    
    .form_group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .form_control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 14px;
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
    
    .button_all {
        color: #fff;
        background-color: #ee4d2d;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    }
    
    .button_all:hover {
        background-color: #d73211;
    }
    
    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    
    .text-muted {
        color: #6c757d;
        font-size: 12px;
    }
    
    .checkbox label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: normal;
    }
    .modal.fade {
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }
    
    .modal.fade.show {
        opacity: 1 !important;
        display: block;
    }
    
    .modal-backdrop.fade {
        opacity: 0;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    body, .btn, .form-control{
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
                <h1>Tài khoản ngân hàng</h1>
                <div class="text_muted">Quản lý tài khoản ngân hàng để nhận thanh toán</div>
                <div class="line"></div>
            </div>

            <!-- Bank Account List -->
            <div class="bank_account_list" id="bank_account_list">
                {bank_account_list}
            </div>

            <!-- Add New Bank Account Button -->
            <div class="add_bank_btn">
                <button class="btn btn-add" onclick="showAddBankModal()">
                    <i class="fa fa-plus"></i> Thêm tài khoản ngân hàng
                </button>
            </div>

            <!-- Add/Edit Bank Account Modal -->
            <div class="modal fade" id="bankModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Thêm tài khoản ngân hàng</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="bankForm">
                                <!-- Account Holder Info -->
                                <div class="form-group">
                                    <label>Họ và Tên</label>
                                    <input type="text" class="form-control" name="account_name" id="account_name" required maxlength="64">
                                    <small class="text-muted char-count">0/64</small>
                                </div>

                                <div class="form-group">
                                    <label>Số CMND/CCCD</label>
                                    <input type="text" class="form-control" name="id_number" id="id_number" required>
                                </div>

                                <!-- Bank Selection -->
                                <div class="form-group">
                                    <label>Tên Ngân hàng</label>
                                    <select name="bank_id" id="bank_id" class="form-control" required>
                                        {bank_options}
                                    </select>
                                    <div id="selected_bank_info" class="mt-2" style="display: none;">
                                        <img id="bank_logo_preview" src="" alt="" style="height: 30px; margin-right: 10px;">
                                        <span id="bank_name_preview"></span>
                                    </div>
                                </div>

                                <!-- Province Selection -->
                                <div class="form-group" id="province_wrapper" style="display: none;">
                                    <label>Tỉnh/Thành phố</label>
                                    <select name="province" id="province" class="form-control" required>
                                        {province_options}
                                    </select>
                                </div>

                                <!-- Branch Selection -->
                                <div class="form-group" id="branch_wrapper" style="display: none;">
                                    <label>Chi nhánh</label>
                                    <select name="branch_id" id="bank_branch" class="form-control" required>
                                        <option value="">Chọn chi nhánh</option>
                                    </select>
                                    <div id="branch_address" class="text-muted mt-1" style="display: none;"></div>
                                </div>

                                <!-- Account Details -->
                                <div class="form-group">
                                    <label>Số tài khoản</label>
                                    <input type="text" class="form-control" name="account_number" id="account_number" required>
                                </div>

                                <div class="form-group">
                                    <label>Tên chủ tài khoản</label>
                                    <input type="text" class="form-control" name="account_holder" id="account_holder" required maxlength="64">
                                    <small class="text-muted char-count">0/64</small>
                                    <small class="text-muted d-block">Viết in hoa, không dấu - VD: NGUYEN VAN A</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_default" id="is_default">
                                        <label class="custom-control-label" for="is_default">Đặt làm tài khoản mặc định</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" onclick="saveBank()">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    // Character counter for name inputs
    $('#account_name, #account_holder').on('input', function() {
        var max = 64;
        var length = $(this).val().length;
        $(this).next('.char-count').text(length + '/' + max);
    });

    // Auto-capitalize account holder name
    $('#account_holder').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    // Show bank logo and info when bank is selected
    $('#bank_id').change(function() {
        var bankId = $(this).val();
        var $selectedOption = $(this).find('option:selected');
        var bankLogo = $selectedOption.data('logo');
        var bankName = $selectedOption.text();

        if (bankId) {
            $('#bank_logo_preview').attr('src', bankLogo);
            $('#bank_name_preview').text(bankName);
            $('#selected_bank_info').show();
            $('#province_wrapper').show();
            $('#province').val('').trigger('change');
        } else {
            $('#selected_bank_info').hide();
            $('#province_wrapper').hide();
            $('#branch_wrapper').hide();
        }
    });

    // Load branches when province is selected
    $('#province').change(function() {
        var provinceId = $(this).val();
        var bankId = $('#bank_id').val();
        
        if (!provinceId || !bankId) {
            $('#branch_wrapper').hide();
            $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
            return;
        }

        // Show loading state
        $('#bank_branch').html('<option value="">Đang tải...</option>');
        $('#branch_wrapper').show();

        // Load bank branches
        $.ajax({
            url: '/ncc/process.php',
            type: 'GET',
            data: {
                action: 'get_bank_branches',
                bank_id: bankId,
                province_id: provinceId
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var options = '<option value="">Chọn chi nhánh</option>';
                    data.data.forEach(function(branch) {
                        options += '<option value="' + branch.id + '" data-address="' + branch.address + '">' 
                                + branch.name + ' (' + branch.code + ')</option>';
                    });
                    $('#bank_branch').html(options);
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi tải danh sách chi nhánh');
                    $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi tải danh sách chi nhánh');
                $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
            }
        });
    });

    // Show branch address when branch is selected
    $('#bank_branch').change(function() {
        var $selectedOption = $(this).find('option:selected');
        var address = $selectedOption.data('address');
        
        if (address) {
            $('#branch_address').text(address).show();
        } else {
            $('#branch_address').hide();
        }
    });
});

function showAddBankModal() {
    $('#bankForm')[0].reset();
    $('#modalTitle').text('Thêm tài khoản ngân hàng');
    $('#selected_bank_info, #province_wrapper, #branch_wrapper, #branch_address').hide();
    $('.char-count').text('0/64');
    $('#bankModal').modal('show');
}

function editBank(bankId) {
    // Reset form and show loading state
    $('#bankForm')[0].reset();
    $('#modalTitle').text('Đang tải...');
    $('#bankModal').modal('show');
    
    // Hide optional sections initially
    $('#selected_bank_info, #province_wrapper, #branch_wrapper, #branch_address').hide();
    
    $.ajax({
        url: '/ncc/process.php',
        type: 'POST',
        data: {
            action: 'get_bank_account',
            id: bankId
        },
        success: function(response) {
            console.log('Edit response:', response);
            try {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#modalTitle').text('Chỉnh sửa tài khoản ngân hàng');
                    fillBankForm(data.data);
                } else {
                    alert(data.message || 'Không thể tải thông tin tài khoản');
                    $('#bankModal').modal('hide');
                }
            } catch (e) {
                console.error('Parse error:', e);
                alert('Có lỗi xảy ra khi xử lý dữ liệu');
                $('#bankModal').modal('hide');
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu');
            $('#bankModal').modal('hide');
        }
    });
}

function fillBankForm(data) {
    console.log('Filling form with data:', data);
    
    // Add hidden bank ID for edit mode
    if (!$('#bank_account_id').length) {
        $('#bankForm').append('<input type="hidden" id="bank_account_id" name="bank_account_id">');
    }
    $('#bank_account_id').val(data.id);
    
    // Fill basic information
    $('#account_name').val(data.account_name);
    $('#id_number').val(data.id_number);
    $('#account_number').val(data.account_number);
    $('#account_holder').val(data.account_holder);
    $('#is_default').prop('checked', data.is_default == 1);

    // Update character counters
    $('#account_name, #account_holder').each(function() {
        $(this).next('.char-count').text($(this).val().length + '/64');
    });

    // Show bank info
    $('#bank_id').val(data.bank_id);
    if (data.bank_logo) {
        $('#bank_logo_preview').attr('src', data.bank_logo);
        $('#bank_name_preview').text(data.bank_name + ' (' + data.bank_code + ')');
        $('#selected_bank_info').show();
    }

    // Show and set province
    $('#province_wrapper').show();
    if (data.province_id) {
        $('#province').val(data.province_id);
    }

    // Load and set branch
    if (data.bank_id && data.province_id) {
        $('#branch_wrapper').show();
        $('#bank_branch').html('<option value="">Đang tải...</option>');

        $.ajax({
            url: '/ncc/process.php',
            type: 'GET',
            data: {
                action: 'get_bank_branches',
                bank_id: data.bank_id,
                province_id: data.province_id
            },
            success: function(response) {
                console.log('Branch response:', response);
                try {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        var options = '<option value="">Chọn chi nhánh</option>';
                        result.data.forEach(function(branch) {
                            var selected = branch.id == data.branch_id ? 'selected' : '';
                            options += '<option value="' + branch.id + '" data-address="' + branch.address + '" ' + selected + '>' 
                                    + branch.name + ' (' + branch.code + ')</option>';
                        });
                        $('#bank_branch').html(options);

                        // Show branch address if available
                        if (data.branch_id && data.branch_address) {
                            $('#branch_address').text(data.branch_address).show();
                        }
                    } else {
                        console.error('Error loading branches:', result.message);
                        $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
                    }
                } catch (e) {
                    console.error('Error parsing branch data:', e);
                    $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error loading branches:', error);
                $('#bank_branch').html('<option value="">Chọn chi nhánh</option>');
            }
        });
    }
}
function saveBank() {
    // Validate required fields
    var requiredFields = ['account_name', 'id_number', 'bank_id', 'account_number', 'account_holder'];
    var isValid = true;

    requiredFields.forEach(function(field) {
        if (!$('#' + field).val()) {
            $('#' + field).focus(); // Focus vào trường trống
            isValid = false;
            return false;
        }
    });

    if (!isValid) return;

    // Hiển thị overlay và trạng thái xử lý
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $('.load_note').html('Đang xử lý...');

    // Get form data
    var formData = {
        action: 'save_bank_account',
        account_name: $('#account_name').val(),
        id_number: $('#id_number').val(),
        bank_id: $('#bank_id').val(),
        branch_id: $('#bank_branch').val() || null,
        account_number: $('#account_number').val(),
        account_holder: $('#account_holder').val().toUpperCase(),
        is_default: $('#is_default').is(':checked') ? 1 : 0
    };

    // Add bank_account_id if in edit mode
    var bankAccountId = $('#bank_account_id').val();
    if (bankAccountId) {
        formData.bank_account_id = bankAccountId;
    }

    $.ajax({
        url: '/ncc/process.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            try {
                var info = JSON.parse(response);
                setTimeout(function() {
                    $('.load_note').html(info.message || (info.status === 'success' ? 
                        (bankAccountId ? 'Cập nhật tài khoản thành công' : 'Thêm tài khoản thành công') : 
                        'Có lỗi xảy ra khi lưu tài khoản'));
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.status === 'success') {
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
                $('.load_note').html('Có lỗi xảy ra khi gửi yêu cầu');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }
    });
}

function setDefaultBank(bankId) {
    // Hiển thị overlay và trạng thái xử lý
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $('.load_note').html('Đang xử lý...');

    $.ajax({
        url: '/ncc/process.php',
        type: 'POST',
        data: {
            action: 'set_default_bank',
            id: bankId
        },
        success: function(response) {
            try {
                var info = JSON.parse(response);
                setTimeout(function() {
                    $('.load_note').html(info.message || (info.status === 'success' ? 
                        'Đã đặt làm tài khoản mặc định' : 'Không thể đặt làm tài khoản mặc định'));
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.status === 'success') {
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
                $('.load_note').html('Có lỗi xảy ra khi gửi yêu cầu');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }
    });
}

</script> 