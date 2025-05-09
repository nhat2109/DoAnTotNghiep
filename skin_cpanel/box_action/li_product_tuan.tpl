<div class="li_product li_product_{id}" sp="{id}">
    <div class="thumbnail">
        <img src="/thumbnail.php?w=320&img={minh_hoa}" alt="{tieu_de}">
    </div>
    <div class="info">
        <div class="name">{tieu_de}</div>
        <div class="price">
            <div class="price-old">{gia_cu}</div>
            <div class="price-new">{gia_drop}</div>
        </div>
        <div class="price">
            <div class="price-tuan"><input type="text" name="gia_tuan" placeholder="Giá chương trình tuần" class="price_format"></div>
            <div class="price-tuan"><input type="text" name="gia_ctv_tuan" placeholder="Giá CTV chương trình tuần" class="price_format"></div>
        </div>
        <div class="price" style="margin-top: 10px;">
            <div class="price-tuan"><input type="text" name="time_start" placeholder="Thời gian bắt đầu" class="datetimepicker_mask"></div>
            <div class="price-tuan"><input type="text" name="time_end" placeholder="Thời gian kết thúc" class="datetimepicker_mask"></div>
        </div>
        <div class="price" style="margin-top: 10px;">
            <div class="price-tuan" style="width: 100%;"><input type="text" name="note_text" placeholder="Nội dung lưu ý" style="width: 100%;"></div>
        </div>
    </div>
    <div class="action">
        <button sp="{id}" gia="{gia_drop}" gia_ctv="{gia_ctv}">Thêm</button>
    </div>
</div>