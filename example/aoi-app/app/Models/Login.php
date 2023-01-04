<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    use HasFactory;
    protected $table = 'user';

    function get_auth($param=array()){
        $user = DB::table('user')
                ->where('username', $param['username'])
                ->where('password', $param['password'])
                ->first();
        return $user;
    }
}
