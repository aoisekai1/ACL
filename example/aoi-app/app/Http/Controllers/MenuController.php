<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Acl;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->menu = new Menu;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->acl->validateRead();
        $data = array();
        $data['results'] = $this->menu::orderByRaw('label_sort,group_code ASC')->get();
        return view('menu/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->acl->validateRead();
        $data = array();
        $code = $this->menu->generate_code_menu();
        $data['code_menu'] = $code;
        return view('menu/form/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->acl->validateStore();
        try {
            DB::beginTransaction();
            $request->request->remove('submit');
            $post = $request->all();
            if($this->menu->create($post)){
                DB::commit();
                return JSONRES(SUCCESS, 'Success save data');
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed save data');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return JSONRES(ERROR, 'Failed save data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['result'] = $this->menu::find($id);
        return view('menu/form/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->menu::find($id);
            $post_data = $request->all();
            unset($post_data['submit']);
            if($result->update($post_data)){
                DB::commit();
                return JSONRES(SUCCESS, 'Success update data');
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed update data');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return JSONRES(ERROR, 'Failed update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->acl->validateDestroy();
        try {
            DB::beginTransaction();
            $result = $this->menu::find($id);
            if($result->delete()){
                DB::commit();
                return JSONRES(SUCCESS, 'Success delete data');
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed delete data');
            }
        } catch (\Throwable $th) {
            return JSONRES(ERROR, 'Failed delete data');
        }
    }
}
