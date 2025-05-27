<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm màu sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tên màu</label>
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tên màu...">
                </div>
                <div class="form_group">
                    <label for="">Mã màu</label>
                    <input class="form_control" name="ma_mau" data-jscolor="{}" value="#f60" placeholder="Nhập mã màu...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự sắp xếp...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <a href="/ncc/list-color" class="btn-secondary-back">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>
                <button name="add_color" class="button_all"> Thêm   <i class="fa fa-check"></i> </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jscolor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_color'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>