<!-- <script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script>
<!-- <script type="text/javascript" src="/tinymce_4.4.3/jquery.tinymce.min.js"></script> -->
<script type="text/javascript">
   tinymce.init({
        selector: '#edit_textarea',
        mode: "exact",
        theme: "modern",
        image_advtab: true,
        menubar: false,
        height: "250px",
        tabindex: 2,
        relative_urls: false,
        browser_spellcheck: true,
        forced_root_block: false,
        entity_encoding: "raw",
        content_css: "/tinymce_4.4.3/content.css",
        fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
        plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
        toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | link unlink | bullist numlist | image searchreplace code | removeformat fullscreen",
        file_picker_callback: function (callback, value, meta) {

            // File type
            if (meta.filetype == "media" || meta.filetype == "image") {

                // Trigger click on file element
                $("#fileupload").trigger("click");
                $("#fileupload").unbind('change');

                // File selection
                $("#fileupload").on("change", function () {
                    var file = this.files[0];
                    var reader = new FileReader();

                    // FormData
                    var fd = new FormData();
                    var files = file;
                    fd.append("action", "upload_tinymce");
                    fd.append("file", files);
                    // AJAX
                    $.ajax({
                        url: "/dropship/process.php",
                        type: "post",
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            filename = info.minh_hoa;
                        }
                    });
                    reader.onload = function (e) {
                        callback(filename);
                    };
                    reader.readAsDataURL(file);
                });
            }

        }
    });
    tinymce.init({
        selector: '#noibat',
        mode: "exact",
        theme: "modern",
        image_advtab: true,
        menubar: false,
        height: "250px",
        tabindex: 2,
        relative_urls: false,
        browser_spellcheck: true,
        forced_root_block: false,
        entity_encoding: "raw",
        content_css: "/tinymce_4.4.3/content.css",
        fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
        plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
        toolbar1: "forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | link unlink | bullist numlist | removeformat",
        file_picker_callback: function (callback, value, meta) {

            // File type
            if (meta.filetype == "media" || meta.filetype == "image") {

                // Trigger click on file element
                $("#fileupload").trigger("click");
                $("#fileupload").unbind('change');

                // File selection
                $("#fileupload").on("change", function () {
                    var file = this.files[0];
                    var reader = new FileReader();

                    // FormData
                    var fd = new FormData();
                    var files = file;
                    fd.append("action", "upload_tinymce");
                    fd.append("file", files);
                    // AJAX
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            filename = info.minh_hoa;
                        }
                    });
                    reader.onload = function (e) {
                        callback(filename);
                    };
                    reader.readAsDataURL(file);
                });
            }

        }
    });
    function generateRandomCode() {
        // Lấy ngày tháng hiện tại
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0'); // DD
        const month = String(now.getMonth() + 1).padStart(2, '0'); // MM (tháng bắt đầu từ 0 nên +1)
        const year = now.getFullYear(); // YYYY
        const dateStr = `${day}${month}${year}`; // DDMMYYYY, ví dụ: 23032025

        // Tạo 3 ký tự ngẫu nhiên (2 chữ cái + 1 số)
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '0123456789';
        const randomLetter1 = letters.charAt(Math.floor(Math.random() * letters.length)); // Chữ cái 1
        const randomLetter2 = letters.charAt(Math.floor(Math.random() * letters.length)); // Chữ cái 2
        const randomNumber = numbers.charAt(Math.floor(Math.random() * numbers.length)); // Số

        // Kết hợp thành mã: chữ cái + số + ngày tháng
        const randomCode = `${randomLetter1}${randomNumber}${randomLetter2}${dateStr}`;
        return randomCode; // Ví dụ: K7X23032025
    }
    // Tự động tạo mã cho hàng phân loại đầu tiên khi trang được tải
    $(document).ready(function() {
        const randomCode = generateRandomCode();
        $('.list_phanloai .li_phanloai input[name^=ma]').val(randomCode);
    });
