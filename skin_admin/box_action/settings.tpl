<h2>Cài đặt chung</h2>
<form id="settings-form" method="POST" action="process.php?action=update_settings">
    <div class="form-group">
        <label>Tiêu đề website:</label>
        <input type="text" name="title" value="{title}" required>
    </div>
    <div class="form-group">
        <label>Mô tả website:</label>
        <textarea name="description">{description}</textarea>
    </div>
    <div class="form-group">
        <label>Logo:</label>
        <input type="text" name="logo" value="{logo}">
    </div>
    <div class="form-group">
        <label>Hotline:</label>
        <input type="text" name="hotline" value="{hotline}">
    </div>
    <button type="submit">Lưu cài đặt</button>
</form>
<div id="message"></div>