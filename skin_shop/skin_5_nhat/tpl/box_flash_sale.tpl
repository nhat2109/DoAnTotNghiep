<div class="box_flashsale">
    <div class="flashsale_header">
        <div class="flashsale_title">
            <h5>GIÁ SỐC HÔM NAY</h5>
            <span class="ega-dot"><span class="ega-ping"></span></span>
        </div>
        <div class="flashsale_countdown-wrapper">
            <span class="text_day">Ngày</span><span class="text_count"></span><span class="text_day">Giờ</span><span class="text_count"></span><span class="text_day">Phút</span><span class="text_count"></span><span class="text_day">Giây</span>
        </div>        
        <div class="flashsale_countdown-wrapper" id="flashsale_countdown-wrapper">
            <span class="time_countdown" id="days">00</span><span class="text_count">:</span><span class="time_countdown" id="hours">00</span><span class="text_count">:</span><span class="time_countdown" id="minutes">00</span><span class="text_count">:</span><span class="time_countdown" id="seconds">00</span>
        </div>
    </div>
    <div class="flashsale__product ">
        <div class="flashsale__item" data-pd-id="1030691245" data-inventory-quantity="300" data-sold-quantity="8" data-available="true">
            <div class="flashsale__bottom" style="">
                {text_flash_sale}
                <div class="flashsale__progressbar">
                    <div class="flashsale___percent" style="width: {phantram}%;">
                    </div>
                </div>
                <input type="hidden" name="flash_sale" value="1">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(function() {
      var currentDate = new Date(),
          finished = false,
          availiableExamples = {
            set5ngay: 15 * 24 * 60 * 60 * 1000,
            set2gio: {time_conlai}*1000,
            set5phut  : 5 * 60 * 1000,
            set1phut  : 1 * 10 * 1000
          };
      
      function callback(event) {
          $this = $(this);
            switch(event.type) {
                case "seconds":
                case "minutes":
                case "hours":
                case "days":
                case "weeks":
                case "daysLeft":
                  $this.find('#'+event.type).html(event.value);
                  if(finished) {
                    $this.fadeTo(0, 1);
                    finished = false;
                  }
                    break;
                case "finished":
            $this.fadeTo('slow', .5);
            sp_id=$('.add_to_cart').attr('sp_id');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'load_price',
                    sp_id:sp_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('input[name=flash_sale]').val(0);
                    $('.product_info .product-price').html(info.gia);
                }
            });
            finished = true;
                    break;
            }
      }
      
        $('div#flashsale_countdown-wrapper').countdown(availiableExamples.set2gio + currentDate.valueOf(), callback);
    });
  </script>