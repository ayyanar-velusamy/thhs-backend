<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Language;
use App\Models\Position;
use App\Models\User;

class ProspectsController extends BaseController
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
    public function index()
    {
        return view('prospects/prospect');
    }

    public function table()
    {
        return view('prospects/prospect2');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function demographics(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('prospects/demographics',compact("data"));
    }

    public function getPersonalInfoData($id){
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages"=>$languages,"user"=>$user,"positions"=>$positions];
    }
}
