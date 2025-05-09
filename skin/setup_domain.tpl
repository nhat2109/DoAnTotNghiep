{header}
<style>
    .sd-domain-setup-container {
        padding: 50px 30px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 16px;
        margin-bottom: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .sd-domain-setup-container:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(220, 53, 69, 0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: 0;
    }
    
    .sd-domain-setup-container:after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 99, 71, 0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: 0;
    }
    
    .sd-domain-setup-inner {
        max-width: 750px;
        width: 100%;
        position: relative;
        z-index: 1;
    }
    
    .sd-setup-title {
        font-size: 32px;
        margin-bottom: 22px;
        color: #343a40;
        text-align: center;
        font-weight: 700;
        position: relative;
        padding-bottom: 18px;
    }
    
    .sd-setup-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #dc3545, #fd7e14);
        border-radius: 3px;
    }
    
    .sd-setup-description {
        margin-bottom: 35px;
        font-size: 18px;
        color: #495057;
        text-align: center;
        line-height: 1.7;
        font-weight: 400;
    }
    
    /* Tab styles */
    .sd-domain-tabs {
        margin-bottom: 30px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .sd-tab-headers {
        display: flex;
        background-color: #f8f9fa;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }
    
    .sd-tab-header {
        flex: 1;
        padding: 18px;
        text-align: center;
        font-weight: 600;
        font-size: 17px;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .sd-tab-header i {
        font-size: 18px;
    }
    
    .sd-tab-header:hover {
        background-color: #e9ecef;
        color: #dc3545;
    }
    
    .sd-tab-header.active {
        background-color: #fff;
        color: #dc3545;
        border-bottom: 3px solid #dc3545;
    }
    
    .sd-tab-content {
        background-color: #fff;
        border-radius: 0 0 12px 12px;
    }
    
    .sd-tab-pane {
        display: none;
        padding: 30px;
    }
    
    .sd-tab-pane.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .sd-input-group {
        display: flex;
        margin: 22px 0;
        border-radius: 10px;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    
    .sd-input-group input {
        border-radius: 10px 0 0 10px;
        border: 1px solid #ced4da;
        padding: 16px 20px;
        flex-grow: 1;
        font-size: 16px;
        height: 56px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .sd-input-group input:focus {
        border-color: #dc3545;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .sd-input-group-addon {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-left: none;
        padding: 16px 20px;
        border-radius: 0 10px 10px 0;
        font-weight: 600;
        color: #495057;
        font-size: 16px;
        height: 56px;
        display: flex;
        align-items: center;
    }
    
    .sd-form-control {
        width: 100%;
        padding: 16px 20px;
        border: 1px solid #ced4da;
        border-radius: 10px;
        margin: 22px 0;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        height: 56px;
        font-weight: 500;
    }
    
    .sd-form-control:focus {
        border-color: #dc3545;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .sd-domain-note {
        color: #6c757d;
        font-size: 15px;
        margin-top: 12px;
        line-height: 1.6;
        padding-left: 5px;
        display: flex;
        align-items: flex-start;
    }
    
    .sd-domain-note i {
        color: #dc3545;
        margin-right: 8px;
        font-size: 16px;
        margin-top: 2px;
    }
    
    .sd-domain-actions {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 30px;
    }
    
    .sd-btn {
        padding: 14px 28px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .sd-btn i {
        margin-right: 10px;
    }
    
    .sd-btn-primary {
        background: #dc3545;
        color: white;
    }
    
    .sd-btn-primary:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.3);
    }
    
    .sd-btn-success {
        background: #28a745;
        color: white;
    }
    
    .sd-btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
    }
    
    /* Alert styles */
    .sd-alert {
        padding: 15px;
        margin-top: 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        font-size: 15px;
        line-height: 1.5;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    .sd-alert i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    .sd-alert-danger {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
        color: #721c24;
    }
    
    .sd-alert-success {
        background-color: #d4edda;
        border-left: 4px solid #28a745;
        color: #155724;
    }
    
    /* Terms and conditions */
    .sd-terms-container {
        margin-top: 25px;
        text-align: center;
    }
    
    .sd-checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .sd-checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .sd-checkbox-wrapper label {
        font-size: 15px;
        color: #495057;
        cursor: pointer;
    }
    
    .sd-checkbox-wrapper a {
        color: #dc3545;
        text-decoration: none;
        font-weight: 600;
    }
    
    .sd-checkbox-wrapper a:hover {
        text-decoration: underline;
    }
    
    .sd-error-message {
        width: 100%;
        text-align: center;
        margin-top: 8px;
        font-size: 14px;
    }
    
    /* Modal styles */
    .sd-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s ease;
    }
    
    .sd-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 25px;
        border: 1px solid #dee2e6;
        width: 90%;
        max-width: 700px;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        animation: slideIn 0.4s ease;
    }
    
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .sd-close {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #adb5bd;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }
    
    .sd-close:hover {
        color: #343a40;
    }
    
    .sd-modal-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #343a40;
        text-align: center;
        font-weight: 700;
        padding-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .sd-terms-box {
        max-height: 400px;
        overflow-y: auto;
        padding: 20px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    
    .sd-terms-box h3 {
        font-size: 18px;
        margin-top: 20px;
        margin-bottom: 10px;
        color: #343a40;
    }
    
    .sd-terms-box h3:first-child {
        margin-top: 0;
    }
    
    .sd-terms-box p {
        font-size: 15px;
        line-height: 1.6;
        color: #495057;
        margin-bottom: 15px;
    }
    
    .sd-modal-footer {
        text-align: center;
        padding-top: 15px;
    }
    
    /* Loading overlay */
    .load_overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
        z-index: 9999;
        display: none;
    }
    
    .load_process {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 10000;
        width: 300px;
        display: none;
    }
    
    .sd-loader-img {
        width: 80px;
        height: auto;
        margin-bottom: 15px;
    }
    
    .load_note {
        margin-top: 15px;
        font-size: 16px;
        color: #495057;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sd-domain-setup-container {
            padding: 30px 20px;
        }
        
        .sd-domain-actions {
            flex-direction: column;
            gap: 15px;
        }
        
        .sd-btn {
            width: 100%;
        }
        
        .sd-tab-header {
            padding: 15px 10px;
            font-size: 15px;
        }
        
        .sd-tab-pane {
            padding: 20px;
        }
        
        .sd-setup-title {
            font-size: 26px;
        }
        
        .sd-setup-description {
            font-size: 16px;
        }
        
        .sd-modal-content {
            width: 95%;
            margin: 10% auto;
            padding: 20px;
        }
        
        .sd-terms-box {
            padding: 15px;
        }
    }
</style>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 12px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 10px;
        position: relative;
    }
    
    .close {
        position: relative;
        top: -20px !important;
        left: 6px !important;
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }
    
    .terms-box {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        margin-bottom: 15px;
    }
    
    .modal-footer {
        text-align: center;
    }
    
    #accept_terms {
        background-color: #ff0000;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    
    #accept_terms:hover {
        background-color: #cc0000;
    }
    
    #agree_terms:disabled + label {
        color: #888;
        cursor: not-allowed;
    }
    
    #terms_link {
        color: #ff0000;
        text-decoration: none;
    }
    
    #terms_link:hover {
        text-decoration: underline;
    }
    .li_input span {
        color: #ff0000;
    }

    .checkbox-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin: 15px 0;
    }

    .checkbox-item {
        flex: 1;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: flex-start;
    }

    .checkbox-wrapper input[type="checkbox"] {
        margin-right: 8px;
        margin-top: 3px;
    }

    .checkbox-wrapper label {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 0;
    }

    .checkbox-wrapper a {
        color: #ff0000;
        text-decoration: none;
    }

    .checkbox-wrapper a:hover {
        text-decoration: underline;
    }

    .error-message {
        margin-top: 5px;
        font-size: 12px;
        display: block;
    }

    .terms-container {
        max-width: 600px;
        margin: 20px auto;
        font-family: Arial, sans-serif;
    }

    .terms-box {
        border: 1px solid #ccc;
        padding: 20px;
        max-height: 300px;
        overflow-y: auto;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .terms-box h2 {
        font-size: 18px;
        margin-top: 0;
    }

    .terms-box p,
    .terms-box ul {
        font-size: 14px;
        line-height: 1.6;
    }

    .terms-box ul {
        padding-left: 20px;
    }

    .agree-button {
        text-align: center;
    }

    .agree-button input[type="checkbox"] {
        margin-right: 10px;
    }

    .agree-button label {
        font-size: 14px;
    }

    .box_success_register {
        padding: 40px 0;
        text-align: center;
    }

    .success_options .option_box:hover .box_option {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
</style>
<body>
    {box_header}
    <div class="home_box home_register" style="margin-top: 0px;">
        <div class="sd-domain-setup-container">
            <div class="sd-domain-setup-inner">
                <h3 class="sd-setup-title">Thiết lập tên miền</h3>
                <p class="sd-setup-description">Vui lòng chọn loại tên miền bạn muốn sử dụng cho doanh nghiệp của mình:</p>               
                <div class="sd-domain-tabs">
                    <div class="sd-tab-headers">
                        <div class="sd-tab-header active" data-tab="subdomain">
                            <i class="fa fa-globe"></i>socdo.vn
                        </div>
                        <div class="sd-tab-header" data-tab="custom_domain">
                            <i class="fa fa-link"></i> Tên miền riêng
                        </div>
                    </div>
                    
                    <div class="sd-tab-content">
                        <!-- Tab 1: Subdomain -->
                        <div class="sd-tab-pane active" id="subdomain-tab">
                            <div class="sd-subdomain-input-group">
                                <div class="sd-input-group">
                                    <input type="text" id="subdomain_name" name="subdomain_name" class="sd-form-control" placeholder="tencuaban">
                                    <div class="sd-input-group-addon">.socdo.vn</div>
                                </div>
                                <p class="sd-domain-note"><i class="fa fa-info-circle"></i> Miễn phí, không cần thiết lập, có thể sử dụng ngay lập tức.</p>
                            </div>
                        </div>
                        
                        <!-- Tab 2: Custom domain -->
                        <div class="sd-tab-pane" id="custom_domain-tab">
                            <div class="sd-custom-domain-input-group">
                                <input type="text" id="custom_domain_name" name="custom_domain_name" class="sd-form-control" placeholder="example.com">
                                <p class="sd-domain-note"><i class="fa fa-info-circle"></i> Sử dụng tên miền riêng của bạn nếu đã có. Bạn cần trỏ DNS về IP: 167.179.110.50 hoặc NS: ns1.socdo.vn và ns2.socdo.vn. Nếu cần hỗ trợ, vui lòng liên hệ hotline: 0987.654.321.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Domain messages -->
                    <div class="sd-domain-messages">
                        <div id="domain-error-message" class="sd-alert sd-alert-danger" style="display: none;">
                            <i class="fa fa-exclamation-circle"></i> <span id="error-text"></span>
                        </div>
                        <div id="domain-success-message" class="sd-alert sd-alert-success" style="display: none;">
                            <i class="fa fa-check-circle"></i> <span id="success-text"></span>
                        </div>
                    </div>
                </div>
                
                <div class="sd-domain-actions">
                    <button type="button" id="check_domain" class="sd-btn sd-btn-primary"><i class="fa fa-search"></i> Kiểm tra tên miền</button>
                    <button type="button" id="setup_domain" class="sd-btn sd-btn-success"><i class="fa fa-check"></i> Sử dụng tên miền</button>
                </div>
                
                <!-- Terms and conditions checkbox -->
                <!-- <div class="sd-terms-container">
                    <div class="sd-checkbox-wrapper">
                        <input type="checkbox" id="agree_terms" name="agree_terms">
                        <label for="agree_terms">Tôi đồng ý với <a href="#" id="terms_link">Điều khoản dịch vụ</a></label>
                        <span class="sd-error-message" style="display: none; color: #e74c3c;">Bạn cần đồng ý với điều khoản dịch vụ</span>
                    </div>
                </div> -->
            </div>
        </div>
        
        <!-- Terms Modal -->
        <div id="terms_modal" class="sd-modal">
            <div class="sd-modal-content">
                <span class="sd-close">&times;</span>
                <h2 class="sd-modal-title">Điều khoản dịch vụ</h2>
                <div class="sd-terms-box">
                    <h3>1. Quy định chung</h3>
                    <p>Khi sử dụng dịch vụ của chúng tôi, bạn đồng ý tuân thủ các điều khoản và điều kiện sau đây.</p>
                    
                    <h3>2. Quyền sở hữu tên miền</h3>
                    <p>Tên miền được đăng ký thông qua dịch vụ của chúng tôi thuộc quyền sở hữu của người đăng ký và tuân theo các quy định của nhà đăng ký tên miền.</p>
                    
                    <h3>3. Sử dụng dịch vụ</h3>
                    <p>Bạn đồng ý không sử dụng dịch vụ của chúng tôi cho bất kỳ mục đích bất hợp pháp nào hoặc bị cấm bởi các điều khoản này.</p>
                    
                    <h3>4. Giới hạn trách nhiệm</h3>
                    <p>Chúng tôi không chịu trách nhiệm về bất kỳ thiệt hại nào phát sinh từ việc sử dụng hoặc không thể sử dụng dịch vụ của chúng tôi.</p>
                    
                    <h3>5. Thay đổi điều khoản</h3>
                    <p>Chúng tôi có thể thay đổi các điều khoản này bất kỳ lúc nào. Việc tiếp tục sử dụng dịch vụ sau khi thay đổi đồng nghĩa với việc bạn chấp nhận các điều khoản mới.</p>
                </div>
                <div class="sd-modal-footer">
                    <button id="accept_terms" class="sd-btn sd-btn-primary">Tôi đã đọc và đồng ý</button>
                </div>
            </div>
        </div>
        
        <!-- Loading Overlay -->
        <div class="load_overlay">
            <div class="load_process">
                <img src="/images/load.gif" alt="Loading" class="sd-loader-img">
                <p class="load_note">Hệ thống đang xử lý</p>
            </div>
        </div>
        
       

        <script>
            $(document).ready(function() {
                // Tab switching functionality
                $('.sd-tab-header').click(function() {
                    var tabId = $(this).data('tab');
                    
                    // Update active tab header
                    $('.sd-tab-header').removeClass('active');
                    $(this).addClass('active');
                    
                    // Show the corresponding tab content
                    $('.sd-tab-pane').removeClass('active');
                    $('#' + tabId + '-tab').addClass('active');
                    
                    // Hide error and success messages when switching tabs
                    $('#domain-error-message').hide();
                    $('#domain-success-message').hide();
                });
                
                // Check domain availability
                $('#check_domain').click(function() {
                    var activeTab = $('.sd-tab-header.active').data('tab');
                    var domain = '';
                    
                    if (activeTab === 'subdomain') {
                        domain = $('#subdomain_name').val();
                        domain_check = domain + '.socdo.vn';
                    } else {
                        domain = $('#custom_domain_name').val();
                        domain_check = domain;
                    }
                    
                    if (!domain) {
                        showError('Vui lòng nhập tên miền!');
                        if(activeTab == 'subdomain'){
                            $('#subdomain_name').focus();
                        }else{
                            $('#custom_domain_name').focus();
                        }
                        return;
                    }
                    
                    // Show loading state
                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang kiểm tra...');
                    
                    // AJAX request to check domain
                    $.ajax({
                        url: '/check_domain.php',
                        type: 'post',
                        data: {
                            action: 'check_domain',
                            domain: domain_check
                        },
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);
                                if (result.available) {
                                    showSuccess(result.message);
                                } else {
                                    showError(result.message);
                                }
                            } catch (e) {
                                showError('Có lỗi xảy ra khi kiểm tra tên miền.');
                            }
                            
                            // Reset button
                            $('#check_domain').html('<i class="fa fa-search"></i> Kiểm tra tên miền');
                        },
                        error: function() {
                            showError('Có lỗi xảy ra khi kết nối đến máy chủ!');
                            // Reset button
                            $('#check_domain').html('<i class="fa fa-search"></i> Kiểm tra tên miền');
                        }
                    });
                });
                
                // Setup domain
                $('#setup_domain').click(function() {
                    var activeTab = $('.sd-tab-header.active').data('tab');
                    var domain = '';
                    
                    if (activeTab === 'subdomain') {
                        domain = $('#subdomain_name').val();
                        domain_check = domain + '.socdo.vn';
                    } else {
                        domain = $('#custom_domain_name').val();
                        domain_check = domain;
                    }
                    
                    if(domain.length < 3){
                        showError('Tên miền phải có ít nhất 3 ký tự!');
                        if(activeTab == 'subdomain'){
                            $('#subdomain_name').focus();
                        }else{
                            $('#custom_domain_name').focus();
                        }
                        return;
                    }
                    
                    // if(!$('#agree_terms').is(':checked')) {
                    //     $('.sd-error-message').show();
                    //     return;
                    // }
                    
                    // Hide any previous error messages
                    // Show loading state
                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang kiểm tra...');
                    
                    // AJAX request to check domain
                    $.ajax({
                        url: '/check_domain.php',
                        type: 'post',
                        data: {
                            action: 'confirm_domain',
                            domain: domain_check
                        },
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);
                                if (result.available) {
                                    showSuccess(result.message);
                                    setTimeout(function () {
                                        window.location.href = 'https://' + domain_check;
                                    }, 1000);
                                } else {
                                    showError(result.message);
                                }
                            } catch (e) {
                                showError('Có lỗi xảy ra khi kiểm tra tên miền.');
                            }
                            
                            // Reset button
                            $('#setup_domain').html('<i class="fa fa-check"></i> Sử dụng tên miền');
                        },
                        error: function() {
                            showError('Có lỗi xảy ra khi kết nối đến máy chủ!');
                            // Reset button
                            $('#setup_domain').html('<i class="fa fa-check"></i> Sử dụng tên miền');
                        }
                    });
                });
                
                // Terms modal functionality
                $('#terms_link').click(function(e) {
                    e.preventDefault();
                    $('#terms_modal').show();
                });
                
                $('.sd-close').click(function() {
                    $('#terms_modal').hide();
                });
                
                $(window).click(function(e) {
                    if ($(e.target).hasClass('sd-modal')) {
                        $('#terms_modal').hide();
                    }
                });
                
                $('#accept_terms').click(function() {
                    $('#agree_terms').prop('checked', true);
                    $('.sd-error-message').hide();
                    $('#terms_modal').hide();
                });
                
                $('#agree_terms').change(function() {
                    if($(this).is(':checked')) {
                        $('.sd-error-message').hide();
                    }
                });
                
                // Add focus effect to input fields
                $('.sd-form-control').focus(function() {
                    $(this).css('border-color', '#dc3545');
                }).blur(function() {
                    $(this).css('border-color', '#ced4da');
                });
                
                function showError(message) {
                    $('#domain-success-message').hide();
                    $('#error-text').html(message);
                    $('#domain-error-message').fadeIn();
                }
                
                function showSuccess(message) {
                    $('#domain-error-message').hide();
                    $('#success-text').html(message);
                    $('#domain-success-message').fadeIn();
                }
            });
        </script>
    </div>
    {footer}
    {script_footer}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    <script>
        var slide_recent = new Swiper('.slide_category', {
            direction: 'horizontal',
            slidesPerView: 5,
            loop: true,
            observer: true,
            observeParents: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: '.slide_category .next',
                prevEl: '.slide_category .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_product = new Swiper('.slide_product', {
            direction: 'horizontal',
            slidesPerView: 3,
            loop: false,
            observer: true,
            observeParents: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.slide_product .next',
                prevEl: '.slide_product .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_banner = new Swiper('.slide_top', {
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.box_slide .next',
                prevEl: '.box_slide .prev',
            },
        })
    </script>
    <script type="text/javascript" charset="utf-8">
        $(function () {
            var currentDate = new Date(),
                finished = false,
                availiableExamples = {
                    set5ngay: 15 * 24 * 60 * 60 * 1000,
                    set5phut: 5 * 60 * 1000,
                    set1phut: 1 * 10 * 1000
                };
            function call_flash(event) {
                $this = $(this);
                switch (event.type) {
                    case "seconds":
                    case "minutes":
                    case "hours":
                    case "days":
                    case "weeks":
                    case "daysLeft":
                        $this.find('.' + event.type).html(event.value);
                        if (finished) {
                            $this.fadeTo(0, 1);
                            finished = false;
                        }
                        break;
                    case "finished":
                        $this.html('Lấy mã xác nhận');
                        finished = true;
                        break;
                }
            }
            $('.timer_countdown').each(function () {
                con = $(this).attr('time') * 1000;
                $(this).countdown(con + currentDate.valueOf(), call_flash);
            });
        });
    </script>
