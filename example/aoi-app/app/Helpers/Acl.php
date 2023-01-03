<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Session;

class Acl
{
    private $table_pg = 'privillage_groups';
    private $table_pu = 'privillage_users';
    private $table_pm = 'privillage_menus';
    private $table_set = 'setting';
    private $table_menu = 'menus';
    private $field_read = "is_read";
    private $field_store = "is_insert";
    private $field_update = "is_update";
    private $field_destroy = "is_delete";
    private $field_approved = "is_approved";

    function getMySession(){
        $userinfo = Session::get('userinfo');
        if(!$userinfo){
            return 'Empty session';
        }
        return $userinfo;
    }
    private function checkPermissionMenu($cname="", $field= '', $permission=null){
        $field = 'pm.'.$field;
        $result = DB::table($this->table_pm.' as pm')
                    ->select('pm.*')
                    ->leftJoin($this->table_pg.' as pg','pg.code','=','pm.privillage_group_code')
                    ->leftJoin($this->table_menu.' as m', 'm.code','=','pm.menu_code')
                    ->where('m.class_name', $cname)
                    ->where($field, $permission)
                    ->get();
        if($result->isEmpty()){
            return false;
        }else{
            return true;
        }
    }
    private function checkPermissionUser(){
        $userinfo = $this->getMySession();
        $result = DB::table($this->table_pu.' as pu')
                    ->select('pu.*')
                    ->leftJoin($this->table_pg.' as pg','pg.code','=','pu.privillage_group_code')
                    ->where('pu.user_code', $userinfo->code)
                    ->get();
        if($result->isEmpty()){
            return false;
        }else{
            return true;
        }
    }
    private function isMaintenance(){
        $result = DB::table($this->table_set)
                    ->where('is_maintenance', 1) 
                    ->get();
        if($result->isEmpty()){
            return true;
        }else{
            return false;
        }
    }
    function managementPermission($cname, $field_name, $permission, $is_json=false, $is_array=false){
        $msg = "";
        if(!$this->isMaintenance()){
            $msg = 'MAINTENANCE PROCESS';
        }
        if(!$this->checkPermissionUser()){
            $msg = "You haven't permission";
        }
        if(!$this->checkPermissionMenu($cname, $field_name, $permission)){
            $msg = "You haven't permission menu";
        }

        if($is_json){
            return json_encode($this->msgValidatePermission($msg));
        }
        if($is_array){
            return $this->msgValidatePermission($msg);
        }

        Session::flash('msg_permission', $msg);
        if($msg != ""){
            dd($msg);
        }

    }
    function validateRead($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_read, true, $is_json, $is_array);
    }
    function validateStore(){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_store, true);
    }
    function validateUpdate(){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_update, true);
    }
    function validateDestroy(){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_destroy, true);
    }
    function validateApproved(){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_approved, true);
    }

    function msgValidatePermission($msg=""){
        $data = array(
            'msg' => $msg
        );
        return $data;
    }

    function getClassName(){
        $path = get_class(Route::getCurrentRoute()->getController());
        $splitPath = explode('\\', $path);
        $cname = $splitPath[3];
        return $cname;
    }

}
?>