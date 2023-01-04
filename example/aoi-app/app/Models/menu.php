<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = ['code','label','group_code','class_name','url','status','sub_status','label_sort'];
    function get_list_menu(){
        $data = array();
        $results = $this->get_label_menu();
        foreach($results as $r){
            $menu = $this->get_menu($r->group_code);
            $group_menu = array(
                'label' => $r->label,
                'gmenu' => $r->group_code,
                'menu' => array()
            );
            foreach($menu as $m){
                $lmenu = array(
                    'label' => $m->label,
                    'url' => $m->url,
                    'sub_menu' => array()
                );
                $sub_menu = $this->get_sub_menu($m->group_code, $m->group_smenu);
                foreach($sub_menu as $sm){
                    $smenu = array(
                        'label' => $sm->label,
                        'url' => $sm->url
                    );
                    array_push($lmenu['sub_menu'], $smenu);
                }
                array_push($group_menu['menu'], $lmenu);
            }
            array_push($data, $group_menu);
        }
        return $data;
    }

    function get_label_menu(){
        $results = DB::table($this->table)
                        ->where('status', 1) //Active
                        ->where('sub_status', 'L')
                        ->orderByRaw('label_sort, group_code ASC')
                        ->get();
        return $results;
    }
    function get_menu($group_code=null){
        $results = DB::table($this->table)
                        ->where('status', 1) //Active
                        ->where('sub_status', 'H')
                        ->where('group_code', $group_code)
                        ->orderByRaw('label_sort, group_code ASC')
                        ->get();
        return $results;
    }
    function get_sub_menu($group_code=null, $smenu=null){
        $initial = 'S'; //If you put 'S' in back from group_smenu that is sub menu
        $smenu = $smenu.$initial;
        $results = DB::table($this->table)
                        ->where('status', 1) //Active
                        ->where('sub_status', 'S')
                        ->where('group_code', $group_code)
                        ->where('group_smenu', $smenu)
                        ->orderByRaw('label_sort, group_code ASC')
                        ->get();
        return $results;
    }
}
