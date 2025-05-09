<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa quản trị viên</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tài khoản</label>
                    <input type="text" class="form_control" name="username" disabled="disabled" value="{username}" placeholder="Nhập tài khoản đăng nhập...">
                </div>
                <div class="form_group">
                    <label for="">Mật khẩu <span style="color: red;font-style: italic;">(bỏ trống nếu không đổi mật khẩu)</span></label>
                    <input type="password" class="form_control" name="password" value="" placeholder="Nhập mật khẩu đăng nhập..">
                </div>
                <div class="form_group">
                    <label for="">Họ và tên</label>
                    <input type="text" class="form_control" name="name" value="{name}" placeholder="Nhập họ và tên...">
                </div>
                <div class="form_group">
                    <label for="">Điện thoại</label>
                    <input type="text" class="form_control" name="mobile" value="{mobile}" placeholder="Nhập số điện thoại...">
                </div>
                <div class="form_group">
                    <label for="">Email</label>
                    <input type="text" class="form_control" name="email" value="{email}" placeholder="Nhập địa chỉ email...">
                </div>
                <div class="form_group">
                    <label for="">Địa chỉ</label>
                    <input type="text" class="form_control" name="address" value="{address}" placeholder="Nhập địa chỉ...">
                </div>
                <div class="form_group">
                    <label for="">Bộ phận hỗ trợ</label>
                    <select name="bo_phan" class="form_control">
                        <option value="">Bộ phận hỗ trợ</option>
                        <option value="hotro_chung">Hỗ trợ chung</option>
                        <option value="don_hang">Hỗ trợ đơn hàng</option>
                        <option value="bao_hanh">Hỗ trợ bảo hành, đổi trả</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Khu vực quản trị <span style="color: red;">(*)</span></label>
                    <div style="clear: both;"></div>
                    <div class="li_input" id="input_donhang"><input type="checkbox" name="group[]" value="donhang"> Đơn hàng</div>
                    <div class="li_input" id="input_naptien"><input type="checkbox" name="group[]" value="naptien"> Nạp tiền</div>
                    <div class="li_input" id="input_coupon"><input type="checkbox" name="group[]" value="coupon"> Coupon</div>
                    <div class="li_input" id="input_nhom"><input type="checkbox" name="group[]" value="nhom"> Nhóm</div>
                    <div class="li_input" id="input_sanpham"><input type="checkbox" name="group[]" value="sanpham"> Sản phẩm</div>
                    <div class="li_input" id="input_category"><input type="checkbox" name="group[]" value="category"> Danh mục sản phẩm</div>
                    <div class="li_input" id="input_color"><input type="checkbox" name="group[]" value="color"> Màu sản phẩm</div>
                    <div class="li_input" id="input_brand"><input type="checkbox" name="group[]" value="brand"> Thương hiệu</div>
                    <div class="li_input" id="input_size"><input type="checkbox" name="group[]" value="size"> Kích cỡ</div>
                    <div class="li_input" id="input_price"><input type="checkbox" name="group[]" value="price"> khoảng giá</div>
                    <div class="li_input" id="input_thongke"><input type="checkbox" name="group[]" value="thongke"> Thống kê</div>
                    <div class="li_input" id="input_baiviet"><input type="checkbox" name="group[]" value="baiviet"> Bài viết</div>
                    <div class="li_input" id="input_theloai"><input type="checkbox" name="group[]" value="theloai"> Danh mục bài viết</div>
                    <div class="li_input" id="input_slide"><input type="checkbox" name="group[]" value="slide"> Slide</div>
                    <div class="li_input" id="input_banner"><input type="checkbox" name="group[]" value="banner"> Banner</div>
                    <div class="li_input" id="input_thanhvien"><input type="checkbox" name="group[]" value="thanhvien"> Thành viên</div>
                    <div class="li_input" id="input_quantri"><input type="checkbox" name="group[]" value="quantri"> Ban quản trị</div>
                    <div class="li_input" id="input_lienhe"><input type="checkbox" name="group[]" value="lienhe"> Liên hệ</div>
                    <div class="li_input" id="input_caidat"><input type="checkbox" name="group[]" value="caidat"> Cài đặt</div>
                    <div class="li_input" id="input_quanly_live"><input type="checkbox" name="group[]" value="quanly_live"> Quản lý live stream</div>
                </div>
            </div>
            <div style="clear: both;height: 30px;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_quantri" class="button_all"> Hoàn thành</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    {list_group}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_quantri'){
                vitri=total_height - 90;
            }
        });
        $('select[name=bo_phan]').val('{bo_phan}');
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>