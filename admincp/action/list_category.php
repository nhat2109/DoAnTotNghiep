<?php 
  if(in_array('theloai', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
	$thongbao="Bạn không có quyền truy cập...";
	$replace=array(
	  'title'=>'Bạn không có quyền truy cập...',
	  'description'=>$index_setting['description'],
	  'thongbao'=>$thongbao,
	  'link_chuyen'=>'/admincp/dashboard'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
	exit();		
  }
  $thaythe['title']='Danh sách danh mục sản phẩm';
  $thaythe['title_action']='Danh sách danh mục sản phẩm';
  $limit=50;
  $thongke=mysqli_query($conn,"SELECT count(*) AS total FROM category_sanpham");
  $r_tk=mysqli_fetch_assoc($thongke);
  $total_page=ceil($r_tk['total']/$limit);
  $category_data = $class_index->list_category($conn, $page, $limit);
  $bien=array(
	'list_theloai'=>$category_data['list_theloai'],
	'parent_categories'=>$category_data['parent_categories'],
	'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-category')
  );
  $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_category',$bien);
?>