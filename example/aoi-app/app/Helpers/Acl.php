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
    private $user = 'user';
    private $role = 'roles';
    private $field_read = 'is_read';
    private $field_store = 'is_insert';
    private $field_update = 'is_update';
    private $field_destroy = 'is_delete';
    private $field_approved = 'is_approved';
    private $super_admin = '1';

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
                    ->first();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }
    private function getPermissionUser(){
        $userinfo = $this->getMySession();
        $result = DB::table($this->table_pu.' as pu')
                    ->select('pu.*','u.username','r.code as role_code','r.description')
                    ->leftJoin($this->table_pg.' as pg','pg.code','=','pu.privillage_group_code')
                    ->leftJoin($this->user.' as u', 'u.code','=','pu.user_code')
                    ->leftJoin($this->role.' as r','r.code','=','u.role_code')
                    ->where('pu.user_code', $userinfo->code)
                    ->first();
        return $result;
    }
    private function checkPermissionUser(){
        $result = $this->getPermissionUser();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }
    private function isMaintenance(){
        $result = DB::table($this->table_set)
                    ->where('is_maintenance', 1) 
                    ->first();
        if(!$result){
            return true;
        }else{
            return false;
        }
    }
    private function isAllGranted(){
        $result = $this->getPermissionUser();
        if(!$result){
            return false; 
        }
        if($result->role_code == $this->super_admin){
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
        if($this->isAllGranted()){
            return true;
        }
        if(!$this->checkPermissionUser()){
            $msg = "You haven't permission";
        }
        if(!$this->checkPermissionMenu($cname, $field_name, $permission)){
            $msg = "You haven't to access this menu";
        }

        if($is_json){
            return json_encode($this->msgValidatePermission($msg));
        }
        if($is_array){
            return $this->msgValidatePermission($msg);
        }

        Session::flash('msg_permission', $msg);
        if($msg != ""){
            return redirect()->away(url('/menu'))->send();
        }

    }
    function validateRead($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_read, true, $is_json, $is_array);
    }
    function validateStore($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_store, true, $is_json, $is_array);
    }
    function validateUpdate($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_update, true, $is_json, $is_array);
    }
    function validateDestroy($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_destroy, true, $is_json, $is_array);
    }
    function validateApproved($is_json=false, $is_array=false){
        $cname = $this->getClassName();
        return $this->managementPermission($cname, $this->field_approved, true, $is_json, $is_array);
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