</script>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Đăng sản phẩm ngoài</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');"
                        value="" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link('sanpham');"
                        value="" placeholder="Nhập link xem...">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Minh họa(Bấm vào ảnh để chọn ảnh mới)</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200"
                            id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <!-- <div class="form_group">
                    <label for="">Giá niêm yết</label>
                    <input type="text" class="form_control price_format" name="gia_cu" value="" placeholder="Nhập giá niêm yết...">
                </div>
                <div class="form_group">
                    <label for="">Giá bán lẻ</label>
                    <input type="text" class="form_control price_format" name="gia_moi" value="" placeholder="Nhập giá bán lẻ...">
                </div> -->
                <!-- <div class="form_group">
                    <label for="">Kho hàng</label>
                    <input type="text" class="form_control price_format" name="kho" value="" placeholder="Nhập số hàng trong kho...">
                </div> -->
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Ảnh sản phẩm</label>
                    <button class="button_select_photo">Chọn ảnh</button>
                    <div class="list_photo"></div>
                </div>
                <div class="form_group">
                    <h3 for="">Kích thước đóng hộp</h3>
                    <div style=" display: flex;">
                        <div style="margin-right:10px;">
                            <label for="">Chiều dài (cm)</label>
                            <input type="text" class="form_control price_format" name="chieudai_shop" value="0"
                                placeholder="Nhập chiều dài (cm)...">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều rộng (cm)</label>
                            <input type="text" class="form_control price_format" name="chieurong_shop" value="0"
                                placeholder="Nhập chiều rộng (cm)...">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều cao (cm)</label>
                            <input type="text" class="form_control price_format" name="chieucao_shop" value="0"
                                placeholder="Nhập chiều cao (cm)...">
                        </div>
                    </div>
                </div>
                <!-- <div class="form_group">
                    <label for="">Màu sản phẩm</label>
                    <div style="clear: both;"></div>
                    <div class="list_input_post">
                        {option_color}
                    </div>
                </div> -->
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Phân loại sản phẩm</label>
                    <button class="button_add_phanloai">Thêm phân loai</button>
                    <div class="list_phanloai">
                        <div class="th_phanloai">
                            <div class="info_ma">
                                SKU
                            </div>
                            <div class="info_name">
                                Kích cỡ
                            </div>
                            <div class="info_mau">
                                Màu sắc
                            </div>
                            <div class="info_can_nang">
                                Cân nặng (kg)
                            </div>
                            <div class="info_gia">
                                Giá niêm yết
                            </div>
                            <div class="info_gia">
                                Giá bán lẻ
                            </div>
                            <div class="info_kho_sanpham_shop">Tồn kho</div>
                            <div class="info_trongluongtinhship">Trọng lượng tính ship</div>
                            <div class="info_action"></div>
                            <div class="info_action_copy"></div>
                        </div>
                        <div class="li_phanloai">
                            <div class="info_ma">
                                <input type="text" name="ma[]" placeholder="Mã">
                            </div>
                            <div class="info_name">
                                <input type="text" name="size[]" giatri="" placeholder="Kích cỡ">
                                <div class="list_goiy scroll"></div>
                            </div>
                            <div class="info_mau">
                                <input type="text" name="color[]" giatri="" placeholder="Màu sắc">
                                <div class="list_goiy scroll">
                                </div>
                            </div>
                            <div class="info_can_nang">
                                <input type="text" name="can_nang[]" placeholder="Trọng lượng">
                            </div>
                            <div class="info_gia">
                                <input type="text" name="gia_cu[]" class="price_format" placeholder="Giá niêm yết">
                            </div>
                            <div class="info_gia">
                                <input type="text" name="gia_moi[]" class="price_format" placeholder="Giá bán">
                            </div>
                            <div class="info_kho_sanpham_shop">
                                <input type="text" name="kho_sanpham_shop[]" class="price_format" value="0"
                                    placeholder="Số hàng trong kho">
                            </div>
                            <div class="info_trongluongtinhship">
                                <input type="text" name="trongluongtinhship[]" class="price_format" value="0" readonly>
                            </div>
                            <div class="info_action"><i class="fa fa-trash-o"></i> Xóa</div>
                            <div class="info_action_copy"><i class="fa fa-files-o"></i> Sao chép</div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Thông số sản phẩm</label>
                    <button class="button_add_info">Thêm dòng</button>
                    <div class="list_info">
                        {list_info}
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div style="clear: both;"></div>

            <div class="col_50">
                <!-- <div class="form_group">
                    <label for="">Kích cỡ</label>
                    <select class="form_control" name="size">
                        <option value="">Chọn kích cỡ</option>
                        {option_size}
                    </select>
                    <input style="margin-top: 5px;" type="text" class="form_control" name="size_2" value="" placeholder="Hoặc thêm mới...">
                </div> -->
                <!-- <div class="form_group">
                    <label for="">Trọng lượng (Đơn vị kg)</label>
                    <input type="text" class="form_control" name="can_nang" value="" placeholder="Nhập trọng lượng bằng số (Ví dụ 5kg thì nhập 5)...">
                </div> -->
                <div class="form_group">
                    <label for="">Thương hiệu</label>
                    <select class="form_control" name="thuong_hieu">
                        <option value="">Chọn thương hiệu</option>
                        {option_brand}
                    </select>
                    <input style="margin-top: 5px;" type="text" class="form_control" name="thuong_hieu_2" value=""
                        placeholder="Hoặc thêm mới...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Danh mục</label>
                    <div style="clear: both;"></div>
                    <div class="list_main_category">
                        <div class="box_category scroll" id="main_category">{option_main_category}</div>
                        <div class="box_category scroll" id="sub_category"></div>
                        <div class="box_category scroll" id="sub_sub_category"></div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Đặc điểm nổi bật</label>
                    <textarea name="noibat" class="form_control" id="noibat"
                        placeholder="Nhập đặc điểm nổi bật của sản phẩm" style="width: 100%;height: 150px;"></textarea>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea"
                        placeholder="Nhập nội dung chi tiết sản phẩm" style="width: 100%;height: 250px;"></textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả bài viết"
                        style="width: 100%;height: 95px;"></textarea>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="add_sanpham_ngoai"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<input type="file" id="photo-add" name="file" accept="image/*" multiple style="display: none;">
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
</script>