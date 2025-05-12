<style>
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
        height: 30px;
    }
    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa slide</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tiêu đề slide...">
                </div>
                <div class="form_group">
                    <label for="">Hình ảnh ( 800 x 300px đến 1900 x 580px)</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Liên kết</label>
                    <input type="text" class="form_control" name="link" value="{link}" placeholder="Nhập liên kết slide...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mới liên kết</label>
                    <select class="form_control" name="target">
                        <option value="">Cửa sổ hiện tại</option>
                        <option value="_blank">Cửa số mới</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_slide" class="button_all"> Lưu thay đổi </button>
                <a href="/ncc/list-slide" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var target = '{target}';
    $('select[name=target]').val(target);
</script>