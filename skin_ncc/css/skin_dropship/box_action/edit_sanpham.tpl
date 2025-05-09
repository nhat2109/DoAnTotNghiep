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
</script>
<!-- ////HuyPhuc/// -->
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa thông tin</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <input type="hidden" name="sp_id" value="{id}">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');"
                        value="{tieu_de}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link('sanpham');"
                        value="{link}" placeholder="Nhập link xem...">
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
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Ảnh sản phẩm</label>
                    <button class="button_select_photo">Chọn ảnh</button>
                    <div class="list_photo">{list_photo}</div>
                </div>
                <div class="form_group">
                    <h3 for="">Kích thước đóng hộp</h3>
                    <div style="display: flex;">
                        <div style="margin-right:10px;">
                            <label for="">Chiều dài (cm)</label>
                            <input type="text" class="form_control price_format" id="chieudai_shop" placeholder="Nhập chiều dài (cm)..." name="chieudai_shop">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều rộng (cm)</label>
                            <input type="text" class="form_control price_format" id="chieurong_shop" placeholder="Nhập chiều rộng (cm)..." name="chieurong_shop">
                        </div>
                        <div style="margin-right:10px;">
                            <label for="">Chiều cao (cm)</label>
                            <input type="text" class="form_control price_format" id="chieucao_shop" placeholder="Nhập chiều cao (cm)..." name="chieucao_shop">
                        </div>
                    </div>
                </div>
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
                        {list_phanloai}
                       
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
                        placeholder="Nhập đặc điểm nổi bật của sản phẩm" style="width: 100%;height: 150px;">{noi_bat}</textarea>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea"
                        placeholder="Nhập nội dung chi tiết sản phẩm" style="width: 100%;height: 250px;">{noi_dung}</textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="{title}" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả bài viết"
                        style="width: 100%;height: 95px;">{description}</textarea>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="edit_sanpham"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<input type="file" id="photo-add" name="file" accept="image/*" multiple style="display: none;">
<script type="text/javascript">
    var kich_thuoc ='{kich_thuoc}'; 
    console.log(kich_thuoc);      
    var kichThuocArr = kich_thuoc.split(",");
    document.getElementById("chieudai_shop").value = kichThuocArr[0] || "";
    document.getElementById("chieurong_shop").value = kichThuocArr[1] || "";
    document.getElementById("chieucao_shop").value = kichThuocArr[2] || "";
</script>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>