<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa gói dịch vụ NCC</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Dịch vụ</label>
                    <select class="form_control" name="loai">
                        <option value="template">Thiết kế và Setup Website</option>
                        <option value="seeding">Quản trị và vận hành website</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tên sản phẩm</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tên của gói...">
                </div>
                <div class="form_group">
                    <label for="">Giá niêm yết</label>
                    <input type="text" class="form_control price_format" name="gia_cu" value="{gia_cu}" placeholder="Nhập giá cũ...">
                </div>
                <div class="form_group">
                    <label for="">Giá bán</label>
                    <input type="text" class="form_control price_format" name="gia" value="{gia}" placeholder="Nhập giá mới...">
                </div>
                <div class="form_group">
                    <label for="">Thời gian</label>
                    <input type="text" class="form_control" name="thoi_gian" value="{thoi_gian}" placeholder="Nhập thời gian...">
                </div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <textarea name="uu_dai" class="form_control" placeholder="" style="width: 100%;height: 95px;">{uu_dai}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự hiển thị...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_goi_seeding_shopee_ncc" class="button_all"> Lưu lại</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=loai]').val('{loai}');
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_seeding'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
    
</script>