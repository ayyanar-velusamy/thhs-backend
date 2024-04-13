<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;

class PersonalInformationController extends BaseController
{
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function personal_info(Request $request, $id)
    {
        $data = $this->getPersonalInfoData($id);
        return view('prospect_personal_info',compact("data"));
    }
    public function getPersonalInfoData($id){
        $languages = Language::all();
        $positions = Position::all();
        $user = User::with("emergency_contacts")->with("work_history")->findOrFail($id);
        return ["languages"=>$languages,"user"=>$user,"positions"=>$positions];
    }

}
