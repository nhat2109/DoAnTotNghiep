<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: center;" class="hide_mobile"><a href="/product/{link}.html" target="_blank"><img src="/thumbnail.php?w=320&img={minh_hoa}" width="120"></a></td>
	<td style="text-align: left;">
		<a href="/product/{link}.html" target="_blank">{tieu_de}</a>
		<div class="hoa_hong">Giá: <b>{gia_moi} đ</b></div>
		<div class="input_aff">
			<input type="text" id="link_aff_{id}" name="link_aff" value="https://socdo.vn/product/{link}.html?utm_source={user_id}">
			<button class="copy_aff"><i class="icofont-ui-copy"></i> copy</button> <button class="rutgon_link" sp_id="{id}">Rút gọn link</button>
		</div>
		<div class="input_aff input_rutgon">
			{rut_gon}
		</div>
	</td>
	<td style="text-align: center;"><b class="color_red">{kho}</b></td>
	<td style="text-align: center;" class="hide_mobile"><b class="color_red">{hoa_hong}</b></td>
	<td style="text-align: center;" class="hide_mobile"><b class="color_red">{click}</b></td>
	<td style="text-align: center;" class="hide_mobile">60 ngày</td>
	<td><a href="/dropship/list-share-sanpham?id={id}" class="flex" sp_id="{id}" style="overflow: hidden;"><span>Đăng bán</span><img src="/images/fb_zalo.png"></a></td>
</tr>