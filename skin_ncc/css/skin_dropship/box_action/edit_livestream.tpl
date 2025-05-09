<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div style="clear: both;"></div>
            <div class="page_title">
                <h1 class="undefined">Sửa trạng thái đặt live stream</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tình trạng:</label>
                    <select class="form_control" name="status">
                        <option value="0">Chờ xử lý</option>
                        <option value="1">Hoàn thành</option>
                        <option value="2">Hủy</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_livestream" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var status = '{status}';
    $('select[name=status]').val(status);
</script>