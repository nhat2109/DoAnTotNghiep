<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm tên miền mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tên domain</label>
                    <input type="text" class="form_control" name="domain" value="" placeholder="Nhập tên domain...">
                </div>
                <div class="form_group">
                    <label for="">Loại tên miền</label>
                    <select class="form_control" name="loai">
                        <option value="quocte">Quốc tế</option>
                        <option value="vietnam">Việt Nam</option>
                    </select>
                </div>
                <div class="form_group khoang">
                    <label for="">Giá</label>
                    <input type="text" class="form_control price_format" name="gia" value="" placeholder="Nhập giá năm đầu...">
                </div>
                <div class="form_group khoang">
                    <label for="">Phí cài đặt</label>
                    <input type="text" class="form_control price_format" name="phi_caidat" value="" placeholder="Nhập phí cài đặt...">
                </div>
                <div class="form_group khoang">
                    <label for="">Giá gia hạn</label>
                    <input type="text" class="form_control price_format" name="gia_han" value="" placeholder="Nhập giá gia hạn tên miền...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự sắp xếp...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_domain" class="button_all"> Thêm </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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