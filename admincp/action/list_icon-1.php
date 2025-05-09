<?php 
    $thaythe['title']='Danh sách icon 1';
	$thaythe['title_action']='Danh sách icon 1';
	$x=file_get_contents('../skin_cpanel/css/font-awesome.min.css');
	preg_match_all('/\.fa-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon']='fa fa-'.$value;
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_icon',$r_tt);
	}
	$bien=array(
		'tieu_de'=>'Danh sách icon 1',
		'list_icon'=>$list
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_icon',$bien);
?>