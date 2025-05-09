<div class="li_size {active} {disabled}" sp_id="{sp_id}" size="{size}" gia_cu="{gia_cu}" pl="{id}" gia_moi="{gia_moi}"
	sale="{sale}" tieu_de="{ten_size}">
	<span>{ten_size}</span>
</div>
<style>
	.li_color,
	.li_size {
		cursor: pointer;
		padding: 5px 10px;
		border: 1px solid #ccc;
		display: inline-block;
		margin: 5px;
	}

	.li_color.active,
	.li_size.active {
		border-color: #007bff;
		background-color: #e7f0ff;
	}

	.li_size.disabled {
		cursor: not-allowed;
		opacity: 0.5;
	}
</style>