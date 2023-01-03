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

    function get_list_menus(){
        $data = array();
        $results = DB::table($this->table)
                        ->where('status', 1) //Active
                        ->orderByRaw('label_sort, group_code ASC')
                        ->get();
        return $results;
    }
}
