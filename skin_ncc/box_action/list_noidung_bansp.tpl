<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%">
            <div class="box_timkiem">
                <a href="/ncc/add-share-sanpham?id={id}"><button class="bg_green" style="border-radius: 5px;"><i class="fa fa-plus"></i> Thêm nội dung</button></a>
            </div>
          <div class="page_title">
              <h1 class="undefined">Nội dung bán "{tieu_de}"</h1>
              <div class="line"></div>
              <hr>
          </div>
          <table class="list_baiviet">
              <tr>
                  <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                  <th style="text-align: left;width: 200px;" class="hide_mobile">Minh họa</th>
                  <th style="text-align: left;">Nội dung</th>
                  <th style="text-align: center;width: 160px;">Hành động</th>
              </tr>
              {list_noidung}
          </table>
          {phantrang}
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
  <script type="text/javascript" src="/js/jquery.countdown.js"></script>
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
              status=$this.attr('status');
              if(status==0){
                $this.find('.text_time').html('Kết thúc sau:');
                con=$this.attr('thoigian')*1000;
                $this.countdown(con + currentDate.valueOf(), call_flash);
                $this.attr('status',1);
              }else{
                $this.fadeTo('slow', .5);
                $this.html('Đã kết thúc');
                finished = true;              
              }
              break;
              }
          }
          $('.count_down').each(function(){
              con=$(this).attr('time')*1000;
              $(this).countdown(con + currentDate.valueOf(), call_flash);
          });
      });
    </script>