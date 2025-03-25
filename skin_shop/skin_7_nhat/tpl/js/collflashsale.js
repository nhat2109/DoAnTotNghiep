if(window.matchMedia('(min-width: 768px)').matches){
			let couponLength = $('.promo-box-wrapper .flashsale-coupon').length 
			$('.promo-box-wrapper').slick({
			autoplay: false,
			autoplaySpeed: 6000,
			dots: false,
			arrows: true,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4
					}
				},
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				}
			]
		})
		}