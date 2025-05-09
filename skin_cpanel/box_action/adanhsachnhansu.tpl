<style>
  /* Hiệu ứng hover cho hàng tr */
  .hover_id_giaoviec {
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    height: 50px;
  }

  #nguoinhan_selected,
  #selected_phongban,
  #nguoigiam_sat_selected {
    display: flex;
  }

  .selected_nguoinhan_dathem,
  .selected_phongban_dathem,
  .selected_giamsat_dathem {
    display: flex;
    background-color: #DCDCDC;
    border-radius: 20px;
    align-items: center;
    justify-content: center;
    margin: 10px 12px 0px 0px;
  }

  .list_nguoinhan button {
    background-color: rgb(255, 104, 29);
    border-radius: 5px;
    transition: right 0.5s ease-in-out;
    padding: 10px 25px;
  }

  .list_nguoinhan button:hover {
    background-color: #32CD32;
  }

  .selected_nguoinhan_dathem h6,
  .selected_phongban_dathem h6,
  .selected_giamsat_dathem h6 {
    margin: 0;
    padding: 10px;
    font-size: 14px;
  }

  .selected_nguoinhan_dathem button,
  .selected_phongban_dathem button,
  .selected_giamsat_dathem button {
    width: 30px;
    height: 30px;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 5px;
    padding: 0;
    background-color: #797979;
  }

  /* Hover đẹp hơn */
  .hover_id_giaoviec:hover {
    background-color: rgba(0, 0, 0, 0.05);
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15);
  }

  /* Thanh timeline */
  .list_timeline .timeline {
    height: 12px;
    width: 100%;
    border-radius: 6px;
    background-color: #e0e0e0;
    position: relative;
  }

  /* Phần tiến trình */
  .list_b {
    height: 100%;
    border-radius: 6px;
    transition: width 0.4s ease-in-out;
    position: relative;
  }

  /* Hình tròn phần trăm (%) ở ngoài, không bị nuốt */
  .tiendo {
    position: absolute;
    right: -20px;
    /* Đẩy hẳn ra ngoài */
    top: 50%;
    transform: translateY(-50%);
    width: 34px;
    height: 34px;
    background-color: #478ffc;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
  }

  .xemchi_tiet_congviec {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.2);
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
    display: none;

  }

  .box_chi_tiet_congviec {
    position: relative;
    height: 60%;
    width: 60%;
    background-color: white;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    padding: 25px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    margin-top: 10%;
    margin-left: 25%;
    padding-top: 40px;
  }

  .mucdouutien {
    position: absolute;
    top: 0;
    right: 0;
    margin-top: 10px;
    margin-right: 20px;
    display: flex;
  }

  .close_chitiet_congviec {
    background-color: red;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    border-radius: 100%;
    border: solid 2px black;
  }

  .tonghop-nhansu {
    margin-top: 40px;
  }

  .box_right_nhansu {
    width: 100%;
    height: 100%;
    padding: 20px;
    margin: 20px;
  }

  .tongket {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    background-color: #DCDCDC;
  }

  .level1 {
    display: flex;
    justify-content: start;
    width: 100%;
    margin: auto;
    align-items: center;
    position: absolute;
    top: 0;
    left: 0;
    background-color: white;
    height: 70px;
  }

  .dexuat,
  .daotao,
  .giaoviec,
  .themphongban,
  .phongban {
    display: none;
  }

  .shadow_mid_main {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: none;
  }

  .shadow_main_box_select {
    position: relative;
    top: 220px;
    left: 50%;
    width: 400px;
    height: 500px;
    transform: translateX(-50%);
    background-color: white;
    padding: 30px;
  }

  .list_nhanvien_form {
    margin-top: 20px;
  }

  .css_select_all {
    background-color: aquamarine;
    cursor: pointer;
    border: 10px;
    width: 100px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    margin: 10px;
  }

  .thongke_tutao {
    display: grid;
    grid-template-columns: repeat(2, 2fr);
    margin: auto;
    gap: 20px;
    justify-content: space-between;
  }

  .thongke_tutao h3 {
    text-align: center;
  }

  .button_socdo_giaoviec {
    position: relative;
    display: inline-block;
    background-color: white;
    color: black;
    margin-left: 12px;
    text-decoration: none;
    padding-bottom: 12px;
  }

  .button_socdo_giaoviec::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 0;
    background-color: #32CD32;
    transition: width 0.3s ease-out;
  }

  .button_socdo_giaoviec:hover::after {
    width: 100%;
  }

  .button_socdo_giaoviec_parent .active {
    position: relative;
    color: #32CD32;

  }

  .button_socdo_giaoviec_parent .active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: #32CD32;
  }

  .thongtinthongke {
    display: flex;
    justify-content: space-between;
    gap: 10px;
  }

  .grid_thongke {
    width: 200px;
    height: 80px;
    background-color: white;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;

  }

  .list_viec_dagiao .box_danhsachnhansu table thead th {
    background-color: #7769fa;
    border: #7769fa;
    color: white;
    height: 40px;

  }

  .shadow_mid_main {
    background-color: rgba(0, 0, 0, 0.2);
    z-index: 99999999;
  }

  .list_viec_dagiao {
    width: 100%;
  }

  .baocaocuanhanvien {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    z-index: 999999999;
  }

  .box_xemchitietbaocao {
    width: 20%;
    height: auto;
    max-height: 60%;
    margin: auto;
    background-color: white;
    margin-left: 40%;
    transform: translateX(-50%);
    margin-top: 20%;
    transform: translateY(-50%);
    position: relative;
    padding: 30px;
    overflow-y: auto;
  }

  .list_baocao_duocxuatra {
    padding: 10px 0px 0px 10px;
  }

  .close_baocao_nhanvien {
    position: absolute;
    top: 0;
    right: 0;
    background-color: rgb(0, 81, 255);
    color: white;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
  }

  .list_baocao_duocxuatra {
    padding: 10px;
    border: 2px solid #007bff;
    /* Viền màu xanh */
    margin-bottom: 10px;
    border-radius: 5px;
    /* Bo góc */
    background-color: #f9f9f9;
    /* Màu nền nhẹ */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    /* Hiệu ứng đổ bóng */
  }

  .baocao_cuanhanvien {
    padding: 8px;
    border: 1px solid #ccc;
    /* Viền nhẹ */
    border-radius: 5px;
    background-color: #ffffff;
    /* Màu nền trắng */
    font-size: 14px;
  }

  .baocao_cuanhanvien strong {
    color: #333;
    /* Màu chữ đậm */
  }

  .box_form_giaolai_congviec {
    height: 800px;
    margin-top: 50px;
  }

  .left_giaoviec_p {
    margin-top: 20px;
    margin-bottom: 10px;
  }

  .left_giaoviec_span {
    background-color: #cde0ff;
    border-radius: 5px;
    padding: 5px;
    color: #2b6ad1;
    font-weight: 600;
  }

  .left_giaoviec_span button {
    background-color: #2b6ad1;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .box_xingiahan {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 999999999;
    display: none;
  }

  .box_main_giahan {
    width: 1000px;
    height: 400px;
    background-color: white;
    padding: 20px;
    margin-left: 100px;
    position: relative;
  }

  .cl_giahan_box {
    position: absolute;
    top: 0;
    right: 0;
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .giaolai_congviec_dagiao {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    background-color: rgba(0, 0, 0, 0.2);
    width: 100%;
    height: 100%;
    display: none;
  }

  .box_giaolaicongviec {
    background-color: white;
    height: 500px;
    width: 500px;
    margin: auto;
  }
</style>
<div class="list_danhsachnhansu_form shadow_mid_main">
  <div class="box_form shadow_main_box_select">
    <input type="text" name="search_nhanvien" placeholder="Search nhan vien" />
    <button name="close_add_nhanvien">x</button>
    <div class="select_all_nhanvien css_select_all">Chọn tất cả</div>
    <div class="list_nhanvien_form">{list_danhsachnhansu}</div>
  </div>
</div>
<div class="list_phongban_form shadow_mid_main">
  <div class="box_form shadow_main_box_select">
    <input type="text" name="search_phongban" placeholder="Search nhan vien" />
    <button name="close_form_phongban">x</button>
    <div class="select_all_phongban css_select_all">Chọn tất cả</div>
    <div class="list_nhanvien_form">{list_phongban}</div>
  </div>
</div>
<div class="danhsachnhansu shadow_mid_main">
  <div class="box_form shadow_main_box_select">
    <input type="text" name="search_nhanvien" id="">
    <button class="close_nhanvien_phongban">X</button>
    <div class="select_nv_phongban_a">{danhsachnhansuphongban}</div>
  </div>
</div>



<div class="box_right">
  <div class="tongket">
    <div class="box_left_nhansu"></div>
    <div class="box_right_nhansu">
      <div class="box_nhansu">
        <div class="level1 button_socdo_giaoviec_parent">
          <button class="button_socdo_giaoviec btn_remove_giaoviec active" name="thongke">Thống kê</button>
          <button class="button_socdo_giaoviec btn_remove_giaoviec" name="phongban">Danh sách phòng ban</button>
          <button class="button_socdo_giaoviec btn_remove_giaoviec" name="dexuat">Đề xuất</button>
          <button class="button_socdo_giaoviec btn_remove_giaoviec" name="daotao">Đào tạo - Truyền thông</button>
          <button class="button_socdo_giaoviec btn_remove_giaoviec" name="giaoviec">Giao việc</button>
          <button class="button_socdo_giaoviec btn_remove_giaoviec" name="themphongban">Thêm phòng ban</button>
        </div>
        <div class="tonghop-nhansu thongke_g">
          <div class="thongtinthongke">
            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Tổng công việc</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: rgb(13, 23, 216); margin-right: 10px;">
                  <i class="fa-solid fa-square-plus"></i>
                </h1>
                <h1 style="margin: 0; color: rgb(13, 23, 216); font-size: 25px; font-weight: bold;">
                  {total_giaoviec}
                </h1>
              </div>
            </div>
            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Miss Deadline(Nhẹ)</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: rgb(215, 115, 115); margin-right: 10px;">
                  <i class="fa-solid fa-hourglass"></i>
                </h1>
                <h1 style="margin: 0; color: rgb(215, 115, 115); font-size: 25px; font-weight: bold;">
                  {quahan}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Chưa nhận việc</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: rgb(134, 132, 135); margin-right: 10px;">
                  <i class="fa-solid fa-table-list"></i>
                </h1>
                <h1 style="margin: 0; color: rgb(134, 132, 135); font-size: 25px; font-weight: bold;">
                  {chuatienhanh}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Chờ phê duyệt</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: #898b8a; margin-right: 10px;">
                  <i class="fa-solid fa-spinner"></i>
                </h1>
                <h1 style="margin: 0; color: #898b8a; font-size: 25px; font-weight: bold;">
                  {total_giaoviec}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Việc hoàn thành</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: #15c872; margin-right: 10px;">
                  <i class="fa-solid fa-circle-check"></i>
                </h1>
                <h1 style="margin: 0; color: #15c872; font-size: 25px; font-weight: bold;">
                  {dahoanthanh}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Đang tiến hành</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: #7769fa; margin-right: 10px;">
                  <i class="fa-solid fa-chart-line"></i>
                </h1>
                <h1 style="margin: 0; color: #7769fa; font-size: 25px; font-weight: bold;">
                  {dangtienhanh}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Chậm tiến độ</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: #ffd059; margin-right: 10px;">
                  <i class="fa-regular fa-calendar-xmark"></i>
                </h1>
                <h1 style="margin: 0; color: #ffd059; font-size: 25px; font-weight: bold;">
                  {chamtiendo}
                </h1>
              </div>
            </div>

            <div class="grid_thongke">
              <p style="text-align: center; margin-top: 10px; font-weight: 600;">Miss Deadline</p>
              <div
                style="display: flex; flex-direction: row; align-items: center; justify-content: center; width: 100px; height: 50px; margin-left: 20px;">
                <h1 style="color: #ff3b3b; margin-right: 10px;">
                  <i class="fa-solid fa-hourglass-end"></i>
                </h1>
                <h1 style="margin: 0; color: #ff3b3b; font-size: 25px; font-weight: bold;">
                  {quahan}
                </h1>
              </div>
            </div>
          </div>
          <div class="" style="display: flex;justify-content: space-around; gap: 20px;">
            <div
              style="width: 45%; margin: auto;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 35px;">
              <h1>Tổng số việc đã giao</h1><select id="filterType" class="filter-select">
                <option value="day">Theo Ngày</option>
                <option value="month">Theo Tháng</option>
                <option value="year">Theo Năm</option>
                <option value="work">Theo Công Việc</option>
                <option value="progress">Theo Tiến Độ</option>
                <option value="total">Tổng công việc</option>
              </select>
              <canvas id="myPieChart1" width="400" height="400"></canvas>
            </div>
            <div class="thongke_tutao">
              <div
                style="width: 350px;height:400px; margin: auto;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 35px;">
                <h3>Số việc đã giao 1 năm</h3>
                <canvas id="myPieChart2"></canvas>
              </div>
              <div
                style="width: 350px;height:400px; margin: auto;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 35px;">
                <h3>Số việc đã giao trong 30 ngày</h3>
                <canvas id="myPieChart3"></canvas>
              </div>
              <div
                style="width: 350px;height:400px; margin: auto;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 35px;">
                <h3>Số việc đã giao trong 7 ngày</h3>
                <canvas id="myPieChart4"></canvas>
              </div>
              <div
                style="width: 350px;height:400px; margin: auto;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 35px;">
                <h3>Số việc đã giao trong hôm nay</h3>
                <canvas id="myPieChart5"></canvas>
              </div>
            </div>
          </div>
          <div class="list_viec_dagiao"
            style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 25px;">
            <div class="bruh">
              <h2>Danh sách công việc đã giao</h2>
              <div class="form_search_danhsachcongviecdagiao">
                <input type="text" name="form_seach_giaoviec_list" placeholder="Search công việc" />
              </div>
            </div>
            <div class="box_danhsachnhansu" style=" padding: 10px;">
              <table class="table">
                <thead>
                  <th style="width: 5%;">STT</th>
                  <th style="width: 10%;">Tên công việc</th>
                  <th style="width: 10%;">Trạng thái</th>
                  <th style="width: 10%;">Người giao việc</th>
                  <th style="width: 10%;">Phòng ban</th>
                  <th style="width: 10%;">Người nhận việc</th>
                  <th style="width: 15%;">Tiến độ</th>
                  <th style="width: 10%;">Deadline</th>
                  <th style="width: 10%;">Hạn</th>
                  <th style="width: 10%;">Ưu tiên</th>
                </thead>
                <tbody>
                  {list_giaoviec}
                </tbody>
              </table>
              <div id="danhSachCongViec"></div> <!-- Nơi hiển thị danh sách -->
              <div id="phanTrang"></div> <!-- Nơi hiển thị nút phân trang -->
              <p id="thongTinTrang"></p> <!-- Hiển thị thông tin trang -->

            </div>
          </div>
        </div>
        <div class="tonghop-nhansu phongban">
          <div class="list_viec_dagiao"
            style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 25px;">
            <h2>Danh sách phòng ban</h2>
            <div class="box_danhsachnhansu" style=" padding: 10px;">
              <table class="table">
                <thead>
                  <th style="width: 5%;">STT</th>
                  <th style="width: 95%;">Tên phòng ban</th>
                </thead>
                <tbody>
                  {list_phongbannhanvien}
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tonghop-nhansu dexuat">
          <div class="list_viec_dagiao"
            style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 25px;">
            <h2>Đề xuất</h2>
            <div class="box_danhsachnhansu" style=" padding: 10px;">
              <div class="box_danhsach_congviec">
                <table class="table_nhansu_xemviec table">
                  <thead>
                    <th style="width: 5%">STT</th>
                    <th style="width: 25%">Tên nhân sự</th>
                    <th style="width: 20%">Thời gian</th>
                    <th style="width: 20%">Phòng ban</th>
                    <th style="width: 20%">Hành động</th>
                    <th style="width: 10%">Trạng thái</th>
                  </thead>
                  <tbody>
                    {dexuat_box}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tonghop-nhansu daotao">
          <div class="list_viec_dagiao"
            style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;background-color:white;margin-top: 15px; padding: 25px;">
            <h2>Đào tạo - Truyền thông</h2>
            <div class="box_danhsachnhansu" style=" padding: 10px;">
              <h1>Coming Soon</h1>
            </div>
          </div>
        </div>
        <div class="tonghop-nhansu giaoviec">
          <div class="box_danhsachnhansu">
            <div class="box_profile"
              style="background-color:white;padding: 20px;margin-top: 40px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px">
              <div class="page_title">
                <h1 class="undefined">Thêm giao việc mới</h1>
                <div class="line"></div>
                <hr />
              </div>
              <div class="col_100">
                <div class="form_group">
                  <label for="">Phòng ban nhận</label>
                  <div class="list_nguoinhan list_nguoi_thuchien">
                    <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                      <button name="themphongban-form">Phòng ban</button>
                      <div id="selected_phongban"></div>
                    </div>
                  </div>
                </div>
                <div class="form_group">
                  <label for="">Người nhận</label>
                  <div class="list_nguoinhan list_nguoi_thuchien">
                    <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                      <button name="themnguoinhan">Thêm người nhận</button>
                      <div id="nguoinhan_selected"></div>
                    </div>
                  </div>
                </div>
                <div class="form_group">
                  <label for="">Người giám sát</label>
                  <div class="list_nguoinhan list_nguoi_thuchien">
                    <div class="li_add_nguoinhan" loai="list_nguoi_thuchien">
                      <button name="nguoi_giamsat">Người giám sát</button>
                      <div id="nguoigiam_sat_selected"></div>
                    </div>
                  </div>
                </div>

                <div class="form_group">
                  <label for="">Tên công việc<span class="color_red">(*)</span></label>
                  <input type="text" class="form_control" name="ten_congviec" value="" placeholder="Nhập tiêu đề..." />
                </div>
              </div>
              <div class="col_100">
                <div style="clear: both"></div>
                <div class="form_group">
                  <label for="">Mô tả chi tiết</label>
                  <textarea name="chitiet_congviec" class="form_control" id="chitiet_congviec"
                    placeholder="Nhập nội dung công việc" style="width: 100%; height: 250px"></textarea>

                </div>
              </div>
              <div class="col_50">
                <div class="form_group" id="input_link">
                  <label for="">Thời hạn</label>
                  <input type="text" placeholder="Nhập thời hạn hoàn thành..." class="form_control datetimepicker_mask"
                    name="date_line" id="datepicker" />
                </div>
                <link rel="stylesheet" href="/uploads/dinh-kem/">
              </div>
              <div class="col_50">
                <div class="form_group" id="">
                  <label for="">Tệp đính kèm</label>
                  <input type="file" class="form_control" name="file_dinhkem" id="file_dinhkem" />
                </div>
              </div>
              <div class="col_50">
                <div class="form_group" id="">
                  <label for="">Mức độ ưu tiên<span class="color_red">(*)</span></label>
                  <select name="uu_tien" id="uu_tien" class="form_control">
                    <option value="0">Bình thường</option>
                    <option value="1">Ưu tiên</option>
                  </select>
                </div>
              </div>
              <div class="col_50">
                <div class="form_group" id="">
                  <label for="">Trong vòng bao lâu phải nhận việc<span class="color_red">(*)</span></label>
                  <input type="text" class="form_control" name="thoigian_phainhanviec" id="thoigian_phainhanviec"
                    placeholder="Nhập số phút cần nhận việc" />
                </div>
              </div>

              <div style="clear: both"></div>
              <div class="form_group">
                <button name="add_giaoviec" class="button_all">
                  Giao việc
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="tonghop-nhansu themphongban">
          <div class="box_danhsachnhansu">
            <div class="box_danhsachnhansu">
              <div class="box_profile"
                style="background-color:white;padding: 20px;margin-top: 40px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px">
                <div class="page_title">
                  <h1 class="undefined">Thêm phòng ban mới</h1>
                  <div class="line"></div>
                  <hr />
                </div>
                <div class="col_100">
                  <div class="form_group">
                    <label for="">Phòng ban cha</label>
                    <div class="list_nguoinhan list_nguoi_thuchien">
                      <select name="phongbancha">
                        <option value="0">---Chọn phòng ban---</option>
                        {phongbancha}
                      </select>
                    </div>
                  </div>


                  <div class="form_group">
                    <label for="">Tên phòng ban<span class="color_red">(*)</span></label>
                    <input type="text" class="form_control" name="ten_phongban_moi" value=""
                      placeholder="Nhập tên phòng ban..." />
                  </div>
                </div>
                <div style="clear: both"></div>
                <div class="form_group">
                  <button name="add_phongbanmoi" class="button_all">
                    Thêm phòng ban
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#datepicker", {
      enableTime: true,  // Bật chọn thời gian
      enableSeconds: true, // Bật chọn giây
      dateFormat: "H:i:s d-m-Y", // Định dạng hiển thị
      time_24hr: true // Hiển thị 24 giờ thay vì AM/PM
    });
  });
