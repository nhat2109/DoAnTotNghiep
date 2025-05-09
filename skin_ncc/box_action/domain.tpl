<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 1000px;">
            <div class="page_title">
                <h1 class="undefined">Thiết lập tên miền</h1>
                <div class="text_muted">Thiết lập tên miền cho cửa hàng của bạn</div>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Tên miền hiện tại: <span class="color_red bold">{domain}</span></label>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="box_check_domain">
                <div class="list_tab">
                    <div class="tab active" id="tab_1">Chưa có tên miền</div>
                    <div class="tab" id="tab_2">Đã có tên miền</div>
                </div>
                <div class="content_tab active" id="content_tab_1">
                    <div style="width: 100%;">
                        <div class="title_tab">Sử dụng tên miền socdo.vn</div>
                        <div class="check_subdomain">
                            <div class="input_check" style="width: 140px;">
                                <input type="text" name="subdomain" placeholder="Viết liền, không dấu">
                            </div>
                            <div class="text_check">.socdo.vn</div>
                            <div style="padding-left: 10px;"><button class="bg_red button_check_subdomain">Kiểm tra</button></div>
                        </div>
                        <div class="text_check_subdomain"></div>
                        <div class="title_tab">Sử dụng tên miền riêng</div>
                        <div class="check_domain">
                            <div class="check_step check_step_1">
                                <div class="title_step"><span>1</span> Nhập các tên miền cần kiểm tra</div>
                                <textarea name="key_domain" id="" cols="30" rows="10" placeholder="Viết liền, không dấu"></textarea>
                            </div>
                            <div class="check_step check_step_2">
                                <div class="title_step"><span>2</span> Chọn ít nhất một loại tên miền</div>
                                <div class="list_loai">
                                    <input type="radio" name="loai" value="all" checked="">Tất cả <input type="radio" name="loai" value="quocte"> Quốc tế <input type="radio" value="vietnam" name="loai"> Việt Nam
                                </div>
                                <div class="list_domain">
                                    {list_domain}
                                </div>
                            </div>
                            <div class="check_step check_step_3">
                                <div class="title_step"><span>3</span> Click để kiểm tra</div>
                                <button class="button_check_domain">Kiểm tra</button>
                            </div>
                        </div>
                        <div class="result">
                            <div class="title_step"><span>4</span> Kết quả kiểm tra tên miền</div>
                            <div class="list_result"></div>
                        </div>
                        <div class="dieukhoan">
                            <div class="title_step"><span>5</span> Điều khoản:</div>
                            <div class="dieukhoan_content">
                                <ul>
                                    <li>1. Sóc đỏ đại diện NCC đăng ký tên miền trên hệ thống</li>
                                    <li>2. Tên miền thuộc sở hữu của NCC và Sóc đỏ không được phép sử dụng vì mục đích riêng</li>
                                    <li>3. Sóc đỏ hỗ trợ đăng ký tên miền và cài đặt</li>
                                    <li>4. Tên miền sẽ được gia hạn hằng năm theo yêu cầu của NCC</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content_tab" id="content_tab_2">
                    <div class="col_left">
                        <div class="form_group">
                            <label for="">Tên miền</label>
                            <input type="text" class="form_control" name="domain" value="" placeholder="Nhập tên miền của bạn...">
                        </div>                      
                        <div style="clear: both;"></div>
                        <div class="form_group">
                            <button class="button_all button_domain" name="button_domain"> Lưu thay đổi <i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                    <div class="col_right">
                        <div class="form_group">
                            + Nhập tên miền của bạn và trỏ tên miền về địa chỉ ip <b>{ip_server}</b>.<br>
                            + Nếu bạn chưa biết cách thao tác, hãy yêu cầu hỗ trợ (Phí dịch vụ 100k).<br>
                            <div style="text-align: center;">
                                <button class="button_hotro" onclick="confirm_action('hotro_domain', 'Xác nhận yêu cầu hỗ trợ', '');">Yêu cầu hỗ trợ</button>                                
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>