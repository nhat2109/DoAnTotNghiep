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

    $(document).ready(function () {
        // Title
        $("input[name=title]").on("input", function () {
            const text = $(this).val().trim();
            const charCount = text.length;
            $("#title-counter").text(`Ký tự: ${charCount}/150`);
            if (charCount > 150) {
                $("#title-counter").css("color", "red");
            } else {
                $("#title-counter").css("color", "black");
            }
        });

        // Description
        $("textarea[name=description]").on("input", function () {
            const text = $(this).val().trim();
            const charCount = text.length;
            $("#description-counter").text(`Ký tự: ${charCount}/150`);
            if (charCount > 150) {
                $("#description-counter").css("color", "red");
            } else {
                $("#description-counter").css("color", "black");
            }
        });

        // Tự động tạo mã cho hàng phân loại đầu tiên khi trang được tải
        function generateRandomCode() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            const dateStr = `${day}${month}${year}`;
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const randomLetter1 = letters.charAt(Math.floor(Math.random() * letters.length));
            const randomLetter2 = letters.charAt(Math.floor(Math.random() * letters.length));
            const randomNumber = numbers.charAt(Math.floor(Math.random() * numbers.length));
            return `${randomLetter1}${randomNumber}${randomLetter2}${dateStr}`;
        }
        const randomCode = generateRandomCode();
        $('.list_phanloai .li_phanloai input[name^=ma]').val(randomCode);
    });

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
    entity_encoding:"raw",
    content_css : "/tinymce_4.4.3/content.css",
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
    file_picker_callback: function(callback, value, meta) {
        
        // File type
        if (meta.filetype =="media" || meta.filetype =="image") {

            // Trigger click on file element
            $("#fileupload").trigger("click");
            $("#fileupload").unbind('change');

            // File selection
            $("#fileupload").on("change", function() {
                var file = this.files[0];
                var reader = new FileReader();
                
                // FormData
                var fd = new FormData();
                var files = file;
                fd.append("action","upload_tinymce");
                fd.append("file",files);
                // AJAX
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: fd,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function(kq){
                        var info=JSON.parse(kq);
                        filename = info.minh_hoa;
                    }
                });
                reader.onload = function(e) {
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
    entity_encoding:"raw",
    content_css : "/tinymce_4.4.3/content.css",
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
    file_picker_callback: function(callback, value, meta) {
        
        // File type
        if (meta.filetype =="media" || meta.filetype =="image") {

            // Trigger click on file element
            $("#fileupload").trigger("click");
            $("#fileupload").unbind('change');

            // File selection
            $("#fileupload").on("change", function() {
                var file = this.files[0];
                var reader = new FileReader();
                
                // FormData
                var fd = new FormData();
                var files = file;
                fd.append("action","upload_tinymce");
                fd.append("file",files);
                // AJAX
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: fd,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function(kq){
                        var info=JSON.parse(kq);
                        filename = info.minh_hoa;
                    }
                });
                reader.onload = function(e) {
                    callback(filename);
                };
                reader.readAsDataURL(file);
            });
        }
        
    }
});

</script>

<style>
/* Main container styles */
.box_right {
    background: #fff; 
    border-radius: 8px ;
    /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
    padding: 20px;
    margin: 20px;
    height: 100%;
}

.box_right_content {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header styles */
.page_title {
    margin-bottom: 30px;
}

.page_title h1 {
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
}

.page_title .line {
    height: 2px;
    background: #e0e0e0;
    margin: 10px 0;
}

/* Form group styles */
.form_group {
    margin-bottom: 25px;
}

.form_group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
}

.form_control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form_control:focus {
    border-color: #4a90e2;
    outline: none;
    box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
}

/* Preview wrapper styles */
.preview-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 6px;
}

.preview-wrapper img {
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: transform 0.2s;
}

.preview-wrapper img:hover {
    transform: scale(1.02);
}

.preview-text {
    color: #666;
    font-size: 13px;
    line-height: 1.5;
}

.preview-text li {
    margin-bottom: 8px;
    font-size: 12px;
}

/* Button styles */
.button_all, .button_select_photo, .button_add_phanloai, .button_add_info {
    background: #4a90e2;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.3s;
}

.button_all:hover, .button_select_photo:hover, .button_add_phanloai:hover, .button_add_info:hover {
    background: #357abd;
}

