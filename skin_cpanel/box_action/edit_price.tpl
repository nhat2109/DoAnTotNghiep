<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa khoảng giá sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Kiểu</label>
                    <select class="form_control" name="kieu" id="kieu_price">
                        <option value="nho">Nhỏ hơn</option>
                        <option value="khoang" selected="">Trong khoảng</option>
                        <option value="lon">Lớn hơn</option>
                    </select>
                </div>
                <div class="form_group price_to" style="display: none;">
                    <label for="">Giá</label>
                    <input type="text" class="form_control price_format" name="price" value="" placeholder="Nhập giá...">
                </div>
                <div class="form_group khoang">
                    <label for="">Giá từ</label>
                    <input type="text" class="form_control price_format" name="min_price" value="{min_price}" placeholder="Nhập giá bắt đầu...">
                </div>
                <div class="form_group khoang">
                    <label for="">Giá tới</label>
                    <input type="text" class="form_control price_format" name="max_price" value="{max_price}" placeholder="Nhập giá kết thúc...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự sắp xếp...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" value="{id}" name="id">
                <button name="edit_price" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    var kieu ='{kieu}';
    var min_price='{min_price}';
    var max_price='{max_price}';
    $('select[name=kieu]').val(kieu);
    if(kieu=='nho'){
        $('input[name=price]').val(max_price);
        $('.khoang').hide();
        $('.price_to').show();
    }else if(kieu=='lon'){
        $('input[name=price]').val(min_price);
        $('.khoang').hide();
        $('.price_to').show();          
    }else{
        $('.khoang').show();
        $('.price_to').hide();  
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_price'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>