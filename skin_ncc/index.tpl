{header}

<body>
  <div class="loadpage">
    <div class="content_loadpage">
      <div class="logox">
        <!-- <a href="/ncc/dashboard"><img src="/skin_ncc/css/images/logo.png" alt="logo"></a> -->
          <a href="/ncc/dashboard"><img src="/skin_ncc/css/images/logo_admin.jpg" alt="logo"></a>
      </div>
      <div class="loadx"></div>
    </div>
  </div>
  <div class="page_body">
    <div class="logo_mobile">
      <!-- <a href="/ncc/dashboard"><img src="/skin_ncc/css/images/logo_admin.jpg" alt="logo"></a> -->
      <div class="slogan"><a href="/">Đơn vị tiên phong về TMĐT hàng hóa chính hãng</a></div>
    </div>

    <!-- Box cao nhất _ toptop -->
    <div class="menu_top">
      <div class="menu_top_left">
        <div class="drop_down">
          <button><i class="icon icon-list"></i> MENU</button>
          <div class="drop_menu scroll">
            {box_menu}
          </div>
        </div>
        <div class="title_action"><i class="fa fa-th"></i> {title_action}</div>
      </div>


      <!-- <div class="menu_top_center">
        <div class="social_box"
          style="margin-left: 15px;border: 1px solid rgb(147, 141, 140); padding: 3px 5px; border-radius: 20px; background-color: rgb(42, 68, 231);">
          <i style="color: #ffffff;" class="fa fa-facebook"></i>
          <span> <a href="https://www.facebook.com/groups/nguonhangsocdo" style="color: aliceblue;"
              target="_blank">Group</a></span>
        </div>
        <div class="social_box"
          style="border: 1px solid rgb(147, 141, 140); padding: 3px 5px; border-radius: 20px; background-color:  rgb(42, 68, 231);">
          <i style="color: rgb(255, 255, 255);" class="fa fa-facebook"></i>
          <span> <a href="https://www.facebook.com/SocDoPage" style="color: aliceblue;"
              target="_blank">Fanpage</a></span>
        </div>
        <input style="margin-left: 20px;" type="text" name="key_hieu" class="search_input"
          placeholder="Bạn đang tìm kiếm điều gì ..." required>
        <button name="timkiem_sanpham_drop_hieu" class="button_timkiem_hieu" kieu="laptop"> <i
            class="fa fa-search search_icon"></i></button>

      </div> -->

      <div class="menu_top_right">


        <div class="notification">
          <div class="icon_notification">
            <i style="border: 2px solid rgb(234, 141, 141); border-radius: 6px;" class="fa fa-bell">
              <span class="total_notification">0</span>
            </i>
          </div>
          <div class="list_notification">
            <div class="tab_notification">
              <div class="li_tab" id="tab_all">Tất cả</div>
              <div class="li_tab active" id="tab_chuadoc">Chưa đọc</div>
              <div class="li_tab active" id=""><a style="color: #ffffff !important;"
                  href="/ncc/list-thongbao">Thông báo mới</a><span style="color: #333;margin-left:4px;"
                  class="total_thongbao">0</span></div>
              <!-- <div class="li_tab active" id=""><a style="color: #ffffff !important;"
                  href="/ncc/list-sanpham-tuan">Chương trình tuần</a><span style="color: #333;margin-left:4px;"
                  class="total_ct_tuan">0</span></div>
              <div class="li_tab active" id=""> <a style="color: #ffffff !important;"
                  href="/ncc/list-sanpham-hethang-catma">Sắp cắt mã</a><span style="color: #333;margin-left:4px;"
                  class="total_catma">0</span></div>
              <div class="li_tab active" id=""><a style="color: #ffffff !important;"
                  href="/ncc/list-sanpham-hethang">Sắp hết hàng</a><span style="color: #333;margin-left:4px;"
                  class="total_hethang">0</span></div> -->
            </div>
            <div class="list_noti scroll" scroll page="1" tiep='1' loaded="1">
              <div class="loading_notification">
                <i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...
              </div>
            </div>
          </div>
        </div>







        <!-- <div style="margin-left: 5px;" class="avatar hide_mobile">
          <a href="/ncc/list-sanpham-follow">
            <img src=""
              style="width: 26px;height:26px;margin-top: 4px; margin-right: 5px;border: 2px solid rgb(234, 141, 141);"
              alt="avatar" onerror="this.src='/images/favourite.png';">
            <span class="total_quantam">{total_follow}</span>
          </a>
        </div> -->


        <div class="drop_down">
          <button>{fullname} <i class="fa fa-angle-down ml-1"></i></button>
          <div class="drop_menu" style="width: 200px;">
            <div class="drop_item"><b>{fullname}</b>
              <div class="text_muted">{email}</div>
            </div>
            <div class="line"></div>
            <a class="drop_item" href="/ncc/profile"><i class="icon icon-profile"></i> Profile</a>
            <div class="line"></div>
            <a class="drop_item text_danger" href="/ncc/logout"><i class="mr-3 icon icon-switch"></i> Đăng xuất</a>
          </div>
        </div>

        <div class="avatar hide_mobile"><a href="/ncc/profile"><img style="border: 2px solid rgb(234, 141, 141);"
              src="{avatar}" alt="avatar" onerror="this.src='/images/user.png';"></a>
        </div>
        <!-- <div class="avatar hide_mobile box_shopcart">
          <a href="/ncc/add-donhang-drop?step=2">
            <img src="" style="border: 2px solid rgb(234, 141, 141);" alt="avatar"
              onerror="this.src='/images/cart.png';">
            <span class="cart-count">{total_cart}</span>
          </a>
        </div> -->

      </div>
    </div>
    <!-- Box cao nhất _ toptop -->

    <!-- mới  -->
    <div id="popup_overlay"></div>
    <!-- mới  -->




    <!-- <div class="list_donhang_top">
      <div class="swiper-container slide_donhang">
        <div class="swiper-wrapper">{list_donhang_slide}
          {marquee}
        </div>
      </div>
    </div> -->
    <div class="box_left">
      <div class="box_menu_left scroll">
        <div class="logo">
          <a href="/ncc/dashboard"><img src="/skin_ncc/css/images/admin_image_1.png" alt="logo"></a>
        </div>
        <div class="box_left_content">
          <!-- đây là menu trái  -->
          {box_menu}
          <!-- đây là menu trái  -->
          <div class="hr"></div>
          <div class="menu_text_center">Administrator Panel</div>
        </div>
      </div>
    </div>
    <!-- Nội dung trang chính ở đâyđây -->
    {box_right}
    <!-- Nội dung trang chính ở đâyđây -->
  </div>
  {box_script_footer}

  <div id="popup_overlay"></div>


  <div id="popup_lo_trinh">
    <div class="popup_content">
      <!-- tầng 1  -->
      <div class="section_box_top">
        <div class="luu_y" style="border: 2px red dotted; border-radius: 20px;">
          <h2>Có thể bạn chưa biết ❓</h2>
          <ul>
            <li><a href="#" class="trigger_small_popup" data-target="popup_afilate"><b>"Afilate"</b> là gì ?</a></li>
            <li><a href="#" class="trigger_small_popup" data-target="popup_template"><b>"Template"</b> là gì ?</a></li>
            <li><a href="#" class="trigger_small_popup" data-target="popup_banhang1cham">Bán hàng 1 chạm như thế nào
                ?</a></li>
            <li><a href="#" class="trigger_small_popup" data-target="popup_congthuc">Công thức tính <b>"hoa hồng</b>,
                <b>thưởng"</b> ? <i class="fa fa-star-o"></i></a></li>
          </ul>
          <!-- <i style="float:right;margin: 0 5px 5px 0;"><a href="" style=" color: #333;">Chi tiết >></a></i> -->
        </div>

        <div class="text_top">
          <div class="content" style="margin-left: 35px;">
            <div class="inner" style="display: flex;">
              <p>Xây dựng - Phát triển thương hiệu cá nhân</p>
              <p>Bán hàng 1 chạm<br> siêu dễ dàng</p>
            </div>

            <div class="social_media_top" style="text-align: center;">
              <div>
                <img src="/images/zalo.png" alt="Zalo">
                <img src="/images/insta.png" alt="Instagram">
                <img src="/images/facebook.png" alt="Facebook">
              </div>

            </div>
            <h3 style="position: relative;"> <a href="/ncc/nhiemvu-nguoimoi">Bán hàng bằng nhân
                hiệu các nhân</a>
              <div class="line1 line_top1"></div>
              <div class="line1 line_top2"></div>
              <div class="line1 line_top3"></div>
            </h3>

          </div>
        </div>

        <div class="banner_img">
          <img src="/images/nen_timhieu-Photoroom.png" style="width: 80%;" alt="Banner lộ trình">
        </div>
      </div>
      <!-- tầng 22  -->
      <div class="section_box_mid">

        <div class="box-two flex-row" style="position: relative;">
          <p>Hoa hồng liên kết <strong>200.000</strong>vnđ/User<i class="user_icon"></i></p>
          <p>Thưởng <strong>5%</strong> hoa hồng nhóm Nhà bán</p>

          <p>Thưởng <strong>1.5 triệu</strong> cho Nhà Bán lên NBCN</p>
          <p>Thưởng <strong>1.5%</strong> nhóm nhà bán CN <i class="fa fa-users"></i></p>
          <div class="line2 line_mid_left1"></div>
          <div class="line2 line_mid_left2"></div>
          <div class="line2 line_mid_left3"></div>
          <div class="line2 line_mid_left4"></div>
        </div>
        <h3>
          <a href="#" class="trigger_small_popup" data-target="popup_suckien">Sự nghiệp trọn đời : Nhà bán hàng Chuyên
            Nghiệp</a>

        </h3>

        <div class="trung-tam">
          <h4>Nhà bán hàng
            <img src="/images/socdo.png" alt="socdo.vn">
          </h4>
          <span class="arrow arrow-right">&rarr;</span>
          <span class="arrow arrow-down">&darr;</span>
          <span class="arrow arrow-up">&uarr;</span>
          <span class="arrow arrow-left">&larr;</span>

        </div>

        <h3>
          <a href="#" class="trigger_small_popup" data-target="popup_bansan">Bán hàng trên sàn thương mại điện tử</a>

        </h3>
        <div class="box-one flex-row" style="display: flex;">
          <div class="social_media_mid">
            <div class="box_social" style="position: relative;">
              <img src="/images/lazada.png" alt="Lazada">
              <img src="/images/shoppee.png" alt="Shopee">
              <img src="/images/tiktok.png" alt="TikTok">
              <div class="line3 line_mid_right1"></div>
              <div class="line3 line_mid_right2"></div>
              <div class="line3 line_mid_right3"></div>
              <div class="line3 line_mid_right4"></div>
              <div class="line3 line_mid_right5"></div>
              <div class="line3 line_mid_right6"></div>
              <div class="line3 line_mid_right7"></div>
              <div class="line3 line_mid_right8"></div>
              <div class="line3 line_mid_right9"></div>


            </div>
          </div>
          <div class="text-mid-3">
            <p><a href="/ncc/list-dichvu#bo-template">Cung cấp Template chuyên nghiệp <i class="fa fa-cog"></i>
              </a></p>
            <p><a href="/ncc/list-dichvu#setup-gian-hang">Setup <i class="fa fa-cog"></i>
                gian hàng <br> chuyên nghiệp</a></p>
            <p><a href="/ncc/list-dichvu#coppy-san-pham">Sao chép và trang trí sản phẩm</a></p>
            <p><strong><a href="/ncc/list-dichvu#seeding-shopee">Wow Seeding</a> <br></strong>🗣️</p>
            <p><a href="/ncc/list-idol">🎬 Book lịch <br>
                LiveStream</a></p>

          </div>

        </div>
      </div>

      <!-- tầng 3  -->
      <div class="section_box_bottom">
        <div class="box1">
        </div>
        <div class="box_2">
          <p><a href="/ncc/domain">Tích hợp <br><strong>tên miền</strong> riêng</a></p>
          <h3><a href="/ncc/list-giaodien">Bán hàng qua<br> Website chuyên nghiệp</a></h3>
          <p><a href="/ncc/list-giaodien">Mẫu<strong>Template</strong><br>hiện đại</a><i class="user_icon"></i>
          </p>
        </div>
        <div class="box_3">
          <p> <a href="">Kênh maketting đầy <br> đủ tính năng</a></p>
          <p> <a href="/ncc/add-sanpham-ngoai">Tự kinh doanh <br>sản phẩm riêng</a></p>
          <p><a href="">Dễ dàng làm <strong>Afillate</strong> <br> đa nền tảng</a></p>
        </div>
        <div class="line4 line_bottom1"></div>
        <div class="line4 line_bottom2"></div>
        <div class="line4 line_bottom3"></div>
        <div class="line4 line_bottom4"></div>

        <div class="banner_img" style="width: 260px;height: 130px;position: absolute; top:20px;left: 20px;">
          <img src="/images/z6354740174903_358754b37bcb429683664387f6d37455.jpg" style="height:100%;width:128%;"
            alt="Banner lộ trình">
        </div>
      </div>
    </div>




    <button class="close_popup">❌</button>
  </div>

  <!-- Small popup, ẩn ban đầu, nằm bên trong popup_lo_trinh -->
  <div class="small_popup" id="popup_afilate">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>"Afilate" là gì ?</h4>
      <p>Nội dung chi tiết về Afilate ....</p>
    </div>
  </div>
  <div class="small_popup" id="popup_template">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>"Template" là gì ?</h4>
      <p>Nội dung chi tiết về Template ....</p>
    </div>
  </div>
  <div class="small_popup" id="popup_banhang1cham">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>Bán hàng 1 chạm</h4>
      <p>Nội dung chi tiết về bán hàng 1 chạm ....</p>
    </div>
  </div>
  <div class="small_popup" id="popup_congthuc">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>Công thức tính hoa hồng, thưởng</h4>
      <p>Nội dung chi tiết về công thức tính ....</p>
    </div>
  </div>
  <div class="small_popup" id="popup_suckien">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>Sự nghiệp trọn đời : Nhà bán hàng Chuyên Nghiệp</h4>
      <p>Nội dung chi tiết ....</p>
    </div>
  </div>
  <div class="small_popup" id="popup_bansan">
    <div class="small_popup_content">
      <button class="close_small_popup" style="background-color: #4c9af3;">❌</button>
      <h4>Bán hàng trên sàn thương mại điện tử</h4>
      <p>Nội dung chi tiết ....</p>
    </div>
  </div>



