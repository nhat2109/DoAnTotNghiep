<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa trạng thái mua tên miền</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thành viên</label>
                    <input type="text" class="form_control" name="username" value="{username}" disabled="">
                </div>
                <div class="form_group">
                    <label for="">Tên domain</label>
                    <input type="text" class="form_control" name="domain" value="{domain}" placeholder="Nhập tên domain...">
                </div>
                <div class="form_group">
                    <label for="">Trạng thái</label>
                    <select class="form_control" name="status">
                        <option value="0">Chờ xử lý</option>
                        <option value="1">Đã hoàn thành</option>
                        <option value="2">Đã hủy</option>
                    </select>
                </div>
                <div class="form_group khoang">
                    <label for="">Giá</label>
                    <input type="text" class="form_control price_format" name="gia" value="{gia}" placeholder="Nhập giá năm đầu...">
                </div>
                <div class="form_group khoang">
                    <label for="">Phí cài đặt</label>
                    <input type="text" class="form_control price_format" name="phi_caidat" value="{phi_caidat}" placeholder="Nhập phí cài đặt...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_mua_domain" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=loai]').val('{loai}');
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_domain_price'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>