<!-- <script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script>
<!-- <script type="text/javascript" src="/tinymce_4.4.3/jquery.tinymce.min.js"></script> -->
<script type="text/javascript">

    // Hàm loại bỏ thẻ HTML, giữ lại ký tự tiếng Việt
    function stripHtml(html) {
        const div = document.createElement("div");
        div.innerHTML = html;
        let text = div.textContent || div.innerText || "";
        text = text
            .replace(/[\n\r]+/g, " ") // Thay thế xuống dòng bằng khoảng trắng
            .replace(/\s+/g, " ") // Chuẩn hóa khoảng trắng
            .trim();
        return text;
    }

    // Hàm cập nhật bộ đếm ký tự
    function updateCharCount(editor, counterId, maxLength) {
        const content = editor.getContent();
        const cleanText = stripHtml(content);
        const charCount = cleanText.length;
        $(`#${counterId}`).text(`Ký tự: ${charCount}/${maxLength}`);
        if (charCount > maxLength) {
            $(`#${counterId}`).css("color", "red");
        } else {
            $(`#${counterId}`).css("color", "black");
        }
    }

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
        // fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
        plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
        toolbar1: "undo redo forecolor | bold italic | alignleft aligncenter | bullist numlist | image",
        setup: function (editor) {
            editor.on("init change keyup", function () {
                updateCharCount(editor, "noidung-counter", 5000);
            });
            editor.on('init', function () {
                editor.getContainer().style.position = 'relative';
            });
            editor.on('BeforeRenderMenu', function (e) {
                var menu = e.target;
                if (menu && menu.control && menu.control.parent()) {
                    var button = menu.control.parent().control;
                    if (button) {
                        var buttonRect = button.getEl().getBoundingClientRect();
                        var editorRect = editor.getContainer().getBoundingClientRect();
                        menu.moveTo(
                            buttonRect.left - editorRect.left,
                            buttonRect.bottom - editorRect.top
                        );
                    }
                }
            });
        },
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
                        url: "/ncc/process.php",
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
        // fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
        plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
        toolbar1: "forecolor | bold italic | alignleft aligncenter | bullist numlist",
        setup: function (editor) {
            editor.on("init change keyup", function () {
                updateCharCount(editor, "noibat-counter", 600);
            });
            editor.on('init', function () {
                editor.getContainer().style.position = 'relative';
            });
            editor.on('BeforeRenderMenu', function (e) {
                var menu = e.target;
                if (menu && menu.control && menu.control.parent()) {
                    var button = menu.control.parent().control;
                    if (button) {
                        var buttonRect = button.getEl().getBoundingClientRect();
                        var editorRect = editor.getContainer().getBoundingClientRect();
                        menu.moveTo(
                            buttonRect.left - editorRect.left,
                            buttonRect.bottom - editorRect.top
                        );
                    }
                }
            });
        },
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

    // Bộ đếm ký tự cho Title và Description
    $(document).ready(function () {
       // Hàm đếm ký tự cho Title
    function updateTitleCounter() {
        const text = $("input[name=title]").val().trim();
        const charCount = text.length;
        $("#title-counter").text(`Ký tự: ${charCount}/150`);
        if (charCount > 150) {
            $("#title-counter").css("color", "red");
        } else {
            $("#title-counter").css("color", "black");
        }
    }

    // Hàm đếm ký tự cho Description
    function updateDescriptionCounter() {
        const text = $("textarea[name=description]").val().trim();
        const charCount = text.length;
        $("#description-counter").text(`Ký tự: ${charCount}/150`);
        if (charCount > 150) {
            $("#description-counter").css("color", "red");
        } else {
            $("#description-counter").css("color", "black");
        }
    }

    // Gán sự kiện và gọi ngay để đếm giá trị ban đầu
    $("input[name=title]").on("input", updateTitleCounter);
    updateTitleCounter(); // Đếm ngay giá trị ban đầu

    $("textarea[name=description]").on("input", updateDescriptionCounter);
    updateDescriptionCounter(); // Đếm ngay giá trị ban đầu
    });