</body>

<style>
  :root {
    --popup-width: 80%;
    --popup-max-width: 1232px;
    --popup-max-height: 90vh;
    --arrow-font-size: 3rem;
    --luu-y-border: 2px red dotted;
    --luu-y-border-radius: 20px;
    --h2-font-size: 10px;
  }

  #popup_overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 900;
  }

  #popup_lo_trinh {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: var(--popup-width);
    max-width: var(--popup-max-width);
    max-height: var(--popup-max-height);
    overflow-y: hidden;
    padding: 20px;
    border: 5px solid #63ACFF;
    border-radius: 40px;
    background-color: #fff;
    box-sizing: border-box;
    z-index: 1000;
  }

  .popup_container {
    position: relative;
  }

  .section_box_top {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 1rem;
  }

  .luu_y {
    flex: 1;
    border: var(--luu-y-border);
    border-radius: var(--luu-y-border-radius);
    padding: 0.5rem;
  }

  .luu_y h2 {
    font-size: 14px;
    color: #63ACFF;
    text-align: center;
  }

  .luu_y ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }


  #popup_lo_trinh .section_box_top .luu_y ul a {
    color: #333;
    margin-left: 28px;
    font-size: 12px;
  }

  /* Content box bên giữa */
  .content_box {
    margin-left: 35px;
  }

  .content .inner {
    display: flex;
  }

  .content .inner p {
    margin: -11px 0 0 9px;
  }

  .social_media {
    text-align: center;
    padding-top: 5px;
  }

  .social_media_top img {
    width: 32px;
    height: 32px;
    margin: 0 5px;
  }

  #popup_lo_trinh .popup_content .section_box_top .text_top h3 {
    padding: 5px 11px 6px 7px;
  }

  .content_box h3 {
    margin: 10px 0 0 86px;
    text-align: center;
    font-size: 10px;
  }

  /* Banner image ở section top */
  .banner_img img {
    height: 143px;
    width: 251px;
    background-color: #fff;
  }

  /* Section mid */
  .section_box_mid {
    margin-bottom: 1rem;
  }

  .box-two {
    padding-left: 58px;
  }

  .box-two p {
    margin: 0;
    font-size: 10px;
  }

  .section_box_mid h3 {
    margin-top: 90px;
    text-align: center;
    font-size: 10px;
  }

  .section_box_mid h4 {
    background-color: #DA1414 !important;
    border: 5px solid #FFA2A4;
    margin-top: 96px;
    margin-left: 10px;
    font-size: 10px;
  }

  .section_box_mid .box-one {
    display: flex;
  }

  .section_box_mid .box-one p,
  .section_box_mid .box-one h3 {
    text-align: center;
    font-size: 10px;
  }

  .section_box_mid .box-one p.link_book {
    position: absolute;
    bottom: 123px;
    right: 57px;
  }

  /* .section_box_bottom {
    position: relative;
    text-align: center;
    margin: 20px auto;
  } */

  .section_box_bottom .box_2 {
    padding-left: 24px;
  }

  .section_box_bottom .box_3 {
    padding-left: 24px;
    margin-top: 10px;
  }

  .section_box_bottom .box_2 p {
    margin-right: 20px;
  }

  .section_box_bottom .box_2 h3 {
    font-size: 10px;
  }

  .section_box_bottom .box_2 p {
    margin-left: 20px;
    font-size: 10px;
  }

  /* Banner image ở section bottom */
  .section_box_bottom .banner_img img {
    height: 125px;
    width: 260px;
  }


  .popup_content h4 {
    font-size: 16px;
    background-color: #FF6363;
    border: 4px solid #FFB370;
    border-radius: 25px;
    padding: 10px;
    margin: 90px 0 0px 38px;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }




  /* Nút đóng popup */
  .close_popup {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 10000;
    padding: 6px 5px;
    background-color: #f2c1c1;
    color: #fff;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 10px;
    transition: background-color 0.3s ease;
  }

  .close_popup:hover {
    background-color: #f28886;
  }

  /* Small popup */
  .small_popup {
    display: none;
    position: fixed;
    width: 717px;
    height: 500px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border: 3px solid #63ACFF;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1100;
    padding: 20px;
  }

  .small_popup_content {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .close_small_popup {
    position: absolute;
    top: -32px;
    right: -11px;
    border: none;
    border-radius: 57%;
    padding: 3px;
    cursor: pointer;
    background-color: #4c9af3;
    color: #fff;
    z-index: 1110;
    transition: background-color 0.3s;
  }

  .close_small_popup:hover {
    background-color: #4c9af3;
  }

  /* Các hover hiệu ứng cho popup_lo_trinh */
  #popup_lo_trinh .popup_content img,
  #popup_lo_trinh .popup_content p,
  #popup_lo_trinh .popup_content h3,
  #popup_lo_trinh .popup_content h4 {
    transition: transform 0.3s ease;
  }

  #popup_lo_trinh .popup_content img:hover,
  #popup_lo_trinh .popup_content p:hover,
  #popup_lo_trinh .popup_content h3:hover,
  #popup_lo_trinh .popup_content h4:hover {
    transform: scale(1.05);
  }

  #popup_lo_trinh .popup_content .luu_y ul li {
    transition: transform 0.3s ease;
  }

  #popup_lo_trinh .popup_content .luu_y ul li:hover {
    transform: scale(1.05);
  }

  /* Các thiết lập chung cho small popup */
  #popup_overlay,
  #popup_lo_trinh {
    display: none;
  }

  #popup_lo_trinh strong {
    color: red;
  }

  #popup_lo_trinh a {
    color: #ffffff;
  }

  #popup_lo_trinh .section_box_top .luu_y ul a {
    color: #333;
  }

  /* Responsive adjustments với media queries nếu cần */
  @media screen and (max-width: 768px) {
    .section_box_top {
      flex-direction: column;
    }

    .arrow {
      font-size: 2.5rem;
    }
  }
