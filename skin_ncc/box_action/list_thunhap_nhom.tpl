<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
        <div class="list_tab">
            <div class="li_tab" loai="drop"><a href="/ncc/list-donhang-nhom?loai=drop&status={status}&page=1">Đơn sàn TMĐT</a></div>
            <div class="li_tab" loai="socdo"><a href="/ncc/list-donhang-nhom?loai=socdo&status={status}&page=1">Đơn SOCDO.VN</a></div>
            <div class="li_tab" loai="affiliate"><a href="/ncc/list-donhang-nhom?loai=affiliate&status={status}&page=1">Đơn Affiliate</a></div>
        </div>
        <div class="content_tab">
            <div class="title_tab">
                <div class="stt">STT</div>
                <div class="ngay">Ngày</div>
                <div class="ma_don">Mã đơn</div>
                <div class="doanh_thu">Doanh thu</div>
                <div class="hoahong">Hoa hồng</div>
                <div class="thanhvien">Người bán</div>
                <div class="username">Tài khoản</div>
                <div class="trangthai">Trạng thái</div>
                <div class="thanhtoan">Thanh toán HH</div>
            </div>
            <div class="list_don">
                {list_donhang}
            </div>
        </div>
        {phantrang}
  	</div>
  </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $('input.timepicker').timepicker({'timeFormat': 'H:i:s','step': 5});
        $('.list_tab').find('.li_tab[loai={loai}] a').addClass('active');
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