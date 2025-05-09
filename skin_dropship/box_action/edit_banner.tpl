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
        background: #f00;
        color: #fff;
    }

    .btn-primary:hover {
        background: green;
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
                    <label for="minh_hoa">Hình ảnh hiện tại:</label>
                    <div class="image-preview">
                        <img src="{minh_hoa}" alt="{tieu_de}">
                    </div>
                    <input type="hidden" name="minh_hoa_cu" value="{minh_hoa}">
                    <input type="file" id="minh_hoa" name="minh_hoa" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="bg_banner">Màu nền:</label>
                    <input type="color" id="bg_banner" name="bg_banner" value="{bg_banner}" required>
                </div>

                <div class="form-group">
                    <label for="target">Target:</label>
                    <select id="target" name="target" required>
                        <option value="_blank" {if target=='_blank'}selected{/if}>Mở trong tab mới</option>
                        <option value="_self" {if target=='_self'}selected{/if}>Mở trong tab hiện tại</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vi_tri">Vị trí:</label>
                    <input type="text" id="vi_tri" name="vi_tri" value="{vi_tri}" required>
                </div>

                <div class="form-group">
                    <label for="thu_tu">Thứ tự:</label>
                    <input type="number" id="thu_tu" name="thu_tu" value="{thu_tu}" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Hoàn thành</button>
                    <a href="/dropship/list-banner" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
