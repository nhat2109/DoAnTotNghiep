{header}
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
    <div class="home_box home_register" style="margin-top: 0px; ">
        <!-- Form đăng ký -->
        
        <div class="box_form_register" style="display: {form_display};">    
            <div class="container">
                <div class="title_box_register" style="margin-top: 30px">
                    <h2>Trở thành đối tác phân phối sẩn phẩm<br>trên sàn thương mại điện tử <span
                            class="bold color_red">Sóc Đỏ</span></h2>
                </div>
                <div class="tab_box" style="display: flex; justify-content: center;">
                    <div class="tab" style="padding-bottom: 10px;">
                        <div class="box_login" style="width: 480px;padding: 10px;">
                            <div class="li_input">
                                <label for="">Tên công ty/ Hộ kinh doanh <span>*</span></label>
                                <input type="text" name="ho_ten" placeholder="Nhập tên công ty/ Hộ kinh doanh">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input" style="width: 100%;">
                                <label for="">Mã số thuế<span>*</span></label>
                                <input type="text" name="maso_thue" placeholder="Mã số thuế/ Số CCCD">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            
                            <div class="li_input">
                                <label for="">Điện thoại <span>*</span></label>
                                <input type="text" name="dien_thoai" placeholder="Nhập số điện thoại">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Mật khẩu <span>*</span></label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Nhập lại mật khẩu <span>*</span></label>
                                <input type="password" name="re_password" placeholder="Nhập lại mật khẩu">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                          
                            <div class="terms-container">
                                <div class="agree-button">
                                    <input type="checkbox" id="agree_terms" name="agree_terms">
                                    <label for="agree_terms">Tôi đồng ý với <a href="#" id="terms_link">Điều khoản dịch vụ của Socdo.vn</a></label>
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                            
                                <!-- Modal Điều khoản -->
                                <div id="terms_modal" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <div class="terms-box">
                                            <h2>ĐIỀU KHOẢN DÀNH CHO NHÀ BÁN TRÊN SÀN TMĐT SOCDO.VN</h2>
                                            <p>Chào mừng anh/chị đến với Socdo.vn – sàn TMĐT thuần Việt kết nối cộng đồng và
                                                thúc đẩy kinh tế người Việt. Để mở gian hàng và bán hàng trên Socdo.vn, Nhà bán
                                                cần tuân thủ các điều khoản dưới đây. Việc đăng ký và hoạt động trên sàn được
                                                xem là sự đồng ý của Nhà bán với các điều khoản này.</p>
        
                                            <h3>1. Điều kiện đăng ký mở gian hàng</h3>
                                            <ul>
                                                <li><strong>Tư cách pháp lý:</strong> Nhà bán phải là cá nhân hoặc tổ chức có tư
                                                    cách pháp lý hợp lệ theo pháp luật Việt Nam (cá nhân cần cung cấp CMND/CCCD,
                                                    doanh nghiệp cần cung cấp Giấy phép kinh doanh).</li>
                                                <li><strong>Tài khoản ngân hàng:</strong> Nhà bán phải có tài khoản ngân hàng
                                                    tại Việt Nam để nhận thanh toán từ Socdo.vn.</li>
                                                <li><strong>Thông tin chính xác:</strong> Nhà bán cần cung cấp thông tin đầy đủ,
                                                    chính xác (tên, địa chỉ, email, số điện thoại) khi đăng ký. Mọi thông tin
                                                    sai lệch có thể dẫn đến việc từ chối mở gian hàng hoặc khóa tài khoản.</li>
                                                <li><strong>Phí dịch vụ:</strong> Socdo.vn không thu phí giao dịch hay hoa hồng,
                                                    nhưng Nhà bán cần tuân thủ các chính sách tài chính khác (nếu có) được thông
                                                    báo trước.</li>
                                            </ul>
        
                                            <h3>2. Quy định về sản phẩm</h3>
                                            <ul>
                                                <li><strong>Sản phẩm hợp pháp:</strong> Sản phẩm đăng bán phải tuân thủ pháp
                                                    luật Việt Nam, không thuộc danh mục cấm (ví dụ: vũ khí, ma túy, hàng giả,
                                                    hàng nhái, sản phẩm khuyến khích tiêu thụ rượu bia với trẻ vị thành niên,
                                                    thuốc lá…).</li>
                                                <li><strong>Chất lượng và mô tả:</strong> Sản phẩm phải có mô tả chính xác, rõ
                                                    ràng (hình ảnh, thông số, giá cả). Nhà bán chịu trách nhiệm về chất lượng
                                                    sản phẩm và đảm bảo không có sai lệch giữa mô tả và thực tế.</li>
                                                <li><strong>Đăng ký sản phẩm đặc thù:</strong> Nếu bán các sản phẩm cần giấy
                                                    phép (thuốc không kê đơn, thực phẩm chức năng…), Nhà bán phải cung cấp giấy
                                                    phép hợp lệ trước khi đăng bán.</li>
                                            </ul>
        
                                            <h3>3. Quy định về vận hành gian hàng</h3>
                                            <ul>
                                                <li><strong>Đồng bộ với website riêng (nếu có):</strong> Nếu Nhà bán sử dụng
                                                    website Sóc Đỏ, sản phẩm trên website sẽ được đồng bộ tự động lên Socdo.vn.
                                                    Nhà bán cần đảm bảo thông tin sản phẩm trên cả hai nền tảng là nhất quán.
                                                </li>
                                                <li><strong>Xử lý đơn hàng:</strong> Nhà bán phải xử lý đơn hàng trong vòng 24
                                                    giờ kể từ khi nhận được thông báo. Đơn hàng phải được giao đúng thời gian
                                                    cam kết (tối đa 30 ngày nếu không có thời gian cụ thể).</li>
                                                <li><strong>Chăm sóc khách hàng:</strong> Nhà bán cần phản hồi thắc mắc của
                                                    khách hàng trong vòng 12 giờ qua hệ thống chat của Socdo.vn. Thái độ phục vụ
                                                    phải chuyên nghiệp, không được sử dụng ngôn từ xúc phạm.</li>
                                                <li><strong>Chính sách đổi trả:</strong> Nhà bán phải tuân thủ chính sách đổi
                                                    trả của Socdo.vn, bao gồm quyền rút lui của khách hàng trong 14 ngày theo
                                                    quy định pháp luật Việt Nam (trừ trường hợp sản phẩm không được đổi trả, ví
                                                    dụ: hàng đặt theo yêu cầu).</li>
                                            </ul>
        
                                            <h3>4. Quy định về tài chính</h3>
                                            <ul>
                                                <li><strong>Thanh toán:</strong> Socdo.vn sẽ chuyển khoản doanh thu cho Nhà bán
                                                    định kỳ (hàng tuần/tháng, tùy chính sách từng thời điểm). Nhà bán cần cung
                                                    cấp thông tin tài khoản chính xác để tránh sai sót.</li>
                                                <li><strong>Chi phí vận chuyển:</strong> Nhà bán có thể sử dụng hệ thống vận
                                                    chuyển thông minh của Socdo.vn để tối ưu chi phí. Nếu tự chọn đơn vị vận
                                                    chuyển, Nhà bán chịu trách nhiệm về mọi vấn đề phát sinh (giao chậm, hư
                                                    hỏng…).</li>
                                                <li><strong>Thuế:</strong> Nhà bán chịu trách nhiệm kê khai và nộp thuế thu nhập
                                                    từ hoạt động bán hàng trên Socdo.vn theo quy định pháp luật Việt Nam.</li>
                                            </ul>
        
                                            <h3>5. Hành vi bị cấm</h3>
                                            <ul>
                                                <li><strong>Gian lận:</strong> Nhà bán không được phép đăng sản phẩm giả mạo,
                                                    thổi phồng chất lượng, hoặc sử dụng hình ảnh/mô tả không đúng sự thật.</li>
                                                <li><strong>Cạnh tranh không lành mạnh:</strong> Cấm các hành vi như tự tạo đơn
                                                    hàng giả, đánh giá không trung thực, hoặc bôi nhọ đối thủ.</li>
                                                <li><strong>Vi phạm quyền sở hữu trí tuệ:</strong> Không được sử dụng hình ảnh,
                                                    nội dung, hoặc thương hiệu của bên thứ ba mà không có sự cho phép.</li>
                                                <li><strong>Lạm dụng dữ liệu khách hàng:</strong> Dữ liệu khách hàng từ Socdo.vn
                                                    chỉ được sử dụng để xử lý giao dịch, không được bán, chia sẻ, hoặc sử dụng
                                                    cho mục đích khác mà không có sự đồng ý của khách hàng.</li>
                                            </ul>
        
                                            <h3>6. Quyền và trách nhiệm của Socdo.vn</h3>
                                            <ul>
                                                <li><strong>Kiểm duyệt:</strong> Socdo.vn có quyền kiểm duyệt, gỡ bỏ sản phẩm
                                                    hoặc khóa gian hàng nếu phát hiện vi phạm mà không cần báo trước.</li>
                                                <li><strong>Hỗ trợ:</strong> Socdo.vn cung cấp hỗ trợ kỹ thuật 24/7 và tư vấn
                                                    chiến lược bán hàng cho Nhà bán.</li>
                                                <li><strong>Thay đổi chính sách:</strong> Socdo.vn có quyền điều chỉnh các điều
                                                    khoản này và sẽ thông báo trước 7 ngày qua email hoặc trên hệ thống.</li>
                                            </ul>
        
                                            <h3>7. Chấm dứt hợp tác</h3>
                                            <ul>
                                                <li><strong>Tự nguyện:</strong> Nhà bán có thể yêu cầu đóng gian hàng bằng cách
                                                    thông báo trước 15 ngày.</li>
                                                <li><strong>Cưỡng chế:</strong> Socdo.vn có quyền chấm dứt hợp tác ngay lập tức
                                                    nếu Nhà bán vi phạm nghiêm trọng (gian lận, bán hàng cấm, không giao hàng
                                                    nhiều lần…).</li>
                                                <li><strong>Hậu quả:</strong> Khi chấm dứt, Nhà bán phải hoàn thành tất cả đơn
                                                    hàng đang xử lý và không được sử dụng dữ liệu khách hàng từ Socdo.vn cho bất
                                                    kỳ mục đích nào.</li>
                                            </ul>
        
                                            <h3>8. Giải quyết tranh chấp</h3>
                                            <ul>
                                                <li><strong>Thương lượng:</strong> Mọi tranh chấp giữa Nhà bán và Socdo.vn sẽ
                                                    được giải quyết thông qua thương lượng trong vòng 30 ngày.</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="accept_terms">Tôi đã đọc và đồng ý</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="li_input">
                                <button type="button" class="button_login" name="dangky_ncc">Đăng ký</button>
                            </div>
                            <div class="li_input">
                                <div class="text-center">
                                    <a href="/ncc/login">Đăng nhập</a> | <a href="/quen-mat-khau.html">Quên mật
                                        khẩu?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thêm box hiển thị khi đăng ký thành công -->
        <div class="box_success_register" style="display: {box_display};">
            <div class="container" style="padding-top: 4px !important;">
                <div class="title_box_register" style="margin-top: 30px">
                    <h2   style="margin-top: 30px; color:#000;">Sau khi đăng ký nhà cung cấp xong, bạn muốn làm gì tiếp theo?</h2>
                </div>
                <div class="success_options" style="display: flex; justify-content: center; gap: 20px; margin-top: 30px;">
                    <a href="/ncc/welcome_setup.php" class="option_box" style="text-decoration: none;">
                        <div class="box_option" style="background-color: #0068ff; padding: 20px; border-radius: 8px; text-align: center; width: 160px; margin-bottom: 30px;">
                            <i class="fa fa-chart-line" style="font-size: 40px; color: #ffffff;"></i>
                            <h3 style="margin: 10px 0; color:white;">Quản lý bán hàng</h3>
                        </div>
                    </a>
                    <a href="/setup-domain.php" class="option_box" style="text-decoration: none;">
                        <div class="box_option" style="background-color: #e3373e; padding: 20px; border-radius: 8px; text-align: center; width: 160px; margin-bottom: 30px;">
                            <i class="fa fa-tasks" style="font-size: 40px; color: #ffffff;"></i>
                            <h3 style="margin: 10px 0; color:white;">Quản lý giao việc</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
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
        // nhatthem 164
        $(".option_box").on("click", function (e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            console.log("Navigating to:", $(this).attr("href")); 
            window.location.href = $(this).attr("href"); 
        });
    
        $('#terms_link').click(function (e) {
            e.preventDefault();
            $('#terms_modal').show();
        });

        
        $('.close').click(function () {
            $('#terms_modal').hide();
        });

        
        $(window).click(function (e) {
            if (e.target == $('#terms_modal')[0]) {
                $('#terms_modal').hide();
            }
        });

        
        $('#accept_terms').click(function () {
            $('#agree_terms').prop('disabled', false).prop('checked', true);
            $('#terms_modal').hide();
        });

        
        if (localStorage.getItem('register_success') === 'true') {
            
            $('.box_form_register').hide();
            $('.box_success_register').show();
        
            
            setTimeout(function () {
                const successBox = $('.box_success_register')[0];
                if (successBox) {
                    successBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    const offset = 150; 
                    const elementPosition = successBox.getBoundingClientRect().top + window.pageYOffset;
                    window.scrollTo({
                        top: elementPosition - offset,
                        behavior: 'smooth'
                    });
                }
                
                localStorage.removeItem('register_success');
            }, 100);
        }

        
        $('#agree_terms').change(function () {
            $(this).siblings('.error-message').hide();
        });
    });
    
</script>

</html>

