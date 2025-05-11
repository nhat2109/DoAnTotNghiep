<div class="li_ma_giam">
    <div class="coupon_info">
        <span class="coupon_code">{ma}</span> 
        <span style="text-transform: lowercase !important;" class="coupon_value">- {giam}đ</span>
    </div>
    <div class="coupon_actions">
        <button type="button" class="field-input-btn btn btn-default" data-coupon="{ma}">
            <span class="btn-content" style="background: #338dbc">Áp dụng</span>
            <i class="btn-spinner icon icon-button-spinner" style="display:none;"></i>
        </button>
    </div>
</div>


<style>
    .li_ma_giam {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        background-color: #ffffff;

    }

    .coupon_code {
        background-color: #eb4545 !important;
    }

    .coupon_value {
        background-color: #b9b4b4 !important;
    }

    .coupon_info {
        display: flex;
        align-items: center;
        font-size: 12px;
        color: #333;
    }

    .coupon_code {
        font-weight: bold;
        margin-right: 5px;
    }

    .coupon_value { 
        font-weight: normal;

    }

    .box_ma_giam .li_ma_giam {
        height: 29px;
        line-height: 21px;
        padding: 5px 15px;
    }

    .coupon_actions button {
        padding: 6px 10px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 5px;
        transition: background-color 0.3s;
    }

  
</style>