<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProspectsController extends BaseController
{
 
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('prospects/prospect');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function demographics()
    {
        return view('prospects/demographics');
    }
}
