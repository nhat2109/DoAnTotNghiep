<!-- <script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script> -->
<!-- <script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script> -->
<!-- <script type="text/javascript" src="/tinymce_4.4.3/jquery.tinymce.min.js"></script> -->
<script src="/tinymce_7.1.0/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
/*tinymce.init({
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
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
    toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | link unlink | bullist numlist | image searchreplace code | removeformat fullscreen",
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
});*/
/*tinymce.init({
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
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
    toolbar1: "forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter code | link unlink | bullist numlist | removeformat",
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
});*/
    tinymce.init({
      selector: '#edit_textarea',
      plugins: 'anchor autolink charmap code codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo bold italic link unlink image media forecolor blocks fontfamily fontsize | alignleft aligncenter code | media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
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
    tinymce.init({
      selector: '#noibat',
      plugins: 'anchor autolink charmap code codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo bold italic link unlink image forecolor blocks fontfamily fontsize | alignleft aligncenter code | media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
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

<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 1200px;">
            <div class="page_title">
                <h1 class="undefined">Thêm sản phẩm mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank('sanpham');" value="{tieu_de}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link('sanpham');" value="{link}" placeholder="Nhập link xem...">
                    <input type="hidden" name="link_old" id="link_old" value="{link}">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Kho Hà Nội</label>
                    <input type="text" class="form_control price_format" name="kho" value="{kho}" placeholder="Nhập số lượng sản phẩm trong kho Hà Nội...">
                </div>
                <div class="form_group">
                    <label for="">Kho Tp.HCM</label>
                    <input type="text" class="form_control price_format" name="kho_hcm" value="{kho_hcm}" placeholder="Nhập số lượng sản phẩm trong kho ở Tp.HCM...">
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
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thương hiệu</label>
                    <select class="form_control" name="thuong_hieu">
                        <option value="">Chọn thương hiệu</option>
                        {option_brand}
                    </select>
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
                                Mã
                            </div>
                            <div class="info_name">
                                Kích cỡ
                            </div>
                            <div class="info_mau">
                                Màu sắc
                            </div>
                            <div class="info_can_nang">
                                Trọng lượng
                            </div>
                            <div class="info_gia">
                                Giá niêm yết
                            </div>
                            <div class="info_gia">
                                Giá bán
                            </div>
                            <div class="info_gia">
                                Giá drop
                            </div>
                            <div class="info_gia">
                                Giá CTV
                            </div>
                            <div class="info_gia">
                                Giá bán tối thiểu
                            </div>
                            <div class="info_action"></div>
                        </div>
                        {list_phanloai}
                    </div>
                </div>
                <div class="form_group">
                    <label for="">Thông số sản phẩm</label>
                    <button class="button_add_info">Thêm dòng</button>
                    <div class="list_info">
                        {list_info}
                    </div>
                </div>
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
                    <textarea name="noibat" class="form_control" id="noibat" placeholder="Nhập đặc điểm nổi bật của sản phẩm" style="width: 100%;height: 150px;">{noi_bat}</textarea>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung chi tiết sản phẩm" style="width: 100%;height: 250px;">{noi_dung}</textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="{title}" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả bài viết" style="width: 100%;height: 95px;">{description}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Hiện box Flash sale</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="box_flash" value="1"> Có <input type="radio" name="box_flash" value="0" checked=""> không
                </div> 
                <div class="form_group">
                    <label for="">Hiện box nổi bật</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="box_noibat" value="1"> Có <input type="radio" name="box_noibat" value="0" checked=""> không
                </div>
                <div class="form_group">
                    <label for="">Hiện box bán chạy</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="box_banchay" value="1"> Có <input type="radio" name="box_banchay" value="0" checked=""> không
                </div>
                <div class="form_group">
                    <label for="">Cắt Mã</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="cat_ma" value="1"> Có <input type="radio" name="cat_ma" value="0" checked=""> không
                </div>
                <div class="form_group">
                    <label for="">Nơi bán</label>
                    <div style="clear: both;"></div>
                    {noi_ban}
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button class="button_all" name="edit_sanpham"> Hoàn thành </button>
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
<script type="text/javascript">
    $(document).ready(function(){
        var box_noibat ='{box_noibat}';
        var cat_ma ='{cat_ma}';
        var box_banchay ='{box_banchay}';
        var box_flash ='{box_flash}';
        $("input[name=box_noibat][value=" + box_noibat + "]").prop('checked', true);
        $("input[name=cat_ma][value=" + cat_ma + "]").prop('checked', true);
        $("input[name=box_banchay][value=" + box_banchay + "]").prop('checked', true);
        $("input[name=box_flash][value=" + box_flash + "]").prop('checked', true);
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_sanpham'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>