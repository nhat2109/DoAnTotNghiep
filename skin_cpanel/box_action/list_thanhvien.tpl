<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="box_timkiem">
                <input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
                <button name="timkiem_thanhvien" class="button_timkiem">Tìm kiếm</button>
            </div>
            <div class="page_title">
                <h1 class="undefined">Danh sách thành viên</h1>
                <div style="clear: both;"></div>
                <div class="line"></div>
                <hr>
            </div>
            <div class="filter_section">
                
                <label for="start_date">Từ ngày:</label>
                <input type="date" id="start_date" name="start_date">
                
                <label for="end_date">Đến ngày:</label>
                <input type="date" id="end_date" name="end_date">
                
                
                
                <button id="filter_button" class="button_filter">Lọc</button>

                <label for="status" style="margin-left: 100px;">Tình trạng:</label>
                <select id="status" name="status">
                    <option value="">Tất cả</option>
                    <option value="active">Nhà bán</option>
                    <option value="inactive">Mua hàng</option>
                    <option value="leader">Chuyên nghiệp</option>            
                </select>
            </div>
            <style type="text/css">
            .list_baiviet i {
                font-size: 35px;
            }
            .filter_section {
                margin: 15px 0;
               text-align: center; 
            }
            .filter_section label {
                margin-right: 5px;
            }
            </style>
            
            <table class="list_baiviet">
                <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
<!--                     <th style="text-align: left;">ID</th> -->
                    <th style="text-align: left;">Họ tên</th>
                    <th style="text-align: left;" class="hide_mobile">Tài khoản</th>
				    <th style="text-align: left;" class="hide_mobile">Chuyên nghiệp</th>
                    <th style="text-align: left;" class="hide_mobile">Người quản lý</th>
                    <th style="text-align: center;" class="hide_mobile">THÊM HOT</th>
                    <th style="text-align: center;" class="hide_mobile">Ngày đăng ký</th>
                    <th style="text-align: center;" class="hide_mobile">Điện thoại</th>
                    <th style="text-align: center;" class="hide_mobile">Email</th>
                    <th style="text-align: center;" class="hide_mobile">TK chính</th>
				    <th style="text-align: center;" class="hide_mobile">TK Khuyến mại</th>
                    <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                    <!-- <th style="text-align: center;" class="hide_mobile">Đăng ký</th> -->
                    <!-- <th style="text-align: center;width: 140px;">Hành động</th> -->
                </tr>
                {list_thanhvien}
            </table>
            {phantrang}
            
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_thanhvien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
        
    });

    $(document).ready(function () {
        $("#status").change(function () {
            var selectedStatus = $(this).val();
    
            $("tr[data-dropship][data-leader]").each(function () {
                var dropshipValue = parseInt($(this).attr("data-dropship"));
                var leaderValue = $(this).attr("data-leader");
    
                var showRow = false;
    
                if (selectedStatus === "active") {
                    if ([1, 2, 4].includes(dropshipValue)) {
                        showRow = true;
                    }
                } else if (selectedStatus === "inactive") {
                    if (dropshipValue === 0) {
                        showRow = true;
                    }
                } else if (selectedStatus === "leader") {
                    if (leaderValue === "Có") {
                        showRow = true;
                    }
                } else {
                    showRow = true;
                }
    
                if (showRow) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $('body').on('click','.button_timkiem', function () {
            key = $('input[name=key]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            }else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            }else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_thanhvien_nhom]').length > 0) {
                id=$('button[name=timkiem_thanhvien_nhom]').attr('nhom');
                action = 'timkiem_thanhvien_nhom';
            } else if ($('button[name=timkiem_thanhvien_drop]').length > 0) {
                action = 'timkiem_thanhvien_drop';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_donhang]').length > 0) {
                action = 'timkiem_donhang';
            }else if ($('button[name=timkiem_donhang_ctv]').length > 0) {
                var action = 'timkiem_donhang_ctv';
            }
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                if(action=='timkiem_thanhvien_nhom'){
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/admincp/process.php',
                        type: 'post',
                        data: {
                            action: action,
                            key: key,
                            id:id
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function() {
                                $('.load_note').html(info.thongbao);
                            }, 500);
                            setTimeout(function() {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if (info.ok == 1) {
                                    $('.list_baiviet').html(info.list);
                                    $('.pagination').hide();
                                } else {
 
                                }
                            }, 1000);
                        }
                    });
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/admincp/process.php',
                        type: 'post',
                        data: {
                            action: action,
                            key: key
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function() {
                                $('.load_note').html(info.thongbao);
                            }, 500);
                            setTimeout(function() {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if (info.ok == 1) {
                                    $('.list_baiviet').html(info.list);
                                    $('.pagination').hide();
                                if(action=='timkiem_sanpham_tuan'){
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
                                }
                                } else {
 
                                }
                            }, 1000);
                        }
                    });
                }
            }
        
    });
    });
    
    