</style>

<style>
  .trung-tam {
    position: relative;
  }

  .arrow {
    position: absolute;
    font-size: 5rem;
    /* thay px bằng rem để dễ co giãn */
    color: #FFB370;
  }

  .arrow-right {
    top: 51%;
    left: 107%;
  }

  .arrow-down {
    top: 113%;
    left: 53%;
  }

  .arrow-up {
    top: -8%;
    left: 52%;
  }

  .arrow-left {
    top: 51%;
    left: -23%;
  }

  .section_box_bottom {
    position: relative;
    text-align: center;

  }

  /* .text-mid-3 {
    position: relative;
  } */

  .line,
  .line1,
  .line2,
  .line3,
  .line4,
  .line5 {
    position: absolute;
    background-color: #FFB370;
    height: 2px;
  }

  .line_top1 {
    width: 7px;
    height: 2px;
    top: -20%;
    left: 47%;
    transform: rotate(-91deg);
  }

  .line_top2 {
    width: 12px;
    height: 2px;
    top: -225%;
    left: 46%;
    transform: rotate(0deg);
  }

  .line_top3 {
    width: 33px;
    height: 2px;
    top: -183%;
    left: 38%;
    transform: rotate(-90deg);
  }





  .line_mid_left1 {
    width: 159px;
    height: 2px;
    top: 34%;
    left: 72%;
    transform: rotate(-144deg);
  }

  .line_mid_left2 {
    width: 128px;
    height: 2px;
    top: 133px;
    left: 78%;
    transform: rotate(-183deg);

  }

  .line_mid_left3 {
    width: 137px;
    height: 2px;
    top: 47%;
    left: 76%;
    transform: rotate(-160deg);
  }

  .line_mid_left4 {
    width: 139px;
    height: 2px;
    top: 73%;
    left: 76%;
    transform: rotate(-203deg);
  }





  .line_mid_right1 {
    width: 48px;
    height: 2px;
    top: 47%;
    right: 104%;
    transform: rotate(0);
  }

  .line_mid_right2 {
    width: 10px;
    height: 2px;
    top: 101%;
    right: -67%;
    transform: rotate(0deg);
  }

  .line_mid_right3 {
    width: 12px;
    height: 2px;
    top: -49%;
    right: -67%;
    transform: rotate(0deg);
  }

  .line_mid_right4 {
    width: 225px;
    height: 2px;
    top: 51%;
    right: -343%;
    transform: rotate(90deg);
  }

  .line_mid_right5 {
    width: 14px;
    height: 2px;
    top: 2%;
    right: -72%;
    transform: rotate(0deg);
  }

  .line_mid_right6 {
    width: 12px;
    height: 2px;
    top: 52%;
    right: -70%;
    transform: rotate(0deg);
  }

  .line_mid_right7 {
    width: 12px;
    height: 2px;
    top: 151%;
    right: -70%;
    transform: rotate(0deg);
  }

  .line_mid_right8 {
    width: 12px;
    height: 2px;
    top: 47%;
    right: -37%;
    transform: rotate(0deg);
  }

  .line_mid_right9 {
    width: 246px;
    height: 2px;
    top: 243%;
    right: 474%;
    transform: rotate(0deg);
  }


  /* .line_bottom1 {
    width: 244px;
    height: 2px;
    bottom: 47%;
    right: 38%;
    transform: rotate(0deg);
  } */
  .line_bottom2 {
    width: 16px;
    height: 2px;
    bottom: 47%;
    right: 59%;
    transform: rotate(90deg);
  }

  .line_bottom3 {
    width: 16px;
    height: 2px;
    bottom: 47%;
    right: 48%;
    transform: rotate(90deg);

  }

  .line_bottom4 {
    width: 15px;
    height: 2px;
    bottom: 47%;
    right: 37.5%;
    transform: rotate(90deg);
  }
