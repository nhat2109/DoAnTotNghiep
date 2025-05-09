<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1>Link tuyển dụng thành viên nhóm</h1>
                <div class="line"></div>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <input type="text" class="form_control link_tuyendung" name="link" value="{link_tuyendung}" placeholder="Sử dụng link này để giới thiệu...">
                </div>
                <div class="form_group qr_container">
                    <div class="qr_code">
                        <img src="/hr-qr.php?link={link_tuyendung}" title="Mã QR tuyển dụng">
                    </div>
                    <div class="qr_description">
                        <p>Sử dụng link hoặc mã QR trên để giới thiệu tuyển dụng thành viên vào nhóm bán hàng của bạn.</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="">
                <h2>Tiền thưởng</h2>
                <p class="">200,000 VNĐ / 1 người</p>
            </div>
            <div style="clear: both;"></div>
            <span>Thời gian lưu cookie tới <b class="color_red">15 ngày</b></span>
            <span class="cookie_notice">"Trong 15 ngày chỉ cần người đăng ký theo Link hoặc QR thì sẽ là thành viên của bạn"</span>
            <div style="clear: both;"></div>
			<div class="total_money_box">
				<h2>Thu nhập từ tuyển dụng</h2>
				<p class="total_money">{tong_tien} VNĐ</p>
			</div>
			
        </div>
    </div>
</div>
<div class="box_right box_right_mobile" style="margin-top: 30px;">
	<div style="float: right" class="box_timkiem_thanhviennhom">
        <div>
            <div class="filter_section">
    
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
                
               text-align: center; 
            }
            .filter_section label {
                margin-right: 5px;
            }
            </style>
        </div>
		<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm" />
		<button name="timkiem_thanhviennhom" nhom="{id}" class="button_timkiem">
			Tìm kiếm
		</button>
        
	</div>
	<div class="box_right_content box_right_content_mobile">
		<div class="box_profile" style="width: 100%; padding: 10px">
			<div class="page_title">
				<h1 class="undefined">Danh sách thành viên nhóm</h1>
				<div class="line"></div>
				<hr />
                
			</div>
            
			<style type="text/css">
				.list_baiviet i {
					margin-right: 5px;
				}
			</style>
			<table class="list_baiviet">
				<tr>
					<th style="text-align: center; width: 50px" class="hide_mobile">
						ID
					</th>
					<th style="text-align: left">Họ và tên</th>
					<th style="text-align: left">Điện thoại</th>
					<th style="text-align: center">Vai trò</th>
					<th style="text-align: center">Tổng đơn hàng</th>
					<th style="text-align: center">Tổng doanh số</th>
					<th style="text-align: center; width: 150px">Hành động</th>
					<th style="text-align: center; width: 150px">Tình trạng</th>
				</tr>
				{list_thanhvien}
			</table>
			{phantrang}
			<p style="text-align: center; font-style: italic">
				Lưu ý: Số đơn hàng và doanh số không tính những <b>đơn hàng hủy</b> và
				<b>đơn hàng hoàn</b>
			</p>
		</div>
	</div>
   
</div>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');


.page_title h1 {
    text-align: center;
    font-size: 22px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.line {
    width: 50px;
    height: 3px;
    background: #007BFF;
    margin: 0 auto 10px;
    border-radius: 5px;
}

.form_group {
    margin-bottom: 15px;
}

.form_control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border 0.3s ease;
}

.form_control:focus {
    border-color: #007BFF;
    outline: none;
}

/* Chia đôi QR Code và nội dung */
.qr_container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.qr_code img {
    width: 200px;
    height: 200px;
    border-radius: 10px;
    border: 2px solid #007BFF;
    transition: transform 0.3s ease-in-out;
}

.qr_code img:hover {
    transform: scale(1.05);
}

.qr_description {
    flex: 1;
    font-size: 16px;
    color: #555;
    text-align: justify;
}

/* Thông báo cookie */
.color_red {
    color: red;
    font-weight: bold;
}

.cookie_notice {
    margin-left: 20px;
    font-size: 16px;
    color: #555;
}

/* Responsive */
@media (max-width: 480px) {
    .qr_container {
        flex-direction: column;
        text-align: center;
    }

    .qr_code img {
        margin-bottom: 10px;
    }
}


