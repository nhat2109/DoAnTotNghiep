<?php
//7-4
        $thaythe['title'] = 'Sửa thương banner';
        $thaythe['title_action'] = 'Sửa thương banner';
        $id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
        $thongtin_banner = mysqli_query($conn, "SELECT * FROM banner WHERE id='$id'");
        $total_banner = mysqli_num_rows($thongtin_banner);
        if ($total_banner == 0) {
            $thongbao = "Banner không tồn tại...";
            $replace = array(
                'title' => 'Banner không tồn tại...',
                'description' => $index_setting['description'],
                'thongbao' => $thongbao,
                'link_chuyen' => '/dropship/list-banner',
            );
            echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
            exit();
        }
        $r_banner = mysqli_fetch_assoc($thongtin_banner);
        $thaythe['box_right']= $skin->skin_replace('skin_dropship/box_action/edit_banner', $r_banner); 