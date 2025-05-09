<div class="menu_thongbao">
  <div class="title"><span>Chú ý</span><span class="close"><i class="fa fa-close"></i></span></div>
  <div class="menu_thongbao_content">
      <div>Tài khoản của bạn sẽ bị tạm khóa sau</div>
      <div class="box_countdown box_countdown_2"><span id="days">00</span> ngày <span id="hours">00</span> giờ <span id="minutes">00</span> phút <span id="seconds">00</span> giây.</div>
      <div>Nếu không có phát sinh đơn hàng hoặc số dư tối thiểu 500k...</div>
  </div>
</div>
<script type="text/javascript" charset="utf-8">
$(function() {
    var currentDate = new Date(),
        finished = false,
        thoigian_set = {
            set5ngay: 15 * 24 * 60 * 60 * 1000,
            set2gio: {time_conlai}* 1000,
            set5phut: 5 * 60 * 1000,
            set1phut: 1 * 10 * 1000
        };

    function callback_2(event) {
        $this = $(this);
        switch (event.type) {
            case "seconds":
            case "minutes":
            case "hours":
            case "days":
            case "weeks":
            case "daysLeft":
                $this.find('#' + event.type).html(event.value);
                if (finished) {
                    $this.fadeTo(0, 1);
                    finished = false;
                }
                break;
            case "finished":
                //$this.fadeTo('slow', .5);
                $('.box_countdown_2').html('<div style="color:red;font-size:20px;text-align:center">Tài khoản của bạn đã bị tạm khóa</div>');
                finished = true;
                break;
        }
    }

    $('.box_countdown').countdown(thoigian_set.set2gio + currentDate.valueOf(), callback_2);
});
</script>