/* Product classification table styles */
.th_phanloai, .li_phanloai {
    display: grid;
    grid-template-columns: 1.2fr 1.2fr 1.2fr 1fr 1.2fr 1.2fr 1fr 1.2fr 0.5fr 0.5fr;
    gap: 10px;
    align-items: center;
}
.th_phanloai > div, .li_phanloai > div {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 0;
}
.li_phanloai input {
    width: 100%;
    box-sizing: border-box;
    text-align: center;
}

.info_ma, .info_name, .info_mau, .info_can_nang, .info_gia,
.info_kho_sanpham_shop, .info_trongluongtinhship {
    padding: 5px;
    width: 120px !important; 
}

.info_action i, .info_action_copy i {
    cursor: pointer;
    color: #666;
    transition: color 0.2s;
}

.info_action i:hover {
    color: #dc3545;
}

.info_action_copy i:hover {
    color: #28a745;
}

/* Category selection styles */
.list_main_category {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}
.box_category {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    min-width: 180px;
    min-height: 40px;
    max-height: 300px;
    background: #fff;
    flex: 1 1 0;
    overflow-y: auto;
    display: none; /* Ẩn mặc định */
}
.box_category.scroll:empty {
    display: none !important; /* Ẩn nếu không có nội dung */
}
.box_category.scroll:not(:empty) {
    display: block !important; /* Hiện khi có nội dung */
}
/* Character counter styles */
#title-counter, #description-counter, #noidung-counter, #noibat-counter {
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}

/* Responsive styles */
@media (max-width: 768px) {
    .box_right {
        margin: 10px;
        padding: 15px;
    }

    .page_title h1 {
        font-size: 20px;
    }

    .preview-wrapper {
        flex-direction: column;
        align-items: center;
    }

    .th_phanloai, .li_phanloai {
        grid-template-columns: repeat(5, 1fr);
        overflow-x: auto;
    }

    .list_main_category {
        grid-template-columns: 1fr;
    }

    .form_group > div {
        flex-direction: column;
    }

    .form_group > div > div {
        width: 100%;
        margin-right: 0;
        margin-bottom: 10px;
    }
}

