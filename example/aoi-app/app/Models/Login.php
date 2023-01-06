<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    use HasFactory;
    protected $table = 'users';

    function get_auth($param=array()){
        $user = DB::table($this->table)
                ->where('username', $param['username'])
                ->where('password', $param['password'])
                ->where('is_active', 1)
                ->first();
        return $user;
    }
}
