<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users';
    protected $t_role = 'roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'username',
        'password',
        'role_code',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    function get_data($param = array()){
        $query = DB::table($this->table." as u")
                        ->select('u.*','r.description as role')
                        ->leftJoin($this->t_role.' as r', 'r.code','=','u.role_code');
        if(!empty($param['id'])){
            $query->where('u.id', $param['id']);
            $results = $query->first();
        }else{
            $results = $query->get();
        }               
        return $results;
    }

    function generate_code(){
        $code_menu = "00000";
        $init_menu = "U";
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

    function dd_role($param=array()){
        $query = DB::table($this->t_role);
        $results = $query->get();
        $buffers = array();
        $buffers[''] = '-All-';
        foreach($results as $r){
            $buffers[$r->code] = $r->description;
        }
        return $buffers;
    }
}
