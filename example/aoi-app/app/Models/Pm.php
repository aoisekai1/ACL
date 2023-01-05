<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pm extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'privillage_menus';
    protected $t_menu = 'menus';
    protected $t_pg = 'privillage_groups';
    protected $fillable = [
        'privillage_group_code',
        'menu_code',
        'is_read',
        'is_insert',
        'is_update',
        'is_delete',
        'is_approved'
    ];
    function get_data($param = array()){
        $query = DB::table($this->table." as pm")
                        ->select('pm.*','m.label as menu', 'pg.label')
                        ->leftJoin($this->t_pg.' as pg', 'pg.code','=','pm.privillage_group_code')
                        ->leftJoin($this->t_menu.' as m', 'm.code','=','pm.menu_code');
        if(!empty($param['pg_code'])){
            $query->where('pm.privillage_group_code', $param['pg_code']);
        }
        if(!empty($param['id'])){
            $query->where('pm.id', $param['id']);
            $results = $query->first();
        }else{
            $results = $query->get();
        }               
        return $results;
    }

    function dd_privillage($param=array()){
        $query = DB::table($this->t_pg);
        if(!empty($param['pg_code'])){
            $query->where('code', $param['pg_code']);
        }
        $results = $query->get();
        $buffers = array();
        foreach($results as $r){
            $buffers[$r->code] = $r->label;
        }
        return $buffers;
    }
    function dd_menu($param=array()){
        $query = DB::table($this->t_menu);
        $query->whereIn('sub_status', ['H','S']);
        if(!empty($param['menu_code'])){
            $query->where('code', $param['menu_code']);
        }
        $results = $query->get();
        $buffers = array();
        $buffers[''] = '-All-';
        foreach($results as $r){
            $buffers[$r->code] = $r->label;
        }
        return $buffers;
    }
}
