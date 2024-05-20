<?php

namespace App\Http\Controllers; 
use App\Http\Requests\SaveRoleRequest; 
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $role_list = UserRole::where('status', '!=' , 0)->select('*')->orderBy('id', 'desc')->get(); 
        return view('roles/role', compact("role_list"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function save_role(SaveRoleRequest $request)
    {
        // exit;
        $role = new UserRole();
        if ($request->input('id')) {
            $role = UserRole::find($request->input('id'));
        } 
        $role->role = $request->input('role');
        $role->status = $request->input('status'); 

        // pr($request->all(),1);
        if ($role->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Role saved successfully";
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Role saving failed";
        }
        return $this->response();
    }
    public function get_role(Request $request, $id)
    {
        $data = $this->getRoleInfoData($id);
        $this->response = compact("data");
        return $this->response();
    }

    public function getRoleInfoData($id)
    {
        $role = UserRole::findOrFail($id);
        return ["role" => $role];
    }

    public function delete_role(Request $request, $id)
    {
        $role = UserRole::find($id);
        $role->status = 0;

        if ($role->save()) {
            $this->response['status'] = true;
            $this->response['message'] = "Role deleted Successfully";

        } else {
            $this->response['status'] = false;
            $this->response['message'] = "Role deleted Failed";

        }
        return $this->response();
    }  
}
