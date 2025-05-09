<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm giao diện mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tiêu đề slide...">
                </div>
                <div class="form_group">
                    <label for="">Hình ảnh</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Hình ảnh(sóc đỏ)</label>
                    <div style="clear: both;"></div>
                    <div class="mh_socdo" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-minhhoa-socdo" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa_socdo" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Link demo</label>
                    <input type="text" class="form_control" name="demo" value="" placeholder="Nhập link demo gian hàng...">
                </div>
                <div class="form_group">
                    <label for="">Giá niêm yết</label>
                    <input type="text" class="form_control price_format" name="gia_cu" value="" placeholder="Nhập giá niêm yết...">
                </div>
                <div class="form_group">
                    <label for="">Giá áp dụng</label>
                    <input type="text" class="form_control price_format" name="gia_moi" value="" placeholder="Nhập giá áp dụng...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_giaodien" class="button_all"> Thêm </button>
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
            if($(this).attr('id')=='menu_giaodien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>
