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
		</div>
		<div class="col_50">
		</div>
		<div style="clear: both;"></div>
		<div class="col_100">
	      <div class="form_group">
	        <label for="">Bấm vào ảnh để chọn ảnh mới</label>
            <div style="clear: both;"></div>
            <div class="mh" style="cursor: pointer;">
                <img src="{value}" onerror="this.src='/images/no-images.jpg';" style="max-width: 100%;max-height: 200px;background: #ff5722;" id="preview-minhhoa" title="click để chọn ảnh">
            </div>
            <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
	      </div>
		</div>
		<div style="clear: both;"></div>
		<div class="col_100">
			<div class="form_group">
			<label for="">Mô tả </label>
		     	<textarea disabled name="description" class="form_control" placeholder="Nhập nội dung..." style="width: 100%;height: 250px;">{description}</textarea>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="form_group">
			<input type="hidden" name="id" value="{name}">
			<button class="button_all" name="edit_setting_img"> Lưu lại </button>
		</div>
  	</div>
  </div>
</div>