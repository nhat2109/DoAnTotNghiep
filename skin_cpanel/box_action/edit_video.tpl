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
        <div class="box_profile" style="width: 1000px;">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa video</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link video</label>
                    <input type="text" class="form_control" name="link_video" value="{link_video}" placeholder="Nhập link video youtube...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Danh mục</label>
                    <div style="clear: both;"></div>
                    {option_category}
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung bài viết" style="width: 100%;height: 250px;">{noi_dung}</textarea>
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
                    <label for="">Đối tượng xem</label>
                    <div style="clear: both;"></div>
                    <div class="li_input" id="loai_all"><input type="checkbox" name="loai[]" value="all"> Tất cả</div>
                    <div class="li_input" id="loai_drop"><input type="checkbox" name="loai[]" value="drop"> Drop</div>
                    <div class="li_input" id="loai_ctv"><input type="checkbox" name="loai[]" value="ctv"> Cộng tác viên</div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button class="button_all" name="edit_video"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {list_loai}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_video'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>