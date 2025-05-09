<script src="/tinymce_7.1.0/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
      selector: '#edit_textarea',
      plugins: 'anchor autolink code charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo bold italic link unlink image media forecolor blocks fontfamily fontsize align numlist bullist removeformat',
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
                    url: "/process.php",
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
      toolbar: 'undo redo bold italic link unlink image forecolor blocks fontfamily fontsize | alignleft aligncenter code | align | removeformat',
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
                    url: "/process.php",
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
                <h1 class="undefined">Thêm giao việc mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Người nhận</label>
                    <div class="list_nguoinhan list_nguoi_thuchien">
                        <div class="li_add_nguoinhan" loai="list_nguoi_thuchien"><i class="fa fa-plus"></i> Thêm người nhận</div>
                    </div>
                </div>
                <div class="form_group">
                    <label for="">Tên công việc<span class="color_red">(*)</span></label>
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tiêu đề...">
                </div>
            </div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Mô tả chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung công việc" style="width: 100%;height: 250px;"></textarea>
                    <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                </div>
            </div>
            <div class="col_50">
                <div class="form_group" id="input_link">
                    <label for="">Thời hạn</label>
                    <input type="text" class="form_control datetimepicker_mask" name="date_line" value="" placeholder="Nhập thời hạn hoàn thành...">
                </div>    
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_giaoviec" class="button_all"> Giao việc</button>
            </div>
        </div>
    </div>
</div>