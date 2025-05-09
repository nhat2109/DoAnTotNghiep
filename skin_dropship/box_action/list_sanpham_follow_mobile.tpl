<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 5px;">
            <div class="title_thuonghieu"><span>Theo dõi sản phẩm quan tâm</span></div>
            <div class="box_timkiem">
                <div class="box_huongdan">
                    <div class="muiten xuong"><i class="fa fa-caret-up"></i></div>
                    <div class="noidung_huongdan">Lọc sản phẩm theo tiêu chí của bạn</div>
                    <div class="button_next"><button step="box_timkiem">Tiếp theo</button></div>
                </div>
                <input type="text" name="key" style="width: 125px;" placeholder="Nhập từ khóa tìm kiếm">
                <button name="timkiem_sanpham_follow" class="button_timkiem" kieu="mobile"><i class="fa fa-search"></i></button>
                <div style="clear: both;"></div>
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
            <div class="info_thuonghieu">
                <div class="cover_thuonghieu">
                    <img src="">
                </div>
                <div class="noidung_thuonghieu"></div>
                <div class="menu_thuonghieu"><span><i class="fa fa-times-circle-o"></i> Đóng lại</span></div>
            </div>
            <div class="page_title">
                <h1 class="undefined">Danh sách sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="list_sanpham">
                {list_sanpham}                
            </div>
            {phantrang}
        </div>
    </div>
</div>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var queryParams = new URLSearchParams(window.location.search);
        sort=queryParams.get("sort");
        key=queryParams.get("key");
        if(sort==null){
            $('#sort_product').val('time-desc');
        }else{
            $('#sort_product').val(sort);
        }
        if(key==null){
            
        }else{
            $('input[name=key]').val(key);
        }
        setTimeout(function(){
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: 1,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 2000,
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
        },1000);
    });
</script>