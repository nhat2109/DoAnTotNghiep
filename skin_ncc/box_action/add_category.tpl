<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1>Thêm danh mục sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Danh mục mẹ</label>
                    <select class="form_control" name="cat_main">
                        <option value="0">Chọn danh mục</option>
                        <option value="0">Danh mục chính</option>
                        {option_main}
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tiêu đề <span class="color_red">*</span></label>
                    <input type="text" class="form_control tieude_seo" name="cat_tieude" onkeyup="check_blank('category');" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem <span class="color_red">*</span></label>
                    <input type="text" class="form_control link_seo" name="cat_blank" onkeyup="check_link('category');" placeholder="Nhập link xem...">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Banner <span class="color_red">(Kích thước 288x590pixel)</span></label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="cat_title" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="cat_description" class="form_control" placeholder="Nhập mô tả danh mục" style="width: 100%;height: 95px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Hiện index</label>
                    <input type="radio" name="cat_index" value="1"> Có <input type="radio" name="cat_index" value="0" checked=""> Không
                </div>
                <div class="form_group">
                    <label for="">Liên kết banner</label>
                    <input type="text" class="form_control" name="cat_link" placeholder="Nhập liên kết với banner...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự <span class="color_red">*</span></label>
                    <input type="text" class="form_control" name="cat_thutu" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_category" class="button_all">Thêm</button>
            </div>
        </div>
    </div>
</div>