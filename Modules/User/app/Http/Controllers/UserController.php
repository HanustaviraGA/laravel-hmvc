<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SysRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource with loadPage helper.
     * @return Renderable
     */
    public function index()
    {
        return loadPage('user::index');
    }

    /**
     * Display a SSP DataTables with helper.
     * @return Renderable
     */
    public function init_table(){
        $query = User::query();
        $query->leftJoin('sys_role', 'users.role_id', '=', 'sys_role.role_id');
        $query->orderBy('users.created_at', 'asc');
        $query->select('users.name', 'users.id as usrid', 'sys_role.role_name');
        $query->get();
        return select_table($query);
    }

    public function role_list(){
        $roles = SysRole::orderBy('role_name', 'asc')->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        \DB::beginTransaction();
        try{
            $query = User::create($data);
            \DB::commit();
            return response()->json(['success' => true], 200);
        }catch(\Exception $e){
            \DB::rollBack();
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function read(Request $request)
    {
        $data = $request->all();
        $query = User::leftJoin('sys_role', 'users.role', '=', 'sys_role.role_id')
        ->select('users.*', 'users.role as role_id', 'users.id AS usrid', 'sys_role.role_name')
        ->where('id', $data['id'])->first();
        if($query){
            return response()->json(['success' => true, 'data' => $query], 200);
        }else{
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $data = $request->all();
        \DB::beginTransaction();
        try{
            $query = User::where('id', $data['id'])->update($data);
            \DB::commit();
            return response()->json(['success' => true], 200);
        }catch(\Exception $e){
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Request $request)
    {
        $data = $request->all();
        \DB::beginTransaction();
        try{
            $query = User::where('id', $data['id'])->delete();
            \DB::commit();
            return response()->json(['success' => true], 200);
        }catch(\Exception $e){
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
