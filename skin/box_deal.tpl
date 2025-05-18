<div class="home_deal">
	<div class="container">
		<div class="heading-bar" style="border: 2px rgb(231, 224, 224) solid; background-color: #283fa7">
			<div class="top_hotdeal">
				<span>FLASH-SALE </span>
				<div class="flashsale__countdown-wrapper">
					<span class="flashsale__countdown-label">Kết thúc trong </span>
					<div class="flashsale__countdown" data-countdown-type="hours" data-countdown="">
						<div class="ega-badge-ctd" id="ega-badge-ctd">
							<div>
								<div class="ega-badge-ctd__item ega-badge-ctd__h">00</div><span>Giờ</span>
							</div>
							<div class="ega-badge-ctd__colon"> : </div>
							<div>
								<div class="ega-badge-ctd__item  ega-badge-ctd__m">00</div><span>Phút</span>
							</div>
							<div class="ega-badge-ctd__colon"> : </div>
							<div>
								<div class="ega-badge-ctd__item ega-badge-ctd__s">00</div><span>Giây</span>
							</div>
						</div>
					</div>
				</div>

				<div class="li_start">Đang diễn ra 00:00 - 23:59</div>

			</div>
		</div>
		<div class="list_sanpham">
			{list_sanpham_deal}
		</div>
	</div>
</div>
<style>
	.home_deal .heading-bar .top_hotdeal {
		height: 40px;
		width: calc(100% - 0px);
		display: flex;
		justify-content: flex-start;
		align-items: center;
		color: #fff;
		margin-left: 20px;

	}

	.home_deal .heading-bar .flashsale__countdown-wrapper {
		display: flex;
		justify-content: flex-start;
		align-items: center;
		flex-wrap: wrap;
		width: 350px;
		margin-left: 20px;
	}

	.heading-bar {
		position: relative;
		border: 2px rgb(231, 224, 224) solid;
		background-color: #283fa7;
		padding: 10px 15px;
		height: auto;
	}

	.top_hotdeal {
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
		min-height: 40px;
		padding: 5px 0;
	}

	.top_hotdeal>span:first-child {
		font-size: 18px;
		font-weight: bold;
		color: #fff;
		text-transform: uppercase;
		white-space: nowrap;
		min-width: 120px;
		margin-right: 0;
	}

	.flashsale__countdown-label {
		color: #fff;
		font-size: 16px;
		white-space: nowrap;
	}

	.ega-badge-ctd {
		display: flex;
		align-items: center;
		gap: 5px;
		color: #fff;
	}

	.li_start {
		margin-left: auto;
		/* Đẩy sang phải */
		background: #ffeb3b;
		padding: 8px 15px;
		border-radius: 20px;
		font-weight: 500;
		color: #000;
		white-space: nowrap;
	}
</style>