<footer>
    <div class="top-footer">
        <div class="container">
            <h4 class="text-center">
                Đăng ký nhận tin
            </h4>
            <div class="form_newsletter_customer">
                <input type="email" placeholder="Nhập địa chỉ email" id="newsletter-email"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                <button type="button" name="subscribe">Đăng ký</button>
            </div>
        </div>
    </div>
    <div class="mid-footer">
        <div class="container">
            <div class="row">
                <div class="footer-click">
                    <h4 class="title-menu clicked">
                        Về chúng tôi
                    </h4>
                    <a href="/" class="logo-wrapper mb-3 d-block ">
                        <img class="lazyload loaded" src="/skin/css/images/logofooter.png" alt="logo"
                            style="width: 150px;">
                    </a>
                    {text_footer}
                </div>
                <div class="footer-click">
                    <h4 class="title-menu clicked">
                        Chính sách <i class="fa fa-angle-down d-md-none d-inline-block"></i>
                    </h4>
                    <ul class="list-menu toggle-mn">
                        {menu_chinhsach}
                    </ul>
                </div>
                <div class="footer-click">
                    <h4 class="title-menu clicked">
                        Hỗ trợ khách hàng <i class="fa fa-angle-down d-md-none d-inline-block"></i>
                    </h4>
                    <ul class="list-menu toggle-mn">
                        {menu_huongdan}
                        <p style="margin-top: 14px;">
                            <a class="modern-button" href="/kho-giao-dien.html">Kho giao diện</a>
                        </p>

                    </ul>
                </div>
                <div class="footer-click">
                    <div class="social-footer">
                        <h4 class="title-menu">
                            Theo dõi chúng tôi
                        </h4>
                        <ul class="follow_option d-flex flex-wrap align-items-center p-0 list-unstyled">
                            <li>
                                <a class="facebook link" href="{link_facebook}" title="Theo dõi Facebook"><i
                                        class="fa fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a class="twitter link" href="{link_twitter}" title="Theo dõi Twitter"><i
                                        class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a class="youtube link" href="{link_youtube}" title="Theo dõi Youtube"><i
                                        class="fa fa-youtube"></i></a>
                            </li>
                            <li>
                                <a class="instgram link" href="{link_instagram}" title="Theo dõi instagram"><i
                                        class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                    <h4 class="title-menu">
                        Phương thức thanh toán
                    </h4>
                    <a href="/" title="Phương thức thanh toán">
                        <img class="lazyload img-fluid loading"
                            src="//theme.hstatic.net/1000410088/1000745150/14/footer_trustbadge.jpg?v=113"
                            alt="Phương thức thanh toán" data-was-processed="true">
                    </a>
                    <a href="http://online.gov.vn/Home/WebDetails/109974" title="Logo bộ công thương">
                        <img class="lazyload loaded" src="/images/logo_bct.png?v=113" alt="Logo bộ công thương"
                            data-was-processed="true" width="200">
                    </a>
                </div>
               
            </div>
            <!--             <div style="text-align: center;padding: 10px;">
            	<p style="margin-top: 10px; margin-bottom: 10px; font-size: 16px;"><strong style="text-transform: uppercase;">Công ty cổ phần Sóc Đỏ</strong></p>
            	<p>Đại điện bởi: Nguyễn Văn Hải<br>Mã ĐKKD: 0109794047 – Ngày cấp: 27/10/2021<br>Nơi cấp: Sở kế hoạch và đầu tư thành phố Hà Nội</p>
            	<p>Số điện thoại: 0943.051.818 - Email: socdogroup@gmail.com</p>
            </div> -->
        </div>
    </div>
    <div class="bg-footer-bottom copyright">
        <div class="container">
            <div id="copyright" class="col-lg-12 col-md-12 col-xs-12 fot_copyright">
                <span class="wsp">
                    Copyright 2023 ©SOCDO.VN</a>
                </span>
            </div>
        </div>
    </div>
</footer>


<style>
    .modern-button {
        /* Đệm bên trong nút */
        padding: 5px;
        border: 2px solid rgb(94, 129, 244);
        /* Đường viền với màu hiện đại */
        border-radius: 25px;
        /* Bo tròn góc nút */
        background-color: rgb(94, 129, 244);
        /* Màu nền nút */
        color: white;
        /* Màu chữ */
        font-size: 13px;
        /* Kích thước chữ */
        font-weight: 600;
        /* Chữ đậm */
        text-decoration: none;
        /* Bỏ gạch chân */
        display: inline-block;
        /* Định dạng hiển thị */
        text-align: center;
        /* Canh giữa nội dung */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng đổ bóng */
        transition: all 0.3s ease-in-out;
        /* Hiệu ứng chuyển động mượt */
    }

    /* Hiệu ứng hover */
    .modern-button:hover {
        background-color: rgb(67, 104, 229);
        /* Đổi màu nền khi hover */
        border-color: rgb(67, 104, 229);
        /* Đổi màu viền khi hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        /* Tăng hiệu ứng đổ bóng */
        transform: translateY(-2px);
        /* Hiệu ứng "nhô lên" */
    }

    /* Hiệu ứng khi nhấn */
    .modern-button:active {
        transform: translateY(0);
        /* Giảm hiệu ứng nhô khi nhấn */
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        /* Giảm đổ bóng */
    }
</style>