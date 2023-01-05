<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'setting';
    protected $t_role = 'roles';
    protected $fillable = [
        'is_maintenance',
        'link_maintenance',
        'role_code_access_all',
        'default_redirect'
    ];

    function dd_roles(){
        $results = DB::table($this->t_role)
                        ->get();
        $buffers = array();
        $buffers[''] = '-All-';
        foreach($results as $r){
            $buffers[$r->code] = $r->description;
        }
        return $buffers;
    }
}
