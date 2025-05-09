<!-- <script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script> -->
<script src="/js/process_cpanel.js?t=<?php echo time();?>"></script>

<div class="load_overlay"></div>
<div class="load_process">
	<div class="load_content">
		<img src="/images/load.gif" alt="loading" width="70">
		<div class="load_note">Hệ thống đang xử lý...</div>
	</div>
</div>
<div class="box_pop" id="box_pop_confirm">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;" id="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hàng động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button id="button_thuchien" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="box_pop" id="box_pop_confirm_action">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;" class="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hàng động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button class="" style="display: none;" id="button_ok">Thực hiện hành động</button>
                <button id="button_thuchien_action" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="box_select_product">
    <div class="box_select_product_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn sản phẩm</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_top">
                <div class="box_search">
                    <input type="text" name="key_deal" placeholder="Nhập từ khóa tìm kiếm"> <button class="search_deal">Tìm</button>
                </div>
                <div class="box_sort">
                    <select name="sort">
                        <option value="id-desc">Sản phẩm mới - cũ</option>
                        <option value="id-asc">Sản phẩm cũ - mới</option>
                        <option value="price-asc">Giá tăng dần</option>
                        <option value="price-desc">Giá giảm dần</option>
                        <option value="tieude-asc">Tên sản phẩm A - Z</option>
                        <option value="tieude-desc">Tên sản phẩm Z - A</option>
                    </select>
                </div>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1"></div>
            <div class="box_bottom">
                <button name="select_main_product" loai="main_product">Tiếp tục</button>
            </div>
        </div>
    </div>
</div>
<div class="box_select_product_trend">
    <div class="box_select_product_trend_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn sản phẩm</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_deal" placeholder="Nhập từ khóa tìm kiếm"> <button class="search_deal">Tìm</button>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1"></div>
        </div>
    </div>
</div>
<div class="box_select_product_tuan">
    <div class="box_select_product_tuan_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn sản phẩm</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_deal" placeholder="Nhập từ khóa tìm kiếm"> <button class="search_deal">Tìm</button>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1"></div>
        </div>
    </div>
</div>
<div class="box_select_nguoinhan">
    <div class="box_select_nguoinhan_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn khách hàng</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_member" placeholder="Nhập từ khóa tìm kiếm"> <button class="search_member">Tìm</button>
            </div>
            <div class="box_list scroll" user_id=""></div>
        </div>
    </div>
</div>
<div class="box_select_quanly">
    <div class="box_select_quanly_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn người quản lý</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_quanly" placeholder="Nhập từ khóa tìm kiếm"> <button class="search_member">Tìm</button>
            </div>
            <div class="list_th">
                <div class="stt">STT</div>
                <div class="name">Họ và tên</div>
                <div class="mobile">Điện thoại</div>
                <div class="total">Thành viên quản lý</div>
                <div class="action">Hành động</div>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1">
            </div>
        </div>
    </div>
</div>
<div class="box_sms_bottom"><div class="box_sms_bottom_content"><a href="/admincp/list-chat"><i class="icon icon-bubbles2"></i><span class="total_chat">0</span></a></div></div>
<div class="box_pop_add"></div>
<input type="hidden" name="thanhvien_chat" value="{thanhvien_chat}">
<input type="hidden" name="bophan_hotro" value="{bo_phan}">
<input type="hidden" name="giaoviec" value="giaoviec">
<audio id="sound_chat">
    <source src="/images/chat.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<audio id="sound_global_message">
    <source src="/images/global_message3.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<audio id="sound_notification">
    <source src="/images/global_message.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<button id="play_chat" onclick="play_chat()" style="display: none;">Play sound</button>
<button id="play_chat_global" onclick="play_global()" style="display: none;">Play sound</button>
<button id="play_notification" onclick="play_notification()" style="display: none;">Play sound</button>
<script>
    var sound_chat = document.getElementById("sound_chat"); 
    var sound_global_message = document.getElementById("sound_global_message");
    var sound_notification = document.getElementById("sound_notification");  
    function play_chat() { 
      sound_chat.play(); 
    } 
    function play_global() { 
      sound_global_message.play(); 
    }
    function play_notification() { 
      sound_notification.play(); 
    } 
</script>