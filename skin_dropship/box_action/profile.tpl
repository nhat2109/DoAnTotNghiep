<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thông tin cá nhân</h1>
                <div class="text_muted">Đổi thông tin cá nhân và liên hệ</div>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Username</label>
                    <input type="text" class="form_control" name="username" disabled value="{username}">
                </div>
                <div class="form_group">
                    <label for="">Số dư hiện tại</label>
                    <input type="text" class="form_control" name="username" disabled value="{user_money}">
                </div>
                <div class="form_group">
                    <label for="">Họ và tên</label>
                    <input type="text" class="form_control" name="name" value="{name}" placeholder="Nhập tên đầy đủ của bạn...">
                </div>
                <div class="form_group">
                    <label for="">Điện thoại</label>
                    <input type="text" class="form_control" name="mobile" value="{mobile}" placeholder="Nhập số điện thoại...">
                </div>
                <div class="form_group">
                    <label for="">Email</label>
                    <input type="text" class="form_control" name="email" value="{email}" placeholder="Nhập địa chỉ email...">
                </div>
                <div class="list_group group_3">
                    <div class="form_group">
                        <label for="">Mã số thuế/CCCD</label>
                        <input type="text" class="form_control" name="maso_thue" value="{maso_thue}" placeholder="Nhập mã số thuế/CCCD...">
                    </div>
                    <div class="form_group">
                        <label for="">Ngày cấp</label>
                        <input type="text" class="form_control datepicker" name="maso_thue_cap" value="{maso_thue_cap}" placeholder="Nhập ngày cấp...">
                    </div>
                    <div class="form_group">
                        <label for="">Nơi cấp</label>
                        <input type="text" class="form_control" name="maso_thue_noicap" value="{maso_thue_noicap}" placeholder="Nhập nơi cấp...">
                    </div>
                </div>
                <div class="list_group group_3">
                    <div class="form_group">
                        <label for="">Tỉnh/TP</label>
                        <select name="tinh" id="load_huyen" class="form_control">
                            <option value="">Chọn tỉnh/TP</option>
                            {option_tinh}
                        </select>
                    </div>
                    <div class="form_group">
                        <label for="">Quận/Huyện</label>
                        <select name="huyen" id="load_xa" class="form_control">
                            <option value="">Chọn quận/huyện</option>
                            {option_huyen}
                        </select>
                    </div>
                    <div class="form_group">
                        <label for="">Xã/Phường</label>
                        <select name="xa" class="form_control">
                            <option value="">Chọn xã/phường</option>
                            {option_xa}
                        </select>
                    </div>
                </div>
                <div class="form_group">
                    <label for="">Địa chỉ</label>
                    <input type="text" class="form_control" name="dia_chi" value="{dia_chi}" placeholder="Nhập địa chỉ chi tiết...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="button_profile"> Lưu thay đổi <i class="fa fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</div>