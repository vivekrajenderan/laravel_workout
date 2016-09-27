<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Car;
use DB;
use Session;
use View;
class DashboardController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth');
    }
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */    
    public function index()
    {
        return View::make('admin.dashboard');
    }    
}