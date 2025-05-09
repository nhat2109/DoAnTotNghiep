<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa thương hiệu sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tên thương hiệu</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}"
                        placeholder="Nhập tên thương hiệu...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}"
                        placeholder="Nhập thứ tự sắp xếp...">
                </div>
                <!-- huyphuc14/04/2025 -->
                <div class="form_group">
                    <label for="">Hình ảnh</label>
                    <div>
                        <img src="{anh_thuong_hieu}" alt="anh" width="120" height="120">
                    </div>
                    <div style="clear: both;"></div>
                    <div class="anh_thuong_hieu" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-thuonghieu" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="thuong_hieu" id="anh_thuonghieu" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">link đi kèm hình ảnh</label>
                    <input type="text" class="form_control" name="link_anh"  value="{link_anh}" placeholder="Nhập link ảnh...">
                </div>
                <div class="form_group">
                    <label for="">Hiển thị ra trang chủ</label>
                    <div class="checkbox_group" data-hien-thi="{status}">
                        <input type="checkbox" id="hien_thi_co" name="hien_thi" value="1">
                        <label for="hien_thi_co">Có</label>
                        <input type="checkbox" id="hien_thi_khong" name="hien_thi" value="0">
                        <label for="hien_thi_khong">Không</label>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_brand" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        total_height = 0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function () {
            total_height += $(this).outerHeight();
            if ($(this).attr('id') == 'menu_brand') {
                vitri = total_height - 90;
            }
        });
        $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
    });
</script>