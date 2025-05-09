{header}
<body>
    {box_header}
    <div class="box_sieu_sale">
        <div class="container">
            <div class="box_top_img">
                <img src="/images/eb9464d54fc3939dcad2.jpg" alt="Mua kèm deal sốc">
            </div>
            <div class="list_tab_sieu_sale">
                <div class="tab_sieu_sale active"><a href="javascript:;">Thông tin mã giảm giá</a></div>
            </div>
            <div class="content_tab_sieu_sale">
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <script type="text/javascript" charset="utf-8">
        $(function() {
          var currentDate = new Date(),
              finished = false,
              availiableExamples = {
                set5ngay: 15 * 24 * 60 * 60 * 1000,
                set5phut  : 5 * 60 * 1000,
                set1phut  : 1 * 10 * 1000
              };         
            function call_flash(event) {
              $this = $(this);
                switch(event.type) {
                    case "seconds":
                    case "minutes":
                    case "hours":
                    case "days":
                    case "weeks":
                    case "daysLeft":
                      $this.find('.'+event.type).html(event.value);
                      if(finished) {
                        $this.fadeTo(0, 1);
                        finished = false;
                      }
                        break;
                    case "finished":
                time_start=$(this).attr('time_start')*1000;
                con=$(this).attr('time')*1000;
                if(time_start>0){
                    $this.attr('time_start','0');
                    $this.find('.text_status').html('Còn');
                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                }else{
                    $this.fadeTo('slow', .5);
                    $this.html('Đã hết hạn');
                }
                finished = true;
                        break;
                }
            }
            $('.timer_countdown').each(function(){
                time_start=$(this).attr('time_start')*1000;
                con=$(this).attr('time')*1000;
                if(time_start>0){
                    $(this).countdown(time_start + currentDate.valueOf(), call_flash);
                }else{
                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                }
            });
        });
      </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(function() {
        $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: "-60:+0" });
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
    </script>
</body>

</html>