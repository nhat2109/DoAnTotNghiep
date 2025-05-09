<tr id="tr_{id}"  class="hover_id_giaoviec" data-id="{id}" data-title="{tieu_de}" style="text-align: center;">
  <td style="text-align: center;background-color: {background_color};" class="hide_mobile">{i}</td>
  <td style="text-align: left" data-title="{tieu_de}">{tieu_de}</td>
  <td style="text-align: center;" class="hide_mobile">{status}</td>
  <td style="text-align: center; width: 90px" class="action" >{nguoi_giao}</td>
  <td style="text-align: center; width: 90px" class="action" >{phong_ban}</td>
  <td style="text-align: center; width: 90px" class="action" >{nguoi_nhan}</td>
  <td><div class="tiendocongviec">
    <div class="list_timeline"  style="width: 300px;padding: 10px 25px 10px 20px">
      <div class="timeline">
        <div class="list_b" style="width: {phantram}%; background-color: {background_color}; ">
          <div class="tiendo" style="background-color: {background_color};">{phantram}%</div>
        </div>
      </div>
    </div>
  </div></td>
  <td>{thoihanketthuc}</td>
  <td>{thoi_gian_conlai}</td>
  <td data-uutien="{uu_tien}">{uu_tien}</td>
</tr>
<div class="xemchi_tiet_congviec tr_{id}">
  <div class="box_chi_tiet_congviec">
  <div class="mucdouutien"> <button class="close_chitiet_congviec" name="close_chitiet_congviec">X</button></div>
    <div class="left_giaoviec">
      <p class="left_giaoviec_p">Tên công việc: </p>
      <span class="left_giaoviec_span">{tieu_de}</span>
      <p class="left_giaoviec_p">Trạng thái: </p>
      <span class="left_giaoviec_span">{status} </span>{phe_duyet}
      <p class="left_giaoviec_p">Thời gian còn lại: </p>
      <span class="left_giaoviec_span">{thoi_gian_conlai}</span>
    <div class="nguoinhan">
      <p class="left_giaoviec_p">Người giao: </p>
      <span class="left_giaoviec_span">{nguoi_giao}</span>
      <p class="left_giaoviec_p">Người giám sát: </p>
      <span class="left_giaoviec_span">{nguoigiamsat_g}</span>
      <p class="left_giaoviec_p">Báo cáo của nhân viên: </p>
      <span class="left_giaoviec_span"><button name="baocao_cuanhanvien" data-id="{id}">Xem báo cáo</button></span>
      <span class="left_giaoviec_span"><button name="lichsu_yeucau_giahan" data-id="{id}">Lịch sử yêu cầu gia hạn</button></span>
    </div>
    </div>
    <div class="right_giaoviec">
      <div class="mota">
        <p class="left_giaoviec_p">Mức độ ưu tiên: <span class="left_giaoviec_span">{uu_tien}</span></p>
        <div class="trangthaitiendo">
          <p>Tình trạng chậm tiện độ: <span class="left_giaoviec_span">{cham_tiendo}</span></p>
          <p>Tình trạng miss deadline: <span class="left_giaoviec_span">{miss_deadline}</span></p>
        </div>
        <div class="tiendocongviec">
          <p>Tiến độ công việc: <span class="left_giaoviec_span">{phantram}%</span></p>
          <div class="list_timeline"  style="width: 300px;padding: 10px 25px 10px 0px">
            <div class="timeline">
              <div class="list_b" style="width: {phantram}%; background-color: {background_color}; ">
                <div class="tiendo" style="background-color: {background_color};">{phantram}%</div>
              </div>
            </div>
          </div>
        </div>
        <p class="left_giaoviec_p">Người nhận: <span class="left_giaoviec_span">{nguoi_nhan_g}</span></p>
        <p class="left_giaoviec_p">Mô tả công việc:</p>
        <span>{noi_dung}</span>
      </div>
      <div class="giaolaicongviec">
        <button name="giaolai_giaoviec" data-id="{id}">Giao lại công việc</button>
      </div>
    </div>
  </div>
</div>
<div class="baocaocuanhanvien baocao_{id}">
  
  <div class="box_xemchitietbaocao ">{bao_cao}<button class="close_baocao_nhanvien" name="close_baocao_nhanvien">X</button></div>

</div>
<div class="baocaocuanhanvien lichsu_giahan{id}">
  
  <div class="box_xemchitietbaocao ">{lichsu_giahan}<button class="close_baocao_nhanvien" name="close_baocao_nhanvien">X</button></div>

</div>
{thedivmuonnam}