</style>


<!-- css trong popup lo_trinh -->
<style>
  /* Tầng div cao nhất chứa 3 box, có border ngoài */
  .section_box_top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;

  }

  #popup_lo_trinh li a {
    font-size: 10px;
    color: #333;
  }



  /* Mỗi box chiếm đều 1 phần (flex: 1) */
  .section_box_top>div {
    flex: 1;
  }

  .box-left {
    text-align: left;
  }

  .box-center {
    text-align: center;
  }

  .box-right {
    text-align: right;
  }

  .social_media_top>div {
    display: inline-block;
    border: 2px solid red;
    border-radius: 25px;
    margin: 7px 0px 0px -29px;
  }

  .social_media_mid>div {
    display: inline-block;
    border: 2px solid red;
    border-radius: 25px;
    margin: 77px 18px 0px -3px;
  }

  .social_media_top img {
    width: 32px;
    height: 32px;
    margin: 5px 5px 0 0;
    vertical-align: middle;
  }

  .social_media_mid img {
    width: 32px;
    height: 32px;
    margin: 4px 4px 1px 1px;
    vertical-align: middle;
  }


  /* Box banner (box phải): căn giữa ảnh */
  .box-right .banner_img {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    height: 100%;
  }

  .box-right .banner_img img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
  }

  .popup_content p {
    font-size: 10px;
    background-color: #63ACFF;
    border: 2px solid #FF8585;
    border-radius: 25px;
    padding: 10px;
    margin: 10px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }



  #popup_lo_trinh .popup_content .section_box_top h3,
  #popup_lo_trinh .popup_content .section_box_mid h3,
  #popup_lo_trinh .popup_content .section_box_bottom h3 {
    font-size: 10px;
    background-color: #FF6363;
    border: 4px solid #FFB370;
    border-radius: 25px;
    padding: 10px;
    margin: 2px 0;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  #popup_lo_trinh .popup_content .section_box_mid h3 {
    margin: 90px -23px 0 0;
  }

  #popup_lo_trinh .popup_content .section_box_top h3 {
    margin: 6px 2px 20px 81px;
  }


  /* Dàn các phần tử trong section_box_mid theo hàng ngang */
  .section_box_mid {
    display: flex;
    justify-content: space-around;
    /* Các box con cách đều nhau */
    align-items: flex-start;
    gap: 70px;
    /* khoảng cách giữa các box con */
  }

  /* Thu nhỏ font của các h3 và p bên trong section_box_bottom xuống 10px */



  .section_box_bottom h3,
  .section_box_bottom p {
    font-size: 10px;
    margin: 5px 0;
  }

  .box-one p,
  .box-one h3,
  .box-two p,
  .box-two h3,
  .content p,
  .content h3 {
    display: inline-block;
    padding: 8px;
    margin: 0;
    width: 136px;
    height: 45px;
    text-align: center;
    margin: 5px;
    color: white;
  }

  .section_box_bottom p,
  .section_box_bottom h3 {
    display: inline-block;
    padding: 10px;
    margin: 0;
    color: white;
  }
