<?php

namespace App\Http\Controllers;

use App\Models\Pm;
use App\Models\Privillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Acl;

class PmController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->pm = new Pm;
        $this->privillage = new Privillage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return abort(404);
        $this->acl->validateStore();
        $data = array();
        $data['dd_privillage'] = $this->pm->dd_privillage(array('pg_code' => $request->get('pg')));
        $data['dd_menu'] = $this->pm->dd_menu();
        $data['privillage_code'] = $request->get('pg');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return abort(404);
        $this->acl->validateStore();
        try {
            DB::beginTransaction();
            $request->request->remove('submit');
            $post = $request->all();
            if($this->pm->create($post)){
                DB::commit();
                return JSONRES(SUCCESS, 'Success save data');
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed save data');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return JSONRES(ERROR, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pm  $pm
     * @return \Illuminate\Http\Response
     */
    public function show($privillage_code=null)
    {
        if(is_null($privillage_code)){
            return abort(404);
        }
        $this->acl->validateRead();
        $data = array();
        $data['dd_menu'] = $this->pm->dd_menu();
        $data['privillage'] = $this->privillage->where('code', $privillage_code)->first();
        if(!$data['privillage']){
            return Redirect::to('privillage');
        }
        $data['results'] = $this->pm->get_data(array('pg_code' => $privillage_code));
        $data['privillage_code'] = $privillage_code;
        return view('pm/index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pm  $pm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
        $this->acl->validateUpdate();
        $data = array();
        $data['result'] = $this->pm->get_data(array('id' => $id));
        $data['dd_privillage'] = $this->pm->dd_privillage(array('pg_code' => $data['result']->privillage_group_code));
        $data['dd_menu'] = $this->pm->dd_menu();
        return view('pu/form/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pm  $pm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->pm::find($id);
            $post_data = $request->all();
            unset($post_data['submit']);
            $addons = array();
            $addons['isRefresh'] = false;
            if($result->update($post_data)){
                DB::commit();
                return JSONRES(SUCCESS, 'Success update data', $addons);
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed update data');
            }
        } catch (\Throwable $th) {
            return JSONRES(ERROR, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pm  $pm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->acl->validateDestroy();
        try {
            DB::beginTransaction();
            $result = $this->pm::find($id);
            if($result->delete()){
                DB::commit();
                return JSONRES(SUCCESS, 'Success delete data');
            }else{
                DB::rollBack();
                return JSONRES(ERROR, 'Failed delete data');
            }
        } catch (\Throwable $th) {
            return JSONRES(ERROR, $th->getMessage());
        }
    }
}
