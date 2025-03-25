$(document).ready(()=>{
	if(!$('#coupon-modal').length){
		$('body').append($('[data-template="couponPopup"]').html())
	}

	if(window.matchMedia('(max-width: 1199px)').matches){
		$(document).on('click','.coupon-icon-info', function(e) {
			e.preventDefault();
			const code = $(this).data('coupon')
			const info = $(this).find('.coupon_info').html()|| ''
			const title = $(this).parents('.coupon_body').find('.coupon_title').text() || ''
			const couponHtml = `
					<div class="coupon-title">${title}</div>
					<div class="coupon-row">
						<div class="coupon-label">Mã khuyến mãi:</div><span class="code">${code}</span>

					</div>
					<div class="coupon-row">
						<div class="coupon-label">Điều kiện:</div><div class="coupon-info">${info}</div>
					</div>
					<div class="coupon-action">
					<button type="button" class="btn btn-main" data-dismiss="modal" data-backdrop="false"
        				aria-label="Close" style="z-index: 9;">Đóng</button>
					<button class="btn btn-main coupon_copy" data-ega-coupon="${code}">
						<span>Sao chép</span></button>
					</div>
					`
			$('.coupon-modal .coupon-content').html(couponHtml)
			$("#coupon-modal").modal();
		})
	}

	$(document).on('click','.coupon_copy', function() {
		let copyText = "Sao chép";
		let copiedText = "Đã sao chép";
		
		 
			copyText = "Sao chép";
					
		
			copiedText = "Đã sao chép";
				
		const coupon = $(this).data().egaCoupon;
		const _this = $(this);
		let iconType = true;
		if(!_this.hasClass("type--icon")){
			iconType = false;
			_this.html(`<span>${copiedText}</span>`);
		}
		_this.addClass('disabled');
		setTimeout(function() {
			if(!iconType){
				_this.html(`<span>${copyText}</span>`);
			}
			_this.removeClass('disabled');
		}, 3000)
		navigator.clipboard.writeText(coupon);
	})
})