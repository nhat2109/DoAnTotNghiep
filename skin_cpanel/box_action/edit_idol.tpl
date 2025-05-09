<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa idol</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Họ và tên</label>
                    <input type="text" class="form_control" name="ho_ten" value="{ho_ten}" placeholder="Nhập tên idol...">
                </div>
                <div class="form_group">
                    <label for="">Hình ảnh đại diện</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{avatar}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Năm sinh</label>
                    <input type="text" class="form_control" name="nam_sinh" value="{nam_sinh}" placeholder="Nhập năm sinh của idol...">
                </div>
                <div class="form_group">
                    <label for="">Chiều cao</label>
                    <input type="text" class="form_control" name="chieu_cao" value="{chieu_cao}" placeholder="Nhập chiều cao của idol...">
                </div>
                <div class="form_group">
                    <label for="">Cân nặng</label>
                    <input type="text" class="form_control" name="can_nang" value="{can_nang}" placeholder="Nhập cân nặng idol...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Kinh nghiệm</label>
                    <textarea name="kinh_nghiem"  class="form_control" style="height: 100px;width: 100%;" placeholder="Nhập kinh nghiệm live stream">{kinh_nghiem}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Video giới thiệu</label>
                    <input type="text" class="form_control" name="video" value="{video}" placeholder="Nhập link video youtube...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thời gian bắt đầu</label>
                    <input type="text" class="form_control timepicker" name="time_start" value="{time_start}" placeholder="Nhập thời gian bắt đầu...">
                </div>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thời gian kết thúc</label>
                    <input type="text" class="form_control timepicker" name="time_end" value="{time_end}" placeholder="Nhập thời gian kết thúc...">
                </div>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Ngân sách live</label>
                    <input type="text" class="form_control price_format" name="ngan_sach" value="{ngan_sach}" placeholder="Nhập chi phí đặt live stream...">
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự hiển thị...">
                </div>
                <div class="form_group">
                    <label for="">Trạng thái</label>
                    <select class="form_control" name="an">
                        <option value="0">Hiển thị</option>
                        <option value="1">Ẩn</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_idol" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input.timepicker').timepicker({'timeFormat': 'H:i','step': 5});
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_livestream'){
                vitri=total_height - 90;
            }
        });
        var an='{an}';
        $('select[name=an]').val(an); 
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>
