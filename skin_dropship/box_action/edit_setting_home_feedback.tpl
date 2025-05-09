<style>
.box_right {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 !important;
}

.box_right_content {
    padding: 20px;
}

.box_profile {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
}

#feedbackContainer {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.feedback-item {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 5px 20px;
    margin-bottom: 0px;
    position: relative;
}

.feedback-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    gap: 20px;
    padding-right: 30px;
}

.avatar-preview {
    width: 60px;
    height: 60px;
    border: 1px solid #e9ecef;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}

.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-preview:hover .upload-overlay {
    opacity: 1;
}

.upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
    cursor: pointer;
}

.avatar-preview .upload-btn {
    position: relative;
    background: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    padding: 0;
    transition: all 0.2s ease;
}

.avatar-preview .upload-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.user-info {
    flex-grow: 1;
}

.user-info .form-group {
    margin-bottom: 10px;
}

.user-info .form-group:last-child {
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
    font-weight: 500;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

textarea.form-control {
    min-height: 60px;
    height: 60px;
    resize: none;
    font-size: 14px;
    line-height: 1.4;
    padding: 8px 12px;
}

.btn {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-success {
    background: #28a745;
    color: #fff;
}

.btn-success:hover {
    background: #218838;
}

#addFeedback {
    margin-right: 10px;
}

/* Remove number input spinners */
input[type="number"] {
    -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .box_right_content {
        padding: 15px;
    }
    
    #feedbackContainer {
        grid-template-columns: 1fr;
    }
    
    .feedback-item {
        padding: 15px;
    }
    
    .feedback-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .avatar-preview {
        margin: 0 auto;
    }
    
    .user-info {
        width: 100%;
    }
}

.delete-feedback {
    position: absolute;
    right: 10px;
    top: 10px;
    background: transparent;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 0;
    font-size: 24px;
    line-height: 1;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
    transition: opacity 0.2s;
    z-index: 1;
}

.delete-feedback:hover {
    opacity: 1;
}

.delete-feedback.hidden {
    display: block;
}
</style>

<!-- Add Font Awesome for the camera icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="box_right">
    <div class="box_right_content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chỉnh sửa đánh giá khách hàng</h3>
            </div>
            <div class="card-body">
                <form id="feedbackForm" method="post" action="" enctype="multipart/form-data">
                    <div id="feedbackContainer">
                        <!-- Template for feedback items -->
                    </div>
                    <input type="hidden" name="id" value="{id}">
                    <input type="hidden" name="shop" value="{shop}">
                    <input type="hidden" name="tieu_de" value="{tieu_de}">
                    <input type="hidden" name="name" value="{name}">
                    <input type="hidden" name="loai" value="{loai}">
                    <input type="hidden" name="giao_dien" value="{giao_dien}">
                    <input type="hidden" name="description" value="{description}">

                    <button type="button" class="btn btn-success" id="addFeedback">Thêm đánh giá</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function updateDeleteButtons() {
        const items = $('.feedback-item').length;
        $('.delete-feedback').toggleClass('hidden', items <= 3);
    }
    updateDeleteButtons();
    $('#addFeedback').click(function() {
        if ($('.feedback-item').length >= 10) {
            alert('Tối đa chỉ được 10 đánh giá!');
            return;
        }
        const template = $('.feedback-item').first().clone();
        template.find('input, textarea').val('');
        template.find('.avatar-preview img').attr('src', '');
        $('#feedbackContainer').append(template);
        updateDeleteButtons();
    });
    $(document).on('click', '.delete-feedback', function() {
        const items = $('.feedback-item').length;
        if (items <= 3) {
            alert('Phải có ít nhất 3 đánh giá!');
            return;
        }
        $(this).closest('.feedback-item').remove();
        updateDeleteButtons();
    });
    $(document).on('change', '.avatar-upload', function() {
        const file = this.files[0];
        const preview = $(this).closest('.feedback-item').find('.avatar-preview img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    $(document).on('click', '.upload-overlay, .upload-btn', function(e) {
        e.preventDefault();
        $(this).closest('.avatar-preview').find('.avatar-upload').click();
    });

    const feedbackData = {feedback_data};

    $.each(feedbackData, function (index, item) {
        const feedbackHtml = `
            <div class="feedback-item">
                <button type="button" class="delete-feedback" title="Xóa đánh giá">×</button>
                <div class="feedback-header">
                    <div class="avatar-preview">
                        <img src="${item.avatar}" alt="Avatar ${index + 1}">
                        <div class="upload-overlay">
                            <button type="button" class="upload-btn" title="Thay đổi ảnh">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <input type="file" class="avatar-upload" accept="image/*" style="display: none;" name="avatar[]" value="${item.avatar}">
                    </div>
                    <div class="user-info">
                        <div class="form-group">
                            <label>Tên người dùng</label>
                            <input type="text" class="form-control" name="user_name[]" value="${item.user_name}" required>
                        </div>
                        <div class="form-group">
                            <label>Đánh giá (1-5 sao)</label>
                            <input type="number" class="form-control" name="danh_gia[]" min="1" max="5" value="${item.danh_gia}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nội dung đánh giá</label>
                    <textarea class="form-control" name="noidung[]" required>${item.noidung}</textarea>
                </div>
            </div>
        `;
        $('#feedbackContainer').append(feedbackHtml);
    });
});
</script>