</script>
<style>
    /* Responsive styles for mobile devices */
    @media (max-width: 768px) {
        .box_right {
            width: 100%;
            padding: 10px;
        }

        .box_right_content {
            width: 100%;
        }

        .box_profile {
            width: 100%;
        }

        .page_title h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .col_50,
        .col_100 {
            width: 100%;
            float: none;
            padding: 0;
        }

        .form_group {
            margin-bottom: 15px;
        }

        .form_control {
            width: 100%;
            padding: 8px;
            font-size: 14px;
        }

        /* Box dimensions section */
        .form_group h3 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .form_group>div {
            display: flex;
            flex-direction: column;
        }

        .form_group>div>div {
            margin-right: 0;
            margin-bottom: 10px;
            width: 100%;
        }

        /* Product classification section */
        .list_phanloai {
            width: 100%;
            overflow-x: auto;
        }

        .th_phanloai,
        .li_phanloai {
            display: flex;
            flex-wrap: nowrap;
            min-width: 1200px;
        }

        .info_ma,
        .info_name,
        .info_mau,
        .info_can_nang,
        .info_gia,
        .info_kho_sanpham_shop,
        .info_trongluongtinhship,
        .info_action,
        .info_action_copy {
            padding: 5px;
            min-width: 100px;
        }

        .info_action,
        .info_action_copy {
            min-width: 80px;
            text-align: center;
        }

        /* Category section */
        .list_main_category {
            display: flex;
            flex-direction: column;
        }

        .box_category {
            width: 100%;
            height: 120px;
            margin-bottom: 10px;
        }

        /* Product images */
        .list_photo {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .list_photo img {
            width: calc(50% - 5px);
            height: auto;
        }

        /* Buttons */
        .button_all {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

        .button_select_photo,
        .button_add_phanloai,
        .button_add_info {
            width: 100%;
            margin-bottom: 10px;
        }

        /* Preview image */
        .mh {
            text-align: center;
        }

        .mh img {
            max-width: 100%;
            height: auto;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .box_right {
            padding: 5px;
        }

        .page_title h1 {
            font-size: 18px;
        }

        .form_control {
            padding: 8px;
            font-size: 14px;
        }

        .list_photo img {
            width: 100%;
        }

        .button_all {
            padding: 10px;
        }
    }

    .preview-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        /* Khoảng cách giữa ảnh và text */
        padding: 0px 2px;
    }

    .preview-text {
        color: #999;
        font-size: 14px;
        margin-top: 0;
        /* Loại bỏ margin nếu cần */
        padding-left: 0;
        list-style: disc;
        cursor: default;
    }

    .preview-text li {
        font-size: 11px;
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa sản phẩm ngoài</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');"
                        value="{tieu_de}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link('sanpham');"
                        value="{link}" placeholder="Nhập link xem...">
                    <input type="hidden" name="link_old" id="link_old" value="{link}">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Minh họa (Bấm vào ảnh để chọn ảnh mới 600 x 600 px)</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <div class="preview-wrapper">
                            <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200"
                                id="preview-minhhoa" title="click để chọn ảnh">
                            <ul class="preview-text">
                                <li>Tải lên hình ảnh 1:1.</li>
                                <li>Ảnh bìa sẽ được hiển thị tại các trang Kết quả tìm kiếm, Gợi ý hôm nay,… Việc sử
                                    dụng ảnh bìa đẹp sẽ thu hút thêm lượt truy cập vào sản phẩm của bạn</li>
                            </ul>
                        </div>
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <h3 for="">Kích thước hộp</h3>
                    <div style="display: flex;">
                        <div style="margin-right:10px;">
                            <label for="">Chiều dài (cm)</label>
                            <input type="text" class="form_control price_format" id="chieudai_shop"
                                placeholder="Nhập chiều dài (cm)..." name="chieudai_shop">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều rộng (cm)</label>
                            <input type="text" class="form_control price_format" id="chieurong_shop"
                                placeholder="Nhập chiều rộng (cm)..." name="chieurong_shop">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều cao (cm)</label>
                            <input type="text" class="form_control price_format" id="chieucao_shop"
                                placeholder="Nhập chiều cao (cm)..." name="chieucao_shop">
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Ảnh đa chiều mô tả sản phẩm (tối đa 8 ảnh kích thước 600 x 600px)</label>
                    <button class="button_select_photo">Chọn ảnh</button>
                    <div class="list_photo">{list_photo}</div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <label for="">Phân loại sản phẩm</label>
                <button class="button_add_phanloai">Thêm phân loại</button>
                <div class="list_phanloai">
                    <div class="th_phanloai">
                        <div class="info_ma">Mã</div>
                        <div class="info_name">Kích cỡ</div>
                        <div class="info_mau">Màu sắc</div>
                        <div class="info_can_nang">Trọng lượng (kg)</div>
                        <div class="info_gia">Giá niêm yết</div>
                        <div class="info_gia">Giá bán</div>
                        <div class="info_gia" style="display: none;">Giá drop</div>
                        <div class="info_gia" style="display: none;">Giá CTV</div>
                        <div class="info_gia" style="display: none;">Giá trên Sóc đỏ</div>
                        <div class="info_kho_sanpham_shop">Kho</div>
                        <div class="info_trongluongtinhship">Trọng lượng tính ship</div>
                        <div class="info_action"></div>
                        <div class="info_action_copy"></div>
                    </div>
                    {list_phanloai}
                </div>
            </div>
            <div style="clear: both;"></div>
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
            <div class="col_100">
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
                        <div class="box_category scroll" id="sub_category">{option_sub_category}</div>
                        <div class="box_category scroll" id="sub_sub_category">{option_sub_sub_category}</div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Đặc điểm nổi bật</label>
                    <textarea name="noibat" class="form_control" id="noibat"
                        placeholder="Nhập đặc điểm nổi bật của sản phẩm"
                        style="width: 100%;height: 150px;">{noi_bat}</textarea>
                    <div id="noibat-counter">Ký tự: 0/600</div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea"
                        placeholder="Nhập nội dung chi tiết sản phẩm"
                        style="width: 100%;height: 250px;">{noi_dung}</textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                    <div id="noidung-counter">Ký tự: 0/5000</div>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="{title}" placeholder="Nhập title...">
                    <div id="title-counter">Ký tự: 0/150</div>
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả bài viết"
                        style="width: 100%;height: 95px;">{description}</textarea>
                    <div id="description-counter">Ký tự: 0/150</div>
                </div>
                
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button class="button_all" name="edit_sanpham_ngoai"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<input type="file" id="photo-add" name="file" accept="image/*" multiple style="display: none;">
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    var kich_thuoc = '{kich_thuoc}';
    var kichThuocArr = kich_thuoc.split(",");
    document.getElementById("chieudai_shop").value = kichThuocArr[0] || "";
    document.getElementById("chieurong_shop").value = kichThuocArr[1] || "";
    document.getElementById("chieucao_shop").value = kichThuocArr[2] || "";
</script>