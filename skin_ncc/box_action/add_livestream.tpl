<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 900px;">
            <div class="page_title">
                <h1 class="undefined">Đặt lịch live stream</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="box_deal_step box_step_laptop">
                <div class="content_step" style="width: 100%;">
                    <div class="title_step">Thông tin cơ bản</div>
                    <div class="tr_step">
                        <div class="step_left"><b>Tên Idol:</b></div>
                        <div class="step_right">
                            {ho_ten}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Năm sinh:</b></div>
                        <div class="step_right">
                            {nam_sinh}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Chiều cao:</b></div>
                        <div class="step_right">
                            {chieu_cao}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Cân nặng:</b></div>
                        <div class="step_right">
                            {can_nang}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Kinh nghiệm:</b></div>
                        <div class="step_right">
                            {kinh_nghiem}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Video giới thiệu:</b></div>
                        <div class="step_right">
                            <button class="pop_video" video="{ma_video}">Xem video</button>
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Khung giờ live stream:</b></div>
                        <div class="step_right">
                            {time_start} - {time_end}
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left"><b>Ngân sách:</b></div>
                        <div class="step_right">
                            {ngan_sach} đ/60 phút
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_deal_step box_step_mobile">
                <div class="content_step" style="width: 100%;">
                    <div class="title_step">Thông tin cơ bản</div>
                    <div class="tr_step">
                        <b>Tên Idol:</b> {ho_ten}
                    </div>
                    <div class="tr_step">
                        <b>Năm sinh:</b> {nam_sinh}
                    </div>
                    <div class="tr_step">
                        <b>Chiều cao:</b> {chieu_cao}
                    </div>
                    <div class="tr_step">
                        <b>Cân nặng:</b> {can_nang}
                    </div>
                    <div class="tr_step">
                        <b style="width: 130px;">Kinh nghiệm:</b> {kinh_nghiem}
                    </div>
                    <div class="tr_step">
                        <b>Video giới thiệu:</b> <button class="pop_video" video="{ma_video}">Xem video</button>
                    </div>
                    <div class="tr_step">
                        <b>Khung giờ live stream:</b> {time_start} - {time_end}
                    </div>
                    <div class="tr_step">
                        <b>Ngân sách:</b> {ngan_sach} đ/60 phút
                    </div>
                </div>
            </div>
            <div class="box_deal_step">
                <div class="content_step" style="width: 100%;">
                    <div class="title_step">Sản phầm cần live stream</div>
                    <div class="tr_step">
                        <textarea name="san_pham" placeholder="Nhập tên sản phầm cần live stream" style="border: 1px solid #dedede;width: 100%;height: 100px;padding: 5px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="box_deal_step">
                <div class="content_step" style="width: 100%;">
                    <div class="title_step">Ghi chú</div>
                    <div class="tr_step">
                        <textarea name="ghi_chu" placeholder="Nhập nội dung ghi chú(Chương trình tặng quà, giảm giá...)" style="border: 1px solid #dedede;width: 100%;height: 100px;padding: 5px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="box_deal_step">
                <div class="content_step" style="width: 100%;">
                    <div class="title_step">Khung giờ đặt lịch</div>
                    <div class="tr_step">
                        <div class="list_time_live">
                            <div class="li_time_live">
                                <div class="col_left">
                                    <div class="form_group">
                                        <label for="">Ngày live stream</label>
                                        <input type="text" class="form_control datepicker" name="ngay" value="" placeholder="Nhập ngày live stream...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="list_time_live">
                            <div class="li_time_live">
                                <div class="col_left">
                                    <div class="form_group">
                                        <label for="">Thời gian bắt đầu</label>
                                        <input type="text" class="form_control timepicker" name="time_start" value="" placeholder="Nhập thời gian bắt đầu...">
                                    </div>
                                </div>
                                <div class="col_right">
                                    <div class="form_group">
                                        <label for="">Thời gian kết thúc</label>
                                        <input type="text" class="form_control timepicker" name="time_end" value="" placeholder="Nhập thời gian kết thúc...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{id}">
                    <div class="title_step">Thành tiền: <span class="color_red bold tt"></span></div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group" style="text-align: center;margin-top: 10px;">
                <button name="add_livestream" class="button_all"> Hoàn thành</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/>
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script src="/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true,minDate: 2 });
        $('input[name=time_start]').timepicker({'timeFormat': 'H:i','step': 60,'minTime': '{time_start}','maxTime': '{time_end}'});
        $('input[name=time_end]').timepicker({'timeFormat': 'H:i','step': 60,'minTime': '{time_start}','maxTime': '{time_end}'});
        $('input[name=time_start]').on('changeTime', function() {
            $('input[name=time_end]').val('');
            $('input[name=time_end]').timepicker({'timeFormat': 'H:i','minTime':$(this).val(),'step':60,'maxTime': '{time_end}'});

        });
        $('input[name=time_end]').on('changeTime', function() {
            time_start=$('input[name=time_start]').val();
            time_end=$('input[name=time_end]').val();
            id=$('input[name=id]').val();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "check_price",
                    time_start: time_start,
                    time_end: time_end,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        $('.tt').html(info.tongtien);
                    }else{
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $('.load_note').html(info.thongbao);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    }
                }
            });
        });
        $('.datetimepicker_mask').datetimepicker({
            format:'H:i d/m/Y',
            //mask:'16:35 26/07/1988',
        });
        $.datepicker.setDefaults({
            closeText: "Đóng",
            prevText: "&#x3C;Trước",
            nextText: "Tiếp&#x3E;",
            currentText: "Hôm nay",
            monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
            ],
            monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
            ],
            dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tu",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });
    })
</script>
<div class="box_video">
    <div class="box_video_content">
        <div class="khung_video">
            <div class="close"><i class="fa fa-close"></i></div>
            <iframe width="560" height="315" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>