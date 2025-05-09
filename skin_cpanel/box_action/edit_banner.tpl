<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa banner</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tiêu đề slide...">
                </div>
                <div class="form_group">
                    <label for="">Hình ảnh</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Màu nền</label>
                    <input type="color" class="form_control" name="bg_banner" value="{bg_banner}" placeholder="Nhập màu nên banner...">
                </div>
                <div class="form_group">
                    <label for="">Liên kết</label>
                    <input type="text" class="form_control" name="link" value="{link}" placeholder="Nhập liên kết slide...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mới liên kết</label>
                    <select class="form_control" name="target">
                        <option value="">Cửa sổ hiện tại</option>
                        <option value="_blank">Cửa số mới</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Vị trí</label>
                    <select class="form_control" name="vi_tri">
                        <option value="top">Banner top</option>
                        <option value="bottom_slide">Banner dưới slide</option>
                        <option value="sanpham_banchay">Box sản phẩm bán chạy</option>
                        <option value="sanpham_noibat">Box sản phẩm nổi bật</option>
                        <option value="banner_index">Banner chính trang chủ laptop</option>
                        <option value="banner_index_mobile">Banner chính trang chủ mobile</option>
                        <option value="banner_baohanh">Banner bảo hành laptop</option>
                        <option value="banner_baohanh_mobile">Banner bảo hành mobile</option>
                        <option value="banner_big">Banner sau banner chính</option>
                        <option value="banner_flash_sale">Banner Page Flash sale</option>
                        <option value="banner_flash_sale_mobile">Banner Page Flash sale Mobile</option>
                        <option value="banner_voucher">Banner Voucher</option>
                        <option value="banner_voucher_mobile">Banner Voucher Mobile</option>
                        <option value="banner_dautruong">Banner Đấu trường</option>
                        <option value="banner_dautruong_mobile">Banner Đấu trường mobile</option>
                        <option value="banner_deal_soc">Banner Deal sốc</option>
                        <option value="banner_deal_soc_mobile">Banner Deal sốc mobile</option>
                        <option value="banner_doitac">Banner Đối tác</option>
                        <option value="banner_doitac_hai">Banner Đối tác hai</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_banner" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var target = '{target}';
    var vi_tri = '{vi_tri}';
    $('select[name=target]').val(target);
    $('select[name=vi_tri]').val(vi_tri);
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_banner'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>