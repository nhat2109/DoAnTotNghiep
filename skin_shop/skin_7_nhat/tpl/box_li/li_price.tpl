<!-- <li>
    <input type="checkbox" value="{price}" id="{id}" {checked} name="price-filter" />
    <label for="{id}">
        {khoang}
    </label>
</li> -->
<li
class="filter-item filter-item--check-box filter-item--green overflow-item"
>
<span>
  <label
    class="custom-checkbox"
    for="{id}"
  >
    <input
      type="checkbox"
      id="{id}"
      {checked} name="price-filter"
      onchange=""
      data-group="Khoảng giá"
      data-field="price_min"
      data-text="Dưới 1000000"
      value="{price}"
      data-operator="OR"
    />
    <i class="fa"></i>
    {khoang}
  </label>
</span>
</li>