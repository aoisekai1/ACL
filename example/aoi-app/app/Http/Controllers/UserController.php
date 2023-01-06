<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Acl;

class UserController extends Controller
{
    function __construct(){
        $this->acl = new Acl;
        $this->user = new User;
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
        $data['results'] = $this->user->all();
        return view('user/index', $data);
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
        $data['code'] = $this->user->generate_code();
        return view('user/form/create', $data);
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
            if($this->user->create($post)){
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->acl->validateUpdate();
        $data = array();
        $data['result'] = $this->user->find($id);
        return view('user/form/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->acl->validateUpdate();
        try {
            DB::beginTransaction();
            $result = $this->user->find($id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->acl->validateDestroy();
        try {
            DB::beginTransaction();
            $result = $this->user->find($id);
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
