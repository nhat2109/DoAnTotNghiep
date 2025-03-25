<section
  class="section awe-section-4 section-section_flashsale"
  style="
    --background-color: #ffffff;
    --countdown-background: #000000;
    --countdown-color: #ffffff;
    --process-background: #c8c8c8;
    --process-color1: #ecc00e;
    --process-color2: #f75308;
    --stock-color: #181717;
    --heading-color: #444444;
  "
>
  <div class="container">
    <div class="flashsale__container border-0 p-0">
      <div
        class="title_module_main heading-bar e-tabs d-flex justify-content-between align-items-center py-0">
        <div
          class="d-flex align-items-center flex-wrap flashsale__header justify-content-between"
        >
          <div class="flash-sale-heading">
            <div style="display: flex; align-items: baseline; gap: 10px">
              <h2 class="heading-bar__title flashsale__title m-0">
                <a class="link" href="flash-sale.html" title="HAPPY SUMMER - GIẢM Đến 40%">
                  HAPPY SUMMER - GIẢM SÂU</a
                >
              </h2>
             
              

              <img
                class="img-fluid"
                alt="HAPPY SUMMER - GIẢM SÂU"
                src="/uploads/minh-hoa/flashsale-hot.png"
                width="33"
                height="15"
              />
            </div>
          </div>
          <div class="flashsale__countdown-wrapper">
            <span class="flashsale__countdown-label">Kết thúc sau</span>
            <div class="flashsale__countdown" data-countdown-type="hours" data-countdown=""></div>
        
            </div>
          </div>
        </div>
      </div>

      <div class="e-tabs">
        <div id="tab-1" class="tab-content content_extab current">
          <div class="row one-row">{list_flash_sale}</div>
        </div>
      </div>

    </div>
  </div>
</section>
<script>
  
  window.flashSale = {
		flashSaleColl: "flashsale",
		type:"hours",
		dateStart: "15/01/2024",
		dateFinish: "1",
		hourStart: "00:00",
		hourFinish:  "24",
		activeDay: "7",
		finishAction: "show",
		finishLabel :"Chương trình đã kết thúc",
		percentMin: "10",
		percentMax: "90",
		maxInStock: "100",
		useSoldQuantity: false,
		useTags:  false,
		timestamp: new Date().getTime(),
		openingText: "Vừa mở bán",
		soldText: "Đã bán [soluong] sản phẩm",
		//outOfStockSoonText: "<img src='/uploads/minh-hoa/fire-icon.svg' /> Sắp cháy hàng"
	}
	 window.sectionScripts = window.sectionScripts  || []
   window.sectionScripts.push("/skin_shop/skin_7_nhat/tpl/js/flashsale.js")

</script>
<style>

</style>