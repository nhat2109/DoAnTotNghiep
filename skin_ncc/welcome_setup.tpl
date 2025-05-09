<!-- socmoi/skin_ncc/welcome_setup.html -->
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title>Hoàn thiện thông tin nhà cung cấp</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
<style>
  /* Reset CSS cho mobile */
  * {
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    box-sizing: border-box;
}

body {
    min-width: 320px;
    font-size: 16px;
    line-height: 1.5;
    touch-action: manipulation;
    background-color: #f5f7fa;
}

/* Container styles */
.welcome-setup-container {
    max-width: 700px;
    margin: 20px auto;
    padding: 20px;
    border: 2px solid #e1e8ef;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    background-color: #fff;
}

/* Tùy chỉnh toàn bộ datepicker */
.ui-datepicker {
    background: #fff;
    border: 2px solid #e1e8ef;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 12px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 14px;
    width: 300px;
    z-index: 1050 !important;
}

/* Header của datepicker */
.ui-datepicker-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: #fff;
    border: none;
    border-radius: 6px 6px 0 0;
    padding: 10px;
    margin: -12px -12px 12px -12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Nút Previous và Next */
.ui-datepicker-prev,
.ui-datepicker-next {
    width: 28px;
    height: 28px;
    line-height: 28px;
    text-align: center;
    cursor: pointer;
    position: relative;
    top: 0;
    transform: none;
}

.ui-datepicker-prev span,
.ui-datepicker-next span {
    display: block;
    width: 100%;
    height: 100%;
    background: transparent;
    color: #fff;
    font-size: 0;
}

