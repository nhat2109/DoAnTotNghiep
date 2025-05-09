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
});
</script>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm Remarketing mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" value="" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Ảnh popup(nếu có)</label>
                    <div style="clear: both;"></div>
                    <div class="mh_popup" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-popup" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="img_popup" id="popup" style="display: none;">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="box_nguoinhan">
                    <div class="form_group">
                        <label for="">Người nhận:</label>
                        <div class="tr_step"><button class="select_nguoinhan">Chọn người nhận</button></div>
                        <div class="list_nguoinhan">
                        </div>
                        <div style="font-style: italic;color: #f00;">Nếu không chọn tức là gửi tất cả khách hàng.</div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung bài viết" style="width: 100%;height: 250px;"></textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
            </div>
            <div class="form_group">
                <label for="">Popup</label>
                <div style="clear: both;"></div>
                <input type="radio" name="pop" value="1"> Có <input type="radio" name="pop" value="0" checked=""> không
            </div> 
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="add_remarketing"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_marketing'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>