</script>
<script>
  // Dữ liệu biểu đồ

  const data2 = {
    labels: ["Danh mục A", "Danh mục B", "Danh mục C", "Danh mục D"],
    datasets: [{
      data: [30, 50, 70, 40],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
    }]
  };
  const data3 = {
    labels: ["Danh mục A", "Danh mục B", "Danh mục C", "Danh mục D"],
    datasets: [{
      data: [30, 50, 70, 40],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
    }]
  };
  const data4 = {
    labels: ["Danh mục A", "Danh mục B", "Danh mục C", "Danh mục D"],
    datasets: [{
      data: [30, 50, 70, 40],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
    }]
  };
  const data5 = {
    labels: ["Danh mục A", "Danh mục B", "Danh mục C", "Danh mục D"],
    datasets: [{
      data: [30, 50, 70, 40],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
    }]
  };

  // Vẽ biểu đồ

  const ctx2 = document.getElementById('myPieChart2').getContext('2d');
  new Chart(ctx2, {
    type: 'pie',
    data: data2,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,

        },
        title: {
          display: false,
          text: 'Thống kê dữ liệu mẫu'
        }
      }
    }
  });
  const ctx3 = document.getElementById('myPieChart3').getContext('2d');
  new Chart(ctx3, {
    type: 'pie',
    data: data3,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,

        },
        title: {
          display: false,
          text: 'Thống kê dữ liệu mẫu'
        }
      }
    }
  });
  const ctx4 = document.getElementById('myPieChart4').getContext('2d');
  new Chart(ctx4, {
    type: 'pie',
    data: data4,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,

        },
        title: {
          display: false,
        }
      }
    }
  });
  const ctx5 = document.getElementById('myPieChart5').getContext('2d');
  new Chart(ctx5, {
    type: 'pie',
    data: data5,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,

        },
        title: {
          display: false,
        }
      }
    }
  });
  const dataByFilter = {
    day: [25, 25, 40, 10, 30],
    month: [30, 50, 70, 40, 30],
    year: [60, 25, 35, 55, 30],
    work: [20, 45, 25, 10, 30],
    progress: [50, 30, 40, 60, 30],
    total: [{ dahoanthanh }, { dangtienhanh }, { chuatienhanh }, { chamtiendo }, { quanhan }]
  };

  const ctx1 = document.getElementById('myPieChart1').getContext('2d');
  const pieChart = new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: ["Việc đã hoàn thành", "Việc đang tiến hành", "Việc chưa tiến hành", "Việc chậm tiến độ", "Miss Deadline"],
      datasets: [{
        data: dataByFilter.total,
        backgroundColor: ['#15c872', '#7769fa', '#da83fc', '#ffd059', '#ff3b3b']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true
        },
        datalabels: {
          color: '#000',
          font: {
            size: 20,
            weight: 'bold'
          },
          formatter: (value, ctx) => {
            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
            let percentage = ((value / sum) * 100).toFixed(1) + "%";
            return percentage;
          },
          anchor: 'center',
          align: 'center',
          clip: false,
          offset: 0,
          // Custom position logic to align text in slice center
          listeners: {
            render: (context) => {
              const meta = context.chart.getDatasetMeta(context.datasetIndex);
              const arc = meta.data[context.dataIndex];
              const centerX = (arc._model.x + arc._view.x) / 2;
              const centerY = (arc._model.y + arc._view.y) / 2;
              return { x: centerX, y: centerY };
            }
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

  document.getElementById('filterType')?.addEventListener('change', (event) => {
    const selectedFilter = event.target.value;
    pieChart.data.datasets[0].data = dataByFilter[selectedFilter];
    pieChart.update();
  });
</script>