.ui-datepicker-prev span::before {
    content: "◄";
    font-size: 16px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.ui-datepicker-next span::before {
    content: "►";
    font-size: 16px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.ui-datepicker-prev:hover,
.ui-datepicker-next:hover {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
}

/* Tiêu đề (Tháng và Năm) */
.ui-datepicker-title {
    flex-grow: 1;
    text-align: center;
    font-weight: 600;
}

.ui-datepicker-month,
.ui-datepicker-year {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 4px 6px;
    font-size: 14px;
    background: #fff;
    color: #333;
    margin: 0 5px;
}

/* Bảng lịch */
.ui-datepicker-calendar {
    width: 100%;
    border-collapse: collapse;
}

.ui-datepicker-calendar th {
    font-size: 13px;
    color: #666;
    padding: 6px;
    text-align: center;
    font-weight: 500;
}

.ui-datepicker-calendar td {
    padding: 3px;
    text-align: center;
}

.ui-datepicker-calendar .ui-state-default {
    display: block;
    padding: 8px;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #fff;
    color: #333;
    font-size: 14px;
    transition: all 0.2s ease;
}

.ui-datepicker-calendar .ui-state-hover {
    background: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.ui-datepicker-calendar .ui-state-active {
    background: #0056b3;
    color: #fff;
    border: 1px solid #0056b3;
    font-weight: bold;
}

.ui-datepicker-calendar .ui-state-highlight {
    background: #e9ecef;
    border: 1px solid #ced4da;
    color: #333;
}

/* Các ngày không trong tháng hiện tại */
.ui-datepicker-calendar .ui-datepicker-other-month .ui-state-default {
    background: #fafafa;
    color: #999;
    border: 1px solid #eee;
}

/* Ngày bị vô hiệu hóa */
.ui-datepicker-unselectable .ui-state-default {
    background: #f5f5f5;
    color: #ccc;
    cursor: default;
}

/* Tùy chỉnh input liên quan */
.form-control.datepicker {
    cursor: pointer;
    background: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="%23666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3E%3Crect x="3" y="4" width="18" height="18" rx="2" ry="2"%3E%3C/rect%3E%3Cline x1="16" y1="2" x2="16" y2="6"%3E%3C/line%3E%3Cline x1="8" y1="2" x2="8" y2="6"%3E%3C/line%3E%3Cline x1="3" y1="10" x2="21" y2="10"%3E%3C/line%3E%3C/svg%3E') no-repeat right 12px center;
    background-size: 18px;
}

/* nhatthem74: Welcome setup styles */
.welcome-setup-container h2 {
    margin-bottom: 15px;
    color: #343a40;
    text-align: center;
    font-size: 26px;
    font-weight: 600;
}

.setup-description {
    text-align: center;
    color: #6c757d;
    margin-bottom: 25px;
    font-size: 15px;
}

.welcome-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
    position: relative;
    padding: 15px;
    background: #f8fafc;
    border: 2px solid #e1e8ef;
    border-radius: 10px;
}

.welcome-steps::before {
    content: '';
    position: absolute;
    top: 36px;
    left: 0;
    right: 0;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #e1e8ef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: #007bff;
    border-color: #007bff;
    color: #fff;
    transform: scale(1.1);
}

.step.completed .step-number {
    background: #28a745;
    border-color: #28a745;
    color: #fff;
}

.step-title {
    font-size: 14px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step.active .step-title {
    color: #007bff;
    font-weight: bold;
}

.step.completed .step-title {
    color: #28a745;
}

.step-content {
    display: none;
    padding: 20px 0;
}

.step-content.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
    color: #344767;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 80%;
    margin-top: 0.25rem;
}

.form-control.is-invalid + .invalid-feedback {
    display: block;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.form-actions button {
    min-width: 140px;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.form-actions button:only-child {
    margin-left: auto;
}

.btn-primary {
    color: #fff;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: 2px solid #007bff;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0069d9, #004085);
    border-color: #0062cc;
}

.btn-success {
    color: #fff;
    background: linear-gradient(45deg, #28a745, #1e7e34);
    border: 2px solid #28a745;
}

.btn-success:hover {
    background: linear-gradient(45deg, #218838, #1c7430);
    border-color: #1e7e34;
}

.btn-outline-secondary {
    color: #6c757d;
    border: 2px solid #e1e8ef;
    background: #fff;
}

.btn-outline-secondary:hover {
    color: #fff;
    background: #6c757d;
    border-color: #6c757d;
}

.setup-note {
    margin-top: 30px;
    padding: 15px;
    background: #f8fafc;
    border: 2px solid #e1e8ef;
    border-radius: 8px;
    font-size: 14px;
    color: #6c757d;
}

/* Address and Bank Items */
.address-item,
.bank-item {
    background: #f8fafc;
    border: 2px solid #e1e8ef;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
}

.address-item p,
.bank-item p {
    margin-bottom: 5px;
}

.address-item button,
.bank-item button {
    margin-top: 10px;
}

/* Mobile Optimization */
@media (max-width: 768px) {
    body {
        background: #f5f7fa;
    }

    .welcome-setup-container {
        margin: 10px;
        padding: 20px;
        border: 2px solid #e1e8ef;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        width: calc(100% - 20px);
    }

    /* Form styling */
    .form-group {
        margin-bottom: 20px;
        padding: 0; /* Bỏ padding trong form-group để tránh lấn không gian */
        border: none; /* Bỏ viền form-group để đơn giản hóa */
        background: transparent;
        box-shadow: none;
    }

    .form-group label {
        color: #344767;
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e1e8ef;
        border-radius: 8px;
        padding: 12px;
        height: auto !important;
        font-size: 16px !important;
        background-color: #fff;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        background-color: #fff;
    }

    /* Select boxes */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M8 11.5l-5-5h10l-5 5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 35px;
        border: 2px solid #e1e8ef;
    }

    /* Textarea */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
        border: 2px solid #e1e8ef;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        font-size: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        min-height: 48px;
        width: 100%;
        text-transform: none;
        letter-spacing: 0.3px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: 2px solid #007bff;
    }

    .btn-outline-secondary {
        border: 2px solid #e1e8ef;
        color: #666;
        background: #fff;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #1e7e34);
        border: 2px solid #28a745;
    }

    /* Steps styling */
    .welcome-steps {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 15px;
        background: #f8fafc;
        border: 2px solid #e1e8ef;
        border-radius: 10px;
    }

    .welcome-steps::before {
        display: none;
    }

    .step {
        display: flex;
        align-items: center;
        width: 100%;
        margin-bottom: 12px;
        padding: 10px;
        background: #fff;
        border: 2px solid #e1e8ef;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .step-number {
        width: 32px;
        height: 32px;
        font-size: 14px;
        margin: 0 10px 0 0;
        border: 2px solid #e1e8ef;
        background: #f0f4f8;
        color: #666;
    }

    .step.active {
        border-color: #007bff;
        background: #f0f7ff;
    }

    .step.active .step-number {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .step.completed .step-number {
        background: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .step-title {
        font-size: 15px;
        margin: 0;
    }

    /* Form row adjustments */
    .form-row {
        flex-direction: column;
        margin: 0;
    }

    .form-row > .form-group {
        width: 100%;
        padding: 0;
        margin: 0 0 15px 0;
    }

    .form-row .form-group.col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    /* Form actions */
    .form-actions {
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .form-actions button {
        width: 100%;
    }

    /* Back to home buttons */
    .back-to-home {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 25px;
    }

    .back-to-home a {
        width: 100%;
        margin: 0 !important;
        text-align: center;
        border-radius: 8px;
    }

    /* Small text and hints */
    .form-text.text-muted {
        color: #666 !important;
        font-size: 13px;
        margin-top: 6px;
    }

    /* Required asterisk */
    .text-danger {
        color: #dc3545 !important;
    }

    /* Setup note */
    .setup-note {
        margin: 25px 0 0;
        padding: 15px;
        background: #f8fafc;
        border: 2px solid #e1e8ef;
        border-radius: 8px;
        font-size: 14px;
    }

    /* Title and description */
    h2 {
        font-size: 24px;
        color: #344767;
        margin-bottom: 10px;
    }

    .setup-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        padding: 0 10px;
    }

    /* Datepicker adjustments */
    .ui-datepicker {
        width: 300px;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
}

/* Extra small devices */
@media (max-width: 375px) {
    .welcome-setup-container {
        margin: 5px;
        padding: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    h2 {
        font-size: 20px;
    }

    .form-control {
        font-size: 15px !important;
        padding: 10px;
    }

    .btn {
        font-size: 15px;
        padding: 10px;
        min-height: 44px;
    }

    .step-title {
        font-size: 14px;
    }

    .setup-description {
        font-size: 13px;
    }
}

/* Fix iOS specific issues */
@supports (-webkit-overflow-scrolling: touch) {
    body {
        cursor: pointer;
    }
    
    input, textarea, select {
        font-size: 16px !important;
    }
    
    .form-control:focus {
        transform: none !important;
        font-size: 16px !important;
    }
}

/* Adjust spacing for form-row */
.form-row .form-group {
    margin-bottom: 1rem;
}

/* Ensure labels stay above inputs in the row */
.form-row .form-group label {
    margin-bottom: 0.5rem;
}
</style>
<body>
<div class="welcome-setup-container">
    <div class="back-to-home" style="text-align: left; margin-bottom: 20px;">
        <a href="/" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Về trang chính
        </a>
        <a href="/dangky-ncc.html" class="btn btn-outline-secondary" style="margin-left: 10px;">
            <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Quay lại lựa chọn
        </a>
    </div>
    <h2>Hoàn thiện thông tin nhà cung cấp</h2>
    <p class="setup-description">Để sử dụng đầy đủ tính năng của hệ thống, vui lòng hoàn thiện các thông tin sau:</p>
    
    <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="welcome-steps">
        <div class="step <?php echo $current_step == 1 ? 'active' : ''; ?> <?php echo $step1_completed ? 'completed' : ''; ?>" data-step="1">
            <div class="step-number"><?php echo $step1_completed ? '✓' : '1'; ?></div>
            <div class="step-title">Thông tin cơ bản</div>
        </div>
        <div class="step <?php echo $current_step == 2 ? 'active' : ''; ?> <?php echo $step2_completed ? 'completed' : ''; ?>" data-step="2">
            <div class="step-number"><?php echo $step2_completed ? '✓' : '2'; ?></div>
            <div class="step-title">Địa chỉ giao nhận</div>
        </div>
        <div class="step <?php echo $current_step == 3 ? 'active' : ''; ?> <?php echo $step3_completed ? 'completed' : ''; ?>" data-step="3">
            <div class="step-number"><?php echo $step3_completed ? '✓' : '3'; ?></div>
            <div class="step-title">Tài khoản ngân hàng</div>
        </div>
    </div>

    <!-- Step 1: Thông tin cơ bản -->
   
<div class="step-content <?php echo $current_step == 1 ? 'active' : ''; ?>">
    <form method="POST">
        <input type="hidden" name="action" value="save_step1">
        <div class="form-group">
            <label>Tên công ty/ Hộ kinh doanh <span class="text-danger">*</span></label>
            <input type="text" class="form-control" readonly name="name" value="<?php echo $name; ?>" required>
            <small class="form-text text-muted">Tên đơn vị kinh doanh của bạn</small>
        </div>
        <div class="form-group">
            <label>Mã số thuế/CCCD <span class="text-danger">*</span></label>
            <input type="text" class="form-control" readonly name="maso_thue" value="<?php echo $maso_thue; ?>" required>
            <small class="form-text text-muted">Mã số thuế sẽ được sử dụng cho việc xuất hóa đơn</small>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Ngày cấp</label>
                <input type="text" class="form-control datepicker" name="maso_thue_cap" value="<?php echo $maso_thue_cap; ?>" placeholder="DD/MM/YYYY">
            </div>
            <div class="form-group col-md-6">
                <label>Nơi cấp</label>
                <input type="text" class="form-control" name="maso_thue_noicap" value="<?php echo $maso_thue_noicap; ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Tên người đại diện <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="ten_daidien" value="<?php echo $ten_daidien; ?>" required>
            <small class="form-text text-muted">Tên người đại diện trước pháp luật</small>
        </div>
        <div class="form-group">
            <label>Chức vụ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="chucvu" value="<?php echo $chucvu; ?>" required>
            <small class="form-text text-muted">Chức vụ của người đại diện</small>
        </div>
        <!-- Three dropdowns in one row -->
        <h6 class="form-text">Địa chỉ công ty/ hộ kinh doanh</h6>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="form-text text-muted">Tỉnh/Thành phố <span class="text-danger">*</span></label>
               
                <select class="form-control" name="tinh" id="select_tinh_step1" required>
                    <option value="">Chọn tỉnh/TP</option>
                    <?php echo $option_tinh_step1; ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-text text-muted">Quận/Huyện <span class="text-danger">*</span></label>
                
                <select class="form-control" name="huyen" id="select_huyen_step1" required>
                    <option value="">Chọn quận/huyện</option>
                    <?php echo $option_huyen; ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-text text-muted">Phường/Xã <span class="text-danger">*</span></label>
                
                <select class="form-control" name="xa" id="select_xa_step1" required>
                    <option value="">Chọn phường/xã</option>
                    <?php echo $option_xa; ?>
                </select>
            </div>
        </div>
        <!-- Detailed address with textarea -->
        <div class="form-group">
            <label>Địa chỉ chi tiết <span class="text-danger">*</span></label>
            <textarea class="form-control" name="dia_chi" rows="3" placeholder="Số nhà, tên đường, thôn/xóm..." required><?php echo $dia_chi; ?></textarea>
        </div>
        <div class="form-group">
            <label>Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
            <small class="form-text text-muted">Email sẽ được sử dụng để nhận thông báo từ hệ thống</small>
        </div>
        <div class="form-group">
            <label>Số điện thoại <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" readonly name="mobile" value="<?php echo $mobile; ?>" required>
            <small class="form-text text-muted">Số điện thoại liên hệ chính</small>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Tiếp tục</button>
        </div>
    </form>
</div>

    <!-- Step 2: Địa chỉ giao nhận -->
    <div class="step-content <?php echo $current_step == 2 ? 'active' : ''; ?>">
        <form method="POST">
            <input type="hidden" name="action" value="save_step2">
            <div class="form-group">
                <label>Họ và tên người nhận <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" name="mobile" value="<?php echo $mobile; ?>" required>
            </div>
            <h6 class="form-text">Địa chỉ giao nhận</h6>
            <div class="form-row">
                
                <div class="form-group col-md-4">
                <label class="form-text text-muted">Tỉnh/Thành phố <span class= text-danger">*</span></label>
                <select class="form-control" name="tinh" id="select_tinh" required>
                    <option value="">Chọn tỉnh/TP</option>
                    <?php echo $option_tinh; ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-text text-muted">Quận/Huyện <span class= text-danger">*</span></label>
                <select class="form-control" name="huyen" id="select_huyen" required>
                    <option value="">Chọn quận/huyện</option>
                    <?php echo $option_huyen; ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="form-text text-muted">Phường/Xã <span class= text-danger">*</span></label>
                <select class="form-control" name="xa" id="select_xa" required>
                    <option value="">Chọn phường/xã</option>
                    <?php echo $option_xa; ?>
                </select>
            </div>
            </div>
            <div class="form-group">
                <label>Địa chỉ chi tiết (địa chỉ giao nhận) <span class="text-danger">*</span></label>
                <!-- <input type="text" class="form-control" name="dia_chi" value="<?php echo $dia_chi; ?>" placeholder="Số nhà, tên đường, thôn/xóm..." required> -->
                <textarea class="form-control" name="dia_chi" rows="3" placeholder="Số nhà, tên đường, thôn/xóm..." required><?php echo $dia_chi; ?></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/ncc/welcome_setup.php?step=1'">Quay lại</button>
                <button type="submit" class="btn btn-primary">Tiếp tục</button>
            </div>
        </form>
    </div>

    <!-- Step 3: Tài khoản ngân hàng -->
    <div class="step-content <?php echo $current_step == 3 ? 'active' : ''; ?>">
        <form method="POST">
            <input type="hidden" name="action" value="save_step3">
            <div class="form-group">
                <label>Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_name" value="<?php echo $name; ?>" required>
                <small class="form-text text-muted">Họ tên người đứng tên tài khoản</small>
            </div>
            <div class="form-group">
                <label>Mã số thuế/CCCD <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="id_number" value="<?php echo $maso_thue; ?>" required>
            </div>
            <div class="form-group">
                <label>Tên ngân hàng <span class="text-danger">*</span></label>
                <select class="form-control" name="bank_id" required>
                    <?php echo $bank_options; ?>
                </select>
                <small class="form-text text-muted">Chọn ngân hàng nhận thanh toán</small>
            </div>
            <div class="form-group">
                <label>Số tài khoản <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_number" required>
                <small class="form-text text-muted">Số tài khoản của bạn tại ngân hàng</small>
            </div>
            <div class="form-group">
                <label>Chủ tài khoản <span class="text-danger">*</span></label>
                <!-- <input type="text" class="form-control" name="account_holder" value="<?php echo strtoupper($name); ?>" required> -->
                <input type="text" class="form-control" name="account_holder" value="<?php echo strtoupper(remove_accents($name)); ?>" required>
                <small class="form-text text-muted">Tên chủ tài khoản như trên giấy tờ ngân hàng (viết hoa, không dấu)</small>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/ncc/welcome_setup.php?step=2'">Quay lại</button>
                <button type="submit" class="btn btn-success">Hoàn thành</button>
            </div>
        </form>
    </div>
    
    <div class="setup-note">
        <p><strong>Lưu ý:</strong> Bạn có thể chỉnh sửa thông tin này sau trong phần quản lý tài khoản.</p>
    </div>
</div>

<script>
$(document).ready(function() {
    // Prevent zoom on focus for iOS
    document.addEventListener('touchstart', (event) => {
        if (event.touches.length > 1) {
            event.preventDefault();
        }
    }, { passive: false });
    
    let lastTouchEnd = 0;
    document.addEventListener('touchend', (event) => {
        const now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);

    // Prevent zoom on double tap
    document.addEventListener('dblclick', (event) => {
        event.preventDefault();
    });

    // Disable auto-zoom on input focus
    const preventZoom = (e) => {
        e.preventDefault();
        document.body.style.touchAction = 'none';
        setTimeout(() => {
            document.body.style.touchAction = 'auto';
        }, 500);
    };

    document.addEventListener('focus', preventZoom, true);
    document.addEventListener('touchstart', preventZoom, true);

    // Prevent form zoom
    $('input, select, textarea').on('focus', function(e) {
        $(this).data('original-font-size', $(this).css('font-size'));
        $(this).css('font-size', '16px');
    }).on('blur', function(e) {
        const originalSize = $(this).data('original-font-size');
        if (originalSize) {
            $(this).css('font-size', originalSize);
        }
    });

    // Auto-capitalize account holder name
    $('input[name="account_holder"]').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    // Hàm loại bỏ dấu tiếng Việt
    function removeAccents(str) {
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd').replace(/Đ/g, 'D');
    }
    
    // Xử lý khi thay đổi tỉnh/thành phố
    $('#select_tinh').change(function() {
        var tinh_id = $(this).val();
        if (tinh_id) {
            // Reset các select phía sau
            $('#select_huyen').html('<option value="">Chọn quận/huyện</option>');
            $('#select_xa').html('<option value="">Chọn phường/xã</option>');
            
            // Lấy danh sách quận/huyện
            $.ajax({
                url: '/ncc/process_ajax.php',
                type: 'GET',
                data: {
                    action: 'get_huyen',
                    tinh: tinh_id
                },
                success: function(data) {
                    $('#select_huyen').html('<option value="">Chọn quận/huyện</option>' + data);
                }
            });
        }
    });

    // Xử lý khi thay đổi quận/huyện
    $('#select_huyen').change(function() {
        var huyen_id = $(this).val();
        if (huyen_id) {
            // Reset select phường/xã
            $('#select_xa').html('<option value="">Chọn phường/xã</option>');
            
            // Lấy danh sách phường/xã
            $.ajax({
                url: '/ncc/process_ajax.php',
                type: 'GET',
                data: {
                    action: 'get_xa',
                    huyen: huyen_id
                },
                success: function(data) {
                    $('#select_xa').html('<option value="">Chọn phường/xã</option>' + data);
                }
            });
        }
    });

    // Xử lý khi thay đổi tỉnh/thành phố (Step 1)
    $('#select_tinh_step1').change(function() {
        var tinh_id = $(this).val();
        if (tinh_id) {
            // Reset các select phía sau
            $('#select_huyen_step1').html('<option value="">Chọn quận/huyện</option>');
            $('#select_xa_step1').html('<option value="">Chọn phường/xã</option>');
            
            // Lấy danh sách quận/huyện
            $.ajax({
                url: '/ncc/process_ajax.php',
                type: 'GET',
                data: {
                    action: 'get_huyen',
                    tinh: tinh_id
                },
                success: function(data) {
                    $('#select_huyen_step1').html('<option value="">Chọn quận/huyện</option>' + data);
                }
            });
        }
    });

    // Xử lý khi thay đổi quận/huyện (Step 1)
    $('#select_huyen_step1').change(function() {
        var huyen_id = $(this).val();
        if (huyen_id) {
            // Reset select phường/xã
            $('#select_xa_step1').html('<option value="">Chọn phường/xã</option>');
            
            // Lấy danh sách phường/xã
            $.ajax({
                url: '/ncc/process_ajax.php',
                type: 'GET',
                data: {
                    action: 'get_xa',
                    huyen: huyen_id
                },
                success: function(data) {
                    $('#select_xa_step1').html('<option value="">Chọn phường/xã</option>' + data);
                }
            });
        }
    });
});
</script>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
        $.datepicker.setDefaults({
            closeText: "Đóng",
            prevText: "<Trước",
            nextText: "Tiếp>",
            currentText: "Hôm nay",
            monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
            ],
            monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
            ],
            dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tu",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });
    })
</script>
<script src="/js/jquery.timepicker.js"></script>
<script src="/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/moment/moment.js"></script>
<script type="text/javascript" src="/js/moment/locale/vi.js"></script>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css" /> -->
<!-- <link rel="stylesheet" href="/skin/css/jquery.timepicker.css"> -->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