</style>
<!-- JS cho popup -->
<script>
  $(document).ready(function () {
    $('.lo_trinh_btn').on('click', function (e) {
      e.preventDefault();
      $('#popup_overlay').fadeIn();
      $('#popup_lo_trinh').fadeIn();
    });

    $('#popup_overlay, #popup_lo_trinh .close_popup').on('click', function () {
      $('#popup_overlay').fadeOut();
      $('#popup_lo_trinh').fadeOut();
    });
  });


  $(document).on('click', '.trigger_small_popup', function (e) {
    e.preventDefault();
    var targetPopup = $(this).data('target');
    $('#' + targetPopup).fadeIn();
  });

  $(document).on('click', '.close_small_popup', function (e) {
    e.preventDefault();
    $(this).closest('.small_popup').fadeOut();
  });

</script>
<!-- css cho thông báo và yêu thích  -->
<style>
  @media (min-width:1200px) {
    .menu_top .menu_top_right .notification .list_notification {
      position: absolute;
      margin: auto;
      top: 30px;
      right: -127px !important;
      width: 866px !important;
      background: #fff;
    }
  }

  .avatar a {
    position: relative;
    /* Cho phép các phần tử con absolute định vị dựa trên đây */
    display: inline-block;
  }

  .total_quantam {
    position: absolute;
    top: 10px;
    right: 7px;
    transform: translate(50%, -50%);
    background-color: red;
    color: #fff;
    border-radius: 50%;
    font-size: 10px;
    padding: 3px 1px;
    line-height: 1;
    min-width: 16px;
    text-align: center;
  }

  .avatar {
    position: relative;
    display: inline-block;
  }

  .cart-count {
    position: absolute;
    top: 0px;
    right: -10px;
    background-color: rgb(249, 8, 8);
    color: rgb(255, 255, 255);
    padding: 0px 4px;
    border-radius: 50%;
    font-size: 10px;
    font-weight: bold;
    border: 2px solid white;
  }
