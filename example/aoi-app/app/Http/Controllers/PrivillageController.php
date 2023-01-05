<?php

namespace App\Http\Controllers;

use App\Models\Privillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Acl;

class PrivillageController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->privillage = new Privillage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->acl->validateRead();
        $data=array();
        $data['results'] = Privillage::all();
        return view('privillage/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->acl->validateStore();
        $data = array();
        $data['code'] = $this->privillage->generate_code();
        return view('privillage/form/create', $data);
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
            if($this->privillage->create($post)){
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
     * @param  \App\Models\privillage  $privillage
     * @return \Illuminate\Http\Response
     */
    public function show(privillage $privillage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\privillage  $privillage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->acl->validateUpdate();
        $data = array();
        $data['result'] = $this->privillage::find($id);
        return view('privillage/form/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\privillage  $privillage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->privillage::find($id);
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
     * @param  \App\Models\privillage  $privillage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->acl->validateDestroy();
        try {
            DB::beginTransaction();
            $result = $this->privillage::find($id);
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
