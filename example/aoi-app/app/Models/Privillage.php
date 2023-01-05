<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Privillage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'privillage_groups';
    protected $fillable = [
        'code',
        'label',
        'status'
    ];

    function generate_code(){
        $code = "00000";
        $init = "PG";
        $result = DB::table($this->table)
                    ->orderByDesc('id')
                    ->first();
        if($result){
            $number = str_replace($init,"",$result->code);
            $code = (int)$number + 1;
        }else{
            $code = $code + 1;
        }
        $code = sprintf('%s%04d', $init, $code);
        return $code;
    }
}
