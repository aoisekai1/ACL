<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Acl;
use Session;

class DashboardController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->dashboard = new Dashboard;
    }
    function index(){
        return view('dash/index');
    }
    function logout(Request $request){
        Session::flush();
        $data = array(
            'error' => 0,
            'status' => 'OK',
            'message' => 'Logout Success',
            'data' => array(),
            'redirect' => url('login') 
        );
        return json_encode($data);
    }
}
