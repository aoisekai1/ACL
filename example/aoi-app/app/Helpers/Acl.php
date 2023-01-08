<?php
    namespace App\Helpers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Http\Request;
    use Session;

    class Acl
    {
        private $table_pg = 'privillage_groups';
        private $table_pu = 'privillage_users';
        private $table_pm = 'privillage_menus';
        private $table_set = 'setting';
        private $table_menu = 'menus';
        private $user = 'users';
        private $role = 'roles';
        private $field_read = 'is_read';
        private $field_store = 'is_insert';
        private $field_update = 'is_update';
        private $field_destroy = 'is_delete';
        private $field_approved = 'is_approved';

        private function getMySession(){
            $userinfo = Session::get('userinfo');
            return $userinfo;
        }
        function checkMySession($is_redirect=true){
            $userinfo = $this->getMySession();
            $set = $this->getSetting();
            if(!$userinfo){
                return false;
            }
            return true;
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
                        ->where('u.is_active', 1)
                        ->first();
            return $result;
        }
        private function getSetting(){
            $result = DB::table($this->table_set) 
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
            $setting = $this->getSetting();
            $userinfo = $this->getMySession();
            if(!$result){
                if($userinfo->role_code == $setting->role_code_access_all){
                    return true;
                }
                return false; 
            }
            if(!$setting){
                return false;
            }
            if($result->role_code == $setting->role_code_access_all){
                return true;
            }else{
                return false;
            }
        }
        private function managementPermission($cname, $field_name, $permission, $is_json=false, $is_array=false){
            $msg = "";
            list($default_redirect, $link_maintenance) = $this->setting();
            if(!$this->checkMySession()){
                return redirect()->away(url($default_redirect))->send();
            }
            if(!$this->isMaintenance()){
                return redirect()->away(url($link_maintenance))->send();
            }
            if($this->isAllGranted()){
                return true;
            }
            if(!$this->checkPermissionUser()){
                $msg = "You haven't permission";
            }
            if(!$this->checkPermissionMenu($cname, $field_name, $permission)){
                $msg = "You haven't to access this ".$this->actionText($field_name)." menu";
            }

            if($is_json){
                return json_encode($this->msgValidatePermission($msg));
            }
            if($is_array){
                return $this->msgValidatePermission($msg);
            }
            Session::flash('msg_permission', $msg);
            if(request()->ajax()){
                $data = array(
                    'error' => 1,
                    'status' => 'Failed',
                    'message' => $msg,
                    'data' => array(),
                    'isRefresh' => false
                );
                $json = json_encode($data);
                if($msg==""){
                    return true;
                }
                die($json);
            }
            if($msg != ""){
                return redirect()->away(url($default_redirect))->send();
            }
            

        }
        function validateRead($cname=null,$is_json=false, $is_array=false){
            if(is_null($cname)){
                $cname = $this->getClassName();
            }
            return $this->managementPermission($cname, $this->field_read, true, $is_json, $is_array);
        }
        function validateStore($cname=null,$is_json=false, $is_array=false){
            if(is_null($cname)){
                $cname = $this->getClassName();
            }
            return $this->managementPermission($cname, $this->field_store, true, $is_json, $is_array);
        }
        function validateUpdate($cname=null,$is_json=false, $is_array=false){
            if(is_null($cname)){
                $cname = $this->getClassName();
            }
            return $this->managementPermission($cname, $this->field_update, true, $is_json, $is_array);
        }
        function validateDestroy($cname=null,$is_json=false, $is_array=false){
            if(is_null($cname)){
                $cname = $this->getClassName();
            }
            return $this->managementPermission($cname, $this->field_destroy, true, $is_json, $is_array);
        }
        function validateApproved($cname=null,$is_json=false, $is_array=false){
            if(is_null($cname)){
                $cname = $this->getClassName();
            }
            return $this->managementPermission($cname, $this->field_approved, true, $is_json, $is_array);
        }
        function maintenanceWeb(){
            list($default_redirect, $link_maintenance) = $this->setting();
            if($this->isMaintenance()){
                return redirect()->away(url($link_maintenance))->send();
            }
        }
        private function msgValidatePermission($msg=""){
            $data = array(
                'msg' => $msg
            );
            return $data;
        }
        private function actionText($field=null){
            $data = array(
                $this->field_read => 'Read',
                $this->field_store => 'Insert',
                $this->field_update => 'Update',
                $this->field_destroy => 'Delete',
                $this->field_approved => 'Approved'
            );
            if(!is_null($field)){
                return $data[$field];
            }
            return '';
        }
        private function getClassName(){
            $path = get_class(Route::getCurrentRoute()->getController());
            $splitPath = explode('\\', $path);
            $cname = $splitPath[3];
            return $cname;
        }

        private function setting(){
            $set = $this->getSetting();
            $default_redirect = '/';
            $link_maintenance = '/maintenance';
            if($set){
                if($set->default_redirect){
                    $default_redirect = $set->default_redirect;
                }
                if($set->link_maintenance){
                    $link_maintenance = $set->link_maintenance;
                }
            }

            return array($default_redirect, $link_maintenance);
        }

    }
?>