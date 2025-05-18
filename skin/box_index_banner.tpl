<div class="home_box">
	<div class="container">
		<div class="title_box">
			<h2><a href="/san-pham/{cat_blank}.html" class="link">{cat_tieude}</a></h2>
			<div class="text-center">
				<a href="/san-pham/{cat_blank}.html" title="Xem tất cả" class="button_more">
					Xem tất cả <i class="fa fa-chevron-right"></i>
				</a>
			</div>
		</div>
		<div class="box_cat">
			<div class="li_hinhanh">
				<a href="{cat_link}" target="_blank">
					<img src="{cat_img}" alt="{cat_tieude}" onerror="this.src='/images/no-images.png'">
				</a>
			</div>
			<div class="list_category">
				{list_sub_box}						
			</div>
		</div>
		<div class="title_box_sanpham">
			<h2><a href="/san-pham/{cat_blank}.html" class="link">{cat_tieude} nổi bật</a></h2>
			<div class="text-center">
				<a href="/san-pham/{cat_blank}.html" title="Xem tất cả sản phẩm">
					Xem tất cả
				</a>
			</div>
		</div>
		<div class="box_sanpham owl-carousel" id="slide_{cat_id}">
			{list_sanpham}
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var owl_{cat_id}=$('#slide_{cat_id}');
		if($(window).width()<480){
			margin_dt=0;
		}else{
			margin_dt=10;
		}
		owl_{cat_id}.owlCarousel({
			loop:true,
			margin:margin_dt,
			nav:true,
			autoplay:false,
			autoplayTimeout:3000,
			autoplayHoverPause:true,
			responsive:{
				0:{
					items:2
				},
				600:{
					items:3
				},
				1000:{
					items:5
				}
			}
		})
		$('.next_{cat_id}').click(function() {
			owl_{cat_id}.trigger('next.owl.carousel');
		});
		$('.prev_{cat_id}').click(function() {
			owl_{cat_id}.trigger('prev.owl.carousel');
		});
	});
</script>  