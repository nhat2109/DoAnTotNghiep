<style>
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
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 0;
    background-color: #32cd32;
    transition: width 0.3s ease-out;
  }

  .button_socdo_giaoviec:hover::after {
    width: 100%;
  }
  .button_socdo_giaoviec_parent .active {
    position: relative;
    color: #32cd32;
  }

  .button_socdo_giaoviec_parent .active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: #32cd32;
  }
  .box_danhsach_congviec {
    margin: auto;
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.2);
    width: 95%;
    margin-top: 20px;
    padding: 20px;
  }
  .table_nhansu_xemviec {
    text-align: center;
    padding: 20px;
    width: 100%;
  }
  .table_nhansu_xemviec thead {
    background-color: #08179c;
    padding: 20px;
    height: 50px;
    font-size: 16px;
    color: white;
  }
  .dongthechitietcongviec {
    display: none;
  }
  /* Thanh timeline */
  .list_timeline .timeline {
    height: 12px;
    width: 100%;
    border-radius: 6px;
    background-color: #e0e0e0;
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
    right: -20px; /* Đẩy hẳn ra ngoài */
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
    border: 2px solid #007bff; /* Viền màu xanh */
    margin-bottom: 10px;
    border-radius: 5px; /* Bo góc */
    background-color: #f9f9f9; /* Màu nền nhẹ */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
  }

  .baocao_cuanhanvien {
    padding: 8px;
    border: 1px solid #ccc; /* Viền nhẹ */
    border-radius: 5px;
    background-color: #ffffff; /* Màu nền trắng */
    font-size: 14px;
  }

  .baocao_cuanhanvien strong {
    color: #333; /* Màu chữ đậm */
  }
  .hover_skin_tr_vieccuanhanvien {
    cursor: pointer;
  }
  .hover_skin_tr_vieccuanhanvien:hover {
    background-color: rgba(113, 113, 113, 0.346);
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
  }
  .chitiet_viecduocgiao {
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.108);
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .box_trong_main {
    background-color: white;
    width: 80%;
    height: 80%;
    padding: 20px;
    position: relative;
    display: flex;
    justify-content: space-between;
  }
  .close_viec_cua_ban {
    position: absolute;
    right: 0;
    top: 0;
    background-color: red;
    margin: 15px 15px 0px 0px;
  }
  .right-box-trongmain{
    width: 50%;
    height: 100%;
    padding: 20px;
  }
  .noidungxacnhan_scroll{
    height: 550px;
    overflow-y: auto;
  }
  .baocao_scroll{
    height: 200px;
    overflow-y: auto;
  }
  .form_box_chonsep{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .box_form_select_sep{
    background-color: white;
    width: 400px;
    height: 400px;
    padding: 20px;
  }
</style>
<div class="form_box_chonsep">
  <div class="box_form_select_sep">
    <div class="close_form_sep">
      <button name="close_form_x">X</button>
    </div>
    <div class="form_select_sep">
      {danhsachsep}
    </div>
  </div>
</div>
<div class="box_right">
  <div class="tongket">
    <div class="box_left_nhansu"></div>
    <div class="box_right_nhansu">
      <div class="box_nhansu">
        <div class="level1 button_socdo_giaoviec_parent">
          <button
            class="button_socdo_giaoviec btn_remove_giaoviec active"
            name="danhsachcongvieccuanhansu"
          >
            Danh sách công việc
          </button>
          <button
            class="button_socdo_giaoviec btn_remove_giaoviec"
            name="dexuat"
          >
            Đề xuất
          </button>
        </div>
        <div class="tonghop-nhansu themphongban danhsachcongviec_duocgiao">
          <div class="congviec_cuanhansu_a">
            <table class="table_nhansu_xemviec table">
              <thead>
                <th style="width: 5%">STT</th>
                <th style="width: 15%">Tên công việc</th>
                <th style="width: 10%">Người giao việc</th>
                <th style="width: 30%">Tiến độ</th>
                <th style="width: 10%">Thời hạn</th>
                <th style="width: 10%">Chức vụ trong dự án</th>
                <th style="width: 10%">Trạng thái</th>
                <th style="width: 10%;">Báo cáo ngày</th>
              </thead>
              <tbody>
                {congviec_nhansu_dcgiao}
              </tbody>
            </table>
          </div>
        </div>
        <div class="tonghop-nhansu dexuat_chosep" style="display: none;">
          <div class="add_dexuat_moi">
            <button name="add_dexuatmoi">Thêm đề xuất mới</button>
          </div>
          <div class="box_danhsach_congviec add_form_dexuat_a">
            <table>
              <thead>
                <th>STT</th>
                <th>Tiêu đề đề xuất</th>
                <th>Người nhận</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </thead>
              <tbody>
                {list_dexuat_nhanvien}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#xingiahan", {
      enableTime: true,  // Bật chọn thời gian
      enableSeconds: true, // Bật chọn giây
      dateFormat: "H:i:s d-m-Y", // Định dạng hiển thị
      time_24hr: true // Hiển thị 24 giờ thay vì AM/PM
    });
  });
</script>
<script>
 $(document).ready(function() {
    $('.form_box_chonsep').hide();
    $('body').on('click','button[name=add_dexuatmoi]',function(){
      localStorage.setItem('pre', $('.add_form_dexuat_a').html());
      $.ajax({
        url:"/admincp/process.php",
                            type:"post",
                            data:{
                                action:'load_form_dexuat_a'
                            },
                            success:function(kq){
                                var info = JSON.parse(kq);
                                $(".add_form_dexuat_a").html(info);
                            }
      })
    })
    $('body').on('click','button[name=quay_trolai_formdexuat]',function(){
      var pre = localStorage.getItem('pre');
      if(pre){
        $('.add_form_dexuat_a').html(pre);
      }
    })
    
    $('body').on('click', 'button[name=chon_nguoidexuat]', function() {
        $('.form_box_chonsep').show();
    });
    $('body').on('click', 'button[name=chonsep_thoi]', function() {
        $(this).hide();
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#sepnhan_selected').append('<div class="sepnhan_selected_c value_duocchon_dexuat_sep' + id + '" data-id="' + id + '" data-name="' + name + '">' + name + ' <button class="remove_dexuat_sep" data-id="' + id + '">X</button></div>');
    });
    $('body').on('click', 'button.remove_dexuat_sep', function() {
        let id = $(this).attr('data-id');
        $('.value_duocchon_dexuat_sep' + id).remove();
        $('.value_id_sep' + id).show();
    });
    $('body').on('click','button[name=close_form_x]',function(){
      $('.form_box_chonsep').hide();
    })
    $('body').on('click','button[name=xemchitiet_dexuat_cuanhanvien]',function(){
      id = $(this).attr('data-id');
      localStorage.setItem('prea', $('.add_form_dexuat_a').html());
      var form_data = new FormData();
      form_data.append('action','xemchitiet_dexuat');
      form_data.append('id',id);
     $.ajax({
       url: "/admincp/process.php",
       type: "post",
       cache: false,
       contentType: false,
       processData: false,
       data: form_data,
       success: function (kq) {
        var info = JSON.parse(kq);
          $('.add_form_dexuat_a').html(info);
       },
     });
    })
    $('body').on('click','button[name=quay_tro_lai_dexuat]',function(){
      var prea = localStorage.getItem('prea');
      if(prea){
        $('.add_form_dexuat_a').html(prea);
      }
    })
});

   


</script>