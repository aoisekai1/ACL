<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;

class Menu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'menus';
    protected $t_setting = 'setting';
    protected $t_pm = 'privillage_menus';
    protected $fillable = [
        'code',
        'label',
        'group_code',
        'class_name',
        'url',
        'status',
        'sub_status',
        'label_sort', 
        'description'
    ];
    function get_list_menu(){
        $data = array();
        $userinfo = Session::get('userinfo');
        $setting = $this->get_setting();
        $results = $this->get_label_menu();
        foreach($results as $r){
            $menu = $this->get_menu($r->group_code);
            $group_menu = array(
                'label' => $r->label,
                'gmenu' => $r->group_code,
                'url' => $r->url,
                'menu' => array(),
                'is_single_menu' => true
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
            $group_menu['is_menu'] = $group_menu['menu'] ? true:false;
            if($userinfo->role_code != $setting->role_code_access_all){
                $group_menu['is_single_menu'] = $group_menu['url'] && $r->menu_code ? true:false;
            }
            array_push($data, $group_menu);
        }
        // dd($data);
        return $data;
    }

    function get_label_menu(){
        $query = DB::table($this->table.' as m');
        $query->select('m.*','pm.menu_code');
        $query->leftJoin($this->t_pm.' as pm','pm.menu_code','=','m.code');
        $query->where('m.status', 1); //Active
        $query->where('m.sub_status', 'L');
        $query->orderByRaw('label_sort, group_code ASC');
        $results = $query->get();
        return $results;
    }
    function get_menu($group_code=null){
        $userinfo = Session::get('userinfo');
        $setting = $this->get_setting();
        $query = DB::table($this->table.' as m')
                        ->select('m.*');
        if($userinfo->role_code != $setting->role_code_access_all){
            $query->join($this->t_pm.' as pm','pm.menu_code','=','m.code');
        }
        $query->where('m.status', 1); //Active
        $query->where('m.sub_status', 'H');
        $query->where('m.group_code', $group_code);
        $query->orderByRaw('label_sort, group_code ASC');
        $results = $query->get();
        return $results;
    }
    function get_sub_menu($group_code=null, $smenu=null){
        $initial = 'S'; //If you put 'S' in back from group_smenu that is sub menu
        $smenu = $smenu.$initial;
        $userinfo = Session::get('userinfo');
        $setting = $this->get_setting();
        $query = DB::table($this->table.' as m')
                        ->select('m.*');
        if($userinfo->role_code != $setting->role_code_access_all){
            $query->join($this->t_pm.' as pm','pm.menu_code','=','m.code');
        }
        $query->where('status', 1); //Active
        $query->where('m.sub_status', 'S');
        $query->where('m.group_code', $group_code);
        $query->where('m.group_smenu', $smenu);
        $query->orderByRaw('label_sort, group_code ASC');
        $results = $query->get();
        return $results;
    }

    function get_setting(){
        $result = DB::table($this->t_setting)
                        ->first();
        return $result;
    }

    function generate_code_menu(){
        $code_menu = "00000";
        $init_menu = "M";
        $result = DB::table($this->table)
                    ->orderByDesc('id')
                    ->first();
        if($result){
            $number = str_replace($init_menu,"",$result->code);
            $code_menu = (int)$number + 1;
        }else{
            $code_menu = $code_menu + 1;
        }
        $code_menu = sprintf('%s%05d', $init_menu, $code_menu);
        return $code_menu;
    }
}
