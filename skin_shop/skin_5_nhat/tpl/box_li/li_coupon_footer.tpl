<div class="h-inhiret grid grid-cols-[30%_auto]">
  <div
    class="flex justify-center items-center p-3 rounded text-primary bg-relative relative"
  >
    <div
      class="coupon-item__code font-bold text-secondary whitespace-nowrap text-ellipsis overflow-hidden"
    >
      <span class="swiper-no-swiping"> {ma} </span>
    </div>
    <div
      class="absolute opacity-50 w-[1px] h-[calc(100%-40px)] border border-dashed border-primary -right-[1px] top-1/2 -translate-y-1/2"
    ></div>
  </div>
  <div class="p-3 rounded text-primary bg-relative relative">
    <div
      class="coupon-item__summary mb-2.5 text-xs text-neutral-400 font-semibold line-clamp-2"
    >
      Mã giảm:{giam}
    </div>

    <div class="coupon-item__rules mb-2.5 hidden"></div>
    <div class="coupon-item__action grid grid-cols-2 gap-3">
      <div class="coupon-item__end-date text-xs">
        Hạn sử dụng: {expired}
      </div>

      <copy-button
        data-copied-text="Đã sao chép"
        onclick="event.stopPropagation()"
      >
        <input type="hidden" value="{ma}" />
        <button
          type="button"
          class="btn text-xs relative z-[1] font-semibold copy-button w-full text-white border border-primary bg-primary py-1.5 whitespace-nowrap px-2"
        >
          Sao chép
        </button>
      </copy-button>
    </div>
  </div>
</div>