</body>


<!-- Thêm JavaScript validation -->
<script>
    $(document).ready(function () {
      // Mở modal khi nhấp vào link điều khoản
    $('#terms_link').click(function (e) {
        e.preventDefault();
        $('#terms_modal').show();
    });

    // Đóng modal khi nhấp vào nút đóng
    $('.close').click(function () {
        $('#terms_modal').hide();
    });

    // Đóng modal khi nhấp ra ngoài
    $(window).click(function (e) {
        if (e.target == $('#terms_modal')[0]) {
            $('#terms_modal').hide();
        }
    });

    // Kích hoạt checkbox khi nhấp "Tôi đã đọc và đồng ý"
    $('#accept_terms').click(function () {
        $('#agree_terms').prop('disabled', false).prop('checked', true);
        $('#terms_modal').hide();
    });

    // Validation nút Đăng ký
    $('button[name="dangky_ncc"]').click(function (e) {
        if (!$('#agree_terms').is(':checked')) {
            $('#agree_terms').siblings('.error-message').text('Bạn cần đồng ý với điều khoản dịch vụ').show();
            e.preventDefault();
            return false;
        }
    });

    // Ẩn thông báo lỗi khi checkbox thay đổi
    $('#agree_terms').change(function () {
        $(this).siblings('.error-message').hide();
    });
    });
</script>

</html>
