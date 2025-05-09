<div class="home_box">
	<div class="container">
		<div class="title_box">
			<h2><a href="/san-pham/{cat_blank}.html" class="link">{cat_tieude}</a></h2>
			<ul>
				{list_sub}
			</ul>
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