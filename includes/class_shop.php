<?php

class class_shop extends class_manage{
    function list_menu($conn,$shop){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM menu_shop WHERE shop='$shop' ORDER BY menu_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $vitri=$r_tt['menu_vitri'];
            $list[$vitri].=$skin->skin_replace('skin_shop/box_li/li_menu_'.$vitri,$r_tt);
            if($vitri=='top'){
                $list['menu_mobile'].=$skin->skin_replace('skin_shop/box_li/li_menu_mobile',$r_tt);
            }
        }
        return json_encode($list);
    }
    //////////////////////////////
    function list_category($conn,$shop){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
            while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                $list_sub.='<li><a class="sub-a" href="/san-pham/'.$r_s['cat_blank'].'.html" title="'.$r_s['cat_tieude'].'">'.$r_s['cat_tieude'].'</a></li>';
                $list_sub_left.='<li class="nav-item">
                                    <a class="nav-link" href="/san-pham/'.$r_s['cat_blank'].'.html" title="'.$r_s['cat_tieude'].'">'.$r_s['cat_tieude'].'</a>
                                </li>';
            }
            if(strlen($list_sub)>10){
                $duoi=$check->duoi_file($r_tt['cat_icon']);
                if(in_array($duoi,array('jpg','png','gif','jpeg','webp'))==true){
                    $cat_icon='<img src="'.$r_tt['cat_icon'].'" alt="'.$r_tt['cat_tieude'].'">';
                }else{
                    $cat_icon=$r_tt['cat_icon'];
                }
                $list.='<li class="dropdown menu-item-count clearfix">
                            <h3><a href="/san-pham/'.$r_tt['cat_blank'].'.html" title="'.$r_tt['cat_tieude'].'">'.$cat_icon.' '.$r_tt['cat_tieude'].'</a></h3>
                            <div class="subcate gd-menu">
                                <div class="sub-flex clearfix">
                                    <ul>'.$list_sub.'</ul>
                                </div>
                            </div>
                        </li>';
                $list_left.='<li class="nav-item ">
                            <a href="/san-pham/'.$r_tt['cat_blank'].'.html" class="nav-link" title="'.$r_tt['cat_tieude'].'">'.$r_tt['cat_tieude'].'</a>
                            <i class="fa fa-angle-down"></i>
                            <ul class="dropdown-menu">'.$list_sub_left.'</ul>
                        </li>';
                unset($list_sub);
                unset($list_sub_left);
            }else{
                $duoi=$check->duoi_file($r_tt['cat_icon']);
                if(in_array($duoi,array('jpg','png','gif','jpeg','webp'))==true){
                    $cat_icon='<img src="'.$r_tt['cat_icon'].'" alt="'.$r_tt['cat_tieude'].'">';
                }else{
                    $cat_icon=$r_tt['cat_icon'];
                }
                $list.='<li class="menu-item-count clearfix">
                            <h3><a href="/san-pham/'.$r_tt['cat_blank'].'.html" title="'.$r_tt['cat_tieude'].'">'.$cat_icon.' '.$r_tt['cat_tieude'].'</a></h3>
                        </li>';
                $list_left.='<li class="nav-item "><a class="nav-link" href="/san-pham/'.$r_tt['cat_blank'].'.html" title="'.$r_tt['cat_tieude'].'">'.$r_tt['cat_tieude'].'</a></li>';
            }
            $list_main.='<li class=""><a href="/san-pham/'.$r_tt['cat_blank'].'.html" class="nav-link" title="'.$r_tt['cat_tieude'].'">'.$r_tt['cat_tieude'].'</a></li>';
        }
        return json_encode(array('list'=>$list,'list_left'=>$list_left,'list_main'=>$list_main));
    }
    function list_box_index($conn,$shop,$list_muakem_id,$list_tang_id,$list_flashsale_id,$list_c){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $tach_list_muakem_id=explode(',', $list_muakem_id);
        $tach_list_tang_id=explode(',', $list_tang_id);
        $tach_list_flashsale_id=explode(',', $list_flashsale_id);
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_index='1' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $cat_id=$r_tt['cat_id'];
            $thongtin_sanpham=mysqli_query($conn,"SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' AND FIND_IN_SET($cat_id,sanpham_shop.cat)>0 ORDER BY sanpham_shop.id DESC LIMIT 8");
            while($r_sp=mysqli_fetch_assoc($thongtin_sanpham)){
                $id_sp=$r_sp['id'];
                $r_sp['date_post']=date('d/m/Y',$r_sp['date_post']);
                if($r_sp['gia_cu']>$r_sp['gia_moi']){
                    $giam=ceil((($r_sp['gia_cu'] - $r_sp['gia_moi'])/$r_sp['gia_cu'])*100);
                    $r_sp['label_sale']='<span class="label-product label-sale">-'.$giam.'%</span>';
                }else{
                    $r_sp['label_sale']='';
                }
                if(in_array($r_sp['id'], $tach_list_muakem_id)==true){
                    if(isset($list_c[$id_sp])){
                        $r_sp['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                        $r_sp['loai']='flash_sale';
                    }else{
                        $r_sp['loai']='muakem';
                    }
                    $r_sp['icon_label']='<div class="icon_label text">Mua kèm deal sốc</div>';
                }else if(in_array($r_sp['id'], $tach_list_tang_id)==true){
                    $r_sp['loai']='tang';
                    $r_sp['icon_label']='<div class="icon_label text">Mua hàng nhận quà tặng</div>';
                }else if(in_array($r_sp['id'], $tach_list_flashsale_id)==true){
                    if(isset($list_c[$id_sp])){
                        $r_sp['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    }
                    $r_sp['loai']='flash_sale';
                    $r_sp['icon_label']='<div class="icon_label text">Sản phẩm flash sale</div>';
                }else{
                    $r_sp['loai']='';
                    $r_sp['icon_label']='<div class="icon_label"></div>';
                }
                $r_sp['gia_cu']=number_format($r_sp['gia_cu']);
                $r_sp['gia_moi']=number_format($r_sp['gia_moi']);
                $r_sp['gia_drop']=number_format($r_sp['gia_drop']);
                if($r_sp['link_aff']!=''){
                    $list_sp.=$skin->skin_replace('skin_shop/box_li/li_sanpham_aff',$r_sp);
                }else if(strpos($r_sp['mau'], ',')!==false){
                    $list_sp.=$skin->skin_replace('skin_shop/box_li/li_sanpham_index_tuychon',$r_sp);
                }else if($r_sp['kho']<1 AND $r_sp['kho_hang']<1 AND $r_sp['link_aff']==''){
                    $list_sp.=$skin->skin_replace('skin_shop/box_li/li_sanpham_index_hethang',$r_sp);
                }else{
                    $list_sp.=$skin->skin_replace('skin_shop/box_li/li_sanpham_index',$r_sp);
                }
            }
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC LIMIT 4");
            while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                $list_sub.='<li><a href="/san-pham/'.$r_s['cat_blank'].'.html" title="'.$r_s['cat_tieude'].'">'.$r_s['cat_tieude'].'</a></li>';
            }
            $r_tt['list_sub']=$list_sub;
            $r_tt['list_sanpham']=$list_sp;
            unset($list_sp);
            unset($list_sub);
            $list.=$skin->skin_replace('skin_shop/box_index',$r_tt);
        }
        return $list;
    }
    //////////////////////////////////////////////////////////////////
    function list_option_danhmuc($conn,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_option_category"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_option_category"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ///////////////////
    function list_option_tinh($conn,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['id']==$id){
                $list.='<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_huyen($conn,$tinh,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY thu_tu ASC");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['id']==$id){
                $list.='<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_sanpham($conn,$shop,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT sanpham_shop.*,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' ORDER BY sanpham_shop.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">-'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }
            $r_tt['gia_cu']=number_format($r_tt['gia_cu']);
            $r_tt['gia_moi']=number_format($r_tt['gia_moi']);
            $r_tt['gia_drop']=number_format($r_tt['gia_drop']);
            //$list.=$skin->skin_replace('skin_shop/box_li/li_sanpham',$r_tt);
            if(strpos($r_tt['mau'], ',')!==false){
                $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_tuychon',$r_tt);
            }else if($r_tt['kho']<1 AND $r_tt['kho_hang']<1){
                $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_hethang',$r_tt);
            }else{
                $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham',$r_tt);
            }
        }
        return $list;
    }
    //////////////////////////////
    function list_sanpham_daxem($conn,$shop,$list_id,$id,$list_muakem_id,$list_tang_id,$list_flashsale_id,$list_c,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $tach_list_muakem_id=explode(',', $list_muakem_id);
        $tach_list_tang_id=explode(',', $list_tang_id);
        $tach_list_flashsale_id=explode(',', $list_flashsale_id);        
        $thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY rand() DESC LIMIT $limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">-'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }
            if(in_array($r_tt['id'], $tach_list_muakem_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai']='flash_sale';
                }else{
                    $r_tt['loai']='muakem';
                }
                $r_tt['icon_label']='<div class="icon_label text">Mua kèm deal sốc</div>';
            }else if(in_array($r_tt['id'], $tach_list_tang_id)==true){
                $r_tt['loai']='tang';
                $r_tt['icon_label']='<div class="icon_label text">Mua hàng nhận quà</div>';
            }else if(in_array($r_tt['id'], $tach_list_flashsale_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai']='flash_sale';
                $r_tt['icon_label']='<div class="icon_label text">Sản phẩm flash sale</div>';
            } else{
                $r_tt['loai']='';
                $r_tt['icon_label']='<div class="icon_label"></div>';
            }
            $r_tt['gia_cu']=number_format($r_tt['gia_cu']);
            $r_tt['gia_moi']=number_format($r_tt['gia_moi']);
            $r_tt['gia_drop']=number_format($r_tt['gia_drop']);
            $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_lienquan',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ///////////////////
    function list_slide($conn,$shop){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM slide WHERE shop='$shop' ORDER BY thu_tu ASC");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_shop/box_li/li_slide',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_category_sanpham_mobile($conn,$shop){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='0' ORDER BY cat_thutu ASC");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE shop='$shop' AND cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub>0){
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $list_sub.='<li class="ng-scope"><a href="/san-pham/'.$r_s['cat_blank'].'.html">'.$r_s['cat_tieude'].'</a></li>';
                }
                $list.='<li class="ng-scope ng-has-child1"><a href="/san-pham/'.$r_tt['cat_blank'].'.html">'.$r_tt['cat_tieude'].' <i class="fa fa-plus fa1" aria-hidden="true"></i></a><ul class="ul-has-child1">'.$list_sub.'</ul></li>';
                unset($list_sub);

            }else{
                $list.=' <li class="ng-scope"><a href="san-pham/'.$r_tt['cat_blank'].'.html">'.$r_tt['cat_tieude'].'</a></li>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_tintuc($conn,$shop,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $r_tt['trich']=$check->words($r_tt['noidung'],20);
            $list.=$skin->skin_replace('skin_shop/box_li/li_tintuc_index',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_tintuc_moi($conn,$shop,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $r_tt['trich']=$check->words($r_tt['noidung'],20);
            $list.=$skin->skin_replace('skin_shop/box_li/li_baiviet_moi',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_color($conn,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM mau_sanpham ORDER BY thu_tu ASC");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if(in_array($r_tt['id'], $tach_id)==true){
                $r_tt['checked']='checked="checked"';
            }else{
                $r_tt['checked']='';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_color',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_brand($conn,$shop,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM thuong_hieu WHERE shop='$shop' ORDER BY thu_tu ASC");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if(in_array($r_tt['id'], $tach_id)==true){
                $r_tt['checked']='checked="checked"';
            }else{
                $r_tt['checked']='';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_thuonghieu',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_size($conn,$shop,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM kich_co WHERE shop='$shop' ORDER BY thu_tu ASC");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['tieu_de']=strtoupper($r_tt['tieu_de']);
            if(in_array($r_tt['id'], $tach_id)==true){
                $r_tt['checked']='checked="checked"';
            }else{
                $r_tt['checked']='';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_size',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_donhang($conn,$shop,$user_id,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang_shop WHERE shop='$shop' AND user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['tongtien']=number_format($r_tt['tongtien']).'đ';
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['status']==0){
                $r_tt['status']='Chờ xử lý';
            }else if($r_tt['status']==1){
                $r_tt['status']='Đã tiếp nhận';
            }else if($r_tt['status']==2){
                $r_tt['status']='Đang vận chuyển';
            }else if($r_tt['status']==3){
                $r_tt['status']='Yêu cầu hủy đơn';
            }else if($r_tt['status']==4){
                $r_tt['status']='Đã hủy đơn';
            }else if($r_tt['status']==5){
                $r_tt['status']='Đã nhận hàng';
            }else if($r_tt['status']==6){
                $r_tt['status']='Đã hoàn đơn';
            }else{
            }
            $tach_sanpham=json_decode($r_tt['sanpham'],true);
            foreach ($tach_sanpham as $key => $value) {
                $s++;
                $list_sanpham.='+'.$value['tieu_de'].'<br>';
            }
            $r_tt['list_sanpham']=$list_sanpham;
            unset($list_sanpham);
            $list.=$skin->skin_replace('skin_shop/box_li/li_donhang',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_tichdiem($conn,$shop,$user_id,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM tich_diem_shop WHERE shop='$shop' AND user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['status']==1){
                $r_tt['status']='Đã cộng';
            }else{
                $r_tt['status']='Tạm giữ';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_tichdiem',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_thongbao($conn,$shop,$user_id,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM thongbao_shop WHERE shop='$shop' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') ORDER BY date_post DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if((time() - $r_tt['date_post'])<3*24*3600){
                $r_tt['new']='<span>new</span>';
            }else{
                $r_tt['new']='';

            }
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $tach_doc=explode(',', $r_tt['doc']);
            if(in_array($user_id, $tach_doc)==true){
                $r_tt['status']='<i class="fa fa-eye"></i> đã đọc';
                $r_tt['new']='';
            }else{
                $r_tt['status']='<i class="fa fa-eye-slash"></i> chưa đọc';
                $r_tt['new']='<span>new</span>';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_thongbao',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_khoang_gia($conn,$id){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM khoang_gia ORDER BY thu_tu ASC");
        $i=$start;
        $tach_id=explode('*', $id);
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if($r_tt['kieu']=='nho'){
                $r_tt['khoang']='<span>Dưới</span> '.number_format($r_tt['max_price']).'₫';
                $r_tt['price']='0-'.$r_tt['max_price'];
            }else if($r_tt['kieu']=='lon'){
                $r_tt['khoang']='<span>Trên</span> '.number_format($r_tt['min_price']).'₫';
                $r_tt['price']=$r_tt['min_price'].'-999999999999';
            }else{
                $r_tt['khoang']=number_format($r_tt['min_price']).'₫ - '.number_format($r_tt['max_price']).'₫';
                $r_tt['price']=$r_tt['min_price'].'-'.$r_tt['max_price'];
            }
            if(in_array($r_tt['price'], $tach_id)==true){
                $r_tt['checked']='checked="checked"';
            }else{
                $r_tt['checked']='';
            }
            $list.=$skin->skin_replace('skin_shop/box_li/li_price',$r_tt);
        }
        return $list;
    }
    //////////////////////////////
    function list_baiviet_category($conn,$shop,$id,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $cat='cat'.$id;
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM post_shop WHERE FIND_IN_SET($id,cat)>0 AND shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $r_tt['trich']=$check->words($r_tt['noidung'],80);
            $list.=$skin->skin_replace('skin_shop/box_li/li_tintuc',$r_tt);
        }
        mysqli_free_result($thongtin);
        $info=array(
            'total'=>$i,
            'list'=>$list,
        );
        return json_encode($info);
    }
    //////////////////////////////
    function list_baiviet_lienquan($conn,$shop,$id,$cat,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        if(strpos($cat, ',')!==false){
            $tach_cat=explode(',', $cat);
            $total_cat=count($tach_cat);
            for ($i=0; $i < $total_cat ; $i++) { 
                if($i==0){
                    $where.="(FIND_IN_SET($tach_cat[$i],cat)>0 ";
                }else{
                    if($tach_cat[$i]==''){

                    }else{
                        $where.="OR FIND_IN_SET($tach_cat[$i],cat)>0 ";
                    }
                }
            }
            $where=$where.")";
        }else{
            $where="FIND_IN_SET($cat,cat)>0";
        }
        $thongtin=mysqli_query($conn,"SELECT * FROM post_shop WHERE $where AND id!='$id' AND shop='$shop' ORDER BY id DESC LIMIT $limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $r_tt['trich']=$check->words($r_tt['noidung'],80);
            $list.=$skin->skin_replace('skin_shop/box_li/li_baiviet_lienquan',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_flashsale($conn,$shop,$list_flashsale_id,$list_c){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $tach_list_muakem_id=explode(',', $list_muakem_id);
        $tach_list_tang_id=explode(',', $list_tang_id);
        $tach_list_flashsale_id=explode(',', $list_flashsale_id);        
        $thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE id IN ($list_flashsale_id) AND shop='$shop' ORDER BY id DESC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $id_sp=$r_tt['id'];
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
/*            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }*/
            if(isset($list_c[$id_sp])){
                $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                $r_tt['expired']=$list_c[$id_sp]['expired'] - time();
            }
            $r_tt['gia_cu']=number_format($r_tt['gia_cu']).'đ';
            $r_tt['gia_moi']=number_format($r_tt['gia_moi']).'đ';
            $r_tt['gia_drop']=number_format($r_tt['gia_drop']);
            $list.=$skin->skin_replace('skin_shop/box_li/li_flash_sale',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_sanpham_lienquan($conn,$shop,$id,$cat,$list_muakem_id,$list_tang_id,$list_flashsale_id,$list_c,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $tach_list_muakem_id=explode(',', $list_muakem_id);
        $tach_list_tang_id=explode(',', $list_tang_id);
        $tach_list_flashsale_id=explode(',', $list_flashsale_id);        
        if(strpos($cat, ',')!==false){
            $tach_cat=explode(',', $cat);
            $total_cat=count($tach_cat);
            for ($i=0; $i < $total_cat ; $i++) { 
                if($i==0){
                    $where.="(FIND_IN_SET($tach_cat[$i],cat)>0 ";
                }else{
                    if($tach_cat[$i]==''){

                    }else{
                        $where.="OR FIND_IN_SET($tach_cat[$i],cat)>0 ";
                    }
                }
            }
            $where=$where.")";
        }else{
            $where="FIND_IN_SET($cat,cat)>0";
        }
        $thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE $where /*AND id!='$id'*/ AND shop='$shop' ORDER BY id DESC LIMIT $limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            $id_sp=$r_tt['id'];
            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">-'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }
            if(in_array($r_tt['id'], $tach_list_muakem_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai']='flash_sale';
                }else{
                    $r_tt['loai']='muakem';
                }
                $r_tt['icon_label']='<div class="icon_label text">Mua kèm deal sốc</div>';
            }else if(in_array($r_tt['id'], $tach_list_tang_id)==true){
                $r_tt['loai']='tang';
                $r_tt['icon_label']='<div class="icon_label text">Mua hàng nhận quà</div>';
            }else if(in_array($r_tt['id'], $tach_list_flashsale_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai']='flash_sale';
                $r_tt['icon_label']='<div class="icon_label text">Sản phẩm flash sale</div>';
            }else{
                $r_tt['loai']='';
                $r_tt['icon_label']='<div class="icon_label"></div>';
            }
            $r_tt['gia_cu']=number_format($r_tt['gia_cu']);
            $r_tt['gia_moi']=number_format($r_tt['gia_moi']);
            $r_tt['gia_drop']=number_format($r_tt['gia_drop']);
            $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_lienquan',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////
    function list_sanpham_timkiem($conn,$shop,$list_muakem_id,$list_tang_id,$list_flashsale_id,$list_c,$where,$order,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $tach_list_muakem_id=explode(',', $list_muakem_id);
        $tach_list_tang_id=explode(',', $list_tang_id);
        $tach_list_flashsale_id=explode(',', $list_flashsale_id);
        $start=$page*$limit - $limit;
        if(strlen($where)<5){
            $thongtin_sanpham=mysqli_query($conn,"SELECT *,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE shop='$shop' ORDER BY $order LIMIT $start,$limit");
        }else{
            $thongtin_sanpham=mysqli_query($conn,"SELECT *,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE ".$where." AND shop='$shop' ORDER BY $order LIMIT $start,$limit");
        }
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin_sanpham)){
            $i++;
            $id_sp=$r_tt['id'];
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">-'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }
            if(in_array($r_tt['id'], $tach_list_muakem_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $r_tt['loai']='flash_sale';
                }else{
                    $r_tt['loai']='muakem';
                }
                $r_tt['icon_label']='<div class="icon_label text">Mua kèm deal sốc</div>';
            }else if(in_array($r_tt['id'], $tach_list_tang_id)==true){
                $r_tt['loai']='tang';
                $r_tt['icon_label']='<div class="icon_label text">Mua hàng nhận quà</div>';
            }else if(in_array($r_tt['id'], $tach_list_flashsale_id)==true){
                if(isset($list_c[$id_sp])){
                    $r_tt['gia_moi']=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                }
                $r_tt['loai']='flash_sale';
                $r_tt['icon_label']='<div class="icon_label text">Sản phẩm flash sale</div>';
            }else{
                $r_tt['loai']='';
                $r_tt['icon_label']='<div class="icon_label"></div>';
            }
            $r_tt['gia_cu']=number_format($r_tt['gia_cu']);
            $r_tt['gia_moi']=number_format($r_tt['gia_moi']);
            $r_tt['gia_drop']=number_format($r_tt['gia_drop']);
            if(strpos($where, 'tieu_de')!==false){
                if($r_tt['link_aff']!=''){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_timkiem_aff',$r_tt);
                }else if(strpos($r_tt['mau'], ',')!==false){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_timkiem_tuychon',$r_tt);
                }else if($r_tt['kho']<1 AND $r_tt['kho_hang']<1){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_timkiem_hethang',$r_tt);
                }else{
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_timkiem',$r_tt);
                }
            }else{
                if($r_tt['link_aff']!=''){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_aff',$r_tt);
                }else if(strpos($r_tt['mau'], ',')!==false){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_tuychon',$r_tt);
                }else if($r_tt['kho']<1 AND $r_tt['kho_hang']<1){
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham_hethang',$r_tt);
                }else{
                    $list.=$skin->skin_replace('skin_shop/box_li/li_sanpham',$r_tt);
                }

            }
        }
        return $list;
    }
    ///////////////////////
    function phantrang_sanpham($page, $total, $link) {
        if($total<=1){
            return '';
        }else{
            if($total<=5){
                for ($i=1; $i <= $total; $i++) { 
                    if($page==$i){
                        $list.='<a href="javascript:;" page="'.$i.'" class="active">'.$i.'</a>';
                    }else{
                        $list.='<a href="javascript:;" page="'.$i.'">'.$i.'</a>';
                    }
                }
                return $list;
            }else{
                if($page<=3){
                    for ($i=1; $i <= 5; $i++) { 
                        if($page==$i){
                            $list.='<a href="javascript:;" page="'.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="javascript:;" page="'.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else if($page>3 AND $page<=($total - 2)){
                    $start=$page - 2;
                    $end=$page + 2;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="javascript:;" page="'.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="javascript:;" page="'.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else{
                    $start=$total - 4;
                    $end=$total;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="javascript:;" page="'.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="javascript:;" page="'.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }

            }
        }
    }
    ///////////////////////
    function phantrang($page, $total, $link) {
        if($total<=1){
            return '';
        }else{
            if($total<=5){
                for ($i=1; $i <= $total; $i++) { 
                    if($page==$i){
                        $list.='<a href="'.$link.'?page='.$i.'" class="active">'.$i.'</a>';
                    }else{
                        $list.='<a href="'.$link.'?page='.$i.'">'.$i.'</a>';
                    }
                }
                return $list;
            }else{
                if($page<=3){
                    for ($i=1; $i <= 5; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'?page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'?page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else if($page>3 AND $page<=($total - 2)){
                    $start=$page - 2;
                    $end=$page + 2;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'?page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'?page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else{
                    $start=$total - 4;
                    $end=$total;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'?page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'?page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }

            }
        }
    }
    ///////////////////////
    function phantrang_timkiem($page, $total, $link) {
        if($total<=1){
            return '';
        }else{
            if($total<=5){
                for ($i=1; $i <= $total; $i++) { 
                    if($page==$i){
                        $list.='<a href="'.$link.'&page='.$i.'" class="active">'.$i.'</a>';
                    }else{
                        $list.='<a href="'.$link.'&page='.$i.'">'.$i.'</a>';
                    }
                }
                return $list;
            }else{
                if($page<=3){
                    for ($i=1; $i <= 5; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'&page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'&page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else if($page>3 AND $page<=($total - 2)){
                    $start=$page - 2;
                    $end=$page + 2;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'&page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'&page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }else{
                    $start=$total - 4;
                    $end=$total;
                    for ($i=$start; $i <= $end; $i++) { 
                        if($page==$i){
                            $list.='<a href="'.$link.'&page='.$i.'" class="active">'.$i.'</a>';
                        }else{
                            $list.='<a href="'.$link.'&page='.$i.'">'.$i.'</a>';
                        }
                    }
                    return $list;
                }

            }
        }
    }
}
?>

