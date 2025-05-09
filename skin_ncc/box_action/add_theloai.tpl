<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile form-container">
            <div class="page_title text-center">
                <h1 class="undefined">Thêm danh mục bài viết mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group" style="display: none;">
                    <label for="">Link copy</label>
                    <input type="text" class="form_control" name="link_copy" value=""
                        placeholder="Nhập link copy thể loại...">
                </div>
                <div class="form_group" style="display: none;">
                    <button class="button_all" name="copy_category"> Copy thể loại </button>
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Danh mục mẹ</label>
                    <select class="form_control" name="cat_main">
                        <option value="0">Chọn danh mục</option>
                        <option value="0">Danh mục chính</option>
                        {option_main}
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="cat_tieude"
                        onkeyup="check_blank('theloai');" value="" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="cat_blank" onkeyup="check_link('theloai');"
                        value="" placeholder="Nhập link xem...">
                    <div class="check_link"></div>
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Nội dung</label>
                    <textarea name="cat_noidung" class="form_control" placeholder="Nhập nội dung danh mục"
                        style="width: 100%;height: 95px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="cat_title" value="" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="cat_description" class="form_control" placeholder="Nhập mô tả thể loại"
                        style="width: 100%;height: 95px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="cat_thutu" value="" placeholder="Nhập thứ tự...">
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Icon</label>
                    <input type="text" class="form_control" name="cat_icon" value="" placeholder="Nhập biểu tưởng...">
                </div>
                <div class="form_group">
                    <label for="">Hiện index</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="cat_index" value="1"> Có <input type="radio" name="cat_index" value="0"
                        checked=""> không
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="add_theloai" class="button_all"> Thêm </button>
            </div>
        </div>
    </div>
</div>
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .text-center {
        text-align: center;
    }

    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    .form_group {
        margin-bottom: 20px;
    }

    .form_control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .button_all {
        display: block;
        width: 200px;
        margin: 20px auto;
        padding: 10px;
        background: #ff0000;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .button_all:hover {
        background: #cc0000;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 10px;
        }

        .form-wrapper {
            width: 95%;
        }
    }
</style>