@media (max-width: 480px) {
    .box_right {
        margin: 5px;
        padding: 10px;
    }

    .page_title h1 {
        font-size: 18px;
    }

    .form_control {
        padding: 8px;
        font-size: 13px;
    }

    .button_all, .button_select_photo, .button_add_phanloai, .button_add_info {
        width: 100%;
        margin-bottom: 10px;
    }
    .button_add_info {
        margin-bottom: 10px;
    }
    .list_info {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }
    .list_info input {
        min-width: 180px;
        padding: 8px 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
        background: #fafbfc;
    }
    .form_control.disabled, .form_control:disabled {
        background: #f5f5f5 !important;
        color: #bbb !important;
        cursor: not-allowed;
    }
}
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1>Đăng sản phẩm mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <!-- <div class="form_group">
                    <label for="">Tiêu đề (tối đa 120 ký tự)</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');" value="" placeholder="Nhập tiêu đề...">
                    <div class="check_link"></div>
                </div> -->
                <div class="form_group">
                    <label for="">Tiêu đề (tối đa 120 ký tự)</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');" value="" placeholder="Nhập tiêu đề...">
                    <div class="check_link"></div>
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link('sanpham');" value="" placeholder="Nhập link xem...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa (Bấm vào ảnh để chọn ảnh mới 600 x 600 px)</label>
                    <div style="clear: both;"></div>
                    <div class="mh">
                        <div class="preview-wrapper">
                            <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                            <ul class="preview-text">
                                <li>Tải lên hình ảnh 1:1.</li>
                                <li>Ảnh bìa sẽ được hiển thị tại các trang Kết quả tìm kiếm, Gợi ý hôm nay,… Việc sử dụng ảnh bìa đẹp sẽ thu hút thêm lượt truy cập vào sản phẩm của bạn</li>
                            </ul>
                        </div>
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <h3 for="">Kích thước đóng hộp</h3>
                    <div style="display: flex;">
                        <div style="margin-right:10px;">
                            <label for="">Chiều dài (cm)</label>
                            <input type="text" class="form_control price_format" name="chieudai_shop" value="0" placeholder="Nhập chiều dài (cm)...">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều rộng (cm)</label>
                            <input type="text" class="form_control price_format" name="chieurong_shop" value="0" placeholder="Nhập chiều rộng (cm)...">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều cao (cm)</label>
                            <input type="text" class="form_control price_format" name="chieucao_shop" value="0" placeholder="Nhập chiều cao (cm)...">
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
                    <div class="list_photo"></div>
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
                        <div class="info_kho_sanpham_shop">Kho</div>
                        <div class="info_trongluongtinhship">Trọng lượng tính ship</div>
                        <span> Hành động
                            <div class="info_action"></div>
                            <div class="info_action_copy"></div>
                        </span>
                    </div>
                    <div class="li_phanloai">
                        <div class="info_ma">
                            <input type="text" name="ma[]" placeholder="Mã">
                        </div>
                        <div class="info_name">
                            <input type="text" name="size[]" giatri="" placeholder="Kích cỡ" autocomplete="off">
                            <input type="hidden" name="ten_size[]">
                            <div class="list_goiy scroll"></div>
                        </div>
                        <div class="info_mau">
                            <input type="text" name="color[]" giatri="" placeholder="Màu sắc" autocomplete="off">
                            <input type="hidden" name="ten_color[]">
                            <input type="hidden" name="ma_mau[]">
                            <div class="list_goiy scroll"></div>
                        </div>
                        <div class="info_can_nang">
                            <input type="text" name="can_nang[]" value="0" placeholder="Trọng lượng">
                        </div>
                        <div class="info_gia">
                            <input type="text" name="gia_cu[]" class="price_format" value="0" placeholder="Giá niêm yết">
                        </div>
                        <div class="info_gia">
                            <input type="text" name="gia_moi[]" class="price_format" value="0" placeholder="Giá bán">
                        </div>
                        <div class="info_kho_sanpham_shop">
                            <input type="text" name="kho_sanpham_shop[]" class="price_format" value="0" placeholder="Số hàng trong kho">
                        </div>
                        <div class="info_trongluongtinhship">
                            <input type="text" name="trongluongtinhship[]" class="price_format" value="0" readonly>
                        </div>
                        <div class="info_action"><i class="fa fa-trash-o"></i></div>
                        <div class="info_action_copy"><i class="fa fa-files-o"></i></div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Thông số sản phẩm</label>
                    <button class="button_add_info">Thêm dòng</button>
                    <div class="list_info">{list_info}</div>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thương hiệu</label>
                    <select class="form_control" name="thuong_hieu" style="margin-top: 5px;">
                        <option value="">Thương hiệu của bạn</option>
                        {option_brand}
                    </select>
                    <input style="margin-top: 5px;" type="text" class="form_control" name="thuong_hieu_2" value="" placeholder="Hoặc thêm mới...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Danh mục website của bạn</label>
                    <div style="clear: both;"></div>
                    <div class="list_main_category">
                        <div class="box_category scroll" id="main_category">{option_main_category}</div>
                        <div class="box_category scroll" id="sub_category"></div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Đặc điểm nổi bật</label>
                    <textarea name="noibat" class="form_control" id="noibat" placeholder="Nhập đặc điểm nổi bật của sản phẩm" style="width: 100%;height: 150px;"></textarea>
                    <div id="noibat-counter">Ký tự: 0/600</div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung chi tiết sản phẩm" style="width: 100%;height: 250px;"></textarea>
                    <div id="noidung-counter">Ký tự: 0/5000</div>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="" placeholder="Nhập title...">
                    <div id="title-counter">Ký tự: 0/150</div>
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả bài viết" style="width: 100%;height: 95px;"></textarea>
                    <div id="description-counter">Ký tự: 0/150</div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="add_sanpham_ngoai">Hoàn thành</button>
            </div>
        </div>
    </div>
</div>
<input type="file" id="photo-add" name="file" accept="image/*" multiple style="display: none;">
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Khi chọn select
        $("select[name='thuong_hieu']").on("change", function() {
            if ($(this).val() !== "") {
                $("input[name='thuong_hieu_2']").val("").prop("disabled", true).addClass("disabled");
            } else {
                $("input[name='thuong_hieu_2']").prop("disabled", false).removeClass("disabled");
            }
        });
    
        // Khi nhập input
        $("input[name='thuong_hieu_2']").on("input", function() {
            if ($(this).val().trim() !== "") {
                $("select[name='thuong_hieu']").val("").prop("disabled", true).addClass("disabled");
            } else {
                $("select[name='thuong_hieu']").prop("disabled", false).removeClass("disabled");
            }
        });
        // CSS for error highlighting
        $('head').append(`
        <style>
            input.error {
                border: 1px solid red !important;
            }
            .error-message {
                font-size: 12px;
                margin-top: 2px;
                display: block;
            }
        </style>
        `);
    });
</script>