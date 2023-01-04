<?php
use App\Models\menu;

if(!function_exists('ListMenu')){
    function ListMenu(){
        $menu = new menu;
        $results = $menu->get_list_menu();
        return $results;
    }
}
?>