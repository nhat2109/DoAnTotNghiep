<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 20px;">
            <div class="page_title">
                <h1 class="undefined">Sửa deal sốc</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="box_deal_step">
                <div class="text_step">
                    <span class="active">1</span>
                </div>
                <div class="content_step">
                    <div class="title_step">Thông tin cơ bản</div>
                    <div class="tr_step">
                        <div class="step_left">Tên chương trình</div>
                        <div class="step_right">
                            <input type="text" value="{tieu_de}" name="tieu_de" placeholder="Nhập vào tên chương trình">
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left">Thời gian bắt đầu/kết thúc</div>
                        <div class="step_right">
                            <div><input type="text" name="date_start" value="{date_start}" placeholder="Thời gian bắt đầu" class="datetimepicker_mask"></div>
                            <div style="padding: 10px;"><i class="fa fa-arrows-h"></i></div>
                            <div><input type="text" name="date_end" value="{date_end}" placeholder="Thời gian kết thúc" class="datetimepicker_mask"></div>                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_deal_step">
                <div class="text_step">
                    <span class="bg_violet">2</span>
                </div>
                <div class="content_step">
                    <div class="title_step">Sản phẩm</div>
                    <div class="tr_step"><button class="select_product_sub">Chọn sản phẩm</button></div>
                    <div class="tr_step">
                        <div id="list_product_sub">{list_sub}</div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group" style="text-align: center;margin-top: 10px;">
                <input type="hidden" value="{id}" name="id">
                <button name="edit_flash_sale" class="button_all"> Hoàn thành</button>
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
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $('input.timepicker').timepicker({'timeFormat': 'H:i:s','step': 5});
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
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_marketing'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>
<script type="text/javascript">
    var loai ='{loai}';
    $("input[name=loai][value=" + loai + "]").prop('checked', true);
</script>