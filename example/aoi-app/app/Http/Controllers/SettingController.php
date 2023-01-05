<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Acl;

class SettingController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->setting = new Setting;
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
        $data['dd_role'] = $this->setting->dd_roles();
        $data['result'] = $this->setting->first();
        return view('setting/form/edit', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
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
            if($this->setting->create($post)){
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->setting->find($id);
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        return abort(404);
    }
}
