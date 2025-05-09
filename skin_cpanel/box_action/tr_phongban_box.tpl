<style>
    .tr_phongban_box:hover{
        background-color: rgba(0, 0, 0, 0.327);
        color: white;
    }
    .box_tr_phongban_b{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.131);
        z-index: 9999;
    }
    .box_chi_tiet_congviec{
        overflow-y: auto;
    }
    .table_nhanvien {
        display: table;
        width: 100%;
        border-collapse: collapse;
    }

    .table_nhanvien .table {
        display: table-row-group;
    }

    .table_nhanvien .thead_b {
        display: table-header-group;
        background-color: #f2f2f2;
    }

    .table_nhanvien .th {
        display: table-cell;
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .table_nhanvien .tbody_t {
        display: table-row-group;
    }

    .table_nhanvien .tbody_t > div {
        display: table-row;
    }

    .table_nhanvien .tbody_t > div > div {
        display: table-cell;
        padding: 8px;
        border: 1px solid #ddd;
    }
</style>
<tr class="tr_phongban_box" data-id="{id}" data-title="{tieu_de_phongban}">
    <td>{index}</td>
    <td>{tieu_de_phongban}</td>
</tr>
<div class="chitietphongban_{id} box_tr_phongban_b" style="display: none;">
    <div class="box_chi_tiet_congviec">
        <div class="close_add_nv_zo_phongban"><button data-id="{id}">X</button></div>
        <div class="bruh">
            <div class="table_nhanvien">
                <div class="table">
                    <div class="thead_b">
                        <div class="th">STT</div>
                        <div class="th">Tên nhân viên</div>
                        <div class="th">Chức vụ</div>
                    </div>
                    <div class="tbody_t">
                        {list_phongban_a}
                    </div>
                </div>
            </div>
        </div>
        <div class="themnhanvienvaophongban">
            <div class="form_add_nhanvien_phongban">
                <button name="themnhanvien_vao_phong_ban_a" data-id="{id}">Them nhan vien</button>
                <div id="nv_duoc_chon_vaopb{id}" class="bruh_lmao_id_haha attr_id_data_phongban_canthem{id}"></div>
            </div>
            <div class="add_truongphong">
                <label for="">Thêm trưởng phòng</label>
                <select name="them_truongphong_pb{id}" id="add_phongbanbox_truongphong{id}">
                    <option value="">--Chọn trưởng phòng--</option>
                    {name_truongphong}
                </select>
            </div>
            <div class="form_add_truongphong_phongban"></div>
            <button name="themnvpb" data-id="{id}">Them</button>
        </div>
    </div>
</div>