</style>
<style>
	/* Style cho container chứa các tab và box */
	.page_body .box_right {
		position: relative;
		width: calc(100% - 250px);
		min-height: calc(100vh - 50px);
		top: 150px;
		bottom: 0px;
		right: 0;
		left: 0;
		background: #fff;
		margin-left: 250px;
	}

	.container {
		width: 100%;
		margin: 0 auto;
	}

	.header {
		display: flex;
		justify-content: space-around;
		background: rgb(73, 110, 230);
		cursor: pointer;
		/* Bo góc nhẹ cho header */
	}

	.header div {
		color: white;
		font-weight: bold;
		padding: 10px 20px;
		transition: background 0.3s, border-radius 0.3s;
		border-radius: 6px;
		/* Bo tròn góc nhẹ */
	}

	.header div:hover,
	.header div.active {
		background: #0056b3;
		border-radius: 10px;
		/* Khi hover, bo tròn nhiều hơn */
	}

	.box_content {
		display: none;
		padding: 20px;
		border: 1px solid #ddd;
		margin-top: 10px;
		background: #f9f9f9;
		border-radius: 8px;
		/* Bo góc nhẹ cho box content */
	}

	.box_content.active {
		display: block;
	}

	/* Style cho container chứa ô tìm kiếm và nút */
	.box_timkiem_thanhviennhom {
		margin-top: 10px;
		display: flex;
		align-items: center;
		gap: 10px;
		/* Khoảng cách giữa input và button */
		float: right;
		/* Đảm bảo phần tử nằm bên phải */
	}

	/* Style cho ô input */
	.box_timkiem_thanhviennhom input[type="text"] {
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 8px;
		/* Bo tròn các góc */
		font-size: 14px;
		outline: none;
		/* Loại bỏ viền khi focus */
		transition: border-color 0.3s, box-shadow 0.3s;
	}

	.box_timkiem_thanhviennhom input[type="text"]:focus {
		border-color: #007bff;
		/* Đổi màu viền khi focus */
		box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
		/* Hiệu ứng shadow khi focus */
	}

	/* Style cho nút tìm kiếm */
	.button_timkiem {
		pointer-events: auto !important;
		position: relative;
		z-index: 20;
		padding: 10px 20px;
		background-color: #007bff;
		color: white;
		border: none;
		border-radius: 8px;
		/* Bo tròn các góc */
		cursor: pointer;
		font-size: 14px;
		transition: background-color 0.3s, transform 0.2s;
	}

	.button_timkiem:hover {
		background-color: #0056b3;
		/* Đổi màu nền khi hover */
		transform: scale(1.05);
		/* Hiệu ứng phóng to nhẹ khi hover */
	}

	.button_timkiem:active {
		transform: scale(0.95);
		/* Hiệu ứng nhỏ lại khi nhấn */
	}

	.filter_section,.box_timkiem_thanhviennhom {
		pointer-events: auto;
	}

	.box_timkiem_thanhviennhom input[name="key"] {
		position: relative;
		z-index: 10;
	}
    .filter_section{
        position: relative;
		z-index: 10;
    }
    .drop_status input[type="radio"] {
        pointer-events: none; /* Không cho click */
        opacity: 0.6; /* Làm mờ một chút để hiển thị chỉ xem */
    }
    
</style>
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
    
            $("tr[data-ncc][data-leader]").each(function () {
                var nccValue = parseInt($(this).attr("data-ncc"));
                var leaderValue = $(this).attr("data-leader");
    
                var showRow = false;
    
                if (selectedStatus === "active") {
                    if ([1, 2, 4].includes(nccValue)) {
                        showRow = true;
                    }
                } else if (selectedStatus === "inactive") {
                    if (nccValue === 0) {
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
    });
    
    

</script>

<style>
	.total_money_box {
		margin-top: 20px;
		text-align: center;
		background: linear-gradient(45deg, #FFD700, #FF6347);
		color: white;
		padding: 10px;
		border-radius: 10px;
		font-size: 16px;
		font-weight: bold;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
		animation: glow 1.5s infinite alternate;
	}
	
	.total_money_box h2 {
		font-size: 20px;
		margin-bottom: 10px;
	}
	
	.total_money {
		font-size: 18px;
		font-weight: bold;
		color: #fff;
		text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
	}
	
	@keyframes glow {
		0% {
			box-shadow: 0px 4px 15px rgba(255, 215, 0, 0.5);
		}
		100% {
			box-shadow: 0px 4px 20px rgba(255, 99, 71, 0.8);
		}
	}
	.filter_section select {
		padding: 8px 12px;
		font-size: 16px;
		border: 1px solid #ddd8d8;
		border-radius: 6px;
		background: #fff;
		cursor: pointer;
		transition: all 0.3s ease-in-out;
	}
	.line, .line1, .line2, .line3, .line4, .line5 {
		position: relative !important;
		background-color: #FFB370;
	}
	
	
	/* Mobile */
@media (max-width: 768px) {
    .box_right {
        width: 100%;
        margin-left: 0;
        padding: 10px;
    }

    .box_right_content {
        padding: 10px;
    }

    .qr_container {
        flex-direction: column;
        text-align: center;
    }

    .qr_code img {
        width: 150px;
        height: 150px;
    }

    .filter_section {
		
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .filter_section label {
        margin-bottom: 5px;
    }

    .box_timkiem_thanhviennhom {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .box_timkiem_thanhviennhom input {
        width: 100%;
    }

    .button_timkiem {
        width: 100%;
    }

    table.list_baiviet {
        width: 100%;
        font-size: 14px;
    }

    table.list_baiviet th,
    table.list_baiviet td {
        padding: 5px;
    }

    table.list_baiviet .hide_mobile {
        display: none;
    }
	.page_body .box_right
	{
		width: 100%;
		margin-left: 0;
	}
	.box_right_mobile{
		margin-top: 220px !important;
	}
	.page_body .box_right .box_right_content_mobile
	{
		top: 180px !important;
	}
}

/* Tablet */
@media (max-width: 1024px) {
    .box_right {
        width: 100%;
        margin-left: 0;
    }

    .qr_container {
        flex-direction: column;
        align-items: center;
    }

    .qr_code img {
        width: 180px;
        height: 180px;
    }

    .box_timkiem_thanhviennhom {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .box_timkiem_thanhviennhom input {
        flex: 1;
        min-width: 200px;
    }

    .button_timkiem {
        flex: none;
    }
}

</style>