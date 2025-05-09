
<tr class="tr_id_{id}">
  <td>{i}</td>
  <td>{tieu_de}</td>
  <td>{name_emin}</td>
  <td  class="hover_skin_tr_vieccuanhanvien" data-id="{id}">
      <div class="list_timeline"  style="padding: 10px 25px">
          <div class="timeline">
            <div class="list_b" style="width: {phantram}%; background-color: #7dadf6;">
              <div class="tiendo" style="background-color: #478ffc;">{phantram}%</div>
            </div>
          </div>
        </div>
  </td>
  <td>{thoi_gian}</td>
  <td>{chucvu_congviec}</td>
  <td>  
    {xac_nhan_congviec}
  </td>
  <td style="color:{background_baocao}">{tt_baocao_n}</td>
</tr>

<div class="dongthechitietcongviec value_id_bruh_{id}">
  <div class="chitiet_viecduocgiao " style="z-index: 99999;">
      <div class="box_trong_main">
        <div class="left-box-trongmain">
          <button class="close_viec_cua_ban">X</button>
        <div class="top_left_viec">
          <div class="mucdouutien">Mức độ: {uu_tien}</div>
          <div class="nguoigiamsat_vieccuaban">Người giám sát: {nguoigiamsat}</div>
          <div class="nguoigiaoviecchoban">Người giao việc: {nguoi_giao}</div>
          <div class="tinhtrangcongvieccuaban">Tình trạng: {status}</div>
          <div class="handeadline">Hạn deadline: {date_line}</div>
          {xembaocao}
        </div>
        <div class="left_main_viec">
          <h3>Miêu tả công việc: {tieu_de}</h3>
          <div class="chitietcongviec">
            <h5>Chi tiết công việc</h5>
            <p>{noi_dung}</p>
          </div>
        </div>
        <div class="bottom_viec_main">
          <a href="{dinh_kem}">Tải file xuống!</a>
        </div>
        </div>
        <div class="right-box-trongmain">
          <label for="">Cập nhật tiến độ</label>
          <input type="text" name="update_tiendo{id}" class="update_tiendo" value="{phantram}">
          <label for="">Nội dung báo cáo</label>
          <textarea
          name="baocaotiendohangngay"
          class="form_control"
          id="baocaotiendohangngay{id}"
          placeholder="Nhập nội dung công việc"
          style="width: 100%; height: 250px"
        ></textarea>
        <input type="file" name="file_baocao_tiendo{id}">
          <button name="submit_update_tiendo" data-id="{giaoviec_id}">Cập nhật tiến độ</button>
          <div class="baocao_scroll">
            {bao_cao}
          </div>
        </div>
        <div class="right-box-trongmain">
          <input
          type="text"
          placeholder="Nhập thời hạn hoàn thành..."
          class="form_control datetimepicker_mask"
          name="date_line{id}"
          id="xingiahan"
        />
          <input type="text" name="xingiahan{id}" class="xingiahan form-control" placeholder="Lý do xin gia hạn...">
        <input type="file" name="file_xingiahan{id}">
          <button name="xingiahan" data-id="{giaoviec_id}">Xin gia hạn</button>
        <div class="noidungxacnhan_scroll">
          {noidung_xacnhan_giahan}
        </div>

        </div>
      </div>
    </div>
</div>
<div class="baocaocuanhanvien baocao_{id}">

  <div class="box_xemchitietbaocao">{lydo_tuchoi}<button class="close_baocao_nhanvien" name="close_baocao_nhanvien">X</button></div>
</div>
<div class="scroll_hidden_fixxx value_b_scrikk_a{id}">
  <div class='xacnhan'>
    <button name='xac_nhan_congviec_duocgiao' data-id="{id}"><strong>Xác nhận công việc</strong><br>Còn {tgian_conlai_nhanviec} phút để nhận việc</button>
      </div>
  <div class="tuchoi_congviec_k">
    <button name="tuchoi_congviec_b" data-id="{id}">Từ chối</button>
    <div class="hidden_scroll_form_tuchoigiaoviec value_id_tuchoixacnhan{id}">
      <textarea name="lydotuchoi_congviec_ns" id="lydotuchoi_congviec_ns{id}"></textarea>
    <button name="xacnhan_tuchoi_congviec_duocgiao" data-id="{id}">Xác nhận từ chối</button>
    </div>
  </div>
</div>