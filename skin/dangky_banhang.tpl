{header}

<body>
    {box_header}
    <div class="home_box home_register" style="margin-top: 0px;">
        <div class="box_form_register">
            <div class="container">
                <div class="title_box_register" style="margin-top: 30px">
                    <h2>Trở thành đối tác kinh doanh<br>với <span class="bold color_red">Sóc Đỏ</span></h2>
                </div>
                <div class="tab_box" style="display: flex; justify-content: center;">
                    <div class="tab" style="padding-bottom: 10px;">
                        <div class="box_login" style="width: 480px;padding: 10px;">
                            <div class="li_input">
                                <label for="">Họ và tên <span>*</span></label>
                                <input type="text" name="ho_ten" placeholder="Nhập họ và tên của bạn">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Điện thoại <span>*</span></label>
                                <input type="text" name="dien_thoai" placeholder="Nhập số điện thoại của bạn">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Email <span>*</span></label>
                                <input type="text" name="email" placeholder="Nhập email của bạn">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_group_input">
                                <div class="li_input" style="width: 100%;">
                                    <label for="">Mã số thuế/Số CCCD <span>*</span></label>
                                    <input type="text" name="maso_thue" placeholder="Mã số thuế/ Số CCCD">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="li_input" style="width: calc(50% - 5px);">
                                    <label for="">Ngày cấp <span>*</span></label>
                                    <input type="text" name="maso_thue_cap" class="datepicker"
                                        placeholder="Nhập ngày cấp">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                                <div class="li_input" style="width: calc(50% - 5px);">
                                    <label for="">Nơi cấp <span>*</span></label>
                                    <input type="text" name="maso_thue_noicap" placeholder="Nhập nơi cấp">
                                    <span class="error-message" style="color: red; display: none;"></span>
                                </div>
                            </div>
                            <div class="li_group_input">
                                <div class="li_input">
                                    <label for="">Tỉnh/TP <span>*</span></label>
                                    <select name="tinh">
                                        <option value="">Chọn tỉnh/TP</option>
                                        {option_tinh}
                                    </select>
                                    <span class="error-message"
                                        style="width: 130%; display:flex !important;  color: red; display: none;"></span>
                                </div>
                                <div class="li_input">
                                    <label for="">Quận/Huyện <span>*</span></label>
                                    <select name="huyen">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                    <span class="error-message"
                                        style="width: 130%; display:flex !important;  color: red; display: none;"></span>
                                </div>
                                <div class="li_input">
                                    <label for="">Xã/Phường <span>*</span></label>
                                    <select name="xa">
                                        <option value="">Chọn xã/phường</option>
                                    </select>
                                    <span class="error-message"
                                        style="width: 130%; display:flex !important;  color: red; display: none;"></span>
                                </div>
                            </div>

                            <div class="li_input">
                                <label for="">Địa chỉ <span>*</span></label>
                                <input type="text" name="dia_chi" placeholder="Nhập địa chỉ chi tiết">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Mật khẩu <span>*</span></label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Nhập lại mật khẩu <span>*</span></label>
                                <input type="password" name="re_password" placeholder="Nhập lại mật khẩu đăng nhập">
                                <span class="error-message" style="color: red; display: none;"></span>
                            </div>
                            <div class="li_input">
                                <label for="">Mã giới thiệu <span>*</span> </label>
                                <input type="text" name="ma_gioithieu" placeholder="Nhập mã giới thiệu">
                                <!-- <span class="error-message" style="color: red; display: none;">an> -->
                            </div>
                            <div class="li_input">
                                <button type="button" class="button_login" name="dangky_banhang">Đăng ký</button>
                            </div>
                            <div class="li_input">
                                <div class="text-center">
                                    <a href="javascript:;" class="show_login">Đăng nhập</a> | <a href="/quen-mat-khau.html">Quên mật
                                        khẩu?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="img" style="width: 630px; height: 809px; object-fit: cover; margin-left: 57%;">
                        <img src="/skin/css/images/phone2-1.png">
                    </div> -->
                </div>
                <div class="box_brank_register">
                    <div class="container_brank_register" style="padding: 50px;">
                        <div class="content_text">
                            <h1>Kinh doanh Online<br> dễ dàng hơn</h1>
                            <div class="desc">cùng mô hình </div>
                            <div class="color_gold">Dropshipping</div>
                            <ul class="list-icon">
                                <li>Không lo nhập hàng</li>
                                <li>Không lo tồn kho</li>
                                <li>Không cần tự đóng gói hay giao hàng</li>
                                <li>Không cần kinh nghiệm</li>
                            </ul>
                        </div>
                    </div>
                </div>
               
            </div>
             
            <div class="container" style="margin-top: 50px;">
                <div class="tab_box">
                    <div class="img">
                        <img src="/skin/css/images/kho-khan.png">
                    </div>
                    <div class="tab">
                        <div class="content_text">
                            <h2>Khó khăn khi<br> <span class="color_red">tự kinh doanh online</span></h2>
                            <ul class="list-icon ">
                                <li>Thiếu kinh nghiệm, kiến thức kinh doanh</li>
                                <li>Sợ rủi ro khi bỏ vốn nhập hàng</li>
                                <li>Không có kinh nghiệm sử dụng các công cụ marketing</li>
                                <li>Không có kinh nghiệm tìm nguồn hàng chất lượng, chiết khấu tốt</li>
                                <li>Không có nhiều thời gian để quản lí được toàn bộ công việc vận hành như quản lý hàng
                                    hoá, vận chuyển, tư vấn, bán hàng,..</li>
                            </ul>
                            <div class="desc"><b> <span class="color_red"> Sóc Đỏ </span> giúp bạn bắt đầu công việc
                                    kinh doanh online dễ dàng hơn </b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_loi_the">
            <div class="container">
                <div class="text-center">
                    <h2 class="ht">Lợi thế khi trở thành <br> đối tác kinh doanh <br> của <span class="color_red"> Sóc
                            Đỏ </span></h2>
                </div>
                <div class="khung_info">
                    <div class="wrap-head">
                        <span data-pos="0" class="img img-1"
                            style="transform: rotateZ(0deg) translateX(405px);"></span><span data-pos="180"
                            class="img img-2" style="transform: rotateZ(180deg) translateX(405px);"></span>
                    </div>
                    <div class="row_info">
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-1.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Giải pháp kinh doanh đơn giản cho mọi người</h5>
                                    <div class="desc">Dropshipping là mô hình kinh doanh giảm thiểu nhiều rủi ro cho cá
                                        nhân kinh doanh. Khi có khách hàng đặt sản phẩm, người bán chỉ cần lên đơn ngay
                                        trên ứng dụng và Sóc Đỏ sẽ giao thẳng đến tay người mua.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-2.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Giảm thiểu gánh nặng chi phí</h5>
                                    <div class="desc">Đối tác kinh doanh của Sóc Đỏ không lo cần phải lo nhập hàng, lưu
                                        trữ sản phẩm, đóng gói, do đó bạn sẽ giảm được nhiều chi phí như vốn nhập hàng,
                                        chi phí bao bì, kho bãi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-3.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Kinh doanh mọi lúc, mọi nơi</h5>
                                    <div class="desc">Nhờ sự hỗ trợ của nền tảng bán hàng Sóc Đỏ, bạn có thể tư vấn, lên
                                        đơn và chăm sóc cho khách hàng ở bất kỳ lúc nào và bất cứ ở đâu trên chính chiếc
                                        điện thoại của mình.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_info">
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-4.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Công nghệ tiên tiến</h5>
                                    <div class="desc">Sóc Đỏ phát triển nền tảng bán hàng 1 CHẠM, Affiliate lưu cookie
                                        tới 60 ngày, ngoài ra nhà bán được cung cấp 1 website tích hợp tên miền và các
                                        kênh marketing như tích điểm, voucher,flash sale... Giúp hỗ trợ bán hàng một
                                        cách dễ dàng và tối ưu nhất.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-5.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Đa dạng sản phẩm chất lượng</h5>
                                    <div class="desc">Sóc Đỏ có hơn 1500+ sản phẩm bao gồm nhiều ngành hàng như: Điên
                                        gia dụng, nhà cửa đời sống, mẹ bé, máy làm đẹp, mỹ phẩm,... là những sản phẩm uy
                                        tín và chất lượng cao qua nhiều năm xây dựng nhằm mang những sản phẩm tốt nhất
                                        đến tay người tiêu dùng.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-info">
                            <div class="item">
                                <div class="img"><img class="img-auto loaded" width="120" height="120"
                                        data-lazy-type="image" src="/skin/css/images/icon-6.png" alt=""></div>
                                <div class="divtext">
                                    <h5 class="title">Được đào tạo các kỹ năng bán hàng</h5>
                                    <div class="desc">Khi trở thành nhà bán hàng của <span class="color_red">Sóc
                                            Đỏ</span> bạn sẽ được đào tạo các kỹ năng về: Bán hàng trên sàn TMĐT, bán
                                        hàng trên các nền tảng mạng xã hội với tính năng 1 CHẠM của Sóc Đỏ. Đào tạo
                                        chuyên sâu về phân tích sản phẩm, phân tích thị trường và quy trình xây dựng
                                        thương hiệu cá nhân một cách tối ưu nhất</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_luachon">
            <div class="container">
                <h2 class="ht"><span class="text-1">Lí do lựa chọn kinh doanh cùng <span class="color_red">Sóc
                            Đỏ</span></span></h2>
                <div class="desc">Sóc Đỏ tự hào đã hỗ trợ người dùng tối ưu hóa việc kinh doanh của mình thông qua mô
                    hình kinh doanh Dropshipping đột phá</div>
                <div class="row_info">
                    <div class="col_info">
                        <div class="item">
                            <div class="img"><img class="img-auto loaded" width="112" height="112"
                                    data-lazy-type="image" src="/skin/css/images/user-1.png" alt=""></div>
                            <div class="number">
                                <span class="timer active" data-form="0" data-to="10000" data-speed="4000">10.000</span>
                                <span class="unit">+</span>
                            </div>
                            <div class="title">Nhà bán</div>
                        </div>
                    </div>
                    <div class="col_info">
                        <div class="item">
                            <div class="img"><img class="img-auto loaded" width="112" height="112"
                                    data-lazy-type="image" src="/skin/css/images/suppliers-1.png" alt=""></div>
                            <div class="number">
                                <span class="timer active" data-form="0" data-to="200" data-speed="4000">200</span>
                                <span class="unit">+</span>
                            </div>
                            <div class="title">Nhà cung cấp sản phẩm</div>
                        </div>
                    </div>
                    <div class="col_info">
                        <div class="item">
                            <div class="img"><img class="img-auto loaded" width="112" height="112"
                                    data-lazy-type="image" src="/skin/css/images/star-1.png" alt=""></div>
                            <div class="number">
                                <span class="timer active" data-form="0" data-to="1500" data-speed="4000">1.500</span>
                                <span class="unit">+</span>
                            </div>
                            <div class="title">Sản phẩm chất lượng, chính hãng</div>
                        </div>
                    </div>
                    <div class="col_info">
                        <div class="item">
                            <div class="img"><img class="img-auto loaded" width="112" height="112"
                                    data-lazy-type="image" src="/skin/css/images/busines-1.png" alt=""></div>
                            <div class="number">
                                <span class="timer active" data-form="0" data-to="500" data-speed="4000">500</span>
                                <span class="unit">+</span>
                            </div>
                            <div class="title">Nhà bán hàng chuyên nghiệp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_mo_hinh">
            <div class="container">
                <h2 class="ht"><span class="text-1">Mô hình kinh doanh <span class="color_red"> Dropshipping </span>
                        <br> của <span class="color_red">Sóc Đỏ</span></span></h2>
                <div class="img">
                    <img class="img-auto loaded" width="1024" height="521" data-lazy-type="image"
                        src="/skin/css/images/mo-hinh.png" alt="">
                </div>
            </div>
        </div>
        <div class="box_kinh_doanh">
            <div class="container">
                <h2>Làm cách nào để kinh doanh cùng <span class="color_red">Sóc Đỏ</span></h2>
                <div class="box_media" data-id="EKfA5E7KUmQ">
                    <img class="loaded" data-lazy-type="image" data-lazy-src="/skin/css/images/image-2.jpg" alt="xxx"
                        src="/skin/css/images/image-2.png">
                    <span class="button-radius"><i class="fa fa-play-circle"></i></span>
                </div>
                <div class="box_thanhcong">
                    <h2 class="ht">Câu chuyện thành công của <br> các đối tác kinh doanh <span class="color_red">Sóc
                            Đỏ</span></h2>
                    <div class="wrap-syn-owl-thumb box_slide">
                        <div class="box_hinh_anh">
                            <div class="wrap-syn-2">
                                <div class="syn-thumb ">
                                    <div data-index="0" data-pos="30" class="img tRes img-1 active">
                                        <img class="lazy-hidden img-auto" width="306" height="306"
                                            data-lazy-type="image" src="/skin/css/images/nv-1.jpg" 0 alt="" />
                                    </div>
                                    <div data-index="1" data-pos="90" class="img tRes img-2">
                                        <img class="lazy-hidden img-auto" width="306" height="306"
                                            data-lazy-type="image" src="/skin/css/images/nv-2.jpg" 0 alt="" />
                                    </div>
                                    <div data-index="2" data-pos="150" class="img tRes img-3">
                                        <img class="lazy-hidden img-auto" width="306" height="306"
                                            data-lazy-type="image" src="/skin/css/images/nv-3.jpg" 0 alt="" />
                                    </div>
                                    <div data-index="3" data-pos="200" class="img tRes img-4">
                                        <img class="lazy-hidden img-auto" width="306" height="306"
                                            data-lazy-type="image" src="/skin/css/images/nv-4.jpg" 0 alt="" />
                                    </div>
                                    <div data-index="4" data-pos="280" class="img tRes img-5">
                                        <img class="lazy-hidden img-auto" width="306" height="306"
                                            data-lazy-type="image" src="/skin/css/images/nv-5.jpg" 0 alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box_text">
                            <div class="wrap-syn-1">
                                <div class="syn-slider-1 owl-carousel s-dots" paramowl="dot=.custom-dot">
                                    <div class="item" data-index="0">
                                        <h4 class="title"><span class="name">Mr. Vương Đắc Hiệp</span> <span
                                                class="pos">- Nhà bán hàng</span></h4>
                                        <div class="desc">Sóc Đỏ bán hàng chính hãng rẻ hơn so với các nơi khác.<br>
                                            </br>
                                            Ban đầu, tôi không tin, nhưng sau khi tôi mua và so sánh giá giữa Sóc Đỏ và
                                            các nơi khác, tôi thấy Sóc Đỏ thực sự rẻ hơn. Ban đầu tôi không hiểu về mô
                                            hình dropshipping, nhưng sau khi tìm hiểu và được tư vấn bởi các nhân viên
                                            của Sóc Đỏ, tôi hiểu rằng nó giúp giảm giá sản phẩm bằng cách loại bỏ các
                                            bước trung gian.
                                        </div>
                                    </div>
                                    <div class="item" data-index="1">
                                        <h4 class="title"><span class="name">Mrs. Ánh</span> <span class="pos">- Nhà bán
                                                hàng</span></h4>
                                        <div class="desc">
                                            Sóc Đỏ cung cấp nguồn hàng chất lượng và công nghệ tiện lợi.
                                            <br><br>
                                            Chị đã kinh doanh trên sàn thương mại khoảng hơn 2 năm. Trải qua nhiều khó
                                            khăn từ vận hành, quảng cáo cho đến tư vấn khách hàng, chốt đơn, và tìm
                                            nguồn hàng uy tín. May mắn, chị đã biết đến Sóc Đỏ, một đơn vị uy tín cung
                                            cấp sản phẩm và hỗ trợ tư vấn sản phẩm, nguồn hàng chất lượng, và công nghệ
                                            lên đơn hàng tiện lợi.
                                        </div>
                                    </div>
                                    <div class="item" data-index="2">
                                        <h4 class="title"><span class="name">Mrs. Hạnh</span> <span class="pos">- Nội
                                                trợ - Hà Nội</span></h4>
                                        <div class="desc">"Sau khi tham gia cùng Sóc Đỏ, mình đã không còn sợ hãi mỗi
                                            khi gặp khó khăn".
                                            <br><br>
                                            Mình chuyển hướng kinh doanh với Sóc Đỏ để đảm bảo cuộc sống sau khi về già.
                                            Mình muốn chia sẻ rằng để đạt được thành công, hãy đối mặt với những điều
                                            bạn sợ hãi. Khi vượt qua được chúng, bạn sẽ có sức mạnh để chiến thắng mọi
                                            thách thức.
                                        </div>
                                    </div>
                                    <div class="item" data-index="3">
                                        <h4 class="title"><span class="name">Mr. Hoàng</span> <span class="pos">- Quản
                                                lý nhà hàng - Bắc Ninh</span></h4>
                                        <div class="desc">"Nhờ Sóc Đỏ, mình có nhiều thời gian làm những điều mình
                                            thích"
                                            <br><br>
                                            Mình đã kinh doanh online và gặp khá nhiều khó khăn. Sau khi biết đến Sóc Đỏ
                                            qua bạn bè, thu nhập của mình đã ổn định hơn, giúp mình dành thời gian cho
                                            sự nghiệp và gia đình, và phát triển sự nghiệp.
                                        </div>
                                    </div>
                                    <div class="item" data-index="4">
                                        <h4 class="title"><span class="name">Mr. Phan Văn An</span> <span class="pos">-
                                                Nhà bán hàng</span></h4>
                                        <div class="desc">
                                            Sản phẩm trên Sóc Đỏ là chính hãng và dễ bán.
                                            <br><br>Tôi yên tâm khi kinh doanh trên Sóc Đỏ vì các sản phẩm là chính hãng
                                            và dễ bán, thuộc các ngành hàng tiêu dùng phù hợp. Tôi tự tin bán hàng trên
                                            Facebook và các mạng xã hội khác do sản phẩm uy tín. Tôi rất cảm ơn Sóc Đỏ
                                            vì hỗ trợ và đào tạo giúp tôi có nguồn thu nhập thứ 2 bền vững.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="custom-dot owl-dots">
                                <div class="owl-dot active"><span></span></div>
                                <div class="owl-dot"><span></span></div>
                                <div class="owl-dot"><span></span></div>
                                <div class="owl-dot"><span></span></div>
                                <div class="owl-dot"><span></span></div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        (function ($) {
                            $(document).ready(function () {
                                //transform: rotateZ(-169deg) translateX(185px); 

                                function xxxx() {

                                    var owl = $('.box_thanhcong .owl-carousel'),
                                        wrap = $('.box_thanhcong .wrap-syn-2'),
                                        w = wrap.outerWidth(),
                                        thumb = wrap.find(".img");
                                    thumb.each(function () {
                                        var index = $(this).index(),
                                            pos = $(this).data('pos');

                                        if (index < 5) {
                                            $(this).css('transform', 'rotateZ(' + pos + 'deg) translateX(' + w / 2 + 'px)');
                                        } else {
                                            $(this).css('transform', 'rotateZ(' + pos + 'deg) translateX(' + ((w / 2) - 50) + 'px)');
                                        }

                                        $(this).children('img').css('transform', 'rotateZ(-' + pos + 'deg)');
                                    });

                                    owl.on('translated.owl.carousel', function (e) {

                                        var current = owl.find('.owl-item.active .item');
                                        index = current.data('index');
                                        wrap.find('[data-index="' + index + '"]').addClass('active').siblings().removeClass('active');
                                    })

                                    thumb.on("click", function (e) {
                                        e.preventDefault();
                                        var number = $(this).index();
                                        if (owl.data('owl.carousel') != undefined) {
                                            $(this).addClass("active").siblings().removeClass('active');
                                            owl.trigger("to.owl.carousel", [number, 300, true]);
                                        }
                                    });



                                }

                                xxxx();


                                $(window).resize(function () {
                                    xxxx();

                                });

                            });
                        })(jQuery); 
                    </script>
                    <link rel="stylesheet" href="/carousel/assets/owl.carousel.min.css">
                    <link rel="stylesheet" href="/carousel/assets/owl.theme.default.min.css">
                    <script type='text/javascript' src='/js/owl.carousel.min.js?ver=20150330' id='slick-js'></script>
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
                prevText: "&#x3C;Trước",
                nextText: "Tiếp&#x3E;",
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
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 5,
            loop: true,
            observer: true,
            observeParents: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
            },
            // Navigation arrows
            navigation: {
                nextEl: '.slide_category .next',
                prevEl: '.slide_category .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_product = new Swiper('.slide_product', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 3,
            loop: false,
            observer: true,
            observeParents: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.slide_product .next',
                prevEl: '.slide_product .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_banner = new Swiper('.slide_top', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
            // If we need pagination
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
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
                        /*$this.fadeTo('slow', .5);*/
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

</html>