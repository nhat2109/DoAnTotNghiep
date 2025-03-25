<!-- <li>
    <input type="checkbox" id="data-color-p{id}" value="{id}" {checked} name="color-filter"/>
    <label for="data-color-p{id}" style="background-color: {ma_mau}"></label>
</li> -->

<li
  class="filter-item color filter-item--check-box filter-item--green overflow-item color-hover"
>
  <span>
    <label class="custom-checkbox color" for="data-color-p{id}">
      <input
        type="checkbox"
        id="data-color-p{id}"
        data-group="tag1"
        data-field="tags"
        data-text="{id}"
        value="{id}"
        {checked}
        name="color-filter"
        data-operator="OR"
      />
      <i class="fa trang" style="background-color: {ma_mau}"></i>
      <p class="tooltip-text">{tieu_de}</p>
    </label>
  </span>
</li>


<style>
   /* Thiết lập ban đầu cho phần hiển thị tiêu đề */
   .custom-checkbox .tooltip-text {
    display: none;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.75);
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
    white-space: nowrap;
    top: 120%; /* Hiển thị bên dưới icon */
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  /* Khi hover vào icon */
  .custom-checkbox .fa:hover + .tooltip-text {
    display: block;
    opacity: 1;
  }

  /* Nếu muốn hover vào cả vùng span hoặc nhãn */
  .custom-checkbox:hover .tooltip-text {
    display: block;
    opacity: 1;
  }
  .custom-checkbox .fa {
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 50%; /* Bo tròn */
    border: 2px solid transparent; /* Đường viền ban đầu */
    transition: all 0.3s ease;
  }
  
  .custom-checkbox input[type="checkbox"]:checked + .trang {
    border: 2px solid #000; /* Đổi viền khi chọn */
  }
</style>
