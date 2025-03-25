<div class="li_ma_giam">
    <div class="code-label">
        <div class="code" style="color:rgb(247, 52, 52); display: flex;">{ma}
            <p class="discount">GIẢM {giam}đ</p>
        </div> 
        
        
    </div>
    <form id="form_discount_add" accept-charset="UTF-8" method="post" class="coupon-form">
        <input name="utf8" type="hidden" value="✓">
        <div class="fieldset">
            <div class="field">
                <div class="field-input-btn-wrapper">
                    <div class="field-input-wrapper">
                        <input type="hidden" name="coupon_mobile" value="{ma}">
                        <button type="button" class="btn-apply-code" onclick="applyCoupon('{ma}')">
                            <span class="btn-content">Áp dụng</span>
                            <i class="btn-spinner icon icon-button-spinner"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function applyCoupon(coupon) {
    if (!coupon) {
        return;
    }

    $('.load_overlay').show();
    $('.load_process').fadeIn();

    $.ajax({
        url: '/process.php',
        type: 'POST',
        data: {
            action: 'apply_coupon',
            coupon: coupon
        },
        success: function(response) {
            try {
                const info = JSON.parse(response);

                setTimeout(() => {
                    $('.load_note').html(info.thongbao);
                }, 500);

                if (info.ok === 1) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 700);
                } else {
                    setTimeout(() => {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 700);
                }
            } catch (error) {
                console.error('Lỗi xử lý dữ liệu:', error);
            }
        },
        error: function() {
            console.error('Lỗi kết nối đến máy chủ.');
        }
    });
}
</script>

<style>
.li_ma_giam {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    border: 1px dashed #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
    background: #fff;
}

.code-label {
    display: flex;
    flex-direction: column;
}

.code {
    font-weight: bold;
    color: #338dbc;
    font-size: 16px;
}

.discount {
    color: #95a200;
    font-size: 14px;
    margin-top: 4px;
    margin-left: 4px;
}

.btn-apply-code {
    background: #338dbc;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-apply-code:hover {
    background: #286f94;
}

.btn-spinner {
    display: none;
}

.btn-apply-code.loading .btn-spinner {
    display: inline-block;
}

.btn-apply-code.loading .btn-content {
    display: none;
}
</style>