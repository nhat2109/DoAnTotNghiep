<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{title}</title>
    <link rel="stylesheet" href="/skin_admin/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="load_overlay" style="display:none;"></div>
    <div class="load_process" style="display:none;">
        <div class="load_content">
            <div class="load_icon"><i class="fa fa-spinner fa-spin"></i></div>
            <div class="load_note">Đang xử lý...</div>
        </div>
    </div>

    <div class="page_body">
        <div class="content_login">
            <div class="logox">
                <img src="/skin_admin/css/images/logo.png" alt="Logo">
            </div>
            <form id="login-form" method="POST">
                <div class="form_group">
                    <input type="text" class="form_control" name="username" placeholder="Nhập tài khoản..." required>
                </div>
                <div class="form_group">
                    <input type="password" class="form_control" name="password" placeholder="Mật khẩu..." required>
                </div>
                <div class="form_group">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="on" checked style="display:none;">
                        <i class="fa fa-check-circle-o"></i> Ghi nhớ đăng nhập
                    </label>
                    <button class="button_login" type="submit">
                        <i class="fa fa-unlock"></i> Đăng nhập
                    </button>
                </div>
            </form>
            <div id="message" class="message_box" style="display:none;"></div>
        </div>
    </div>
    {box_script_footer}
</body>
</html>