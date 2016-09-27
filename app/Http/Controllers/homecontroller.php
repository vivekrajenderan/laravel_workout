<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Car;
use DB;
use Session;
use View;
use Auth;
use Redirect;

class HomeController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function doLogout() {
        
        Auth::logout(); // log the user out of our application
        return Redirect::to(''); // redirect the user to the login screen
    }

}
