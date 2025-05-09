<!-- <script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script> -->
<script src="/tinymce_7.1.0/tinymce.min.js" referrerpolicy="origin"></script>
<!-- <script type="text/javascript" src="/tinymce_4.4.3/jquery.tinymce.min.js"></script> -->
<script type="text/javascript">
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
</script>
<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 950px;">
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
		</div>
		<div class="col_50">
		</div>
		<div style="clear: both;"></div>
		<div class="col_100">
	      <div class="form_group">
	        <label for="">Giá trị</label>
	        <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung..." style="width: 100%;height: 250px;">{value}</textarea>
            <input type='file' name='fileupload' id='fileupload' style='display: none;'>
	      </div>
		</div>
		<div style="clear: both;"></div>
		<div class="form_group">
			<input type="hidden" name="id" value="{name}">
			<button class="button_all" name="edit_setting_html"> Hoàn thành </button>
		</div>
  	</div>
  </div>
</div>
