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
            $error = 1;
            $message = 'Login failed';
            $data = array(
                'status' => 'Failed',
                'data' => array(),
                'redirect' => ''
            );
            $user = $this->login->get_auth($request->all());
            if($user){
                Session::put('userinfo', $user);
                $error = 0;
                $message = 'Login success';
                $data['status'] = 'OK';
                $data['redirect'] = url('dashboard');
            }
            
            return JSONRES($error, $message, $data);
        }
    }
}
