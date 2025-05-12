<style>
    .box_profile {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: #fff;
        height: 36px;
    }

    .image-preview-banner img {
        max-width: 100%;
        max-height: 200px;
        margin: 10px 0;
    }

    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .position-description {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <h2 class="title" style="text-align: center;">Thêm mới banner</h2>
            <form id="addBannerForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_banner">

                <div class="form-group">
                    <label for="tieu_de">Tiêu đề:</label>
                    <input type="text" id="tieu_de" name="tieu_de" placeholder="Nhập tiêu đề" required>
                </div>

                <div class="form-group">
                    <label for="link">Link:</label>
                    <input type="text" id="link" name="link" placeholder="Nhập link" required>
                </div>
                <div class="form-group">
                    <label for="target">Target:</label>
                    <select id="target" name="target" required>
                        <option value="_blank">Mở trong tab mới</option>
                        <option value="_self">Mở trong tab hiện tại</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vi_tri">Vị trị và loại banner:</label>
                    <select id="vi_tri" name="vi_tri" onchange="updateThuTuOptions(); updatePositionDescription();" required>
                        <option value="">Loại banner</option>
                        <option value="banner_doitac">Banner Bên Cạnh Slide </option>
                        <option value="banner_giua">Banner Giữa Màn Hình</option>
                    </select>
                    <div id="positionDescription" class="position-description"></div>
                </div>

                <div class="form-group">
                    <label for="thu_tu">Thứ tự:</label>
                    <select id="thu_tu" name="thu_tu" required>
                        <option value="">Thứ tự</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="image-preview-banner">
                        <img id="preview" src="" alt="Preview">
                    </div>
                    <label for="minh_hoa">Hình ảnh:</label>
                    <input type="file" id="minh_hoa" name="minh_hoa" accept="image/*" onchange="previewImage(event)" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="add_banner">Thêm mới</button>
                    <a href="/ncc/list-banner" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function updateThuTuOptions() {
        const viTri = document.getElementById("vi_tri").value;
        const thuTu = document.getElementById("thu_tu").options;
        for (let i = 0; i < thuTu.length; i++) {
            thuTu[i].disabled = false;
            if ((viTri === "banner_doitac" && i < 5) || (viTri === "banner_giua" && i >= 5)) {
                thuTu[i].disabled = true;
            }
        }
        const preview = document.getElementById("preview");
        const minhHoa = document.getElementById("minh_hoa");
        preview.src = "";
        minhHoa.value = "";
    }

    function updatePositionDescription() {
        const viTri = document.getElementById("vi_tri").value;
        const description = document.getElementById("positionDescription");
        if (viTri === "banner_doitac") {
            description.textContent = "Hiển thị banner bên cạnh slide ảnh (Banner đối tác: 300x150)";
        } else if (viTri === "banner_giua") {
            description.textContent = "Hiển thị banner ở trang chính màn gồm 2 banner cùng một hàng (\nBanner giữa: 950x200)";
        }
    }

    function previewImage(event) {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        const output = document.getElementById("preview");
        const file = event.target.files[0];
        if (file) {
            const viTri = document.getElementById("vi_tri").value;
            const img = new Image();
            img.onload = function () {
                 if (viTri === "banner_doitac") {
                    if (img.width !== 300 || img.height !== 150) {
                     setTimeout(function () {
                        $('.load_note').html('Kích thước ảnh không phù hợp.\nBanner đối tác: 300x150.');
                    }, 500);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 2000);
                        event.target.value = "";
                        output.src = "";
                        return;
                    }
                }
                if (viTri === "banner_giua") {
                    if (img.width !== 950 || img.height !== 200) {
                    setTimeout(function () {
                        $('.load_note').html('Kích thước ảnh không phù hợp.\nBanner giữa: 950x200.');
                    }, 500);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 2000);
                        event.target.value = "";
                        output.src = "";
                        return;
                    }
                }
                setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                }, 500);
                output.src = URL.createObjectURL(file);
            };
            img.src = URL.createObjectURL(file);
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            }
        }
    }

    $(document).ready(function() {
        $("#addBannerForm").submit(function(e) {
            e.preventDefault();

            // Lấy giá trị từ form
            const tieu_de = $("#tieu_de").val().trim();
            const link = $("#link").val().trim();
            const vi_tri = $("#vi_tri").val();
            const thu_tu = $("#thu_tu").val();
            const minh_hoa = $("#minh_hoa").val();

            // Kiểm tra các trường không được để trống
            if (tieu_de === "" || link === "" || vi_tri === "" || thu_tu === "") {
                $('.load_note').html("Vui lòng điền đầy đủ thông tin!");
                $('.load_note').css("color", "red");
                return;
            }

            // Kiểm tra xem đã chọn ảnh minh họa chưa
            if (minh_hoa === "") {
                $('.load_note').html("Vui lòng chọn ảnh minh họa!");
                $('.load_note').css("color", "red");
                return;
            }

            // Hiển thị overlay tải lên
            $('.load_overlay').show();
            $('.load_process').fadeIn();

            // Gửi dữ liệu qua AJAX
            const formData = new FormData(this);
            $.ajax({
                url: "/ncc/process.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var info = JSON.parse(response); // Đổi từ "kq" thành "response"
                        console.log(info);

                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);

                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.href = '/ncc/list-banner';
                            }
                        }, 3000);
                    } catch (err) {
                        $('.load_note').html("Lỗi xử lý kết quả từ máy chủ.");
                    }
                },
                error: function() {
                    $('.load_note').html("Có lỗi xảy ra, vui lòng thử lại.");
                }
            });
        });
    });

</script>