</script>


<style>

    .add_hot {
        background-color: #ff6325; /* Màu xanh */
        color: white;
    }
    
    .da_themhot {
        background-color: #5a5a5a; /* Màu đỏ */
        color: white;
    }
    
    
  /* Giới hạn độ dài email */
.list_baiviet td:nth-child(9) { /* Cột Email */
  max-width: 175px; /* Giới hạn chiều rộng */
  white-space: nowrap; /* Không xuống dòng */
  overflow: hidden;
  text-overflow: ellipsis; /* Hiển thị "..." khi quá dài */
}

/* Giảm độ rộng cột tài khoản */
.list_baiviet td:nth-child(3) /* Cột Tài khoản */
{
  max-width: 120px; /* Giới hạn chiều rộng */
  white-space: nowrap; /* Không xuống dòng */
  overflow: hidden;
  text-overflow: ellipsis; /* Hiển thị "..." khi quá dài */
}
/* Giới hạn chiều rộng cột Tài khoản và hiển thị "..." khi quá dài */
.list_baiviet td:nth-child(2) {
  max-width: 120px; /* Điều chỉnh nếu cần */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  position: relative; /* Giữ nguyên vị trí */
}

/* Khi hover, hiển thị toàn bộ nội dung */
.list_baiviet td:nth-child(2):hover::after {
  content: attr(data-fulltext); /* Lấy nội dung từ attribute */
  position: absolute;
  background: rgba(0, 0, 0, 0.8); /* Nền đen */
  color: #fff; /* Chữ trắng */
  padding: 5px 10px;
  border-radius: 5px;
  white-space: nowrap;
  z-index: 1000;
  left: 0;
  top: 100%;
}

/* Giảm độ rộng cột tài khoản */
.list_baiviet td:nth-child(6) /* Cột Tài khoản */
{
  max-width: 200px !important; /* Giới hạn chiều rộng */
  white-space: nowrap; /* Không xuống dòng */
  overflow: hidden;
  text-overflow: ellipsis; /* Hiển thị "..." khi quá dài */
}
.list_baiviet td:nth-child(5) /* Cột Tài khoản */
{
  max-width: 200px; /* Giới hạn chiều rộng */
  white-space: nowrap; /* Không xuống dòng */
  overflow: hidden;
  text-overflow: ellipsis; /* Hiển thị "..." khi quá dài */
}

  /* Tổng thể */
.box_right {
  width: 100%;
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.box_right_content {
  background: #fff;
  padding: 15px;
  border-radius: 8px;
}

.page_title h1 {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

.line {
  height: 2px;
  background: #007bff;
  width: 100%;
  margin: 10px 0;
}

/* Thanh tìm kiếm */
.box_timkiem {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
}

.box_timkiem input {
  flex: 1;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.button_timkiem {
  padding: 8px 15px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button_timkiem:hover {
  background: #0056b3;
}

/* Bộ lọc */
.filter_section {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 15px;
}

.filter_section label {
  font-weight: bold;
}

.filter_section input,
.filter_section select {
  padding: 6px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.button_filter {
  padding: 8px 15px;
  background:   #e1ce00;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button_filter:hover {
  background: #ffea00;
}

/* Bảng dữ liệu */
table.list_baiviet {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
  background: white;
}

table.list_baiviet th {
  background: #007bff;
  color: white;
  padding: 10px;
  text-align: center;
  font-size: 14px;
  border: 1px solid #ccc;
}

table.list_baiviet td {
  padding: 10px;
  text-align: center;
  font-size: 14px;
  border: 1px solid #ddd;
}

/* Chỉnh căn lề */
table.list_baiviet td:first-child {
  font-weight: bold;
}

table.list_baiviet td a {
  color: #007bff;
  text-decoration: none;
}

table.list_baiviet td a:hover {
  text-decoration: underline;
}

/* Làm nổi bật các dòng chẵn */
table.list_baiviet tr:nth-child(even) {
  background: #f8f9fa;
}

/* Trạng thái */
.drop_status {
  font-weight: bold;
  color: #d9534f;
}


</style>
