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
    file_picker_callback: function(callback, value, meta) {

        // File type
        if (meta.filetype == "media" || meta.filetype == "image") {

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
                    success: function(kq) {
                        var info = JSON.parse(kq);
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
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa cài đặt</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Mục</label>
                    <input type="text" class="form_control" name="name" value="{name}" disabled="disabled">
                </div>
                <div class="form_group">
                    <label for="">Màu nền shop</label>
                    <input class="form_control" name="background" data-jscolor="{}" value="{bg_background}" placeholder="Nhập mã màu nền shop...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền topbar</label>
                    <input class="form_control" name="topbar" data-jscolor="{}" value="{bg_topbar}" placeholder="Nhập mã màu nền topbar...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền header</label>
                    <input class="form_control" name="header" data-jscolor="{}" value="{bg_header}" placeholder="Nhập mã màu nền header...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền nút tìm kiếm</label>
                    <input class="form_control" name="timkiem" data-jscolor="{}" value="{bg_timkiem}" placeholder="Nhập mã màu nền nút tìm kiếm...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền box hotline</label>
                    <input class="form_control" name="hotline" data-jscolor="{}" value="{bg_hotline}" placeholder="Nhập mã màu nền hotline...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền thanh menu</label>
                    <input class="form_control" name="menu" data-jscolor="{}" value="{bg_menu}" placeholder="Nhập mã màu nền thanh menu...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền tiêu đề menu</label>
                    <input class="form_control" name="title_menu" data-jscolor="{}" value="{bg_title_menu}" placeholder="Nhập mã màu nền tiêu đề menu...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền tiêu đề box</label>
                    <input class="form_control" name="title_box" data-jscolor="{}" value="{bg_title_box}" placeholder="Nhập mã màu nền tiêu đề box...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền mã giảm giá</label>
                    <input class="form_control" name="ma_giamgia" data-jscolor="{}" value="{bg_ma_giamgia}" placeholder="Nhập mã màu nền mã giảm giá...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền label sale</label>
                    <input class="form_control" name="label_sale" data-jscolor="{}" value="{bg_label_sale}" placeholder="Nhập mã màu nền label sale...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền button to top</label>
                    <input class="form_control" name="button_top" data-jscolor="{}" value="{bg_button_top}" placeholder="Nhập mã màu nền button to top...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền thanh đăng ký nhận tin</label>
                    <input class="form_control" name="subcribe" data-jscolor="{}" value="{bg_subcribe}" placeholder="Nhập mã màu nền thanh đăng ký nhận tin...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền top menu mobile</label>
                    <input class="form_control" name="top_menu_mobile" data-jscolor="{}" value="{bg_top_menu_mobile}" placeholder="Nhập mã màu nền top menu mobile...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền nút nhận tin</label>
                    <input class="form_control" name="nhantin" data-jscolor="{}" value="{bg_nhantin}" placeholder="Nhập mã màu nền nút đăng ký nhận tin...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền top footer</label>
                    <input class="form_control" name="top_footer" data-jscolor="{}" value="{bg_top_footer}" placeholder="Nhập mã màu nền top footer...">
                </div>
                <div class="form_group">
                    <label for="">Màu chữ tiêu đề footer</label>
                    <input class="form_control" name="text_title_top_footer" data-jscolor="{}" value="{text_title_top_footer}" placeholder="Nhập mã màu chữ tiêu đề footer...">
                </div>
                <div class="form_group">
                    <label for="">Màu chữ top footer</label>
                    <input class="form_control" name="text_top_footer" data-jscolor="{}" value="{text_top_footer}" placeholder="Nhập mã màu chữ top footer...">
                </div>
                <div class="form_group">
                    <label for="">Màu nền bottom footer</label>
                    <input class="form_control" name="bottom_footer" data-jscolor="{}" value="{bg_bottom_footer}" placeholder="Nhập mã màu nền bottom footer...">
                </div>
                <div class="form_group">
                    <label for="">Màu chữ bottom footer</label>
                    <input class="form_control" name="text_bottom_footer" data-jscolor="{}" value="{text_bottom_footer}" placeholder="Nhập mã màu chữ bottom footer...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{name}">
                <button class="button_all" name="edit_setting_css"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jscolor.js"></script>