<script src="https://cdn.tiny.cloud/1/eynwt0l5rdw91m1okad8o318qwdv43pee9hbwjnp4frqmf6z/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
      selector: '#edit_textarea',
      plugins: 'anchor autolink code charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
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
        <div class="box_profile" style="width: 960px;">
            <div class="page_title">
                <h1 class="undefined">Thêm nội dung nhiệm vụ "ngày {ngay}"</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" value="" placeholder="Nhập tiêu đề...">
                </div>
            </div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Hình ảnh</label>
                    <button class="button_select_photo">Chọn ảnh - video</button>
                    <div class="list_photo"></div>
                </div>
            </div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung chi tiết nhiệm vụ" style="width: 100%;height: 250px;"></textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="nhiemvu_id" value="{id}">
                <button class="button_all" name="add_noidung_nhiemvu"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<input type="file" id="photo-add" name="file" accept="image/*,video/mp4,video/x-m4v,video/*" multiple style="display: none;">
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
</script>
<script type="text/javascript">
    $(document).ready(function(){
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