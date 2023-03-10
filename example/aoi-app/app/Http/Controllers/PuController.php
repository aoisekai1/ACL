<?php

namespace App\Http\Controllers;

use App\Models\Pu;
use App\Models\Privillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Acl;

class PuController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->pu = new Pu;
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
        $this->acl->validateStore();
        $data = array();
        $data['dd_privillage'] = $this->pu->dd_privillage(array('pg_code' => $request->get('pg')));
        $data['dd_user'] = $this->pu->dd_user();
        $data['privillage_code'] = $request->get('pg');
        return view('pu/form/create', $data);
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
            if($this->pu->create($post)){
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
     * @param  \App\Models\pu  $pu
     * @return \Illuminate\Http\Response
     */
    public function show($privillage_code)
    {
        $this->acl->validateRead();
        $data = array();
        $data['privillage'] = $this->privillage->where('code', $privillage_code)->first();
        if(!$data['privillage']){
            return Redirect::to('privillage');
        }
        $data['results'] = $this->pu->get_data(array('pg_code' => $privillage_code));
        $data['privillage_code'] = $privillage_code;
        return view('pu/index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pu  $pu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->acl->validateUpdate();
        $data = array();
        $data['result'] = $this->pu->get_data(array('id' => $id));
        $data['dd_privillage'] = $this->pu->dd_privillage(array('pg_code' => $data['result']->privillage_group_code));
        $data['dd_user'] = $this->pu->dd_user();
        return view('pu/form/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pu  $pu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->pu::find($id);
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
            return JSONRES(ERROR, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pu  $pu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->acl->validateDestroy();
        try {
            DB::beginTransaction();
            $result = $this->pu::find($id);
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
