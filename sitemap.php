<?php
header("Content-type: text/xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="/skin/css/sitemap.xsl"?>';
include './includes/tlca_world.php';
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_index');
$page = intval($_REQUEST['page']);
if(intval($page)<1){
	$page=1;
}
$loai = addslashes(strip_tags($_REQUEST['loai']));
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$limit = 500;
$start = $page * $limit - $limit;
if ($loai == 'product') {
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY id ASC LIMIT $start,$limit");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<url><loc>' . $index_setting['link_domain'] . 'product/'.$r_tt['link'].'.html</loc></url>';
	}
	?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
echo $list;
	?>
</urlset>
	<?php

}else if ($loai == 'category') {
	$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham ORDER BY cat_id ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<url><loc>' . $index_setting['link_domain'] . 'san-pham/'.$r_tt['cat_blank'].'.html</loc></url>';
	}
	?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
echo $list;
	?>
</urlset>
	<?php

}else if ($loai == 'category_tintuc') {
	$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_id ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<url><loc>' . $index_setting['link_domain'] . 'tin-tuc/'.$r_tt['cat_blank'].'.html</loc></url>';
	}
	?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
echo $list;
	?>
</urlset>
	<?php

}else if ($loai == 'post') {
	$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<url><loc>' . $index_setting['link_domain'] . 'detail/'.$r_tt['link'].'.html</loc></url>';
	}
	?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
echo $list;
	?>
</urlset>
	<?php

} else if ($loai == 'page') {
	$list .= '<url><loc>' . $index_setting['link_domain'] . '</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'lien-he.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'dieu-khoan.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'gioi-thieu.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'don-hang.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'dang-ky.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'dangky-banhang.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'dang-nhap.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'dang-xuat.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'quen-mat-khau.html</loc></url>';
	$list .= '<url><loc>' . $index_setting['link_domain'] . 'tim-kiem.html</loc></url>';
	?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
echo $list;
	?>
</urlset>
	<?php

} else {
	$thongtin_sanpham = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham");
	$r_t = mysqli_fetch_assoc($thongtin_sanpham);
	$total_page_sanpham = ceil($r_t['total'] / $limit);
	for ($i = 0; $i < $total_page_sanpham; $i++) {
		$n = $i + 1;
		$list_sanpham .= '<sitemap><loc>' . $index_setting['link_domain'] . 'product-' . $n . '.xml</loc></sitemap>';
	}
	$thongtin_category = mysqli_query($conn, "SELECT count(*) AS total FROM category_sanpham");
	$r_category = mysqli_fetch_assoc($thongtin_category);
	$total_page_category = ceil($r_category['total'] / $limit);
	for ($i = 0; $i < $total_page_category; $i++) {
		$n = $i + 1;
		$list_category .= '<sitemap><loc>' . $index_setting['link_domain'] . 'category-' . $n . '.xml</loc></sitemap>';
	}
	$thongtin_category_tintuc = mysqli_query($conn, "SELECT count(*) AS total FROM category");
	$r_category_tintuc = mysqli_fetch_assoc($thongtin_category_tintuc);
	$total_page_category_tintuc = ceil($r_category_tintuc['total'] / $limit);
	for ($i = 0; $i < $total_page_category_tintuc; $i++) {
		$n = $i + 1;
		$list_category_tintuc .= '<sitemap><loc>' . $index_setting['link_domain'] . 'danhmuc-tintuc-' . $n . '.xml</loc></sitemap>';
	}
	$thongtin_tintuc = mysqli_query($conn, "SELECT count(*) AS total FROM post");
	$r_tintuc = mysqli_fetch_assoc($thongtin_tintuc);
	$total_page_tintuc = ceil($r_tintuc['total'] / $limit);
	for ($i = 0; $i < $total_page_tintuc; $i++) {
		$n = $i + 1;
		$list_tintuc .= '<sitemap><loc>' . $index_setting['link_domain'] . 'post-' . $n . '.xml</loc></sitemap>';
	}
	$list_page = '<sitemap><loc>' . $index_setting['link_domain'] . 'page.xml</loc></sitemap>';
	?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
	//echo $list_page;
	echo $list_category;
	echo $list_category_tintuc;
	echo $list_page;
	echo $list_tintuc;
	echo $list_sanpham;
	?>
</sitemapindex>
<?php
}
?>
<!-- XML Sitemap generated by code chuẩn -->