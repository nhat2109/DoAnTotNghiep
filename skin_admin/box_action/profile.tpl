<h2>Hồ sơ cá nhân</h2>
<form id="profile-form" method="POST" action="process.php?action=change_profile">
    <div class="form-group">
        <label>Họ và tên:</label>
        <input type="text" name="ho_ten" value="{name}" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="{email}" required>
    </div>
    <div class="form-group">
        <label>Số điện thoại:</label>
        <input type="text" name="dien_thoai" value="{mobile}" required>
    </div>
    <button type="submit">Cập nhật</button>
</form>
<h3>Đổi mật khẩu</h3>
<form id="password-form" method="POST" action="process.php?action=change_password">
    <div class="form-group">
        <label>Mật khẩu cũ:</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Mật khẩu mới:</label>
        <input type="password" name="new_password" required>
    </div>
    <div class="form-group">
        <label>Nhập lại mật khẩu mới:</label>
        <input type="password" name="confirm_password" required>
    </div>
    <button type="submit">Đổi mật khẩu</button>
</form>
<div id="message"></div>