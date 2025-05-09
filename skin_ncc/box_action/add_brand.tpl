<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm thương hiệu sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="form_group">
                <div class="list_phanloai">
                    <div class="th_phanloai">           
                        <div class="info_brand">Thương hiệu Sóc Đỏ</div>
                    </div>
                    <div class="li_phanloai">    
                        <div class="info_name">
                            <input type="text" name="brand[]" giatri="" placeholder="Tìm thương hiệu Sóc Đỏ..." class="brand-socdo-input">
                            <input type="hidden" name="id_thuonghieu_socdo" value="0">
                            <div class="list_goiy scroll"></div>
                        </div>  
                    </div> 
                </div>
             
                <div class="col_50">
                    <div class="form_group">
                        <label for="">Tên thương hiệu</label>
                        <input type="text" class="form_control brand-socdo-input-text" name="tieu_de" value="" placeholder="Nhập tên thương hiệu...">
                    </div>
                    <div class="form_group">
                        <label for="">Thứ tự</label>
                        <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự sắp xếp...">
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <button name="add_brand" class="button_all">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        total_height = 0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height += $(this).outerHeight();
            if($(this).attr('id') == 'menu_brand'){
                vitri = total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);

        

        
    });
</script>

<style>
    .list_phanloai .li_phanloai input {
        width: 180% !important;
    }
    .list_phanloai .th_phanloai .info_brand {
        width: 175px !important;
        text-indent: 5px;
    }
.list_goiy .li_goiy {
    display: flex;
    align-items: center;
    padding: 5px;
    cursor: pointer;
}
.list_goiy .li_goiy:hover {
    background-color: #f0f0f0;
}
</style>
