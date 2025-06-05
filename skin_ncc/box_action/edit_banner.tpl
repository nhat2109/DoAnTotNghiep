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

    .form-group input[type="text"]:hover,
    .form-group input[type="number"]:hover,
    .form-group select:hover {
        border-color: #999;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="number"]:focus,
    .form-group select:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1);
    }

    .form-group .image-preview {
        margin: 15px 0;
        text-align: center;
    }

    .form-group .image-preview img {
        max-width: 200px;
        max-height: 150px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        object-fit: contain;
    }

    .form-group input[type="file"] {
        display: block;
        margin-top: 10px;
        padding: 8px;
        background: #f8f9fa;
        border: 1px dashed #ddd;
        border-radius: 4px;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s ease;
        height: 36px;
    }

    .form-group input[type="file"]:hover {
        border-color: #4a90e2;
        background: #f1f8ff;
    }

    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
    }

    .btn-primary {
        background: #1a1f46;;
        color: #fff;
    }

    .btn-primary:hover {
        background: #11142e;;;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        padding-right: 30px;
    }

    @media (max-width: 768px) {
        .box_profile {
            padding: 15px;
            margin: 10px;
        }

        .form-actions {
            flex-direction: column;
            gap: 8px;
        }

        .btn {
            width: 100%;
        }

        .form-group .image-preview img {
            max-width: 100%;
            max-height: 120px;
        }
    }
    .position-description{
        margin: 5px 0px;
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_banner">
                <input type="hidden" name="id" value="{id}">
                <input type="hidden" name="shop_id" value="{shop_id}">

                <div class="form-group">
                    <label for="tieu_de">Tiêu đề:</label>
                    <input type="text" id="tieu_de" name="tieu_de" value="{tieu_de}" required>
                </div>

                <div class="form-group">
                    <label for="link">Link:</label>
                    <input type="text" id="link" name="link" value="{link}" required>
                </div>

                <div class="form-group">
                    <label for="target">Target:</label>
                    <select id="target" name="target" required value={target}>
                        <option value="_blank">Mở trong tab mới</option>
                        <option value="_self">Mở trong tab hiện tại</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="vi_tri">Vị trị và loại banner:</label>
                    <select id="vi_tri" name="vi_tri" onchange="updateThuTuOptions(); updatePositionDescription();" required value={vi_tri}>
                        <option value="">Loại banner</option>
                        <option value="banner_doitac">Banner Bên Cạnh Slide </option>
                        <option value="banner_giua">Banner Giữa Màn Hình</option>
                    </select>
                    <div id="positionDescription" class="position-description"></div>
                </div>
                <div class="form-group">
                    <label for="thu_tu">Thứ tự:</label>
                    <select id="thu_tu" name="thu_tu" required value="{thu_tu}">
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
                <div class="form_group">
                    <label for="">Hình ảnh hiện tại:</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="100%" id="preview" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;"  onchange="previewImage(event)">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Hoàn thành</button>
                    <a href="/ncc/list-banner" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setSelectedValue(selectId, value) {
        const select = document.getElementById(selectId);
        if (select) {
            select.value = value;
        }
    }
    setSelectedValue("target", "{target}");
    setSelectedValue("vi_tri", "{vi_tri}");
    setSelectedValue("thu_tu", "{thu_tu}");
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
    $('#editBannerForm').on('submit', function (e) {
    e.preventDefault();

    // Thu thập giá trị từ form
    const tieu_de = $("#tieu_de").val().trim();
    const link = $("#link").val().trim();
    const vi_tri = $("#vi_tri").val();
    const thu_tu = $("#thu_tu").val();
    const minh_hoa = $("#minh_hoa").val();

    // Kiểm tra các trường bắt buộc
    if (!tieu_de || !link || !vi_tri || !thu_tu) {
        $('.load_note').html("Vui lòng điền đầy đủ thông tin!").css({"color": "red", "font-weight": "bold"}).fadeIn();
        return;
    }

    // Kiểm tra ảnh minh họa khi thêm mới
    if (!minh_hoa) {
        $('.load_note').html("Vui lòng chọn ảnh minh họa!").css({"color": "red", "font-weight": "bold"}).fadeIn();
        return;
    }

    // Hiển thị overlay tải lên
    $('.load_overlay').show();
    $('.load_process').fadeIn();

        const formData = new FormData(this);
        console.log([...formData]);

        $.ajax({
            url: '/ncc/process.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (kq) {
                        var info = JSON.parse(kq); // Đổi từ "kq" thành "response"
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
            },
            error: function() {
                    $('.load_note').html("Có lỗi xảy ra, vui lòng thử lại.");
            }
        });
    });
});
</script>