</style>
<!-- Css các icon mới -->
<style>
  .marquee {
    margin-left: 350px;
  }

  .menu_top {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .menu_top_center {
    display: flex;
    align-items: center;
    width: 50%;
    margin: 0 auto;
  }

  .search_input {
    flex-grow: 1;
    width: auto;
    height: 30px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: -29px;
  }

  .search_icon {
    font-size: 20px;
    color: #333;
    margin-right: 10px;
  }

  .fa-search:before {
    content: "\f002";
    padding-left: 5px;
    color: #fff;
    /* padding: 4px;
    color: aliceblue;
    border-radius: 8px;
    background-color: rgb(250, 87, 0);
    border: 1px solid rgb(234, 141, 141); */
  }

  .social_box {
    display: flex;
    align-items: center;
    margin-right: 10px;
    font-size: 12px;
  }

  .social_box i {
    font-size: 13px;
    margin-right: 5px;
  }

  .avatar {
    position: relative;
    display: inline-block;
  }

  .notification_badge {
    position: absolute;
    top: 0;
    right: 0;
    background: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 10px;
    display: none;
  }
</style>






<style>
  @media only screen and (max-width: 768px) {
    .menu_top {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      align-items: center;
      justify-content: space-between;
      font-size: 12px;
      height: auto;
    }

    .menu_top .menu_top_right .notification .list_notification {
      right: -121px;
    }

    .page_body .box_right .box_right_content .box_profile .box_timkiem input {
      display: none;
    }

    .page_body .box_right .box_right_content .box_profile .box_timkiem button {
      display: none;
    }

    .page_body .box_right .box_right_content .box_profile .box_shopcart {
      display: none;
    }

    .menu_top_center {
      display: flex;
      align-items: center;
      width: 100%;
      margin: 0 auto;
    }

    .menu_top_left {
      display: flex;
      align-items: center;
      gap: 10px;
      order: 2;
      /* Đưa menu_top_left xuống hàng dưới */
      flex: 1;
      /* Đảm bảo nó chiếm không gian bằng nhau */
    }

    .menu_top_right {
      display: flex;
      align-items: center;
      gap: 0px;
      order: 2;
      /* Đưa menu_top_right xuống cùng hàng với menu_top_left */
      flex: 1;
      margin-left: 48px;
      /* Đảm bảo nó chiếm không gian bằng nhau */
    }

    .menu_top .menu_top_right .drop_down .drop_menu {
      width: 200px;
      position: absolute;
      top: 66px;
      right: -68px;
      z-index: 1000;
      float: left;
      color: #212529;
      text-align: left;
      list-style: none;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, .15);
      padding-top: 1rem;
      border-radius: .25rem;
      display: none;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    .search_input,
    .button_timkiem {
      flex: 1;
      width: auto;
    }

    .social_box {
      flex: 1;
      text-align: center;
    }

    .logo_mobile {
      text-align: center;
    }

    .slogan {
      font-size: 14px;
      color: #777;
      margin-top: 5px;
    }

    .notification,
    .avatar,
    .drop_down {
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .menu_top_center .social_box {
      margin: 0 5px;
      padding: 3px 6px;
      border: 1px solid rgb(147, 141, 140);
      border-radius: 15px;
      background-color: rgb(42, 68, 231);
      font-size: 12px;
    }

    .menu_top_center .social_box i {
      font-size: 16px;
      margin-right: 3px;
    }

    .menu_top .menu_top_right button {
      display: none;
    }

    .menu_top_center .social_box span a {
      color: aliceblue;
      font-size: 12px;
      text-decoration: none;
    }

  }
</style>

</html>