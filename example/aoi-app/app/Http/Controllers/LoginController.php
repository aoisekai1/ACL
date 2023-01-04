<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Acl;

class LoginController extends Controller
{
    function __construct(){
        $this->login = new Login;
        $this->acl = new Acl;
    }
    function index(){
        return view('login/index');
    }

    function auth(Request $request){
        $request->request->remove('submit');
        if(count($request->all()) > 0){
            $data = array(
                'error' => 1,
                'status' => 'Failed',
                'message' => 'Login failed',
                'data' => array(),
                'redirect' => ''
            );
            $user = $this->login->get_auth($request->all());
            if($user){
                Session::put('userinfo', $user);
                $data['error'] = 0;
                $data['status'] = 'OK';
                $data['message'] = 'Login success';
                $data['redirect'] = url('dashboard');
            }
            $json = json_encode($data);
            return $json;
        }
    }
}
