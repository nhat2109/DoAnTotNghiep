<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="box_timkiem">
                <input type="text" name="key" placeholder="Mã đơn, điện thoại, email...">
                <button name="timkiem_donhang_ctv" class="button_timkiem">Tìm kiếm</button>
            </div>
            <div class="page_title">
                <h1 class="undefined">Danh sách đơn hàng CTV</h1>
                <div style="clear: both;"></div>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
            .list_baiviet i {
                font-size: 35px;
            }
            </style>
            <table class="list_baiviet">
                <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Mã đơn</th>
                    <th style="text-align: left;" class="hide_mobile">Ngày</th>
                    <th style="text-align: left;">ĐT TV</th>
                    <th style="text-align: left;width: 150px;">Tên thành viên</th>
                    <th style="text-align: left;width: 150px;">Họ và tên</th>
                    <th style="text-align: center; width: 200px;">Sản phẩm</th>
                    <th style="text-align: center; width: 200px;">Cập nhật</th>
                    <th style="text-align: left;" class="hide_mobile">Giá trị</th>
                    <th style="text-align: center;width: 150px;" class="hide_mobile">Tình trạng</th>
                    <th style="text-align: center;width:140px;">Hành động</th>
                </tr>
                {list_donhang}
            </table>
            {phantrang}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_donhang'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>