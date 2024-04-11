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

    public function table()
    {
        return view('prospects/prospect2');
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
