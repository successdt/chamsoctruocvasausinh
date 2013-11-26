<?php

function ewp_admin() {
    add_menu_page( 'Quản lý đặt hàng', 'Đặt hàng', 'manage_options', 'ewp/booking-manager.php', '', plugins_url('ewp/images/Plane_icon.png' ), 6 );
    
}
add_action('admin_menu', 'ewp_admin');
?>