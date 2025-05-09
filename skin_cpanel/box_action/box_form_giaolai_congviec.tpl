<div class="tongket" style="background-color: white;">
    <div class="button_quaytrolai">
        <button name="quay_tro_ve">Quay trở về</button>
    </div>
    <div class="box_form_giaolai_congviec">
        <div class="box_profile" style="background-color:white;padding: 20px;margin-top: 40px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px">
            <div class="page_title">
              <h1 class="undefined">Thêm giao việc mới</h1>
              <div class="line"></div>
              <hr>
            </div>
            <div class="col_100">
              <div class="form_group">
                <label for="">Phòng ban nhận</label>
                <div class="list_nguoinhan list_nguoi_thuchien">
                  <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                    <button name="themphongban-form">Phòng ban</button>
                    <div id="selected_phongban">
                        {phongban_select}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form_group">
                <label for="">Người nhận</label>
                <div class="list_nguoinhan list_nguoi_thuchien">
                  <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                    <button name="themnguoinhan">Thêm người nhận</button>
                    <div id="nguoinhan_selected">
                        {list_nguoinhan}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form_group">
                <label for="">Người giám sát</label>
                <div class="list_nguoinhan list_nguoi_thuchien">
                  <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                    <button name="nguoi_giamsat">Người giám sát</button>
                    <div id="nguoigiam_sat_selected">
                        {list_nguoigiamsat}
                    </div>
                  </div>
                </div>
              </div>

              <div class="form_group">
                <label for="">Tên công việc<span class="color_red">(*)</span></label>
                <input type="text" class="form_control" name="ten_congviec" value="{tieu_de}" placeholder="Nhập tiêu đề...">
              </div>
            </div>
            <div class="col_100">
              <div style="clear: both"></div>
              <div class="form_group">
                <label for="">Mô tả chi tiết</label>
                <textarea name="chitiet_congviec" class="form_control" id="giaolai_congviec" placeholder="Nhập nội dung công việc">{noi_dung}</textarea>
              </div>
            </div>
            <div class="col_50">
              <div class="form_group" id="input_link">
                <label for="">Thời hạn</label>
                <input
                   type="datetime-local"
                   placeholder="Nhập thời hạn hoàn thành..."
                   class="form_control datetimepicker_mask"
                   name="date_line"
                   id="date_giaolaicongviec"
                   value="{date_time_a}"
                 />
              </div>
            </div>
            <div class="col_50">
              <div class="form_group" id="">
                <label for="">Tệp đính kèm</label>
                <input type="file" class="form_control" name="file_dinhkem" id="file_dinhkem">
              </div>
            </div>
            <div class="col_50">
              <div class="form_group" id="">
                <label for="">Mức độ ưu tiên<span class="color_red">(*)</span></label>
                <select name="uu_tien" id="uu_tien" class="form_control">
                  {list_uutien}
                </select>
              </div>
            </div>
            <div class="col_50">
              <div class="form_group" id="">
                <label for="">Trong vòng bao lâu phải nhận việc<span class="color_red">(*)</span></label> 
              <input type="text" class="form_control" name="thoigian_phainhanviec" id="thoigian_phainhanviec" placeholder="Nhập số phút cần nhận việc" value="{thoigian_phainhanviec}">
              </div>
            </div>

            <div style="clear: both"></div>
            <div class="form_group">
              <button name="giaolai_congviec" data-id="{id}" class="button_all">
                Giao việc
              </button>
            </div>
          </div>
    </div>
  </div>