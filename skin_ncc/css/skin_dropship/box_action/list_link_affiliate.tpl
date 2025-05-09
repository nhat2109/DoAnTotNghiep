<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="list_thuonghieu list_link_affiliate">
                <div class="swiper-container slide_thuonghieu">
                    <div class="swiper-wrapper">
                        {list_banner_qc}
                    </div>
                </div>
            </div>

          
            <div class="box_timkiem">
                <div class="sanpham_trend"><a href="/dropship/list-sanpham-trend">Click : Sản phẩm Trend để bán</a>
                </div>
                <select name="chon_kho" id="chon_kho">
                    <option value="kho">Kho Hà Nội</option>
                    <option value="kho_hcm">Kho Tp.HCM</option>
                </select>
                <select name="category" id="timkiem_category">
                    <option value="">Danh mục</option>
                    <option value="">Tất cả</option>
                    {option_category}
                </select>
                <select name="thuong_hieu" id="timkiem_thuonghieu">
                    <option value="">Thương hiệu</option>
                    <option value="">Tất cả</option>
                    {option_thuonghieu}
                </select>
                <select name="sort" id="sort_product">
                    <option value="">Sắp xếp</option>
                    <option value="kho-desc">Tồn kho giảm dần</option>
                    <option value="kho-asc">Tồn kho tăng dần</option>
                    <option value="drop-desc">Giá drop giảm dần</option>
                    <option value="drop-asc">Giá drop tăng dần</option>
                    <option value="price-desc">Giá bán giảm dần</option>
                    <option value="price-asc">Giá bán tăng dần</option>
                    <option value="name-asc">Tên A - Z</option>
                    <option value="name-desc">Tên Z - A</option>
                    <option value="time-desc">Sản phẩm mới - cũ</option>
                    <option value="time-asc">Sản phẩm cũ - mới</option>
                </select>
                <!-- <input type="text" name="key" style="width: 125px;" placeholder="Nhập từ khóa tìm kiếm">
                <button name="timkiem_link_affiliate" class="button_timkiem" kieu="laptop"><i
                        class="fa fa-search"></i></button> -->
                <!-- <div class="box_shopcart"><a href="/dropship/add-donhang-drop?step=2"><i class="icon icon-basket"></i>
                        (<span>{total_cart}</span>)</a></div>
                <div style="clear: both;"></div> -->
            </div>
            <div style="clear: both;"></div>
            <div style="margin-top: 10px;margin-bottom: 10px;">
                <!--                 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7667437466339231"
                     crossorigin="anonymous"></script> -->
                <!-- hiển thị -->
                <!--                 <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7667437466339231"
                     data-ad-slot="2193067812"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script> -->
            </div>
            <!-- <div class="info_thuonghieu">
                <div class="cover_thuonghieu">
                    <img src="">
                </div>
                <div class="noidung_thuonghieu"></div>
                <div class="menu_thuonghieu"><span><i class="fa fa-times-circle-o"></i> Đóng lại</span></div>
            </div>
            <div class="page_title">
                <h1 class="undefined">Link Affiliate</h1>
                <div class="line"></div>
                <hr>
            </div> -->
            <table class="list_baiviet">
                <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
                    <th style="text-align: left;">Tên sản phẩm</th>
                    <th style="text-align: center;width: 50px;">Kho</th>
                    <th style="text-align: center;width: 120px;" class="hide_mobile">Hoa hồng</th>
                    <th style="text-align: center;width: 120px;" class="hide_mobile">Total click</th>
                    <th style="text-align: center;width: 80px;" class="hide_mobile">Cookie</th>
                    <th style="text-align: center;width: 130px;" class="hide_mobile">Hành động</th>
                </tr>
                {list_sanpham}
            </table>
            {phantrang}
        </div>
    </div>


</div>




<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var queryParams = new URLSearchParams(window.location.search);
        sort = queryParams.get("sort");
        key = queryParams.get("key");
        if (sort == null) {
            $('#sort_product').val('time-desc');
        } else {
            $('#sort_product').val(sort);
        }
        if (key == null) {

        } else {
            $('input[name=key]').val(key);
        }
        setTimeout(function () {
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: 5,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 3000,
                },
                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                // Navigation arrows
                navigation: {
                    nextEl: '.slide_thuonghieu .next',
                    prevEl: '.slide_thuonghieu .prev',
                    disabledClass: 'hide_button',
                    hiddenClass: 'hide_button'
                },
            });
        }, 1000);
    });
</script>