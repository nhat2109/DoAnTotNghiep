<?php
$list = '<div><button name="quay_trolai_formdexuat">Quay trở lại</button></div><div class="form_dexuat" style="height: 230px;">
    <h1>Đề xuất</h1>
    <div class="col_50">
      <div class="form_group">
        <label for="">Nhập tiêu đề đề xuất</label>
        <input
          type="text"
          placeholder="Tiêu đề..."
          name="tieu_de_dexuat"
        />
      </div>
    </div>
    <div class="col_50">
      <div class="form_group">
        <label for="">Nội dung chi tiết đề xuất</label>
        <input
          type="text"
          placeholder="Nội dung..."
          name="noi_dung_dexuat"
        />
      </div>
    </div>
    <div class="col_50">
      <div class="form_group">
        <label for="">File đính kèm(nếu có)</label>
        <input
          type="file"
          name="file"
        />
      </div>
    </div>
    <div class="col_50">
      <div class="form_group">
        <label for="">Hạn đề xuất</label>
        <input
          type="datetime-local"
          name="datetime_local"
        />
      </div>
    </div>
    <div class="col_50">
      <div class="form_group">
        <label for="">Chọn người đề xuất</label>
        <button name="chon_nguoidexuat">Chọn người đề xuất</button>
        <div id="sepnhan_selected"></div>
      </div>
    </div>
    <div class="col_50">
      <div class="form_group">
        <div class="submit_button">
          <button name="submit_dexuat">Gửi đề xuất</button>
        </div>
      </div>
    </div>
  </div>';
  
echo json_encode($list) ;