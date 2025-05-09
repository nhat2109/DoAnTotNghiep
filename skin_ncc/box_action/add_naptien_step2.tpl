<div class="box_right">
  <div class="box_right_content">
    <div class="box_profile" style="width: 600px;padding: 10px;">
        <div class="box_time">
            <h2 style="text-align: center;text-transform: uppercase;">Hoàn thành nạp tiền</h2>
            <div style="text-align: left;margin-top: 20px;">
                <div class="title_ck" style="text-align: center;font-weight: 700;margin-top: 10px;">Quét mã QR để chuyển khoản</div>
                <div class="img_ck" style="width: 100%;text-align: center;">
                    <img src="https://img.vietqr.io/image/VPBank-687078888-compact.png?amount={sotien_2}&addInfo=naptien%20{username}%20{id}&accountName=RED%20SQUIRREL%20JOINT%20STOCK%20COMPANY" width="165">
                </div>
                <div class="title_ck" style="text-align: center;font-weight: 700;">Thông tin tài khoản ngân hàng: </div>
               <div style="text-align: center;margin-top: 10px;">Vui lòng chuyển <span class="color_red bold">{sotien} đ</span> với nội dụng:<br> <span class="color_red bold" style="font-size: 20px;padding-top: 10px;padding-bottom: 10px;display: inline-block;">naptien {username} {id}</span></div>
            </div>
            <div>tới số tài khoản ngân hàng bên dưới để hoàn thành giao dịch.</div>
            <table class="table_nganhang">
                  <tbody><tr>
                    <td>Tên ngân hàng</td>
                    <td>{bank_name}</td>
                  </tr>
                  <tr>
                    <td>Chủ khoản</td>
                    <td>{bank_holder}</td>
                  </tr>
                  <tr>
                    <td>Số tài khoản</td>
                    <td>{bank_account}</td>
                  </tr>
                  <tr>
                    <td>Số tiền</td>
                    <td style="color: red;font-weight: 700;">{sotien} đ</td>
                  </tr>
                </tbody>
            </table>
            <div class="list_button" style="display: flex;justify-content: center;">
                <button id="add_naptien_step2" id_nap="{id_nap}">Hoàn thành</button>
            </div>
            <div style="margin-top: 10px;font-style: italic;">Lưu ý: Nếu không hoàn thành, giao dịch sẽ bị hủy sau <b>15 phút</b></div>
        </div>
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