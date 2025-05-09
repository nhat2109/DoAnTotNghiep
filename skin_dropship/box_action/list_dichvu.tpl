<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 1000px;">
            <div class="page_title">
                <h1 class="undefined">DANH SÁCH DỊCH VỤ</h1>
                <!-- <div class="text_muted" style="text-transform: uppercase;font-style: italic;font-weight: 700;">Gói dịch vụ buff đơn, đánh giá 5 sao - Follow shop danh riêng cho sàn Shopee</div> -->
                <div class="line"></div>
                <hr>
            </div>
            <div style="clear: both;"></div>
            <div class="title_sosanh" id="bo-template" style="text-transform: uppercase;"><span>Bộ Template</span></div>
            <div class="box_check_domain">
                <div class="result">
                    <div class="list_result">
                        <table cellpadding="0" cellspacing="1" class="domain-items">
                            <tbody>
                                <tr>
                                    <th style="width: 15%;">Tên gói</th>
                                    <th style="width: 40%;">Nội dung gói</th>
                                    <th style="width: 15%;">Đơn giá</th>
                                    <th style="width: 15%;">Khuyến mại<br>Nhà bán Sóc Đỏ</th>
                                    <th style="width: 15%;">Hành động</th>
                                </tr>
                                {list_goi_template}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="title_sosanh" id="setup-gian-hang" style="text-transform: uppercase;">
                <span>Setup gian hàng shopee</span>
            </div>
            <div class="box_check_domain">
                <div class="result">
                    <div class="list_result">
                        <table cellpadding="0" cellspacing="1" class="domain-items">
                            <tbody>
                                <tr>
                                    <th style="width: 15%;">Tên gói</th>
                                    <th style="width: 40%;">Nội dung gói</th>
                                    <th style="width: 15%;">Đơn giá</th>
                                    <th style="width: 15%;">Khuyến mại<br>Nhà bán Sóc Đỏ</th>
                                    <th style="width: 15%;">Hành động</th>
                                </tr>
                                {list_goi_setup_shopee}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="title_sosanh" id="coppy-san-pham" style="text-transform: uppercase;"><span>Copy sản phẩm
                    shopee</span></div>
            <div class="box_check_domain">
                <div class="result">
                    <div class="list_result">
                        <table cellpadding="0" cellspacing="1" class="domain-items">
                            <tbody>
                                <tr>
                                    <th style="width: 15%;">Tên gói</th>
                                    <th style="width: 40%;">Nội dung gói</th>
                                    <th style="width: 15%;">Đơn giá</th>
                                    <th style="width: 15%;">Khuyến mại<br>Nhà bán Sóc Đỏ</th>
                                    <th style="width: 15%;">Hành động</th>
                                </tr>
                                {list_goi_copy_sanpham}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="title_sosanh" id="seeding-shopee" style="text-transform: uppercase;"><span>Seeding shopee</span>
            </div>
            <div class="box_check_domain">
                <div class="result">
                    <div class="list_result">
                        <table cellpadding="0" cellspacing="1" class="domain-items">
                            <tbody>
                                <tr>
                                    <th style="width: 15%;">Tên gói</th>
                                    <th style="width: 40%;">Nội dung gói</th>
                                    <th style="width: 15%;">Đơn giá</th>
                                    <th style="width: 15%;">Khuyến mại<br>Nhà bán Sóc Đỏ</th>
                                    <th style="width: 15%;">Hành động</th>
                                </tr>
                                {list_goi_seeding_shopee}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--             <div class="title_sosanh" style="text-transform: uppercase;"><span>Tăng like và follow shopee</span></div>
            <div class="box_check_domain">
                <div class="result">
                    <div class="list_result">
                        <table cellpadding="0" cellspacing="1" class="domain-items">
                            <tbody>
                                <tr>
                                    <th style="width: 20%;">Tên gói</th>
                                    <th style="width: 40%;">Ưu đãi</th>
                                    <th style="width: 20%;">Đơn giá</th>
                                    <th style="width: 20%;">Hành động</th>
                                </tr>
                                {list_goi_follow}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
            <div class="text_note">
                <table style="width: 100%;font-weight: 700;">
                    <tr>
                        <td>+ Giá gói Buff chưa bao gồm tiền hàng và tiền ship </td>
                    </tr>
                    <tr>
                        <td>+ Bảo hành: 30 ngày (setup shop và làm lại gói)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Khi click vào link trong box_menu
        $('.main_menu a').on('click', function (e) {
            var href = $(this).attr('href');
            var hashIndex = href.indexOf('#');
            if (hashIndex !== -1) {
                e.preventDefault();
                var targetID = href.substring(hashIndex);
                var $target = $(targetID);
                if ($target.length) {
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 55 // Giảm 50px để cuộn lùi lại
                    }, 800, function () {
                        $('.box_check_domain table').css('border', '');
                        $target.nextAll('.box_check_domain').first().find('table').css('border', '2px red solid');
                    });
                }
            }
        });

        // Nếu URL có hash khi load trang
        if (window.location.hash) {
            var $target = $(window.location.hash);
            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - 55 // Giảm 50px để cuộn lùi lại
                }, 800, function () {
                    $('.box_check_domain table').css('border', '');
                    $target.nextAll('.box_check_domain').first().find('table').css('border', '2px red solid');
                });
            }
        }
    });

</script>