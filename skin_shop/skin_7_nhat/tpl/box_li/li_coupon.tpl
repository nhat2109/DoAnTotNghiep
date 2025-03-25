

<div class="coupon-item-wrap py-2 col-lg-3 col-md-5 col-lg col-10">
    <div class="coupon_item coupon--new-style">
        <div class="coupon_icon pos-relative embed-responsive embed-responsive-1by1">
            <a href="/flash-sale.html" title="/flash-sale.html">
                <img class="img-fluid"
                    src="/uploads/minh-hoa/coupon_1_img.png"
                    alt="coupon_1_img.png" loading="lazy" width="79" height="70" />
            </a>
        </div>
        <div class="coupon_body">
            <div class="coupon_head coupon--has-info">
                <h3 class="coupon_title">Mã giảm</h3>
                <!-- <div class="coupon_desc">Mã giảm cho đơn hàng từ 500k</div> -->
                <div class="coupon-icon-info text-center" data-coupon="{ma}">
                    <i class="fa fa-info"></i>
                    <div class="coupon-desc-info">
                        <div class="coupon-desc--head">DISCOUNT CODE</div>
                        <div class="coupon-desc--body">
                            <div class="coupon-desc--row">
                                <span>Mã:</span>
                                <div>
                                    <span> {ma}</span>
                                    <div class="coupon-copy-code coupon_copy copied type--icon"
                                        data-ega-coupon="{ma}">
                                        <i class="far fa-copy"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="coupon-desc--row">
                                <span>HSD:</span>
                                <div> {expired}</div>
                            </div>
                            <div class="coupon-desc--row coupon-about">
                                - Mã giảm {giam} cho đơn hàng có giá trị tối thiểu 2
                                triệu <br />
                                
                            </div>
                        </div>
                    </div>
                    <div class="coupon_info">
                        - Mã giảm {giam} cho đơn hàng có giá trị tối thiểu 2 triệu
                        <br />
                        
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap justify-content-between">
                <div class="coupon-code-body">
                    <div class="coupon-code-row code">
                        <span>Mã:</span>  {ma}
                    </div>

                    <div class="coupon-code-row">
                        <span>HSD:  {expired}</span>
                    </div>
                </div>

                <button id="copyButton" type="button" class="btn btn-main btn-sm coupon_copy mb-0"
                    data-ega-coupon="{ma}">
                    <span>Sao chép</span>
                </button>
                
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('copyButton').addEventListener('click', function () {
        const coupon = this.getAttribute('data-ega-coupon'); // Lấy mã từ data attribute
        
        if (!coupon) {
            alert('Mã không hợp lệ hoặc trống!');
            return;
        }
        
        console.log("Xin chào");
        // Sử dụng Clipboard API
        navigator.clipboard.writeText(coupon)
        .then(() => {
           
        })
        .catch(err => {
           
            });
    });
    
</script>