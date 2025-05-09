<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm menu mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">kiểu menu</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="loai" value="link" checked="checked">Liên kết ngoài  <input type="radio" name="loai" value="category"> Danh mục sản phẩm  <input type="radio" name="loai" value="theloai"> Danh mục Bài viết <input type="radio" name="loai" value="page"> Trang
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Vi trị</label>
                    <select class="form_control" name="vi_tri">
                        <option value="top">Menu chính</option>
                        <option value="chinhsach">Menu Chính sách</option>
                        <option value="huongdan">Menu Hướng dẫn</option>
                    </select>
                </div>
                <div class="form_group" style="display: none;" id="select_category">
                    <label for="">Chọn danh mục sản phẩm</label>
                    <select class="form_control" name="category">
                        <option>Chọn danh mục</option>
                    	{option_category_sanpham}
                    </select>
                </div>
                <div class="form_group" style="display: none;" id="select_theloai">
                    <label for="">Chọn danh mục bài viết</label>
                    <select class="form_control" name="theloai">
                        <option>Chọn danh mục</option>
                        {option_category}
                    </select>
                </div>
                <div class="form_group" style="display: none;" id="select_page">
                    <label for="">Chọn trang</label>
                    <select class="form_control" name="page">
                        <option>Chọn trang</option>
                        <option value="/lien-he.html">Liên hệ</option>
                        <option value="/gioi-thieu.html">Giới thiệu</option>
                        <option value="/san-pham.html">Sản phẩm</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group" id="input_link">
                    <label for="">Link</label>
                    <input type="text" class="form_control" name="link" value="" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mở</label>
                    <select class="form_control" name="target">
                        <option value="">Cửa sổ hiện tại</option>
                        <option value="_blank">Cửa sổ mới</option>
                    </select>
                </div>               
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_menu" class="button_all"> Thêm </button>
            </div>
        </div>
    </div>
</div>