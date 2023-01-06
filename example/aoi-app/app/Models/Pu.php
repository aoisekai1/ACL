<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'privillage_users';
    protected $t_pg = 'privillage_groups';
    protected $t_user = 'users';
    protected $fillable = [
        'privillage_group_code',
        'user_code',
        'status'
    ];

    function get_data($param = array()){
        $query = DB::table($this->table." as pu")
                        ->select('pu.*','u.username', 'pg.label')
                        ->leftJoin($this->t_pg.' as pg', 'pg.code','=','pu.privillage_group_code')
                        ->leftJoin($this->t_user.' as u', 'u.code','=','pu.user_code');
        if(!empty($param['pg_code'])){
            $query->where('pu.privillage_group_code', $param['pg_code']);
        }
        if(!empty($param['id'])){
            $query->where('pu.id', $param['id']);
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
    function dd_user($param=array()){
        $query = DB::table($this->t_user);
        if(!empty($param['user_code'])){
            $query->where('code', $param['user_code']);
        }
        $results = $query->get();
        $buffers = array();
        $buffers[''] = '-All-';
        foreach($results as $r){
            $buffers[$r->code] = $r->username;
        }
        return $buffers;
    }
}
