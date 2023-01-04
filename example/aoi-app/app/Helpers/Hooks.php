<?php
use App\Models\Menu;

if(!function_exists('ListMenu')){
    function ListMenu(){
        $menu = new menu;
        $results = $menu->get_list_menu();
        return $results;
    }
}
?>